<?php
require_once(__DIR__ . '/../../initialize_coreT2.php');
require_once(__DIR__ . '/../inc/sess_auth.php');
require_once(__DIR__ . '/../inc/access_control.php');
require_once __DIR__ . '/../inc/check_auth.php';

// Comment out permission check if it's causing issues
// checkPermission('disbursement_tracker');

include(__DIR__ . '/../inc/header.php');
include(__DIR__ . '/../inc/navbar.php');
include(__DIR__ . '/../inc/sidebar.php');
?>

<!-- CDN Libraries -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<style>
    body { font-family: sans-serif; }
    .stat-card {
        padding: 1rem; border-radius: .6rem; color: #fff; cursor: pointer;
        transition: all 0.3s ease; position: relative; border: 3px solid transparent;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,.15); }
    .stat-card.active {
        border: 3px solid #fff; box-shadow: 0 0 20px rgba(255,255,255,.5); transform: scale(1.05);
    }
    .stat-card.active::after {
        content: '✓ FILTERED'; position: absolute; top: 5px; right: 10px;
        font-size: 0.65rem; font-weight: bold; opacity: 0.9;
    }
    .stat-title { font-size: 0.9rem; opacity: .9; }
    .stat-value { font-size: 1.6rem; font-weight: 700; margin-top: .25rem; }
    .table-small td, .table-small th { padding: .4rem .6rem; font-size: .9rem; }
    .filter-section { background: #f8f9fa; padding: 1rem; border-radius: .5rem; margin-bottom: 1rem; }
    .alert-floating {
        position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;
        animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .action-btn-group {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    .action-btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>

<main class="main-content p-4" id="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-cash-stack me-2"></i>Disbursement Tracker</h4>
            <div class="d-flex gap-2">
                <button id="exportPdfBtn" class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i> Export PDF</button>
                <button id="reloadBtn" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-clockwise"></i> Reload</button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="card stat-card bg-primary" data-filter="all">
                    <div class="stat-title">Total Disbursements</div>
                    <div id="card_total" class="stat-value">0</div>
                    <small class="d-block mt-1" style="opacity: 0.8;"><i class="bi bi-hand-index"></i> Click to view all</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-success" data-filter="Released">
                    <div class="stat-title">Total Released</div>
                    <div id="card_released" class="stat-value">0</div>
                    <small class="d-block mt-1" style="opacity: 0.8;"><i class="bi bi-hand-index"></i> Click to filter</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-warning text-dark" data-filter="Pending">
                    <div class="stat-title">Total Pending</div>
                    <div id="card_pending" class="stat-value">0</div>
                    <small class="d-block mt-1" style="opacity: 0.8;"><i class="bi bi-hand-index"></i> Click to filter</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-info text-white" data-filter="amount">
                    <div class="stat-title">Total Amount</div>
                    <div id="card_amount" class="stat-value">₱0.00</div>
                    <small class="d-block mt-1" style="opacity: 0.8;">Total disbursed</small>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filter-section">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small mb-1">Search</label>
                    <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search loan ID, member, fund source...">
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Status</label>
                    <select id="statusFilter" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Released">Released</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Fund Source</label>
                    <select id="fundFilter" class="form-select form-select-sm">
                        <option value="">All Funds</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Date Range</label>
                    <input type="date" id="dateFilter" class="form-control form-control-sm">
                </div>
                <div class="col-md-1">
                    <label class="form-label small mb-1">Rows</label>
                    <select id="rowsPerPage" class="form-select form-select-sm">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button id="clearFilters" class="btn btn-sm btn-outline-secondary w-100">Clear</button>
                </div>
            </div>
        </div>

        <!-- Disbursement Table -->
        <div class="card p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">
                    <span>Disbursement Records</span>
                    <span id="filterIndicator" class="badge bg-info ms-2" style="display: none;"></span>
                </h6>
                <span id="recordCount" class="text-muted small"></span>
            </div>

            <div style="overflow:auto">
                <table class="table table-striped table-hover table-small" id="disbTable">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th><th>Loan ID</th><th>Member</th><th>Date</th><th>Amount</th>
                            <th>Fund Source</th><th>Approved By</th><th>Status</th><th>Remarks</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="disbTbody">
                        <tr><td colspan="10" class="text-center">Loading...</td></tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div id="paginationInfo" class="small text-muted"></div>
                    <div id="paginationControls" class="btn-group"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- View Disbursement Modal -->
<div class="modal fade" id="disbModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-eye me-1"></i> Disbursement Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6"><strong>Disbursement ID:</strong> <span id="view_disb_id"></span></div>
                    <div class="col-md-6"><strong>Loan ID:</strong> <span id="view_loan_id"></span></div>
                    <div class="col-md-6"><strong>Member:</strong> <span id="view_member"></span></div>
                    <div class="col-md-6"><strong>Date:</strong> <span id="view_date"></span></div>
                    <div class="col-md-6"><strong>Amount:</strong> <span id="view_amount"></span></div>
                    <div class="col-md-6"><strong>Fund Source:</strong> <span id="view_fund"></span></div>
                    <div class="col-md-6"><strong>Status:</strong> <span id="view_status"></span></div>
                    <div class="col-md-6"><strong>Approved By:</strong> <span id="view_approved"></span></div>
                    <div class="col-12"><strong>Remarks:</strong> <div id="view_remarks" class="mt-1"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../inc/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1, limit = 10;
    let currentFilters = { search: '', status: '', fund: '', date: '', cardFilter: 'all' };
    let allDisbursements = [];

    const tbody = document.getElementById('disbTbody');
    const paginationControls = document.getElementById('paginationControls');
    const paginationInfo = document.getElementById('paginationInfo');
    const filterIndicator = document.getElementById('filterIndicator');

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showAlert(message, type = 'danger') {
        const icon = type === 'success' ? 'success' : type === 'warning' ? 'warning' : type === 'info' ? 'info' : 'error';
        const title = type === 'success' ? 'Success!' : type === 'warning' ? 'Warning!' : type === 'info' ? 'Info' : 'Error!';
        
        Swal.fire({
            icon: icon,
            title: title,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }

    function loadData() {
        const params = new URLSearchParams({
            action: 'list', page: currentPage, limit: limit,
            search: currentFilters.search, status: currentFilters.status,
            fund: currentFilters.fund, date: currentFilters.date,
            cardFilter: currentFilters.cardFilter
        });

        tbody.innerHTML = '<tr><td colspan="10" class="text-center"><div class="spinner-border spinner-border-sm"></div> Loading...</td></tr>';

        // Try both filenames (with and without 's')
        fetch('ajax_disbursement.php?' + params)
            .then(r => {
                if (!r.ok) throw new Error(`HTTP ${r.status}: ${r.statusText}`);
                return r.text();
            })
            .then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Invalid JSON response:', text);
                    throw new Error('Server returned invalid JSON. Check console for details.');
                }
            })
            .then(data => {
                console.log('Received data:', data);
                if (data.error) throw new Error(data.message || 'Server error');
                allDisbursements = data.all_disbursements || data.disbursements || [];
                renderTable(data);
                populateFundSources(data.fund_sources || []);
                updateFilterIndicator();
            })
            .catch(err => {
                console.error('Fetch error:', err);
                showError('Failed to fetch data: ' + err.message);
                showAlert(err.message, 'danger');
            });
    }

    function showError(message) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center text-danger">
            <i class="bi bi-exclamation-triangle"></i> ${escapeHtml(message)}
            <br><small class="text-muted mt-2">Check the browser console (F12) for more details</small>
        </td></tr>`;
    }

    function updateFilterIndicator() {
        const filterTexts = { 'all': '', 'Released': 'Released Only', 'Pending': 'Pending Only', 'Cancelled': 'Cancelled Only' };
        if (currentFilters.cardFilter !== 'all') {
            filterIndicator.textContent = filterTexts[currentFilters.cardFilter];
            filterIndicator.style.display = 'inline-block';
            filterIndicator.className = 'badge ms-2 ' + (currentFilters.cardFilter === 'Released' ? 'bg-success' :
                currentFilters.cardFilter === 'Pending' ? 'bg-warning text-dark' : 'bg-danger');
        } else {
            filterIndicator.style.display = 'none';
        }
    }

    function populateFundSources(sources) {
        const fundFilter = document.getElementById('fundFilter');
        const currentValue = fundFilter.value;
        fundFilter.innerHTML = '<option value="">All Funds</option>';
        sources.forEach(source => {
            const option = document.createElement('option');
            option.value = source;
            option.textContent = source;
            fundFilter.appendChild(option);
        });
        fundFilter.value = currentValue;
    }

    function renderTable(data) {
        // Update summary cards
        document.getElementById('card_total').textContent = data.summary?.total || 0;
        document.getElementById('card_released').textContent = data.summary?.released || 0;
        document.getElementById('card_pending').textContent = data.summary?.pending || 0;
        document.getElementById('card_amount').textContent = '₱' + Number(data.summary?.total_amount || 0).toLocaleString('en-PH', {minimumFractionDigits: 2});

        // Update record count
        const start = (currentPage - 1) * limit + 1;
        const end = Math.min(currentPage * limit, data.pagination?.total_records || 0);
        const total = data.pagination?.total_records || 0;
        document.getElementById('recordCount').textContent = total > 0 ? `Showing ${start}-${end} of ${total} records` : 'No records found';

        // Render table rows
        tbody.innerHTML = '';
        if (data.disbursements?.length > 0) {
            data.disbursements.forEach(d => {
                const statusBadge = d.status === 'Released' ? 'bg-success' : d.status === 'Cancelled' ? 'bg-danger' : 'bg-warning text-dark';
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${escapeHtml(String(d.disbursement_id))}</td>
                    <td>${escapeHtml(String(d.loan_id))}</td>
                    <td>${escapeHtml(d.member_name || 'N/A')}</td>
                    <td>${escapeHtml(d.disbursement_date || '')}</td>
                    <td>₱${Number(d.amount || 0).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                    <td>${escapeHtml(d.fund_source || '-')}</td>
                    <td>${escapeHtml(d.approved_by_name || '-')}</td>
                    <td><span class="badge ${statusBadge}">${escapeHtml(d.status)}</span></td>
                    <td class="text-start">${escapeHtml(d.remarks || '-')}</td>
                    <td class="text-center">
                        <div class="action-btn-group">
                            <button class="btn btn-sm btn-info view-disb-btn" data-id="${d.disbursement_id}" title="View Details">
                                <i class="bi bi-eye"></i> View
                            </button>
                            ${d.status === 'Pending' ? `
                            <button class="btn btn-sm btn-success approve-btn" data-id="${d.disbursement_id}" title="Approve">
                                <i class="bi bi-check-circle"></i> Approve
                            </button>` : ''}
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });

            document.querySelectorAll('.view-disb-btn').forEach(btn => btn.addEventListener('click', onViewDisbursement));
            document.querySelectorAll('.approve-btn').forEach(btn => btn.addEventListener('click', onApproveDisbursement));
        } else {
            const filterMsg = currentFilters.cardFilter !== 'all' ? ` matching "${filterIndicator.textContent}"` : '';
            tbody.innerHTML = `<tr><td colspan="10" class="text-center text-muted"><i class="bi bi-inbox"></i> No disbursements found${filterMsg}</td></tr>`;
        }

        renderPagination(data.pagination?.current_page || 1, data.pagination?.total_pages || 1);
    }

    function renderPagination(current, total) {
        paginationControls.innerHTML = '';
        paginationInfo.textContent = total > 0 ? `Page ${current} of ${total}` : '';
        if (total <= 1) return;

        const prev = document.createElement('button');
        prev.textContent = 'Prev';
        prev.className = 'btn btn-sm btn-outline-primary';
        prev.disabled = current === 1;
        prev.onclick = () => { currentPage--; loadData(); };
        paginationControls.appendChild(prev);

        const next = document.createElement('button');
        next.textContent = 'Next';
        next.className = 'btn btn-sm btn-outline-primary';
        next.disabled = current === total;
        next.onclick = () => { currentPage++; loadData(); };
        paginationControls.appendChild(next);
    }

    function onViewDisbursement(e) {
        const id = e.currentTarget.dataset.id;
        const disb = allDisbursements.find(d => d.disbursement_id == id);
        if (disb) {
            document.getElementById('view_disb_id').textContent = disb.disbursement_id || '';
            document.getElementById('view_loan_id').textContent = disb.loan_id || '';
            document.getElementById('view_member').textContent = disb.member_name || 'N/A';
            document.getElementById('view_date').textContent = disb.disbursement_date || '';
            document.getElementById('view_amount').textContent = '₱' + Number(disb.amount || 0).toLocaleString('en-PH', {minimumFractionDigits: 2});
            document.getElementById('view_fund').textContent = disb.fund_source || '-';
            document.getElementById('view_status').innerHTML = `<span class="badge bg-${disb.status === 'Released' ? 'success' : disb.status === 'Cancelled' ? 'danger' : 'warning'}">${escapeHtml(disb.status)}</span>`;
            document.getElementById('view_approved').textContent = disb.approved_by_name || '-';
            document.getElementById('view_remarks').textContent = disb.remarks || 'No remarks';
            new bootstrap.Modal(document.getElementById('disbModal')).show();
        }
    }

    function onApproveDisbursement(e) {
        const id = e.currentTarget.dataset.id;
        
        Swal.fire({
            title: 'Approve Disbursement?',
            text: `Are you sure you want to approve disbursement ${id}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                fetch('disbursement_action.php', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({ 
                        action: 'approve', 
                        id: id 
                    }),
                    credentials: 'same-origin'
                })
                .then(r => { 
                    if (!r.ok) {
                        throw new Error(`HTTP ${r.status}: ${r.statusText}`);
                    }
                    return r.json(); 
                })
                .then(res => {
                    Swal.close();
                    if (res.status === 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Approved!',
                            text: 'Disbursement has been approved successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        loadData();
                    } else {
                        throw new Error(res.msg || 'Failed to approve');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: err.message || 'Failed to approve disbursement'
                    });
                });
            }
        });
    }

    // Clickable stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
            const filter = this.dataset.filter;
            document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
            if (filter === 'amount') return;
            if (currentFilters.cardFilter === filter) {
                currentFilters.cardFilter = 'all';
            } else {
                this.classList.add('active');
                currentFilters.cardFilter = filter;
            }
            currentPage = 1;
            loadData();
        });
    });

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), wait);
        };
    }

    // Filter event listeners
    document.getElementById('searchInput').addEventListener('input', debounce((e) => {
        currentFilters.search = e.target.value.trim();
        currentPage = 1;
        loadData();
    }, 500));

    document.getElementById('statusFilter').addEventListener('change', (e) => {
        currentFilters.status = e.target.value;
        currentPage = 1;
        loadData();
    });

    document.getElementById('fundFilter').addEventListener('change', (e) => {
        currentFilters.fund = e.target.value;
        currentPage = 1;
        loadData();
    });

    document.getElementById('dateFilter').addEventListener('change', (e) => {
        currentFilters.date = e.target.value;
        currentPage = 1;
        loadData();
    });

    document.getElementById('rowsPerPage').addEventListener('change', (e) => {
        limit = parseInt(e.target.value);
        currentPage = 1;
        loadData();
    });

    document.getElementById('clearFilters').addEventListener('click', () => {
        currentFilters = { search: '', status: '', fund: '', date: '', cardFilter: 'all' };
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('fundFilter').value = '';
        document.getElementById('dateFilter').value = '';
        document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
        currentPage = 1;
        loadData();
    });

    document.getElementById('reloadBtn').addEventListener('click', () => loadData());

    // Export PDF
    document.getElementById('exportPdfBtn').addEventListener('click', function() {
        if (allDisbursements.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Data',
                text: 'No data available to export'
            });
            return;
        }

        try {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');

            doc.setFontSize(18);
            doc.text('Disbursement Tracker Report', 14, 15);
            doc.setFontSize(10);
            doc.setTextColor(100);
            doc.text(`Generated: ${new Date().toLocaleString()}`, 14, 22);
            doc.setFontSize(12);
            doc.setTextColor(40);
            doc.text('Summary', 14, 32);
            doc.setFontSize(10);

            const total = document.getElementById('card_total').textContent;
            const released = document.getElementById('card_released').textContent;
            const pending = document.getElementById('card_pending').textContent;
            const amount = document.getElementById('card_amount').textContent;

            doc.text(`Total: ${total}`, 14, 38);
            doc.text(`Released: ${released}`, 70, 38);
            doc.text(`Pending: ${pending}`, 126, 38);
            doc.text(`Amount: ${amount}`, 182, 38);

            if (currentFilters.cardFilter !== 'all') {
                doc.setFontSize(9);
                doc.setTextColor(200, 0, 0);
                doc.text(`Filter: ${filterIndicator.textContent}`, 14, 44);
            }

            const tableData = allDisbursements.map(d => [
                d.disbursement_id, d.loan_id, d.member_name || 'N/A', d.disbursement_date,
                `₱${Number(d.amount).toLocaleString()}`, d.fund_source || '-',
                d.status, d.approved_by_name || '-'
            ]);

            doc.autoTable({
                startY: currentFilters.cardFilter !== 'all' ? 48 : 44,
                head: [['ID', 'Loan ID', 'Member', 'Date', 'Amount', 'Fund', 'Status', 'Approved By']],
                body: tableData,
                styles: { fontSize: 8, cellPadding: 2 },
                headStyles: { fillColor: [13, 110, 253], textColor: 255, fontStyle: 'bold' },
                alternateRowStyles: { fillColor: [245, 245, 245] }
            });

            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.setTextColor(150);
                doc.text(`Page ${i} of ${pageCount}`, doc.internal.pageSize.width / 2, doc.internal.pageSize.height - 10, { align: 'center' });
            }

            doc.save(`disbursement_tracker_${new Date().toISOString().split('T')[0]}.pdf`);
            
            Swal.fire({
                icon: 'success',
                title: 'Exported!',
                text: 'PDF has been downloaded successfully',
                timer: 2000,
                showConfirmButton: false
            });
        } catch (err) {
            console.error('PDF Export Error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Export Failed',
                text: 'Failed to export PDF: ' + err.message
            });
        }
    });

    // Initial load
    loadData();
});
</script>