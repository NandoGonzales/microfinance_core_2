<!-- Enhanced Sidebar with Smooth Animations -->
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
        /* Enhanced smooth transitions */
        transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                    box-shadow 0.3s ease;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Custom scrollbar for sidebar */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
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
        /* Smooth fade in effect */
        animation: fadeInDown 0.5s ease-out;
    }

    .sidebar a {
        display: block;
        padding: 10px 25px;
        color: #fff;
        text-decoration: none;
        position: relative;
        overflow: hidden;
        /* Enhanced smooth transitions */
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 4px solid transparent;
    }

    /* Smooth ripple effect on hover */
    .sidebar a::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 0;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-50%);
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: -1;
    }

    .sidebar a:hover::before {
        width: 100%;
    }

    .sidebar a:hover {
        background-color: rgba(74, 84, 72, 0.6);
        text-decoration: none;
        padding-left: 30px;
        transform: translateX(2px);
    }

    .sidebar a i {
        margin-right: 10px;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-block;
    }

    .sidebar a:hover i {
        transform: scale(1.1) rotate(5deg);
    }

    /* Enhanced gradient highlight for the active page */
    .sidebar a.active {
        background: linear-gradient(135deg, #276749, #38a169);
        border-left: 4px solid #81e6d9;
        box-shadow: inset 2px 0 8px rgba(0, 0, 0, 0.2),
                    0 2px 8px rgba(56, 161, 105, 0.3);
        font-weight: 600;
        animation: slideInLeft 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar a.active i {
        color: #c6f6d5;
        transform: scale(1.15);
    }

    .sidebar a.active::after {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(to bottom, 
            transparent, 
            rgba(129, 230, 217, 0.8), 
            transparent);
        animation: pulse 2s ease-in-out infinite;
    }

    .main-content {
        padding-top: calc(var(--navbar-height) + 0);
        margin-left: var(--sidebar-width);
        padding-left: 40px;
        padding-right: 40px;
        /* Smooth transition for content shift */
        transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.3s ease;
    }

    .sidebar.collapsed {
        left: calc(0px - var(--sidebar-width));
        box-shadow: none;
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
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .toggle-btn:hover {
        transform: scale(1.1) rotate(90deg);
    }

    /* Divider smooth appearance */
    .sidebar-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        margin: 10px 0;
        opacity: 0;
        animation: fadeIn 0.5s ease-out 0.3s forwards;
    }

    /* Menu items staggered fade-in animation */
    .sidebar nav ul li {
        opacity: 0;
        animation: fadeInLeft 0.4s ease-out forwards;
    }

    .sidebar nav ul li:nth-child(1) { animation-delay: 0.1s; }
    .sidebar nav ul li:nth-child(2) { animation-delay: 0.15s; }
    .sidebar nav ul li:nth-child(3) { animation-delay: 0.2s; }
    .sidebar nav ul li:nth-child(4) { animation-delay: 0.25s; }
    .sidebar nav ul li:nth-child(5) { animation-delay: 0.3s; }
    .sidebar nav ul li:nth-child(6) { animation-delay: 0.35s; }
    .sidebar nav ul li:nth-child(7) { animation-delay: 0.4s; }
    .sidebar nav ul li:nth-child(8) { animation-delay: 0.45s; }
    .sidebar nav ul li:nth-child(9) { animation-delay: 0.5s; }
    .sidebar nav ul li:nth-child(10) { animation-delay: 0.55s; }

    /* Keyframe Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-10px);
            opacity: 0.8;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 0.6;
        }
        50% {
            opacity: 1;
        }
    }

    /* Smooth hover effect for all clickable items */
    .sidebar a {
        cursor: pointer;
    }

    /* Add smooth focus states for accessibility */
    .sidebar a:focus {
        outline: 2px solid rgba(129, 230, 217, 0.5);
        outline-offset: -2px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            max-width: 252px;
        }
        
        .main-content {
            margin-left: 0;
        }
        
        .sidebar.collapsed {
            left: -100%;
        }
    }
</style>

<?php
// Base URL to your project root
$base_url = '/admin';
$current_page = basename($_SERVER['PHP_SELF']);

// Check what actual files/folders exist
$admin_path = $_SERVER['DOCUMENT_ROOT'] . '/admin';

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
                <?php if (path_exists('/admin/Loan-Portfolio-Risk-Management/')): ?>
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
                <?php if (path_exists('/admin/Repayment-Tracker/')): ?>
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
                <?php if (path_exists('/admin/Saving-Collection-Monitoring/')): ?>
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
                <?php if (path_exists('/admin/Disbursement-Fund-Allocation-Tracker/')): ?>
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
                <?php if (path_exists('/admin/Compliance-Audith-Trail-System/')): ?>
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
            <li class="sidebar-divider"></li>

            <!-- User Management Section -->
            <li>
                <?php if (path_exists('/admin/User-Management-Role-Based-Access/')): ?>
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
                <?php if (path_exists('/admin/User-Management-Role-Based-Access/')): ?>
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
                <?php if (path_exists('/admin/User-Management-Role-Based-Access/')): ?>
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

<!-- Enhanced Sidebar JS -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('mySidebar');
        const mainContent = document.getElementById('main-content');
        const toggleButton = document.getElementById('sidebarToggle');

        if (toggleButton) {
            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                if (mainContent) mainContent.classList.toggle('expanded');
                
                // Add smooth bounce effect on toggle
                toggleButton.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    toggleButton.style.transform = 'scale(1)';
                }, 150);
            });
        }

        // Add smooth scroll behavior for sidebar
        const sidebarLinks = document.querySelectorAll('.sidebar a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Add ripple effect on click
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.width = '100%';
                ripple.style.height = '100%';
                ripple.style.top = '0';
                ripple.style.left = '0';
                ripple.style.background = 'rgba(255, 255, 255, 0.3)';
                ripple.style.transform = 'scale(0)';
                ripple.style.borderRadius = '0';
                ripple.style.pointerEvents = 'none';
                
                this.style.position = 'relative';
                this.appendChild(ripple);
                
                // Animate ripple
                setTimeout(() => {
                    ripple.style.transition = 'transform 0.5s ease-out, opacity 0.5s ease-out';
                    ripple.style.transform = 'scale(1)';
                    ripple.style.opacity = '0';
                }, 10);
                
                // Remove ripple after animation
                setTimeout(() => {
                    ripple.remove();
                }, 500);
            });
        });
    });
</script>