<?php
require_once(__DIR__ . '/../../initialize_coreT2.php');
require_once(__DIR__ . '/../inc/sess_auth.php');
require_once(__DIR__ . '/../inc/access_control.php');
require_once __DIR__ . '/../inc/check_auth.php';

// Enforce RBAC for this page
checkPermission('compliance_logs');

// Include layout
include(__DIR__ . '/../inc/header.php');
include(__DIR__ . '/../inc/navbar.php');
include(__DIR__ . '/../inc/sidebar.php');
?>

<main class="main-content" id="main-content">
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="bi bi-shield-check"></i> Compliance & Audit Trail Logs</h3>
            <a id="exportPdfBtn" href="#" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form id="filterForm" class="row g-3" onsubmit="return false;">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" id="search" name="search" class="form-control" placeholder="User, action, module...">
                    </div>
                    <div class="col-md-2">
                        <label for="start" class="form-label">Start Date</label>
                        <input type="date" id="start" name="start" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="end" class="form-label">End Date</label>
                        <input type="date" id="end" name="end" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">All</option>
                            <option value="Compliant">Compliant</option>
                            <option value="Non-Compliant">Non-Compliant</option>
                            <option value="Under Review">Under Review</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="rowsPerPage" class="form-label">Rows</label>
                        <select id="rowsPerPage" name="rowsPerPage" class="form-select">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button id="filterBtn" class="btn btn-primary w-100"><i class="bi bi-funnel"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0" id="logsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Module</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Date/Time</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="8" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small" id="recordInfo">Showing 0 to 0 of 0 entries</div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0" id="logsPagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include(__DIR__ . '/../inc/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 2200,
        timerProgressBar: true
    });

    const tbody = document.querySelector('#logsTable tbody');
    const pagination = document.getElementById('logsPagination');
    const recordInfo = document.getElementById('recordInfo');
    const searchInput = document.getElementById('search');
    const startInput = document.getElementById('start');
    const endInput = document.getElementById('end');
    const statusInput = document.getElementById('status');
    const rowsInput = document.getElementById('rowsPerPage');
    const exportBtn = document.getElementById('exportPdfBtn');

    let currentPage = 1;
    let currentLimit = 10;
    let currentFilters = {};

    function toastError(msg) { 
        Toast.fire({ icon: 'error', title: msg }); 
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text ? String(text).replace(/[&<>"']/g, m => map[m]) : '-';
    }

    function buildExportLink(search, start, end, status) {
        const params = new URLSearchParams({
            export: 'pdf',
            search: search,
            start: start,
            end: end,
            status: status
        });
        return 'compliance_logs_action.php?' + params.toString();
    }

    function loadLogs(page = 1) {
        currentPage = page;
        currentLimit = parseInt(rowsInput.value);
        
        currentFilters = {
            action: 'list',
            page: page,
            limit: currentLimit,
            search: searchInput.value || '',
            start: startInput.value || '',
            end: endInput.value || '',
            status: statusInput.value || ''
        };

        const params = new URLSearchParams(currentFilters);

        tbody.innerHTML = '<tr><td colspan="8" class="text-center">Loading...</td></tr>';

        fetch('compliance_logs_action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: params.toString()
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'error') {
                toastError(data.msg || 'Failed to load logs');
                tbody.innerHTML = '<tr><td colspan="8" class="text-danger text-center">Error loading data</td></tr>';
                return;
            }

            tbody.innerHTML = '';
            const rows = data.rows || [];
            
            if (!rows.length) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-muted text-center py-4">No logs found.</td></tr>';
                recordInfo.textContent = 'Showing 0 to 0 of 0 entries';
            } else {
                const startRecord = ((currentPage - 1) * currentLimit) + 1;
                const endRecord = Math.min(startRecord + rows.length - 1, data.total);
                
                rows.forEach((r, index) => {
                    const badgeClass =
                        r.compliance_status === 'Compliant' ? 'bg-success' :
                        r.compliance_status === 'Non-Compliant' ? 'bg-danger' :
                        r.compliance_status === 'Pending' ? 'bg-warning text-dark' :
                        'bg-info text-dark';

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${startRecord + index}</td>
                        <td>${escapeHtml(r.full_name || r.username || 'System')}</td>
                        <td><small>${escapeHtml(r.action_type)}</small></td>
                        <td><small>${escapeHtml(r.module_name)}</small></td>
                        <td class="text-start"><small>${escapeHtml(r.remarks || '-')}</small></td>
                        <td><span class="badge ${badgeClass}">${escapeHtml(r.compliance_status)}</span></td>
                        <td><small>${escapeHtml(r.action_time)}</small></td>
                        <td><small>${escapeHtml(r.ip_address || '-')}</small></td>
                    `;
                    tbody.appendChild(tr);
                });

                recordInfo.textContent = `Showing ${startRecord} to ${endRecord} of ${data.total} entries`;
            }

            // Build pagination
            pagination.innerHTML = '';
            const totalPages = Math.max(1, Math.ceil((data.total || 0) / currentLimit));
            
            // Previous button
            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>`;
            pagination.appendChild(prevLi);
            
            // Page numbers (show max 5 pages)
            const maxPages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxPages / 2));
            let endPage = Math.min(totalPages, startPage + maxPages - 1);
            
            if (endPage - startPage < maxPages - 1) {
                startPage = Math.max(1, endPage - maxPages + 1);
            }
            
            if (startPage > 1) {
                const li = document.createElement('li');
                li.className = 'page-item';
                li.innerHTML = `<a class="page-link" href="#" data-page="1">1</a>`;
                pagination.appendChild(li);
                
                if (startPage > 2) {
                    const dots = document.createElement('li');
                    dots.className = 'page-item disabled';
                    dots.innerHTML = `<span class="page-link">...</span>`;
                    pagination.appendChild(dots);
                }
            }
            
            for (let i = startPage; i <= endPage; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
                pagination.appendChild(li);
            }
            
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    const dots = document.createElement('li');
                    dots.className = 'page-item disabled';
                    dots.innerHTML = `<span class="page-link">...</span>`;
                    pagination.appendChild(dots);
                }
                
                const li = document.createElement('li');
                li.className = 'page-item';
                li.innerHTML = `<a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>`;
                pagination.appendChild(li);
            }
            
            // Next button
            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>`;
            pagination.appendChild(nextLi);

            // Update export link
            exportBtn.href = buildExportLink(
                searchInput.value, 
                startInput.value, 
                endInput.value, 
                statusInput.value
            );
        })
        .catch(error => { 
            console.error('Error:', error); 
            toastError('Failed to load data. Please try again.');
            tbody.innerHTML = '<tr><td colspan="8" class="text-danger text-center">Failed to load data</td></tr>';
        });
    }

    // Initial load
    loadLogs();

    // Filter button
    document.getElementById('filterBtn').addEventListener('click', e => {
        e.preventDefault();
        
        if (startInput.value && endInput.value && startInput.value > endInput.value) {
            return toastError('Start date must be before end date.');
        }
        
        loadLogs(1);
    });

    // Rows per page change
    rowsInput.addEventListener('change', () => {
        loadLogs(1);
    });

    // Search on Enter key
    searchInput.addEventListener('keypress', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            loadLogs(1);
        }
    });

    // Pagination click handler
    pagination.addEventListener('click', e => {
        e.preventDefault();
        
        if (e.target.tagName === 'A' && !e.target.parentElement.classList.contains('disabled')) {
            const page = parseInt(e.target.dataset.page);
            if (page > 0) {
                loadLogs(page);
            }
        }
    });
});
</script>