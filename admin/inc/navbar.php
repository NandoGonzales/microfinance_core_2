<?php
// ===========================
// navbar.php
// ===========================
if (session_status() == PHP_SESSION_NONE) session_start();

// Get current user info
$user_id   = $_SESSION['userdata']['user_id'] ?? 0;
$user_name = $_SESSION['userdata']['full_name'] ?? 'User';
$user_role = $_SESSION['userdata']['role'] ?? 'Member';
$user_email = '';

if ($user_id) {
  $stmt = $conn->prepare("SELECT email FROM users WHERE user_id=? LIMIT 1");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();
  $user_email = $res['email'] ?? '';
  $stmt->close();
}
?>

<!-- STYLE -->
<style>
  body {
    padding-top: 56px;
    font-family: sans-serif;
  }

  .navbar {
    background-color: #2c7244;
  }

  /* Pulse animation for logout icon */
  @keyframes pulse {
    0% {
      transform: scale(1);
      opacity: 1;
    }

    50% {
      transform: scale(1.2);
      opacity: 0.7;
    }

    100% {
      transform: scale(1);
      opacity: 1;
    }
  }

  .pulse-icon {
    animation: pulse 1.5s infinite;
  }
</style>

<!-- NAVBAR -->
<nav class="navbar fixed-top shadow-sm">
  <div class="container-fluid">
    <!-- Sidebar Toggle -->
    <button id="sidebarToggle" class="btn text-white me-2 d-none d-md-inline" type="button"
      data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-expanded="false" aria-controls="sidebarMenu">
      <i class="bi bi-list"></i>
    </button>

    <a class="navbar-brand text-white fw-semibold" href="#">Microfinance EIS</a>

    <div class="d-flex ms-auto align-items-center">

      <!-- Notification Dropdown -->
      <div class="dropdown me-3">
        <a class="btn text-white position-relative" href="#" id="notificationDropdown" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-bell"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
          <li><a class="dropdown-item" href="#">🔔 New loan application</a></li>
          <li><a class="dropdown-item" href="#">📊 Report generated</a></li>
          <li><a class="dropdown-item" href="#">⚠ Compliance alert</a></li>
        </ul>
      </div>

      <!-- User Dropdown -->
      <div class="dropdown">
        <a class="btn text-white dropdown-toggle" href="#" id="userDropdown" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle"></i> <span id="navbarUsername"><?= htmlspecialchars($user_name) ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a></li>
          <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal">Settings</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item text-danger bi bi-box-arrow-right" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- PROFILE MODAL -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <i class="bi bi-person-circle display-3 text-secondary"></i>
        <h5 class="mt-3 mb-0" id="profileFullName"><?= htmlspecialchars($user_name) ?></h5>
        <p class="text-muted" id="profileRole"><?= htmlspecialchars($user_role) ?></p>
        <hr>
        <p><strong>Email:</strong> <span id="profileEmail"><?= htmlspecialchars($user_email) ?></span></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- SETTINGS MODAL -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="settingsModalLabel">Account Settings</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="settingsForm">
          <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullName" value="<?= htmlspecialchars($user_name) ?>">
          </div>
          <div class="mb-3">
            <label for="userEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="userEmail" value="<?= htmlspecialchars($user_email) ?>">
          </div>
          <div class="mb-3">
            <label for="userPassword" class="form-label">Change Password</label>
            <input type="password" class="form-control" id="userPassword" placeholder="Enter new password">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveSettingsBtn">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- LOGOUT MODAL -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirm Logout</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <i class="bi bi-box-arrow-right display-4 text-danger mb-3 pulse-icon"></i>
        <p>Are you sure you want to log out?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="https://core2.microfinancial-1.com/admin/logout.php?timeout=1&auto=1" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- AJAX for Settings Update -->
<script>
  document.getElementById('saveSettingsBtn').addEventListener('click', async () => {
    const fullName = document.getElementById('fullName').value.trim();
    const email = document.getElementById('userEmail').value.trim();
    const password = document.getElementById('userPassword').value.trim();

    if (!fullName || !email) {
      alert("Full Name and Email are required");
      return;
    }

    try {
      const res = await fetch('/admin/inc/settings_update.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          fullName,
          email,
          password
        })
      });
      const data = await res.json();
      if (data.status === 'success') {
        alert("Settings updated successfully");
        document.getElementById('navbarUsername').textContent = fullName;
        document.getElementById('profileFullName').textContent = fullName;
        document.getElementById('profileEmail').textContent = email;
        document.getElementById('settingsModal').querySelector('.btn-close').click();
      } else {
        alert("Error: " + data.msg);
      }
    } catch (err) {
      console.error(err);
      alert("Error updating settings");
    }
  });
</script>