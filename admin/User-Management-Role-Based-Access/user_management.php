<?php
require_once(__DIR__ . '/../../initialize_coreT2.php');
require_once(__DIR__ . '/../inc/sess_auth.php');
require_once(__DIR__ . '/../inc/access_control.php');
require_once __DIR__ . '/../inc/check_auth.php';

checkPermission('user_management');

include(__DIR__ . '/../inc/header.php');
include(__DIR__ . '/../inc/navbar.php');
include(__DIR__ . '/../inc/sidebar.php');

?>
<main class="main-content" id="main-content">
  <div class="content-wrapper p-4">
    <h2>User Management</h2>

    <!-- Summary Cards -->
    <div class="row mb-4">
      <div class="col-md-2">
        <div class="card text-white bg-primary clickable-card" data-filter="all" style="cursor: pointer;">
          <div class="card-body">
            <h6>Total Users</h6>
            <h3 class="card-text mb-0" id="totalUsersCard">0</h3>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card text-white bg-success clickable-card" data-filter="Active" style="cursor: pointer;">
          <div class="card-body">
            <h6>Active Users</h6>
            <h3 class="card-text mb-0" id="activeUsersCard">0</h3>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card text-white bg-danger clickable-card" data-filter="Inactive" style="cursor: pointer;">
          <div class="card-body">
            <h6>Inactive Users</h6>
            <h3 class="card-text mb-0" id="inactiveUsersCard">0</h3>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card text-white bg-info clickable-card" data-filter-role="Super Admin" style="cursor: pointer;">
          <div class="card-body">
            <h6>Super Admin</h6>
            <h3 class="card-text mb-0" id="superAdminCard">0</h3>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card text-white bg-secondary clickable-card" data-filter-role="Admin" style="cursor: pointer;">
          <div class="card-body">
            <h6>Admin</h6>
            <h3 class="card-text mb-0" id="adminCard">0</h3>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card text-white bg-warning clickable-card" data-filter-role="Staff" style="cursor: pointer;">
          <div class="card-body">
            <h6>Staff</h6>
            <h3 class="card-text mb-0" id="staffCard">0</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-2">
        <div class="card text-white bg-dark clickable-card" data-filter-role="Client" style="cursor: pointer;">
          <div class="card-body">
            <h6>Client</h6>
            <h3 class="card-text mb-0" id="clientCard">0</h3>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card text-white clickable-card" data-filter-role="Distributor" style="background-color: #6f42c1; cursor: pointer;">
          <div class="card-body">
            <h6>Distributor</h6>
            <h3 class="card-text mb-0" id="distributorCard">0</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Controls -->
    <div class="row mb-3">
      <div class="col-md-3">
        <button class="btn btn-primary" id="addUserBtn">
          <i class="fas fa-plus"></i> Add User
        </button>
        <button class="btn btn-secondary" id="resetFiltersBtn">
          <i class="fas fa-redo"></i> Reset Filters
        </button>
      </div>
      <div class="col-md-9">
        <div class="row">
          <div class="col-md-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
          </div>
          <div class="col-md-3">
            <select id="roleFilter" class="form-control">
              <option value="">All Roles</option>
              <option value="Super Admin">Super Admin</option>
              <option value="Admin">Admin</option>
              <option value="Staff">Staff</option>
              <option value="Client">Client</option>
              <option value="Distributor">Distributor</option>
            </select>
          </div>
          <div class="col-md-3">
            <select id="statusFilter" class="form-control">
              <option value="">All Status</option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
          <div class="col-md-2">
            <select id="rowsPerPage" class="form-control">
              <option value="10">10 rows</option>
              <option value="25">25 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
              <option value="all">All rows</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Filters Display -->
    <div id="activeFilters" class="mb-3"></div>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="userTableBody">
          <tr>
            <td colspan="8" class="text-center">Loading...</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="row">
      <div class="col-md-6">
        <p id="showingInfo" class="text-muted"></p>
      </div>
      <div class="col-md-6">
        <nav>
          <ul class="pagination justify-content-end" id="pagination"></ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form id="userForm">
          <div class="modal-header">
            <h5 class="modal-title" id="userModalTitle">Add User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="user_id" id="user_id">
            <div class="mb-3">
              <label class="form-label">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password <span class="text-danger" id="passwordRequired">*</span></label>
              <input type="password" name="password" id="password" class="form-control">
              <small class="text-muted" id="passwordHelp" style="display: none;">Leave blank to keep current password.</small>
            </div>
            <div class="mb-3">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <input type="text" name="full_name" id="full_name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Role <span class="text-danger">*</span></label>
              <select name="role" id="role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="Super Admin">Super Admin</option>
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
                <option value="Client">Client</option>
                <option value="Distributor">Distributor</option>
              </select>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" name="status" id="status" class="form-check-input" checked>
              <label class="form-check-label">Active</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">
              <i class="fas fa-save"></i> Save
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="fas fa-times"></i> Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php include(__DIR__ . '/../inc/footer.php'); ?>

