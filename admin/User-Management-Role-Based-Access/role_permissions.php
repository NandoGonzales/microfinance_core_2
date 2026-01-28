<?php
require_once(__DIR__ . '/../../initialize_coreT2.php');
require_once(__DIR__ . '/../inc/sess_auth.php');
require_once(__DIR__ . '/../inc/access_control.php');
require_once(__DIR__ . '/../inc/check_auth.php');

// ✅ Use centralized access control (shows RED modal with detailed message)
checkPermission('role_permissions');

// ==========================
// Fetch user's role from DB
// ==========================
$user_id = $_SESSION['userdata']['user_id'] ?? 0;
$stmt = $conn->prepare("
    SELECT u.role, ur.role_name, ur.role_id
    FROM users u
    LEFT JOIN user_roles ur ON u.role_id = ur.role_id
    WHERE u.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch all roles for dropdown
$roles_query = "SELECT role_id, role_name FROM user_roles ORDER BY role_name";
$roles_result = $conn->query($roles_query);
$roles = [];
while ($role = $roles_result->fetch_assoc()) {
    $roles[] = $role;
}

// Fetch all distinct modules for suggestions
$modules_query = "SELECT DISTINCT module_name FROM role_permissions ORDER BY module_name";
$modules_result = $conn->query($modules_query);
$modules = [];
while ($module = $modules_result->fetch_assoc()) {
    $modules[] = $module['module_name'];
}

// Include your layout files
include(__DIR__ . '/../inc/header.php');
include(__DIR__ . '/../inc/navbar.php');
include(__DIR__ . '/../inc/sidebar.php');
?>

<main class="main-content" id="main-content">
  <div class="container-fluid mt-4">

    <!-- Info Cards -->
    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0" style="background:linear-gradient(135deg,#1976d2,#64b5f6);color:white;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Total Permissions</h5>
              <h2 class="card-text" id="totalPermCount">0</h2>
            </div>
            <i class="bi bi-shield-lock fs-2"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0" style="background:linear-gradient(135deg,#4caf50,#81c784);color:white;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Modules</h5>
              <h2 class="card-text" id="moduleCount">0</h2>
            </div>
            <i class="bi bi-grid fs-2"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0" style="background:linear-gradient(135deg,#f57c00,#ffb74d);color:white;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Roles</h5>
              <h2 class="card-text" id="roleCount">0</h2>
            </div>
            <i class="bi bi-people-fill fs-2"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>Role Permissions Management</h3>
      <button class="btn btn-primary" id="addPermissionBtn">
        <i class="bi bi-plus-circle"></i> Add Permission
      </button>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <div class="row g-2">
          <div class="col-md-4">
            <select class="form-select" id="filterRole">
              <option value="">Filter by Role...</option>
              <?php foreach ($roles as $role): ?>
                <option value="<?= $role['role_id'] ?>"><?= htmlspecialchars($role['role_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
            <select class="form-select" id="filterModule">
              <option value="">Filter by Module...</option>
              <?php foreach ($modules as $module): ?>
                <option value="<?= htmlspecialchars($module) ?>"><?= htmlspecialchars($module) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
            <button class="btn btn-secondary w-100" id="clearFilter">
              <i class="bi bi-x-circle"></i> Clear Filters
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="table-responsive shadow-sm">
      <table class="table table-hover text-center align-middle" id="permTable">
        <thead class="table-dark">
          <tr>
            <th>Role</th>
            <th>Module</th>
            <th>View</th>
            <th>Add</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="7" class="text-center">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- Modal -->
<div class="modal fade" id="permModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="permModalLabel">Add Permission</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="permForm">
        <input type="hidden" id="permission_id" name="permission_id">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
              <select class="form-select" id="role_id" name="role_id" required>
                <option value="">Select Role</option>
                <?php foreach ($roles as $role): ?>
                  <option value="<?= $role['role_id'] ?>"><?= htmlspecialchars($role['role_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="module" class="form-label">Module <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="module" name="module" 
                     placeholder="e.g., User Management" list="moduleList" required>
              <datalist id="moduleList">
                <option value="User Management">
                <option value="Loan Portfolio">
                <option value="Savings Monitoring">
                <option value="Disbursement Tracker">
                <option value="Repayment Tracker">
                <option value="Compliance & Audit Trail">
                <?php foreach ($modules as $module): ?>
                  <option value="<?= htmlspecialchars($module) ?>">
                <?php endforeach; ?>
              </datalist>
            </div>
          </div>

          <div class="mt-4">
            <label class="fw-bold mb-3 d-block">Permissions</label>
            <div class="row g-3">
              <div class="col-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="can_view" id="can_view">
                  <label class="form-check-label" for="can_view">
                    <i class="bi bi-eye"></i> View
                  </label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="can_add" id="can_add">
                  <label class="form-check-label" for="can_add">
                    <i class="bi bi-plus-circle"></i> Add
                  </label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="can_edit" id="can_edit">
                  <label class="form-check-label" for="can_edit">
                    <i class="bi bi-pencil"></i> Edit
                  </label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="can_delete" id="can_delete">
                  <label class="form-check-label" for="can_delete">
                    <i class="bi bi-trash"></i> Delete
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Save
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include(__DIR__ . '/../inc/footer.php'); ?>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#permTable tbody');
    const totalPermCount = document.getElementById('totalPermCount');
    const roleCount = document.getElementById('roleCount');
    const moduleCount = document.getElementById('moduleCount');
    const filterRole = document.getElementById('filterRole');
    const filterModule = document.getElementById('filterModule');
    const clearFilterBtn = document.getElementById('clearFilter');

    let allPermissions = [];

    function loadPermissions() {
      fetch('role_permissions_action.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            action: 'list'
          })
        })
        .then(r => {
          if (!r.ok) throw new Error('Network response was not ok');
          return r.json();
        })
        .then(data => {
          allPermissions = data;
          displayPermissions(data);
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error', 'Failed to load permissions', 'error');
          tbody.innerHTML = '<tr><td colspan="7" class="text-danger">Error loading permissions</td></tr>';
        });
    }

    function displayPermissions(data) {
      tbody.innerHTML = '';
      
      if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-muted">No permissions defined yet</td></tr>';
        totalPermCount.textContent = '0';
        roleCount.textContent = '0';
        moduleCount.textContent = '0';
      } else {
        let roles = new Set(),
          modules = new Set();
        
        data.forEach(p => {
          roles.add(p.role_name || p.role);
          modules.add(p.module_name);
          
          tbody.innerHTML += `
            <tr>
              <td><span class="badge bg-secondary">${escapeHtml(p.role_name || p.role)}</span></td>
              <td><strong>${escapeHtml(p.module_name)}</strong></td>
              <td>${p.can_view == 1 ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle text-muted"></i>'}</td>
              <td>${p.can_add == 1 ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle text-muted"></i>'}</td>
              <td>${p.can_edit == 1 ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle text-muted"></i>'}</td>
              <td>${p.can_delete == 1 ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle text-muted"></i>'}</td>
              <td>
                <button class="btn btn-sm btn-info editBtn" data-id="${p.perm_id}" title="Edit">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn btn-sm btn-danger delBtn" data-id="${p.perm_id}" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>`;
        });
        
        totalPermCount.textContent = data.length;
        roleCount.textContent = roles.size;
        moduleCount.textContent = modules.size;
      }
    }

    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    function filterPermissions() {
      const roleFilter = filterRole.value;
      const moduleFilter = filterModule.value.toLowerCase();

      const filtered = allPermissions.filter(p => {
        const matchRole = !roleFilter || p.role_id == roleFilter;
        const matchModule = !moduleFilter || p.module_name.toLowerCase().includes(moduleFilter);
        return matchRole && matchModule;
      });

      displayPermissions(filtered);
    }

    // Event Listeners
    filterRole.addEventListener('change', filterPermissions);
    filterModule.addEventListener('change', filterPermissions);
    
    clearFilterBtn.addEventListener('click', () => {
      filterRole.value = '';
      filterModule.value = '';
      displayPermissions(allPermissions);
    });

    loadPermissions();

    document.getElementById('addPermissionBtn').addEventListener('click', () => {
      document.getElementById('permForm').reset();
      document.getElementById('permission_id').value = '';
      document.getElementById('permModalLabel').innerText = 'Add Permission';
      new bootstrap.Modal(document.getElementById('permModal')).show();
    });

    tbody.addEventListener('click', e => {
      if (e.target.closest('.editBtn')) {
        const id = e.target.closest('.editBtn').dataset.id;
        fetch('role_permissions_action.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
              action: 'get',
              id
            })
          })
          .then(r => r.json())
          .then(p => {
            document.getElementById('permission_id').value = p.perm_id;
            document.getElementById('role_id').value = p.role_id;
            document.getElementById('module').value = p.module_name;
            document.getElementById('can_view').checked = p.can_view == 1;
            document.getElementById('can_add').checked = p.can_add == 1;
            document.getElementById('can_edit').checked = p.can_edit == 1;
            document.getElementById('can_delete').checked = p.can_delete == 1;
            document.getElementById('permModalLabel').innerText = 'Edit Permission';
            new bootstrap.Modal(document.getElementById('permModal')).show();
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load permission details', 'error');
          });
      }

      if (e.target.closest('.delBtn')) {
        const id = e.target.closest('.delBtn').dataset.id;
        
        Swal.fire({
          title: 'Delete Permission?',
          text: "This action cannot be undone!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch('role_permissions_action.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                  action: 'delete',
                  id
                })
              })
              .then(r => r.json())
              .then(response => {
                if (response.success) {
                  Swal.fire('Deleted!', 'Permission has been deleted.', 'success');
                  loadPermissions();
                } else {
                  Swal.fire('Error', response.message || 'Failed to delete permission', 'error');
                }
              })
              .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to delete permission', 'error');
              });
          }
        });
      }
    });

    document.getElementById('permForm').addEventListener('submit', e => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const permId = document.getElementById('permission_id').value;
      formData.append('action', permId ? 'edit' : 'add');
      
      // Convert checkboxes to 1/0
      formData.set('can_view', document.getElementById('can_view').checked ? 1 : 0);
      formData.set('can_add', document.getElementById('can_add').checked ? 1 : 0);
      formData.set('can_edit', document.getElementById('can_edit').checked ? 1 : 0);
      formData.set('can_delete', document.getElementById('can_delete').checked ? 1 : 0);

      fetch('role_permissions_action.php', {
          method: 'POST',
          body: formData
        })
        .then(r => r.json())
        .then(response => {
          if (response.success) {
            Swal.fire('Success', response.message || 'Permission saved successfully', 'success');
            loadPermissions();
            bootstrap.Modal.getInstance(document.getElementById('permModal')).hide();
          } else {
            Swal.fire('Error', response.message || 'Failed to save permission', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error', 'Failed to save permission', 'error');
        });
    });
  });
</script>

<style>
  .table tbody tr:hover {
    background-color: #f8f9fa;
  }
  
  .form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
  }
  
  .badge {
    font-size: 0.85rem;
    padding: 0.4em 0.8em;
  }
</style>