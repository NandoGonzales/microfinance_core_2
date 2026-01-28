<?php
require_once(__DIR__ . '/../inc/header.php');
require_once(__DIR__ . '/../inc/navbar.php');
require_once(__DIR__ . '/../inc/sidebar.php');
require_once(__DIR__ . '/../../initialize_coreT2.php');
require_once(__DIR__ . '/../inc/sess_auth.php');
require_once(__DIR__ . '/../inc/access_control.php');
require_once(__DIR__ . '/../inc/check_auth.php');


?>

<main class="main-content" id="main-content">
  <div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3><i class="bi bi-activity"></i> Permission & User Audit Logs</h3>
      <a id="exportCsvBtn" href="permission_logs_action.php?export=csv" class="btn btn-success">
        <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
      </a>
    </div>

    <!-- Filters -->
    <form id="filterForm" class="row g-3 mb-3 align-items-end">
      <div class="col-md-3">
        <label for="start" class="form-label">Start Date</label>
        <input type="date" id="start" name="start" class="form-control">
      </div>
      <div class="col-md-3">
        <label for="end" class="form-label">End Date</label>
        <input type="date" id="end" name="end" class="form-control">
      </div>
      <div class="col-md-3">
        <label for="rowsPerPage" class="form-label">Rows Per Page</label>
        <select id="rowsPerPage" name="rowsPerPage" class="form-select">
          <option value="5">5 rows</option>
          <option value="10" selected>10 rows</option>
          <option value="25">25 rows</option>
          <option value="50">50 rows</option>
          <option value="100">100 rows</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="button" id="filterBtn" class="btn btn-primary me-2">
          <i class="bi bi-funnel"></i> Filter
        </button>
        <button type="button" id="resetBtn" class="btn btn-secondary">
          <i class="bi bi-arrow-clockwise"></i> Reset
        </button>
      </div>
    </form>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="text-center my-5" style="display: none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-2">Loading logs...</p>
    </div>

    <!-- Table -->
    <div class="table-responsive shadow-sm">
      <table class="table table-hover table-striped align-middle text-center" id="logsTable">
        <thead class="table-dark">
          <tr>
            <th>Audit ID</th>
            <th>Username</th>
            <th>Action</th>
            <th>Module</th>
            <th>Remarks</th>
            <th>IP Address</th>
            <th>Date / Time</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="7" class="text-muted">Loading...</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Logs pagination">
      <ul class="pagination justify-content-center mt-3" id="logsPagination"></ul>
    </nav>

    <!-- Results Info -->
    <div class="text-center text-muted mt-2" id="resultsInfo"></div>
  </div>
</main>

