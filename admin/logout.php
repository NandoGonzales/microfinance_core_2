<?php
require_once('../initialize_coreT2.php');
require_once(__DIR__ . '/inc/log_audit_trial.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Helper function to log to BOTH tables
function log_to_both_tables($user_id, $action, $module, $remarks, $status = 'Success') {
    global $conn;
    
    // Log to audit_trail (existing)
    log_audit_trial($user_id, $action, $module, $remarks);
    
    // ✅ Also log to permission_logs
    try {
        $stmt = $conn->prepare("
            INSERT INTO permission_logs (user_id, module_name, action_name, action_status, action_time)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param('isss', $user_id, $module, $action, $status);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        error_log("Permission log error: " . $e->getMessage());
    }
}

// Log the logout if user is logged in
if (!empty($_SESSION['userdata']['user_id'])) {
    $user_id = $_SESSION['userdata']['user_id'];
    $username = $_SESSION['userdata']['full_name'] ?? $_SESSION['userdata']['username'] ?? 'User';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

    // Determine logout type
    $logout_type = isset($_GET['auto']) ? 'Auto Logout' : 'Logout';
    $remarks = isset($_GET['auto']) 
        ? "User $username auto-logged out due to inactivity from IP: $ip"
        : "User $username logged out from IP: $ip";

    // ✅ Log to both tables
    log_to_both_tables(
        $user_id,
        $logout_type,
        'Authentication',
        $remarks,
        'Success'
    );
}

// Destroy session completely
$_SESSION = [];
session_unset();
session_destroy();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect
if (isset($_GET['auto'])) {
    header("Location: login.php?timeout=1&auto=1");
} else {
    header("Location: login.php?logout=1");
}
exit();