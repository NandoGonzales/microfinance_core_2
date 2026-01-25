<!-- Sidebar Css -->
<style>
    :root {
        --navbar-height: 60px;
        --sidebar-width: 250px;
        --transition-speed: 0.3s;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        overflow-x: hidden;
    }

    .sidebar {
        height: 100vh;
        width: 252px;
        position: fixed;
        left: 0;
        background-color: #2f855a;
        color: white;
        z-index: 1000;
        transition: left var(--transition-speed) ease;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-title {
        padding: 20px;
        font-size: 1.1em;
        font-weight: bold;
        color: #fff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 10px;
    }

    .sidebar a {
        display: block;
        padding: 10px 25px;
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        border-left: 4px solid transparent;
    }

    .sidebar a:hover {
        background-color: #4a5448;
        text-decoration: none;
        padding-left: 28px;
    }

    /* 🔰 Gradient highlight for the active page */
    .sidebar a.active {
        background: linear-gradient(135deg, #276749, #38a169);
        border-left: 4px solid #81e6d9;
        box-shadow: inset 2px 0 8px rgba(0, 0, 0, 0.2);
        font-weight: 600;
    }

    .sidebar a.active i {
        color: #c6f6d5;
    }

    .main-content {
        padding-top: calc(var(--navbar-height) + 0);
        margin-left: var(--sidebar-width);
        padding-left: 40px;
        padding-right: 40px;
        transition: margin-left var(--transition-speed) ease;
    }

    .sidebar.collapsed {
        left: calc(0px - var(--sidebar-width));
    }

    .main-content.expanded {
        margin-left: 0;
    }

    .toggle-btn {
        font-size: 24px;
        cursor: pointer;
        background: none;
        border: none;
        color: #fff;
        margin-right: 15px;
        outline: none;
    }
</style>

<?php
// Base URL to your project root
$base_url = '/coret2/admin';
$current_page = basename($_SERVER['PHP_SELF']);

// Check what actual files/folders exist
$admin_path = $_SERVER['DOCUMENT_ROOT'] . '/coret2/admin/';

// Function to check if a file or folder exists
function path_exists($path) {
    return file_exists($_SERVER['DOCUMENT_ROOT'] . $path);
}
?>

<!-- Sidebar Menu -->
<div class="sidebar" id="mySidebar">
    <div class="sidebar-title">Core Transaction 2</div>
    <nav>
        <ul style="list-style: none; padding-left: 0;">
            <li>
                <a href="<?= $base_url ?>/dashboard.php" <?= $current_page == 'dashboard.php' ? 'class="active"' : '' ?>>
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <!-- Check if folder exists, otherwise use direct file -->
                <?php if (path_exists('/coret2/admin/Loan-Portfolio-Risk-Management/')): ?>
                    <a href="<?= $base_url ?>/Loan-Portfolio-Risk-Management/index.php" <?= strpos($_SERVER['REQUEST_URI'], 'Loan-Portfolio-Risk-Management') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-wallet2"></i> Loan Portfolio
                    </a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/loan_portfolio.php" <?= strpos($_SERVER['REQUEST_URI'], 'loan_portfolio') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-wallet2"></i> Loan Portfolio
                    </a>
                <?php endif; ?>
            </li>
            <li>
                <?php if (path_exists('/coret2/admin/Repayment-Tracker/')): ?>
                    <a href="<?= $base_url ?>/Repayment-Tracker/repayments.php" <?= strpos($_SERVER['REQUEST_URI'], 'Repayment-Tracker/repayments.php') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-cash-stack"></i> Repayment Tracker
                    </a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/repayments.php" <?= strpos($_SERVER['REQUEST_URI'], 'repayments') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-cash-stack"></i> Repayment Tracker
                    </a>
                <?php endif; ?>
            </li>
            <li>
                <?php if (path_exists('/coret2/admin/Saving-Collection-Monitoring/')): ?>
                    <a href="<?= $base_url ?>/Saving-Collection-Monitoring/savings_monitoring.php" <?= strpos($_SERVER['REQUEST_URI'], 'Saving-Collection-Monitoring/savings_monitoring.php') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-piggy-bank"></i> Savings Monitoring
                    </a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/savings_monitoring.php" <?= strpos($_SERVER['REQUEST_URI'], 'savings_monitoring') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-piggy-bank"></i> Savings Monitoring
                    </a>
                <?php endif; ?>
            </li>
            <li>
                <?php if (path_exists('/coret2/admin/Disbursement-Fund-Allocation-Tracker/')): ?>
                    <a href="<?= $base_url ?>/Disbursement-Fund-Allocation-Tracker/disbursement_tracker.php" <?= strpos($_SERVER['REQUEST_URI'], 'Disbursement-Fund-Allocation-Tracker/disbursement_tracker.php') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-cash-stack"></i> Disbursement Tracker
                    </a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/disbursement_tracker.php" <?= strpos($_SERVER['REQUEST_URI'], 'disbursement_tracker') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-cash-stack"></i> Disbursement Tracker
                    </a>
                <?php endif; ?>
            </li>
            <li>
                <?php if (path_exists('/coret2/admin/Compliance-Audith-Trail-System/')): ?>
                    <a href="<?= $base_url ?>/Compliance-Audith-Trail-System/compliance_logs.php" <?= strpos($_SERVER['REQUEST_URI'], 'Compliance-Audith-Trail-System/compliance_logs.php') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-shield-check"></i> Compliance & Audit Trail
                    </a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/compliance_logs.php" <?= strpos($_SERVER['REQUEST_URI'], 'compliance_logs') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-shield-check"></i> Compliance & Audit Trail
                    </a>
                <?php endif; ?>
            </li>

            <!-- Divider -->
            <li style="border-top:1px solid rgba(255,255,255,0.2); margin:10px 0;"></li>

            <!-- User Management Section -->
            <li>
                <?php if (path_exists('/coret2/admin/User-Management-Role-Based-Access/')): ?>
                    <a href="<?= $base_url ?>/User-Management-Role-Based-Access/user_management.php" <?= strpos($_SERVER['REQUEST_URI'], 'User-Management/user_management.php') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-people-fill"></i> User Management
                    </a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/user_management.php" <?= strpos($_SERVER['REQUEST_URI'], 'user_management') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-people-fill"></i> User Management
                    </a>
                <?php endif; ?>
            </li>
            <li>
                <?php if (path_exists('/coret2/admin/User-Management-Role-Based-Access/')): ?>
                    <a href="<?= $base_url ?>/User-Management-Role-Based-Access/role_permissions.php" <?= strpos($_SERVER['REQUEST_URI'], 'User-Management/role_permissions.php') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-shield-lock"></i> Role Permissions
                    </a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/role_permissions.php" <?= strpos($_SERVER['REQUEST_URI'], 'role_permissions') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-shield-lock"></i> Role Permissions
                    </a>
                <?php endif; ?>
            </li>
            <li>
                <?php if (path_exists('/coret2/admin/User-Management-Role-Based-Access/')): ?>
                    <a href="<?= $base_url ?>/User-Management-Role-Based-Access/permission_logs.php" <?= strpos($_SERVER['REQUEST_URI'], 'User-Management/permission_logs.php') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-activity"></i> Permission Logs
                    </a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/permission_logs.php" <?= strpos($_SERVER['REQUEST_URI'], 'permission_logs') !== false ? 'class="active"' : '' ?>>
                        <i class="bi bi-activity"></i> Permission Logs
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</div>

<!-- Sidebar JS -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('mySidebar');
        const mainContent = document.getElementById('main-content');
        const toggleButton = document.getElementById('sidebarToggle');

        if (toggleButton) {
            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                if (mainContent) mainContent.classList.toggle('expanded');
            });
        }
    });
</script>