<?php include(__DIR__ . '/../inc/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Toast configuration
  const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer);
      toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
  });

  // DOM Elements
  const tbody = document.querySelector('#logsTable tbody');
  const pagination = document.getElementById('logsPagination');
  const resultsInfo = document.getElementById('resultsInfo');
  const startInput = document.getElementById('start');
  const endInput = document.getElementById('end');
  const rowsPerPageSelect = document.getElementById('rowsPerPage');
  const exportBtn = document.getElementById('exportCsvBtn');
  const filterBtn = document.getElementById('filterBtn');
  const resetBtn = document.getElementById('resetBtn');
  const loadingSpinner = document.getElementById('loadingSpinner');

  // State
  let currentPage = 1;
  let limit = parseInt(rowsPerPageSelect.value);

  // Helper functions
  const toastError = (msg) => Toast.fire({ icon: 'error', title: msg });
  const toastSuccess = (msg) => Toast.fire({ icon: 'success', title: msg });
  const toastInfo = (msg) => Toast.fire({ icon: 'info', title: msg });

  // Validate dates
  function validateDates() {
    const start = startInput.value;
    const end = endInput.value;

    if (!start || !end) return true;

    if (start > end) {
      toastError('Start date must be before or equal to End date');
      return false;
    }

    const today = new Date().toISOString().split('T')[0];
    if (start > today || end > today) {
      toastError('Cannot select future dates');
      return false;
    }

    return true;
  }

  // Build export link
  function buildExportLink(start, end) {
    let url = 'permission_logs_action.php?export=csv';
    if (start && end) {
      url += `&start=${encodeURIComponent(start)}&end=${encodeURIComponent(end)}`;
    }
    return url;
  }

  // Show/hide loading
  function setLoading(isLoading) {
    if (isLoading) {
      loadingSpinner.style.display = 'block';
      tbody.innerHTML = '<tr><td colspan="7" class="text-muted">Loading...</td></tr>';
      filterBtn.disabled = true;
      resetBtn.disabled = true;
      rowsPerPageSelect.disabled = true;
    } else {
      loadingSpinner.style.display = 'none';
      filterBtn.disabled = false;
      resetBtn.disabled = false;
      rowsPerPageSelect.disabled = false;
    }
  }

  // Update results info
  function updateResultsInfo(page, total, limit) {
    const start = (page - 1) * limit + 1;
    const end = Math.min(page * limit, total);
    
    if (total === 0) {
      resultsInfo.innerHTML = 'No records found';
    } else {
      resultsInfo.innerHTML = `Showing ${start} to ${end} of ${total} records`;
    }
  }

  // Escape HTML to prevent XSS
  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  // Load logs function
  async function loadLogs(page = 1) {
    if (!validateDates()) return;

    currentPage = page;
    limit = parseInt(rowsPerPageSelect.value);
    setLoading(true);

    const params = new URLSearchParams({
      action: 'list',
      page: page.toString(),
      limit: limit.toString(),
      start: startInput.value || '',
      end: endInput.value || ''
    });

    try {
      const response = await fetch('permission_logs_action.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString()
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      if (data.status !== 'ok') {
        toastError(data.msg || 'Failed to load logs');
        tbody.innerHTML = '<tr><td colspan="7" class="text-danger">Error loading data</td></tr>';
        console.error('API Error:', data);
        return;
      }

      const rows = data.rows || [];
      tbody.innerHTML = '';

      if (rows.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-muted">No logs found for the selected filters.</td></tr>';
        pagination.innerHTML = '';
        updateResultsInfo(0, 0, limit);
      } else {
        // Populate table rows
        rows.forEach(r => {
          const actionType = r.action_type || 'N/A';
          const badgeClass = 
            actionType.toLowerCase().includes('failed') || 
            actionType.toLowerCase().includes('denied') ||
            actionType.toLowerCase().includes('error')
              ? 'bg-danger'
              : actionType.toLowerCase().includes('success') ||
                actionType.toLowerCase().includes('login')
                ? 'bg-success'
                : 'bg-info';

          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${escapeHtml(r.audit_id || 'N/A')}</td>
            <td>${escapeHtml(r.username || 'System')}</td>
            <td><span class="badge ${badgeClass}">${escapeHtml(actionType)}</span></td>
            <td>${escapeHtml(r.module_name || 'N/A')}</td>
            <td class="text-start" style="max-width:400px; white-space:normal;">
              ${escapeHtml(r.remarks || 'No remarks')}
            </td>
            <td>${escapeHtml(r.ip_address || 'N/A')}</td>
            <td>${escapeHtml(r.action_time || 'N/A')}</td>
          `;
          tbody.appendChild(row);
        });

        // Build pagination
        pagination.innerHTML = '';
        const totalPages = data.totalPages || Math.ceil((data.total || 0) / limit);
        
        if (totalPages > 1) {
          // Previous button
          const prevLi = document.createElement('li');
          prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
          prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">&laquo; Previous</a>`;
          pagination.appendChild(prevLi);

          // Page numbers
          const maxButtons = 7;
          let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
          let endPage = Math.min(totalPages, startPage + maxButtons - 1);

          if (endPage - startPage < maxButtons - 1) {
            startPage = Math.max(1, endPage - maxButtons + 1);
          }

          for (let i = startPage; i <= endPage; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
            pagination.appendChild(li);
          }

          // Next button
          const nextLi = document.createElement('li');
          nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
          nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Next &raquo;</a>`;
          pagination.appendChild(nextLi);
        }

        // Update results info
        updateResultsInfo(currentPage, data.total || 0, limit);
      }

      // Update export link
      exportBtn.href = buildExportLink(startInput.value, endInput.value);

    } catch (error) {
      console.error('Fetch error:', error);
      toastError('Failed to load logs. Please try again.');
      tbody.innerHTML = '<tr><td colspan="7" class="text-danger">Network error. Please check your connection.</td></tr>';
    } finally {
      setLoading(false);
    }
  }

  // Event: Rows per page change
  rowsPerPageSelect.addEventListener('change', () => {
    toastInfo(`Changed to ${rowsPerPageSelect.value} rows per page`);
    loadLogs(1); // Reset to page 1 when changing rows per page
  });

  // Event: Filter button
  filterBtn.addEventListener('click', (e) => {
    e.preventDefault();
    if (validateDates()) {
      toastInfo('Applying filters...');
      loadLogs(1);
    }
  });

  // Event: Reset button
  resetBtn.addEventListener('click', () => {
    startInput.value = '';
    endInput.value = '';
    rowsPerPageSelect.value = '10';
    toastInfo('Filters cleared');
    loadLogs(1);
  });

  // Event: Pagination clicks
  pagination.addEventListener('click', (e) => {
    e.preventDefault();
    const target = e.target;
    
    if (target.tagName === 'A' && target.dataset.page) {
      const page = parseInt(target.dataset.page);
      if (page >= 1) {
        loadLogs(page);
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    }
  });

  // Event: Enter key in date inputs
  startInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      filterBtn.click();
    }
  });

  endInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      filterBtn.click();
    }
  });

  // Initial load
  loadLogs(1);
});
</script>