<style>
  .clickable-card:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  }
  .clickable-card.active-filter {
    border: 3px solid #ffc107;
    box-shadow: 0 0 10px rgba(255,193,7,0.5);
  }
  .badge-filter {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
  }
</style>

<script>
  const userModal = new bootstrap.Modal(document.getElementById('userModal'));
  let currentUserId = null;
  let allUsers = [];
  let filteredUsers = [];
  let currentPage = 1;
  let rowsPerPage = 10;
  
  // Filter state
  let filters = {
    search: '',
    role: '',
    status: ''
  };

  function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  function loadUsers() {
    document.getElementById('userTableBody').innerHTML = '<tr><td colspan="8" class="text-center">Loading...</td></tr>';
    
    fetch('user_action.php?action=list')
      .then(res => res.json())
      .then(data => {
        if (data.users) {
          allUsers = data.users;
          applyFilters();
          updateSummaryCards();
        } else {
          allUsers = [];
          filteredUsers = [];
          renderTable();
          updateSummaryCards();
        }
      })
      .catch(err => {
        console.error('Error loading users:', err);
        Swal.fire('Error', 'Failed to load users. Please try again.', 'error');
        document.getElementById('userTableBody').innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error loading users</td></tr>';
      });
  }

  function applyFilters() {
    filteredUsers = allUsers.filter(user => {
      // Search filter
      if (filters.search) {
        const searchLower = filters.search.toLowerCase();
        const matchSearch = 
          user.username.toLowerCase().includes(searchLower) ||
          user.full_name.toLowerCase().includes(searchLower) ||
          (user.email && user.email.toLowerCase().includes(searchLower)) ||
          user.user_id.toString().includes(searchLower);
        if (!matchSearch) return false;
      }
      
      // Role filter
      if (filters.role && user.role !== filters.role) {
        return false;
      }
      
      // Status filter
      if (filters.status && user.status !== filters.status) {
        return false;
      }
      
      return true;
    });
    
    currentPage = 1;
    renderTable();
    updateActiveFiltersDisplay();
  }

  function renderTable() {
    const tbody = document.getElementById('userTableBody');
    tbody.innerHTML = '';
    
    if (filteredUsers.length === 0) {
      tbody.innerHTML = '<tr><td colspan="8" class="text-center">No users found</td></tr>';
      updatePagination();
      return;
    }
    
    const start = rowsPerPage === 'all' ? 0 : (currentPage - 1) * parseInt(rowsPerPage);
    const end = rowsPerPage === 'all' ? filteredUsers.length : start + parseInt(rowsPerPage);
    const pageUsers = filteredUsers.slice(start, end);
    
    pageUsers.forEach(u => {
      const statusBadge = u.status === 'Active' 
        ? '<span class="badge bg-success">Active</span>' 
        : '<span class="badge bg-danger">Inactive</span>';
      
      tbody.innerHTML += `
        <tr>
          <td>${escapeHtml(u.user_id)}</td>
          <td>${escapeHtml(u.username)}</td>
          <td>${escapeHtml(u.full_name)}</td>
          <td>${escapeHtml(u.email)}</td>
          <td><span class="badge bg-info">${escapeHtml(u.role)}</span></td>
          <td>${statusBadge}</td>
          <td>${escapeHtml(u.date_created)}</td>
          <td>
            <button class="btn btn-sm btn-warning editBtn" data-id="${u.user_id}" title="Edit">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger deleteBtn" data-id="${u.user_id}" title="Delete">
              <i class="fas fa-trash"></i>
            </button>
            <button class="btn btn-sm btn-secondary toggleBtn" data-id="${u.user_id}" data-status="${u.status}" title="${u.status === 'Active' ? 'Deactivate' : 'Activate'}">
              <i class="fas fa-${u.status === 'Active' ? 'ban' : 'check'}"></i>
            </button>
          </td>
        </tr>`;
    });
    
    updatePagination();
  }

  function updatePagination() {
    const totalPages = rowsPerPage === 'all' ? 1 : Math.ceil(filteredUsers.length / parseInt(rowsPerPage));
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    
    if (totalPages <= 1) {
      document.getElementById('showingInfo').textContent = `Showing ${filteredUsers.length} of ${filteredUsers.length} users`;
      return;
    }
    
    // Previous button
    pagination.innerHTML += `
      <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
      </li>`;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
        pagination.innerHTML += `
          <li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${i}">${i}</a>
          </li>`;
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagination.innerHTML += `<li class="page-item disabled"><a class="page-link">...</a></li>`;
      }
    }
    
    // Next button
    pagination.innerHTML += `
      <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
      </li>`;
    
    const start = (currentPage - 1) * parseInt(rowsPerPage) + 1;
    const end = Math.min(currentPage * parseInt(rowsPerPage), filteredUsers.length);
    document.getElementById('showingInfo').textContent = `Showing ${start} to ${end} of ${filteredUsers.length} users`;
  }

  function updateSummaryCards() {
    let total = 0, active = 0, inactive = 0;
    let superAdmin = 0, admin = 0, staff = 0, client = 0, distributor = 0;
    
    allUsers.forEach(u => {
      total++;
      if (u.status === 'Active') active++;
      else inactive++;
      
      switch(u.role) {
        case 'Super Admin': superAdmin++; break;
        case 'Admin': admin++; break;
        case 'Staff': staff++; break;
        case 'Client': client++; break;
        case 'Distributor': distributor++; break;
      }
    });
    
    document.getElementById('totalUsersCard').innerText = total;
    document.getElementById('activeUsersCard').innerText = active;
    document.getElementById('inactiveUsersCard').innerText = inactive;
    document.getElementById('superAdminCard').innerText = superAdmin;
    document.getElementById('adminCard').innerText = admin;
    document.getElementById('staffCard').innerText = staff;
    document.getElementById('clientCard').innerText = client;
    document.getElementById('distributorCard').innerText = distributor;
  }

  function updateActiveFiltersDisplay() {
    const container = document.getElementById('activeFilters');
    let html = '';
    
    if (filters.search) {
      html += `<span class="badge bg-primary badge-filter">Search: "${escapeHtml(filters.search)}" <i class="fas fa-times" style="cursor: pointer;" onclick="clearFilter('search')"></i></span>`;
    }
    if (filters.role) {
      html += `<span class="badge bg-info badge-filter">Role: ${escapeHtml(filters.role)} <i class="fas fa-times" style="cursor: pointer;" onclick="clearFilter('role')"></i></span>`;
    }
    if (filters.status) {
      html += `<span class="badge bg-success badge-filter">Status: ${escapeHtml(filters.status)} <i class="fas fa-times" style="cursor: pointer;" onclick="clearFilter('status')"></i></span>`;
    }
    
    container.innerHTML = html;
    
    // Update card highlights
    document.querySelectorAll('.clickable-card').forEach(card => {
      card.classList.remove('active-filter');
    });
    
    if (filters.status) {
      document.querySelector(`[data-filter="${filters.status}"]`)?.classList.add('active-filter');
    }
    if (filters.role) {
      document.querySelector(`[data-filter-role="${filters.role}"]`)?.classList.add('active-filter');
    }
  }

  window.clearFilter = function(filterType) {
    if (filterType === 'search') {
      filters.search = '';
      document.getElementById('searchInput').value = '';
    } else if (filterType === 'role') {
      filters.role = '';
      document.getElementById('roleFilter').value = '';
    } else if (filterType === 'status') {
      filters.status = '';
      document.getElementById('statusFilter').value = '';
    }
    applyFilters();
  }

  // Event Listeners
  document.getElementById('searchInput').addEventListener('input', function() {
    filters.search = this.value;
    applyFilters();
  });

  document.getElementById('roleFilter').addEventListener('change', function() {
    filters.role = this.value;
    applyFilters();
  });

  document.getElementById('statusFilter').addEventListener('change', function() {
    filters.status = this.value;
    applyFilters();
  });

  document.getElementById('rowsPerPage').addEventListener('change', function() {
    rowsPerPage = this.value;
    currentPage = 1;
    renderTable();
  });

  document.getElementById('pagination').addEventListener('click', function(e) {
    e.preventDefault();
    if (e.target.tagName === 'A' && e.target.dataset.page) {
      currentPage = parseInt(e.target.dataset.page);
      renderTable();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  });

  document.getElementById('resetFiltersBtn').addEventListener('click', function() {
    filters = { search: '', role: '', status: '' };
    document.getElementById('searchInput').value = '';
    document.getElementById('roleFilter').value = '';
    document.getElementById('statusFilter').value = '';
    applyFilters();
  });

  // Clickable summary cards
  document.querySelectorAll('.clickable-card').forEach(card => {
    card.addEventListener('click', function() {
      const filterType = this.dataset.filter;
      const filterRole = this.dataset.filterRole;
      
      if (filterType) {
        if (filterType === 'all') {
          filters.status = '';
          document.getElementById('statusFilter').value = '';
        } else {
          filters.status = filterType;
          document.getElementById('statusFilter').value = filterType;
        }
      }
      
      if (filterRole) {
        filters.role = filterRole;
        document.getElementById('roleFilter').value = filterRole;
      }
      
      applyFilters();
    });
  });

  document.getElementById('addUserBtn').addEventListener('click', () => {
    currentUserId = null;
    document.getElementById('userForm').reset();
    document.getElementById('userModalTitle').innerText = 'Add User';
    document.getElementById('password').setAttribute('required', 'required');
    document.getElementById('passwordRequired').style.display = 'inline';
    document.getElementById('passwordHelp').style.display = 'none';
    document.getElementById('role').value = '';
    userModal.show();
  });

  document.getElementById('userForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fd.append('action', currentUserId ? 'edit' : 'add');
    fd.append('status', document.getElementById('status').checked ? 'Active' : 'Inactive');
    if (currentUserId) fd.append('user_id', currentUserId);
    
    fetch('user_action.php', {
      method: 'POST',
      body: fd
    })
    .then(res => res.json())
    .then(resp => {
      if (resp.status === 'success') {
        Swal.fire('Success', resp.msg, 'success');
        userModal.hide();
        loadUsers();
      } else {
        Swal.fire('Error', resp.msg, 'error');
      }
    })
    .catch(err => {
      console.error('Error:', err);
      Swal.fire('Error', 'Failed to save user. Please try again.', 'error');
    });
  });

  document.getElementById('userTableBody').addEventListener('click', function(e) {
    const btn = e.target.closest('button');
    if (!btn) return;
    
    const id = btn.dataset.id;
    
    if (btn.classList.contains('editBtn')) {
      fetch('user_action.php?action=get&id=' + id)
        .then(res => res.json())
        .then(u => {
          currentUserId = u.user_id;
          document.getElementById('userModalTitle').innerText = 'Edit User';
          document.getElementById('username').value = u.username;
          document.getElementById('full_name').value = u.full_name;
          document.getElementById('email').value = u.email || '';
          document.getElementById('role').value = u.role;
          document.getElementById('status').checked = u.status === 'Active';
          document.getElementById('password').value = '';
          document.getElementById('password').removeAttribute('required');
          document.getElementById('passwordRequired').style.display = 'none';
          document.getElementById('passwordHelp').style.display = 'block';
          userModal.show();
        })
        .catch(err => {
          console.error('Error:', err);
          Swal.fire('Error', 'Failed to load user data.', 'error');
        });
    }
    
    if (btn.classList.contains('deleteBtn')) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          const fd = new FormData();
          fd.append('action', 'delete');
          fd.append('id', id);
          fetch('user_action.php', {
            method: 'POST',
            body: fd
          })
          .then(res => res.json())
          .then(resp => {
            if (resp.status === 'success') {
              Swal.fire('Deleted!', resp.msg, 'success');
              loadUsers();
            } else {
              Swal.fire('Error', resp.msg, 'error');
            }
          })
          .catch(err => {
            console.error('Error:', err);
            Swal.fire('Error', 'Failed to delete user.', 'error');
          });
        }
      });
    }
    
    if (btn.classList.contains('toggleBtn')) {
      const status = btn.dataset.status === 'Active' ? 'Inactive' : 'Active';
      const fd = new FormData();
      fd.append('action', 'toggle_status');
      fd.append('id', id);
      fd.append('status', status);
      fetch('user_action.php', {
        method: 'POST',
        body: fd
      })
      .then(res => res.json())
      .then(resp => {
        if (resp.status === 'success') {
          Swal.fire('Success', resp.msg, 'success');
          loadUsers();
        } else {
          Swal.fire('Error', resp.msg, 'error');
        }
      })
      .catch(err => {
        console.error('Error:', err);
        Swal.fire('Error', 'Failed to update user status.', 'error');
      });
    }
  });

  // Initialize
  loadUsers();
</script>