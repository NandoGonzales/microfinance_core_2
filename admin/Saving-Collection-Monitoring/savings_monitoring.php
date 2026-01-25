<?php
require_once(__DIR__ . '/../../initialize_coreT2.php');
require_once(__DIR__ . '/../inc/sess_auth.php');
require_once(__DIR__ . '/../inc/access_control.php');
require_once __DIR__ . '/../inc/check_auth.php';

checkPermission('savings_monitoring');

include(__DIR__ . '/../inc/header.php');
include(__DIR__ . '/../inc/navbar.php');
include(__DIR__ . '/../inc/sidebar.php');
?>

<!-- Add jsPDF Libraries for PDF Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<style>
    .hover-card {
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.15s;
        position: relative;
        border: 3px solid transparent;
    }

    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .hover-card.active {
        border: 3px solid #0d6efd;
        box-shadow: 0 0 20px rgba(13, 110, 253, 0.5);
        transform: scale(1.02);
    }

    .hover-card.active::after {
        content: '✓ FILTERED';
        position: absolute;
        top: 8px;
        right: 10px;
        font-size: 0.7rem;
        font-weight: bold;
        color: #0d6efd;
        background: white;
        padding: 2px 6px;
        border-radius: 3px;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.9;
        }
    }

    .hover-card.active {
        animation: pulse 2s infinite;
    }

    .filter-section {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: .5rem;
        margin-bottom: 1rem;
    }

    .badge-deposit {
        background-color: #198754;
    }

    .badge-withdrawal {
        background-color: #dc3545;
    }
</style>

<main class="main-content" id="main-content">
    <div class="container-fluid mt-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0 fw-bold text-primary">Savings Monitoring</h3>
            <div class="d-flex gap-2">
                <button class="btn btn-danger btn-sm" id="exportPdfBtn">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
                <a id="exportCsvBtn" class="btn btn-success btn-sm" href="#">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                </a>
                <button class="btn btn-primary btn-sm" id="addTxBtn">
                    <i class="bi bi-plus-circle"></i> New Transaction
                </button>
            </div>
        </div>

        <!-- Summary Cards (Clickable) -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card shadow-sm hover-card bg-primary text-white" data-filter="all">
                    <div class="card-body">
                        <h6 class="mb-2">Total Transactions</h6>
                        <h4 id="card_total_tx" class="mb-0">0</h4>
                        <small class="d-block mt-2" style="opacity: 0.9;">
                            <i class="bi bi-hand-index"></i> Click to view all
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm hover-card bg-success text-white" data-filter="deposit">
                    <div class="card-body">
                        <h6 class="mb-2">Total Deposits</h6>
                        <h4 id="card_total_deposit" class="mb-0">0</h4>
                        <small class="d-block mt-2" style="opacity: 0.9;">
                            <i class="bi bi-hand-index"></i> Click to filter
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm hover-card bg-danger text-white" data-filter="withdrawal">
                    <div class="card-body">
                        <h6 class="mb-2">Total Withdrawals</h6>
                        <h4 id="card_total_withdraw" class="mb-0">0</h4>
                        <small class="d-block mt-2" style="opacity: 0.9;">
                            <i class="bi bi-hand-index"></i> Click to filter
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm hover-card bg-info text-white" data-filter="balance">
                    <div class="card-body">
                        <h6 class="mb-2">Current Balance</h6>
                        <h4 id="card_balance" class="mb-0">₱0.00</h4>
                        <small class="d-block mt-2" style="opacity: 0.9;">
                            <i class="bi bi-info-circle"></i> Latest balance
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filter-section">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small mb-1">Search</label>
                    <input id="searchInput" class="form-control form-control-sm"
                        placeholder="Search by member ID, type, or date...">
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Transaction Type</label>
                    <select id="typeFilter" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="Deposit">Deposit</option>
                        <option value="Withdrawal">Withdrawal</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Date From</label>
                    <input type="date" id="dateFrom" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Date To</label>
                    <input type="date" id="dateTo" class="form-control form-control-sm">
                </div>
                <div class="col-md-1">
                    <label class="form-label small mb-1">Rows</label>
                    <select id="rowsPerPage" class="form-select form-select-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button id="clearFilters" class="btn btn-sm btn-outline-secondary w-100">Clear</button>
                </div>
            </div>
        </div>

        <!-- Filter Indicator -->
        <div class="mb-2">
            <span id="filterIndicator" class="badge bg-info" style="display: none;"></span>
            <span id="recordCount" class="text-muted small ms-2"></span>
        </div>

        <!-- Table -->
        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-striped align-middle text-center" id="savingsTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Member ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Recorded By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div id="paginationControls" class="btn-group"></div>
            <div id="paginationInfo" class="text-muted small"></div>
        </div>
    </div>
