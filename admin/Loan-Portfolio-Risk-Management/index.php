<?php
// === Include layout files ===
include(__DIR__ . '/../inc/header.php');
include(__DIR__ . '/../inc/navbar.php');
include(__DIR__ . '/../inc/sidebar.php');
include(__DIR__ . '/../inc/footer.php');

require_once(__DIR__ . '/../../initialize_coreT2.php');
require_once(__DIR__ . '/../inc/sess_auth.php');
require_once __DIR__ . '/../inc/check_auth.php';

if (session_status() === PHP_SESSION_NONE) session_start();
?>

<!-- Add Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Add jsPDF and jsPDF-AutoTable for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<style>
    body {
        font-family: sans-serif;
    }

    .stat-card {
        padding: 1rem;
        border-radius: .6rem;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        border: 3px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .stat-card.active {
        border: 3px solid #fff;
        box-shadow: 0 0 25px rgba(255, 255, 255, 0.6);
        transform: scale(1.05);
    }

    .stat-card.active::after {
        content: '✓ FILTERED';
        position: absolute;
        top: 5px;
        right: 10px;
        font-size: 0.65rem;
        font-weight: bold;
        opacity: 0.9;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.85;
        }
    }

    .stat-card.active {
        animation: pulse 2s infinite;
    }

    .stat-title {
        font-size: 0.9rem;
        opacity: .9;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 700;
        margin-top: .25rem;
    }

    .chart-card {
        padding: 1rem;
        border-radius: .6rem;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .chart-container {
        position: relative;
        height: 280px;
    }

    .table-small td,
    .table-small th {
        padding: .4rem .6rem;
        font-size: .9rem;
    }

    .overdue {
        background-color: #f8d7da !important;
    }

    .near-due {
        background-color: #fff3cd !important;
    }

    .filter-section {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: .5rem;
        margin-bottom: 1rem;
    }
</style>

<main class="main-content" id="main-content">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 fw-bold text-primary">Loan Portfolio & Risk Management</h4>
            <div class="d-flex gap-2">
                <button id="exportPdfBtn" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
                <button id="reloadBtn" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-arrow-clockwise"></i> Reload
                </button>
            </div>
        </div>

        <!-- Summary Cards (Clickable) -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="card stat-card bg-primary" data-filter="all">
                    <div class="stat-title">Total Loans</div>
                    <div id="card_total_loans" class="stat-value">0</div>
                    <small class="d-block mt-1" style="opacity: 0.8;"><i class="bi bi-hand-index"></i> Click to view all</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-success" data-filter="active">
                    <div class="stat-title">Active Loans</div>
                    <div id="card_active_loans" class="stat-value">0</div>
                    <small class="d-block mt-1" style="opacity: 0.8;"><i class="bi bi-hand-index"></i> Click to filter</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-warning text-dark" data-filter="overdue">
                    <div class="stat-title">Overdue Loans</div>
                    <div id="card_overdue_loans" class="stat-value">0</div>
                    <small class="d-block mt-1" style="opacity: 0.8;"><i class="bi bi-hand-index"></i> Click to filter</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-danger" data-filter="defaulted">
                    <div class="stat-title">Defaulted Loans</div>
                    <div id="card_defaulted_loans" class="stat-value">0</div>
                    <small class="d-block mt-1" style="opacity: 0.8;"><i class="bi bi-hand-index"></i> Click to filter</small>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filter-section">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small mb-1">Search</label>
                    <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search loans...">
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Status</label>
                    <select id="statusFilter" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Active">Active</option>
                        <option value="Completed">Completed</option>
                        <option value="Defaulted">Defaulted</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Risk Level</label>
                    <select id="riskFilter" class="form-select form-select-sm">
                        <option value="">All Risks</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Loan Type</label>
                    <select id="typeFilter" class="form-select form-select-sm">
                        <option value="">All Types</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Rows per page</label>
                    <select id="rowsPerPage" class="form-select form-select-sm">
                        <option value="10" selected>10 rows</option>
                        <option value="20">20 rows</option>
                        <option value="50">50 rows</option>
                        <option value="100">100 rows</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button id="clearFilters" class="btn btn-sm btn-outline-secondary w-100">Clear</button>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="chart-card">
                    <h6 class="mb-3">Loan Status Distribution</h6>
                    <div class="chart-container">
                        <canvas id="loanStatusPie"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <h6 class="mb-3">Risk Level Breakdown</h6>
                    <div class="chart-container">
                        <canvas id="riskDonut"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Risk Table -->
        <div class="card p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">
                    <span id="tableTitle">Loan Risk Table</span>
                    <span id="filterIndicator" class="badge bg-info ms-2" style="display: none;"></span>
                </h6>
                <span id="recordCount" class="text-muted small"></span>
            </div>

            <div style="overflow:auto">
                <table class="table table-striped table-hover table-small" id="loanRiskTable">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Member</th>
                            <th>Type</th>
                            <th>Principal</th>
                            <th>IRate</th>
                            <th>Term</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                            <th>Overdue</th>
                            <th>Risk</th>
                            <th>Next Due</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="loanRiskTbody"></tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div id="paginationInfo" class="small text-muted"></div>
                    <div id="paginationControls" class="btn-group"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- View Loan Modal -->
<div class="modal fade" id="viewLoanModal" tabindex="-1" aria-labelledby="viewLoanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewLoanModalLabel"><i class="bi bi-eye me-1"></i> Loan Details & Payment History</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="loanDetailsContent">
                    <p class="text-center text-muted">Loading loan details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let loanStatusChart, riskDonutChart;
        let currentPage = 1,
            limit = 10;
        let currentFilters = {
            search: '',
            status: '',
            risk: '',
            type: '',
            cardFilter: 'all'
        };
        let allLoansData = []; // Store all loans for PDF export

        const tbody = document.getElementById('loanRiskTbody');
        const paginationControls = document.getElementById('paginationControls');
        const paginationInfo = document.getElementById('paginationInfo');
        const filterIndicator = document.getElementById('filterIndicator');

        // --- Load data ---
        function loadData() {
            const params = new URLSearchParams({
                page: currentPage,
                limit: limit,
                search: currentFilters.search,
                status: currentFilters.status,
                risk: currentFilters.risk,
                type: currentFilters.type,
                cardFilter: currentFilters.cardFilter
            });

            tbody.innerHTML = '<tr><td colspan="13" class="text-center"><div class="spinner-border spinner-border-sm"></div> Loading...</td></tr>';

            fetch(`ajax_loan_risk_data.php?${params}`)
                .then(r => {
                    if (!r.ok) throw new Error('Network response was not ok');
                    return r.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    if (!data.error) {
                        allLoansData = data.loans || []; // Store for PDF export
                        renderChartsAndTable(data);
                        populateLoanTypes(data.loan_types || []);
                        updateFilterIndicator();
                    } else {
                        console.error('Error from server:', data.error);
                        showError('Failed to load data: ' + data.error);
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    showError('Failed to fetch data. Please try again.');
                });
        }

        function showError(message) {
            tbody.innerHTML = `<tr><td colspan="13" class="text-center text-danger"><i class="bi bi-exclamation-triangle"></i> ${message}</td></tr>`;
        }

        function updateFilterIndicator() {
            const filterTexts = {
                'all': '',
                'active': 'Active Loans Only',
                'overdue': 'Overdue Loans Only',
                'defaulted': 'Defaulted Loans Only'
            };

            if (currentFilters.cardFilter !== 'all') {
                filterIndicator.textContent = filterTexts[currentFilters.cardFilter];
                filterIndicator.style.display = 'inline-block';
                filterIndicator.className = 'badge ms-2 ' +
                    (currentFilters.cardFilter === 'active' ? 'bg-success' :
                        currentFilters.cardFilter === 'overdue' ? 'bg-warning text-dark' : 'bg-danger');
            } else {
                filterIndicator.style.display = 'none';
            }
        }

        function populateLoanTypes(types) {
            const typeFilter = document.getElementById('typeFilter');
            const currentValue = typeFilter.value;
            typeFilter.innerHTML = '<option value="">All Types</option>';
            types.forEach(type => {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type;
                typeFilter.appendChild(option);
            });
            typeFilter.value = currentValue;
        }

        // --- Render charts & table ---
        function renderChartsAndTable(data) {
            // Summary Cards
            document.getElementById('card_total_loans').textContent = data.summary?.total_loans || 0;
            document.getElementById('card_active_loans').textContent = data.summary?.active_loans || 0;
            document.getElementById('card_overdue_loans').textContent = data.summary?.overdue_loans || 0;
            document.getElementById('card_defaulted_loans').textContent = data.summary?.defaulted_loans || 0;

            // Loan Status Pie
            if (loanStatusChart) loanStatusChart.destroy();
            if (data.loan_status && data.loan_status.labels && data.loan_status.labels.length > 0) {
                const ctx = document.getElementById('loanStatusPie');
                if (ctx) {
                    loanStatusChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.loan_status.labels,
                            datasets: [{
                                data: data.loan_status.values,
                                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            }

            // Risk Donut
            if (riskDonutChart) riskDonutChart.destroy();
            if (data.risk_breakdown && data.risk_breakdown.labels && data.risk_breakdown.labels.length > 0) {
                const ctx = document.getElementById('riskDonut');
                if (ctx) {
                    riskDonutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: data.risk_breakdown.labels,
                            datasets: [{
                                data: data.risk_breakdown.values,
                                backgroundColor: ['#198754', '#ffc107', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            }

            // Record Count
            const start = (currentPage - 1) * limit + 1;
            const end = Math.min(currentPage * limit, data.pagination?.total_records || 0);
            const total = data.pagination?.total_records || 0;
            document.getElementById('recordCount').textContent =
                total > 0 ? `Showing ${start}-${end} of ${total} records` : 'No records found';

            // Table
            tbody.innerHTML = '';
            if (data.loans && data.loans.length > 0) {
                data.loans.forEach(l => {
                    const riskBadge = l.risk_level === 'High' ? 'bg-danger' :
                        l.risk_level === 'Medium' ? 'bg-warning text-dark' : 'bg-success';
                    const statusBadge = l.status === 'Active' ? 'bg-success' :
                        l.status === 'Defaulted' ? 'bg-danger' :
                        l.status === 'Completed' ? 'bg-info' : 'bg-warning';

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${l.loan_id}</td>
                        <td>${escapeHtml(l.member_name || 'N/A')}</td>
                        <td>${escapeHtml(l.loan_type)}</td>
                        <td>₱${Number(l.principal_amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                        <td>${l.interest_rate ?? '-'}%</td>
                        <td>${l.loan_term ?? '-'} mo</td>
                        <td>${l.start_date ?? '-'}</td>
                        <td>${l.end_date ?? '-'}</td>
                        <td><span class="badge ${statusBadge}">${l.status}</span></td>
                        <td><span class="badge ${l.overdue_count > 0 ? 'bg-danger' : 'bg-secondary'}">${l.overdue_count || 0}</span></td>
                        <td><span class="badge ${riskBadge}">${l.risk_level}</span></td>
                        <td>${l.next_due || '-'}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info view-loan-btn" data-id="${l.loan_id}" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });

                document.querySelectorAll('.view-loan-btn').forEach(b => {
                    b.addEventListener('click', onViewLoan);
                });
            } else {
                const filterMsg = currentFilters.cardFilter !== 'all' ?
                    ` matching "${filterIndicator.textContent}"` : '';
                tbody.innerHTML = `<tr><td colspan="13" class="text-center text-muted"><i class="bi bi-inbox"></i> No loans found${filterMsg}</td></tr>`;
            }

            renderPagination(data.pagination?.current_page || 1, data.pagination?.total_pages || 1);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // --- PDF Export Function ---
        document.getElementById('exportPdfBtn').addEventListener('click', function() {
            if (allLoansData.length === 0) {
                alert('No data available to export');
                return;
            }

            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4'); // Landscape orientation

            // Get summary data
            const totalLoans = document.getElementById('card_total_loans').textContent;
            const activeLoans = document.getElementById('card_active_loans').textContent;
            const overdueLoans = document.getElementById('card_overdue_loans').textContent;
            const defaultedLoans = document.getElementById('card_defaulted_loans').textContent;

            // Title
            doc.setFontSize(18);
            doc.setTextColor(40, 40, 40);
            doc.text('Loan Portfolio & Risk Management Report', 14, 15);

            // Date
            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text(`Generated: ${new Date().toLocaleString()}`, 14, 22);

            // Summary Section
            doc.setFontSize(12);
            doc.setTextColor(40, 40, 40);
            doc.text('Summary', 14, 32);

            doc.setFontSize(10);
            doc.text(`Total Loans: ${totalLoans}`, 14, 38);
            doc.text(`Active Loans: ${activeLoans}`, 70, 38);
            doc.text(`Overdue Loans: ${overdueLoans}`, 126, 38);
            doc.text(`Defaulted Loans: ${defaultedLoans}`, 182, 38);

            // Filter info
            if (currentFilters.cardFilter !== 'all') {
                doc.setFontSize(9);
                doc.setTextColor(200, 0, 0);
                doc.text(`Filter Applied: ${filterIndicator.textContent}`, 14, 44);
            }

            // Prepare table data
            const tableData = allLoansData.map(l => [
                l.loan_id,
                l.member_name || 'N/A',
                l.loan_type,
                `₱${Number(l.principal_amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}`,
                `${l.interest_rate ?? '-'}%`,
                `${l.loan_term ?? '-'} mo`,
                l.start_date ?? '-',
                l.end_date ?? '-',
                l.status,
                l.overdue_count || 0,
                l.risk_level,
                l.next_due || '-'
            ]);

            // Add table
            doc.autoTable({
                startY: currentFilters.cardFilter !== 'all' ? 48 : 44,
                head: [
                    ['ID', 'Member', 'Type', 'Principal', 'Rate', 'Term', 'Start', 'End', 'Status', 'Overdue', 'Risk', 'Next Due']
                ],
                body: tableData,
                styles: {
                    fontSize: 8,
                    cellPadding: 2,
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
                        cellWidth: 35
                    },
                    2: {
                        cellWidth: 25
                    },
                    3: {
                        cellWidth: 28
                    },
                    4: {
                        cellWidth: 15
                    },
                    5: {
                        cellWidth: 15
                    },
                    6: {
                        cellWidth: 22
                    },
                    7: {
                        cellWidth: 22
                    },
                    8: {
                        cellWidth: 20
                    },
                    9: {
                        cellWidth: 15
                    },
                    10: {
                        cellWidth: 18
                    },
                    11: {
                        cellWidth: 22
                    }
                },
                didParseCell: function(data) {
                    // Color code risk levels
                    if (data.column.index === 10) {
                        if (data.cell.raw === 'High') {
                            data.cell.styles.textColor = [220, 53, 69];
                            data.cell.styles.fontStyle = 'bold';
                        } else if (data.cell.raw === 'Medium') {
                            data.cell.styles.textColor = [255, 193, 7];
                            data.cell.styles.fontStyle = 'bold';
                        } else if (data.cell.raw === 'Low') {
                            data.cell.styles.textColor = [25, 135, 84];
                            data.cell.styles.fontStyle = 'bold';
                        }
                    }
                    // Color code status
                    if (data.column.index === 8) {
                        if (data.cell.raw === 'Active') {
                            data.cell.styles.textColor = [25, 135, 84];
                        } else if (data.cell.raw === 'Defaulted') {
                            data.cell.styles.textColor = [220, 53, 69];
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
                doc.text(`Page ${i} of ${pageCount}`, doc.internal.pageSize.width / 2, doc.internal.pageSize.height - 10, {
                    align: 'center'
                });
            }

            // Save the PDF
            const filename = `Loan_Portfolio_Report_${new Date().toISOString().slice(0, 10)}.pdf`;
            doc.save(filename);
        });

        // --- Pagination ---
        function renderPagination(current, total) {
            paginationControls.innerHTML = '';
            paginationInfo.textContent = total > 0 ? `Page ${current} of ${total}` : '';

            if (total <= 1) return;

            const prev = document.createElement('button');
            prev.textContent = 'Prev';
            prev.className = 'btn btn-sm btn-outline-primary';
            prev.disabled = current === 1;
            prev.onclick = () => {
                currentPage--;
                loadData();
            };
            paginationControls.appendChild(prev);

            const next = document.createElement('button');
            next.textContent = 'Next';
            next.className = 'btn btn-sm btn-outline-primary';
            next.disabled = current === total;
            next.onclick = () => {
                currentPage++;
                loadData();
            };
            paginationControls.appendChild(next);
        }

        // Card click handler
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Remove active from all
                document.querySelectorAll('.stat-card')
                    .forEach(c => c.classList.remove('active'));

                // Toggle filter
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
        // --- Filter listeners ---
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

        document.getElementById('riskFilter').addEventListener('change', (e) => {
            currentFilters.risk = e.target.value;
            currentPage = 1;
            loadData();
        });

        document.getElementById('typeFilter').addEventListener('change', (e) => {
            currentFilters.type = e.target.value;
            currentPage = 1;
            loadData();
        });

        document.getElementById('rowsPerPage').addEventListener('change', (e) => {
            limit = parseInt(e.target.value);
            currentPage = 1;
            loadData();
        });

        document.getElementById('clearFilters').addEventListener('click', () => {
            currentFilters = {
                search: '',
                status: '',
                risk: '',
                type: '',
                cardFilter: 'all'
            };
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('riskFilter').value = '';
            document.getElementById('typeFilter').value = '';
            document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
            currentPage = 1;
            loadData();
        });

        document.getElementById('reloadBtn').addEventListener('click', () => loadData());

        // --- View Loan ---
        function onViewLoan(e) {
            const loan_id = e.currentTarget.dataset.id;
            const content = document.getElementById('loanDetailsContent');
            content.innerHTML = '<div class="text-center"><div class="spinner-border"></div><p class="mt-2">Loading...</p></div>';

            fetch(`loan_crud.php?loan_id=${loan_id}`)
                .then(r => r.json())
                .then(res => {
                    if (res.success && res.loan) {
                        const l = res.loan;
                        let html = `
                        <div class="row g-3 mb-4">
                            <div class="col-md-6"><strong>Loan ID:</strong> ${l.loan_id}</div>
                            <div class="col-md-6"><strong>Member:</strong> ${escapeHtml(l.member_name)} (ID: ${l.member_id})</div>
                            <div class="col-md-6"><strong>Type:</strong> ${escapeHtml(l.loan_type)}</div>
                            <div class="col-md-6"><strong>Status:</strong> <span class="badge bg-${l.status === 'Active' ? 'success' : l.status === 'Completed' ? 'info' : l.status === 'Defaulted' ? 'danger' : 'warning'}">${l.status}</span></div>
                            <div class="col-md-6"><strong>Principal:</strong> ₱${Number(l.principal_amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}</div>
                            <div class="col-md-6"><strong>Interest Rate:</strong> ${l.interest_rate}%</div>
                            <div class="col-md-6"><strong>Loan Term:</strong> ${l.loan_term} months</div>
                            <div class="col-md-6"><strong>Start Date:</strong> ${l.start_date}</div>
                            <div class="col-md-6"><strong>End Date:</strong> ${l.end_date}</div>
                        </div>`;

                        if (res.schedules && res.schedules.length > 0) {
                            html += `<h6 class="mb-2"><i class="bi bi-calendar-check me-1"></i> Payment Schedule & History</h6>
                            <div class="table-responsive"><table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Due Date</th>
                                    <th>Amount Due</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead><tbody>`;

                            res.schedules.forEach(s => {
                                const badge = s.status === 'Paid' ? 'bg-success' : s.status === 'Overdue' ? 'bg-danger' : 'bg-warning';
                                const balance = Number(s.amount_due) - Number(s.amount_paid);
                                html += `<tr>
                                    <td>${s.due_date}</td>
                                    <td>₱${Number(s.amount_due).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                    <td>₱${Number(s.amount_paid).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                    <td>₱${balance.toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                    <td>${s.payment_date || '-'}</td>
                                    <td><span class="badge ${badge}">${s.status}</span></td>
                                </tr>`;
                            });
                            html += '</tbody></table></div>';
                        } else {
                            html += '<p class="text-muted">No payment schedules available</p>';
                        }

                        content.innerHTML = html;
                        new bootstrap.Modal(document.getElementById('viewLoanModal')).show();
                    } else {
                        content.innerHTML = '<p class="text-center text-danger">Failed to load loan details.</p>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    content.innerHTML = '<p class="text-center text-danger">Error loading loan.</p>';
                });
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), wait);
            };
        }

        // Initial load
        loadData();
    });
</script>