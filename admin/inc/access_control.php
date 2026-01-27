<?php
// ============================================================================
// access_control.php — Central RBAC (Role-Based Access Control)
// ============================================================================

require_once(__DIR__ . '/../../initialize_coreT2.php');
if (session_status() === PHP_SESSION_NONE) session_start();

// ============================================================================
// ✅ Session Validation
// ============================================================================
if (!isset($_SESSION['userdata'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Session Expired',
            text: 'Please log in again to continue.',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            window.location.href = '../login.php';
        });
    </script>";
    exit();
}

// ============================================================================
//  Get Current User Info
// ============================================================================
$user = $_SESSION['userdata'];
$user_role = $user['role'] ?? 'Guest';
$user_id   = $user['user_id'] ?? 0;

// ============================================================================
//  Role Permission Map (adjust per your modules)
// ============================================================================
$allowed_roles = [
    'dashboard'            => ['Super Admin', 'Admin', 'Staff'],
    'loan_portfolio'       => ['Super Admin', 'Admin', 'Staff'],
    'Repayment_Tracker'       => ['Super Admin', 'Admin', 'Staff'],
    'savings_monitoring'   => ['Super Admin', 'Admin', 'Staff'],
    'disbursement_tracker' => ['Super Admin', 'Admin', 'Staff'],
    'compliance_logs'      => ['Super Admin', 'Admin'],
    'user_management'      => ['Super Admin'],
    'role_permissions'     => ['Super Admin'],
    'permission_logs'      => ['Super Admin']
];

// ============================================================================
//  SweetAlert Access Denied Function
// ============================================================================
function showAccessDenied($module)
{
    $pretty = ucfirst(str_replace('_', ' ', $module));
    echo "
    <html><head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head><body>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Access Denied!',
            text: 'You don't have permission to access {$pretty}.',
            confirmButtonText: 'Return to Dashboard',
            confirmButtonColor: '#d33'
        }).then(() => {
            window.location.href = '../dashboard.php';
        });
    </script>
    </body></html>";
    exit();
}

// ============================================================================
// ✅ Log Permission Activity (Success or Denied)
// ============================================================================
function logPermission($conn, $user_id, $module_name, $action_name, $status = 'Success')
{
    if (!$conn) return;
    try {
        $stmt = $conn->prepare("
            INSERT INTO permission_logs (user_id, module_name, action_name, action_status)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param('isss', $user_id, $module_name, $action_name, $status);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        // Silent fail — do not break app
    }
}

// ============================================================================
// ✅ Check Permission (Main Function)
// ============================================================================
function checkPermission($module)
{
    global $allowed_roles, $user_role, $user_id, $conn;

    // If module not defined, Super Admin only
    if (!isset($allowed_roles[$module])) {
        if ($user_role !== 'Super Admin') {
            logPermission($conn, $user_id, $module, 'Access', 'Denied');
            showAccessDenied($module);
        }
        return;
    }

    // Check if allowed
    if (!in_array($user_role, $allowed_roles[$module])) {
        logPermission($conn, $user_id, $module, 'Access', 'Denied');
        showAccessDenied($module);
        exit();
    }

    // Log success
    logPermission($conn, $user_id, $module, 'Access', 'Success');
}

// ============================================================================
// ✅ Helper to Get Role
// ============================================================================
function getCurrentUserRole()
{
    global $user_role;
    return $user_role;
}

// ============================================================================
// ✅ hasPermission() helper (for button-level checks)
// ============================================================================
if (!function_exists('hasPermission')) {
    function hasPermission($conn, $role, $module, $action)
    {
        // Super Admin has access to everything
        if ($role === 'Super Admin') return true;

        // FIXED: Complete permission mapping for all roles
        $rolePermissions = [
            'Super Admin' => [
                'User Management' => ['view', 'add', 'edit', 'delete'],
                'Savings Monitoring' => ['view', 'add', 'edit', 'delete'],
                'Loan Portfolio' => ['view', 'add', 'edit', 'delete'],
                'Repayment Tracker' => ['view', 'add', 'edit', 'delete'],
                'Disbursement Tracker' => ['view', 'add', 'edit', 'delete'],
                'Compliance & Audit Trail' => ['view', 'add', 'edit', 'delete'],
                'Compliance Logs' => ['view', 'add', 'edit', 'delete'],
                'Permission Logs' => ['view', 'add', 'edit', 'delete'],
                'Audit Trail' => ['view', 'add', 'edit', 'delete'],
                'Role Permissions' => ['view', 'add', 'edit', 'delete'],
            ],
            'Admin' => [
                'Savings Monitoring' => ['view', 'add', 'edit', 'delete'],  // ✅ FIXED: Added full access
                'Loan Portfolio' => ['view', 'add', 'edit'],
                'Repayment Tracker' => ['view', 'add', 'edit'],
                'Disbursement Tracker' => ['view', 'add', 'edit'],
                'Compliance & Audit Trail' => ['view'],
                'Compliance Logs' => ['view'],
                'Audit Trail' => ['view'],
            ],
            'Staff' => [
                'Dashboard' => ['view'],
                'Savings Monitoring' => ['view', 'add'],  // ✅ FIXED: Added Savings Monitoring
                'Loan Portfolio' => ['view', 'add'],
                'Repayment Tracker' => ['view', 'add'],
                'Disbursement Tracker' => ['view', 'add'],
            ],
        ];

        // Check if role and module exist in permissions
        $hasAccess = isset($rolePermissions[$role][$module]) &&
            in_array($action, $rolePermissions[$role][$module]);

        // Log access denial to audit trail
        if (!$hasAccess) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $userId = $_SESSION['userdata']['user_id'] ?? null;
            $username = $_SESSION['userdata']['username'] ?? 'Unknown';
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

            try {
                $stmt = $conn->prepare("
                    INSERT INTO audit_trail (user_id, action_type, module_name, remarks, ip_address, action_time)
                    VALUES (?, 'Access Denied', ?, ?, ?, NOW())
                ");
                $remarks = "User '$username' tried to $action $module without permission.";
                $stmt->bind_param('isss', $userId, $module, $remarks, $ip);
                $stmt->execute();
                $stmt->close();
            } catch (Exception $e) {
                // Silent fail - don't break the app
                error_log("Failed to log access denial: " . $e->getMessage());
            }
        }

        return $hasAccess;
    }
}