</main>

<!-- Add Transaction Modal -->
<div class="modal fade" id="txModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="txForm" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">New Transaction</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Member ID</label>
                    <input type="number" name="member_id" id="member_id" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Transaction Date</label>
                    <input type="date" name="transaction_date" id="transaction_date" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Type</label>
                    <select name="transaction_type" id="transaction_type" class="form-select" required>
                        <option value="Deposit">Deposit</option>
                        <option value="Withdrawal">Withdrawal</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                </div>
                <div class="form-text text-muted">Balance will be recalculated automatically.</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit">Save</button>
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- View Transaction Modal -->
<div class="modal fade" id="viewTxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-eye me-2"></i>View Transaction</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <strong>Transaction ID:</strong>
                        <p class="mb-0" id="v_id"></p>
                    </div>
                    <div class="col-6">
                        <strong>Member ID:</strong>
                        <p class="mb-0" id="v_member"></p>
                    </div>
                    <div class="col-6">
                        <strong>Date:</strong>
                        <p class="mb-0" id="v_date"></p>
                    </div>
                    <div class="col-6">
                        <strong>Type:</strong>
                        <p class="mb-0" id="v_type"></p>
                    </div>
                    <div class="col-6">
                        <strong>Amount:</strong>
                        <p class="mb-0">₱<span id="v_amount"></span></p>
                    </div>
                    <div class="col-6">
                        <strong>Balance After:</strong>
                        <p class="mb-0">₱<span id="v_balance"></span></p>
                    </div>
                    <div class="col-12">
                        <strong>Recorded By:</strong>
                        <p class="mb-0" id="v_by"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../inc/footer.php'); ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tbody = document.querySelector('#savingsTable tbody');
        const paginationControls = document.getElementById('paginationControls');
        const paginationInfo = document.getElementById('paginationInfo');
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const dateFrom = document.getElementById('dateFrom');
        const dateTo = document.getElementById('dateTo');
        const rowsPerPage = document.getElementById('rowsPerPage');
        const clearFilters = document.getElementById('clearFilters');
        const exportCsvBtn = document.getElementById('exportCsvBtn');
        const exportPdfBtn = document.getElementById('exportPdfBtn');
        const addTxBtn = document.getElementById('addTxBtn');
        const filterIndicator = document.getElementById('filterIndicator');
        const recordCount = document.getElementById('recordCount');

        const txModal = new bootstrap.Modal(document.getElementById('txModal'));
        const viewModal = new bootstrap.Modal(document.getElementById('viewTxModal'));
        const txForm = document.getElementById('txForm');

        let currentPage = 1,
            limit = 10,
            currentSearch = '',
            currentCardFilter = 'all';

        let allTransactionsData = []; // Store for PDF export
        let summaryData = {}; // Store summary for PDF

        function updateFilterIndicator() {
            const filterTexts = {
                'all': '',
                'deposit': 'Deposits Only',
                'withdrawal': 'Withdrawals Only'
            };

            if (currentCardFilter !== 'all') {
                filterIndicator.textContent = filterTexts[currentCardFilter];
                filterIndicator.style.display = 'inline-block';
                filterIndicator.className = 'badge ms-2 ' +
                    (currentCardFilter === 'deposit' ? 'bg-success' : 'bg-danger');
            } else {
                filterIndicator.style.display = 'none';
            }
        }

        function loadData() {
            const params = new URLSearchParams({
                action: 'list',
                page: currentPage,
                limit: limit,
                search: currentSearch,
                filter: currentCardFilter,
                type: typeFilter.value,
                date_from: dateFrom.value,
                date_to: dateTo.value
            });

            tbody.innerHTML = '<tr><td colspan="8" class="text-center"><div class="spinner-border spinner-border-sm"></div> Loading...</td></tr>';

            fetch('savings_action.php', {
                    method: 'POST',
                    body: params
                })
                .then(r => r.json())
                .then(data => {
                    if (data.status !== 'success') {
                        Swal.fire('Error', data.msg || 'Load failed', 'error');
                        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Failed to load data</td></tr>';
                        return;
                    }

                    // Store data for PDF export
                    allTransactionsData = data.rows || [];
                    summaryData = data.summary || {};

                    // Update summary cards
                    document.getElementById('card_total_tx').textContent = data.summary.total || 0;
                    document.getElementById('card_total_deposit').textContent = data.summary.total_deposits || 0;
                    document.getElementById('card_total_withdraw').textContent = data.summary.total_withdrawals || 0;
                    document.getElementById('card_balance').textContent = '₱' + parseFloat(data.summary.last_balance || 0).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    // Update record count
                    const start = (currentPage - 1) * limit + 1;
                    const end = Math.min(currentPage * limit, data.pagination?.total_records || 0);
                    const total = data.pagination?.total_records || 0;
                    recordCount.textContent = total > 0 ? `Showing ${start}-${end} of ${total} records` : 'No records found';

                    // Render table
                    tbody.innerHTML = '';
                    if (data.rows && data.rows.length > 0) {
                        data.rows.forEach(r => {
                            const typeBadge = r.transaction_type === 'Deposit' ? 'badge-deposit' : 'badge-withdrawal';
                            tbody.innerHTML += `
                        <tr>
                            <td>${r.saving_id}</td>
                            <td>${r.member_id}</td>
                            <td>${r.transaction_date}</td>
                            <td><span class="badge ${typeBadge}">${r.transaction_type}</span></td>
                            <td>₱${Number(r.amount).toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                            <td>₱${Number(r.balance).toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                            <td>${r.recorded_by_name || '-'}</td>
                            <td>
                                <button class="btn btn-sm btn-info viewBtn" data-id="${r.saving_id}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>`;
                        });
                    } else {
                        const filterMsg = currentCardFilter !== 'all' ?
                            ` matching "${filterIndicator.textContent}"` : '';
                        tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted">
                        <i class="bi bi-inbox"></i> No transactions found${filterMsg}
                    </td></tr>`;
                    }

                    // Pagination
                    renderPagination(data.pagination?.current_page || 1, data.pagination?.total_pages || 1);

                    // Update CSV export link
                    exportCsvBtn.href = `savings_action.php?export=csv&search=${encodeURIComponent(currentSearch)}&filter=${encodeURIComponent(currentCardFilter)}&type=${encodeURIComponent(typeFilter.value)}&date_from=${encodeURIComponent(dateFrom.value)}&date_to=${encodeURIComponent(dateTo.value)}`;

                    updateFilterIndicator();
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error loading data</td></tr>';
                });
        }

        function renderPagination(current, total) {
            paginationControls.innerHTML = '';
            paginationInfo.textContent = total > 0 ? `Page ${current} of ${total}` : '';

            if (total <= 1) return;

            const prev = document.createElement('button');
            prev.className = 'btn btn-sm btn-outline-primary';
            prev.textContent = 'Prev';
            prev.disabled = current === 1;
            prev.onclick = () => {
                currentPage--;
                loadData();
            };

            const next = document.createElement('button');
            next.className = 'btn btn-sm btn-outline-primary';
            next.textContent = 'Next';
            next.disabled = current === total;
            next.onclick = () => {
                currentPage++;
                loadData();
            };

            paginationControls.appendChild(prev);
            paginationControls.appendChild(next);
        }

        // Card filter click
        document.querySelectorAll('.hover-card').forEach(card => {
            card.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Remove active from all cards
                document.querySelectorAll('.hover-card').forEach(c => c.classList.remove('active'));

                // Toggle filter
                if (currentCardFilter === filter) {
                    currentCardFilter = 'all';
                } else {
                    this.classList.add('active');
                    currentCardFilter = filter;
                }

                currentPage = 1;
                loadData();
            });
        });

        // PDF Export
        exportPdfBtn.addEventListener('click', function() {
            if (allTransactionsData.length === 0) {
                Swal.fire('No Data', 'No transactions available to export', 'info');
                return;
            }

            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');

            // Title
            doc.setFontSize(18);
            doc.setTextColor(40, 40, 40);
            doc.text('Savings Monitoring Report', 14, 15);

            // Date
            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text(`Generated: ${new Date().toLocaleString()}`, 14, 22);

            // Summary Section
            doc.setFontSize(12);
            doc.setTextColor(40, 40, 40);
            doc.text('Summary', 14, 32);

            doc.setFontSize(10);
            doc.text(`Total Transactions: ${summaryData.total || 0}`, 14, 38);
            doc.text(`Total Deposits: ${summaryData.total_deposits || 0}`, 70, 38);
            doc.text(`Total Withdrawals: ${summaryData.total_withdrawals || 0}`, 126, 38);
            doc.text(`Current Balance: ₱${parseFloat(summaryData.last_balance || 0).toLocaleString()}`, 14, 44);

            // Filter info
            if (currentCardFilter !== 'all') {
                doc.setFontSize(9);
                doc.setTextColor(200, 0, 0);
                doc.text(`Filter Applied: ${filterIndicator.textContent}`, 14, 50);
            }

            // Prepare table data
            const tableData = allTransactionsData.map(r => [
                r.saving_id,
                r.member_id,
                r.transaction_date,
                r.transaction_type,
                `₱${Number(r.amount).toLocaleString(undefined, {minimumFractionDigits: 2})}`,
                `₱${Number(r.balance).toLocaleString(undefined, {minimumFractionDigits: 2})}`,
                r.recorded_by_name || '-'
            ]);

            // Add table
            doc.autoTable({
                startY: currentCardFilter !== 'all' ? 54 : 48,
                head: [
                    ['ID', 'Member ID', 'Date', 'Type', 'Amount', 'Balance', 'Recorded By']
                ],
                body: tableData,
                styles: {
                    fontSize: 9,
                    cellPadding: 3,
                },
                headStyles: {
                    fillColor: [13, 110, 253],
                    textColor: 255,
                    fontStyle: 'bold'
                },
                alternateRowStyles: {
                    fillColor: [245, 245, 245]
                },
                columnStyles: {
                    0: {
                        cellWidth: 15
                    },
                    1: {
                        cellWidth: 25
                    },
                    2: {
                        cellWidth: 28
                    },
                    3: {
                        cellWidth: 25
                    },
                    4: {
                        cellWidth: 30
                    },
                    5: {
                        cellWidth: 30
                    },
                    6: {
                        cellWidth: 35
                    }
                },
                didParseCell: function(data) {
                    // Color code transaction types
                    if (data.column.index === 3) {
                        if (data.cell.raw === 'Deposit') {
                            data.cell.styles.textColor = [25, 135, 84];
                            data.cell.styles.fontStyle = 'bold';
                        } else if (data.cell.raw === 'Withdrawal') {
                            data.cell.styles.textColor = [220, 53, 69];
                            data.cell.styles.fontStyle = 'bold';
                        }
                    }
                }
            });

            // Footer
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.setTextColor(150);
                doc.text(
                    `Page ${i} of ${pageCount}`,
                    doc.internal.pageSize.width / 2,
                    doc.internal.pageSize.height - 10, {
                        align: 'center'
                    }
                );
            }

            // Save the PDF
            const filename = `Savings_Report_${new Date().toISOString().slice(0, 10)}.pdf`;
            doc.save(filename);
        });

        // Add Transaction
        addTxBtn.addEventListener('click', () => {
            txForm.reset();
            // Set today's date as default
            document.getElementById('transaction_date').valueAsDate = new Date();
            txModal.show();
        });

        txForm.addEventListener('submit', e => {
            e.preventDefault();
            const fd = new FormData(txForm);
            fd.append('action', 'add');

            fetch('savings_action.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(resp => {
                    if (resp.status === 'success') {
                        Swal.fire('Saved', resp.msg, 'success');
                        txModal.hide();
                        loadData();
                    } else {
                        Swal.fire('Error', resp.msg, 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Failed to save transaction', 'error');
                });
        });

        // View Transaction
        tbody.addEventListener('click', e => {
            const viewBtn = e.target.closest('.viewBtn');
            if (!viewBtn) return;

            const id = viewBtn.dataset.id;
            fetch('savings_action.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'get',
                        id
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.status !== 'success') {
                        Swal.fire('Error', res.msg, 'error');
                        return;
                    }

                    const d = res.row;
                    document.getElementById('v_id').textContent = d.saving_id;
                    document.getElementById('v_member').textContent = d.member_id;
                    document.getElementById('v_date').textContent = d.transaction_date;
                    document.getElementById('v_type').innerHTML = `<span class="badge ${d.transaction_type === 'Deposit' ? 'badge-deposit' : 'badge-withdrawal'}">${d.transaction_type}</span>`;
                    document.getElementById('v_amount').textContent = Number(d.amount).toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                    document.getElementById('v_balance').textContent = Number(d.balance).toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                    document.getElementById('v_by').textContent = d.recorded_by_name || 'Unknown';
                    viewModal.show();
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Failed to load transaction details', 'error');
                });
        });

        // Filter event listeners with debounce for search
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), wait);
            };
        }

        searchInput.addEventListener('input', debounce(() => {
            currentSearch = searchInput.value.trim();
            currentPage = 1;
            loadData();
        }, 500));

        typeFilter.addEventListener('change', () => {
            currentPage = 1;
            loadData();
        });

        dateFrom.addEventListener('change', () => {
            currentPage = 1;
            loadData();
        });

        dateTo.addEventListener('change', () => {
            currentPage = 1;
            loadData();
        });

        rowsPerPage.addEventListener('change', () => {
            limit = parseInt(rowsPerPage.value);
            currentPage = 1;
            loadData();
        });

        clearFilters.addEventListener('click', () => {
            currentSearch = '';
            currentCardFilter = 'all';
            currentPage = 1;

            searchInput.value = '';
            typeFilter.value = '';
            dateFrom.value = '';
            dateTo.value = '';
            rowsPerPage.value = '10';
            limit = 10;

            document.querySelectorAll('.hover-card').forEach(c => c.classList.remove('active'));
            loadData();
        });

        // Initial load
        loadData();
    });
</script>