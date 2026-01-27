<?php
// === Initialize database and session FIRST ===
require_once(__DIR__ . '/../../initialize_coreT2.php');
require_once(__DIR__ . '/../inc/sess_auth.php');
require_once(__DIR__ . '/../inc/check_auth.php');

if (session_status() === PHP_SESSION_NONE) session_start();

// === Include layout files AFTER database is ready ===
include(__DIR__ . '/../inc/header.php');
include(__DIR__ . '/../inc/navbar.php');
include(__DIR__ . '/../inc/sidebar.php');
?>

<!-- Add Chart.js and jsPDF CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-card.active {
        border: 3px solid #fff;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
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
        0%, 100% { opacity: 1; }
        50% { opacity: 0.85; }
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
            <h4 class="mb-0 fw-bold text-primary">Repayment Tracker & Monitoring</h4>
            <div class="d-flex gap-2">
                <button id="exportPdfBtn" class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i> Export PDF</button>
                <button id="reloadBtn" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-clockwise"></i> Reload</button>
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
                <div class="card stat-card bg-danger" data-filter="at_risk">
                    <div class="stat-title">At Risk Loans</div>
                    <div id="card_at_risk_loans" class="stat-value">0</div>
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
                        <canvas id="loanStatusChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <h6 class="mb-3">Risk Level Breakdown</h6>
                    <div class="chart-container">
                        <canvas id="riskChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Portfolio Table -->
        <div class="card p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">
                    <span id="tableTitle">Loan Portfolio Table</span>
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
                            <th>Rate %</th>
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
<div class="modal fade" id="viewLoanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-eye me-1"></i> Loan Details & Payment History</h5>
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
        let loanStatusChart, riskChart;
        let currentPage = 1, limit = 10;
        let currentFilters = {
            search: '',
            status: '',
            risk: '',
            type: '',
            cardFilter: 'all'
        };
        let allLoans = [];

        const tbody = document.getElementById('loanRiskTbody');
        const paginationControls = document.getElementById('paginationControls');
        const paginationInfo = document.getElementById('paginationInfo');
        const filterIndicator = document.getElementById('filterIndicator');

        // ✅ Helper function - defined FIRST
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ✅ Event delegation handler for view buttons
        function handleViewButtonClick(e) {
            const button = e.target.closest('.view-loan-btn');
            if (!button) return;

            const loan_id = button.dataset.id;
            console.log('Clicked View button for loan ID:', loan_id);
            
            const content = document.getElementById('loanDetailsContent');
            content.innerHTML = '<div class="text-center"><div class="spinner-border"></div><p class="mt-2">Loading...</p></div>';

            const url = `../Loan-Portfolio-Risk-Management/loan_crud.php?loan_id=${loan_id}`;
            console.log('Fetching URL:', url);

            fetch(url)
                .then(r => {
                    console.log('Response status:', r.status);
                    if (!r.ok) {
                        return r.text().then(text => {
                            throw new Error(`HTTP ${r.status}: ${text}`);
                        });
                    }
                    return r.json();
                })
                .then(res => {
                    console.log('Response data:', res);

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
                    <div class="col-md-6"><strong>Term:</strong> ${l.loan_term} months</div>
                    <div class="col-md-6"><strong>Start:</strong> ${l.start_date}</div>
                    <div class="col-md-6"><strong>End:</strong> ${l.end_date}</div>
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

                        // Show modal
                        const modalEl = document.getElementById('viewLoanModal');
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    } else {
                        content.innerHTML = '<p class="text-center text-danger">Failed to load loan details.</p>';
                    }
                })
                .catch(err => {
                    console.error('View loan error:', err);
                    content.innerHTML = `<p class="text-center text-danger">Error: ${err.message}</p>`;
                });
        }

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

            fetch(`ajax_repayments.php?${params}`)
                .then(r => {
                    if (!r.ok) {
                        return r.text().then(text => {
                            throw new Error(`HTTP ${r.status}: ${text}`);
                        });
                    }
                    return r.json();
                })
                .then(data => {
                    console.log('Received data:', data);

                    if (data.error) {
                        throw new Error(data.message || 'Server error');
                    }

                    allLoans = data.all_loans || data.loans || [];
                    renderChartsAndTable(data);
                    populateLoanTypes(data.loan_types || []);
                    updateFilterIndicator();
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    showError('Failed to fetch data: ' + err.message);
                });
        }

        function showError(message) {
            tbody.innerHTML = `<tr><td colspan="13" class="text-center text-danger"><i class="bi bi-exclamation-triangle"></i> ${escapeHtml(message)}</td></tr>`;
        }

        function updateFilterIndicator() {
            const filterTexts = {
                'all': '',
                'active': 'Active Loans Only',
                'overdue': 'Overdue Loans Only',
                'at_risk': 'At Risk Loans Only'
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

        function renderChartsAndTable(data) {
            // Summary Cards
            document.getElementById('card_total_loans').textContent = data.summary?.total_loans || 0;
            document.getElementById('card_active_loans').textContent = data.summary?.active_loans || 0;
            document.getElementById('card_overdue_loans').textContent = data.summary?.overdue_loans || 0;
            document.getElementById('card_at_risk_loans').textContent = data.summary?.at_risk_loans || 0;

            // Loan Status Chart
            if (loanStatusChart) loanStatusChart.destroy();

            if (data.loan_status && data.loan_status.labels && data.loan_status.labels.length > 0) {
                const ctx = document.getElementById('loanStatusChart');
                if (ctx) {
                    loanStatusChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.loan_status.labels,
                            datasets: [{
                                label: 'Number of Loans',
                                data: data.loan_status.values,
                                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                }
            }

            // Risk Chart
            if (riskChart) riskChart.destroy();

            if (data.risk_breakdown && data.risk_breakdown.labels && data.risk_breakdown.labels.length > 0) {
                const ctx = document.getElementById('riskChart');
                if (ctx) {
                    const filteredLabels = [];
                    const filteredValues = [];
                    const filteredColors = [];
                    const colors = { 'Low': '#198754', 'Medium': '#ffc107', 'High': '#dc3545' };

                    data.risk_breakdown.labels.forEach((label, index) => {
                        const value = data.risk_breakdown.values[index];
                        if (value > 0) {
                            filteredLabels.push(label);
                            filteredValues.push(value);
                            filteredColors.push(colors[label] || '#6c757d');
                        }
                    });

                    if (filteredLabels.length > 0) {
                        riskChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: filteredLabels,
                                datasets: [{ data: filteredValues, backgroundColor: filteredColors }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { position: 'bottom' } }
                            }
                        });
                    }
                }
            }

            // Record Count
            const start = (currentPage - 1) * limit + 1;
            const end = Math.min(currentPage * limit, data.pagination?.total_records || 0);
            const total = data.pagination?.total_records || 0;
            document.getElementById('recordCount').textContent =
                total > 0 ? `Showing ${start}-${end} of ${total} records` : 'No records found';

            // ✅ FIXED: Table with event delegation
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

                // ✅ CRITICAL: Attach event listener to tbody (event delegation)
                tbody.removeEventListener('click', handleViewButtonClick);
                tbody.addEventListener('click', handleViewButtonClick);
                
            } else {
                const filterMsg = currentFilters.cardFilter !== 'all' ?
                    ` matching "${filterIndicator.textContent}"` : '';
                tbody.innerHTML = `<tr><td colspan="13" class="text-center text-muted"><i class="bi bi-inbox"></i> No loans found${filterMsg}</td></tr>`;
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

        // Clickable Stat Cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('click', function() {
                const filter = this.dataset.filter;
                document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));

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

        // Filter listeners
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
            currentFilters = { search: '', status: '', risk: '', type: '', cardFilter: 'all' };
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('riskFilter').value = '';
            document.getElementById('typeFilter').value = '';
            document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
            currentPage = 1;
            loadData();
        });

        document.getElementById('reloadBtn').addEventListener('click', () => loadData());

        // Export PDF
        document.getElementById('exportPdfBtn').addEventListener('click', function() {
            if (allLoans.length === 0) {
                alert('No data to export');
                return;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');

            doc.setFontSize(18);
            doc.setTextColor(40, 40, 40);
            doc.text('Repayment Tracker Report', 14, 15);

            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text(`Generated: ${new Date().toLocaleString()}`, 14, 22);

            doc.setFontSize(12);
            doc.setTextColor(40, 40, 40);
            doc.text('Summary', 14, 32);

            doc.setFontSize(10);
            const totalLoans = document.getElementById('card_total_loans').textContent;
            const activeLoans = document.getElementById('card_active_loans').textContent;
            const overdueLoans = document.getElementById('card_overdue_loans').textContent;
            const atRiskLoans = document.getElementById('card_at_risk_loans').textContent;

            doc.text(`Total Loans: ${totalLoans}`, 14, 38);
            doc.text(`Active: ${activeLoans}`, 70, 38);
            doc.text(`Overdue: ${overdueLoans}`, 126, 38);
            doc.text(`At Risk: ${atRiskLoans}`, 182, 38);

            if (currentFilters.cardFilter !== 'all') {
                doc.setFontSize(9);
                doc.setTextColor(200, 0, 0);
                doc.text(`Filter Applied: ${filterIndicator.textContent}`, 14, 44);
            }

            const tableData = allLoans.map(l => [
                l.loan_id,
                l.member_name,
                l.loan_type,
                `₱${Number(l.principal_amount).toLocaleString()}`,
                `${l.interest_rate}%`,
                `${l.loan_term} mo`,
                l.start_date,
                l.status,
                l.overdue_count || 0,
                l.risk_level
            ]);

            doc.autoTable({
                startY: currentFilters.cardFilter !== 'all' ? 48 : 44,
                head: [['ID', 'Member', 'Type', 'Principal', 'Rate', 'Term', 'Start', 'Status', 'Overdue', 'Risk']],
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

            doc.save(`repayment_tracker_${new Date().toISOString().split('T')[0]}.pdf`);
        });

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), wait);
            };
        }

        // INITIAL LOAD
        loadData();
    });
</script>

<?php include(__DIR__ . '/../inc/footer.php'); ?>