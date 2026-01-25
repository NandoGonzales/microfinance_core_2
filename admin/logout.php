<?php
require_once('../initialize_coreT2.php');
require_once(__DIR__ . '/inc/log_audit_trial.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Log the logout in audit_trial if user is logged in
if (!empty($_SESSION['userdata']['user_id'])) {
    $user_id = $_SESSION['userdata']['user_id'];
    $username = $_SESSION['userdata']['full_name'] ?? 'User';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

    // Determine logout type
    $logout_type = isset($_GET['auto']) ? 'Auto Logout (Inactivity)' : 'Manual Logout';

    log_audit_trial(
        $user_id,
        $logout_type,
        'Authentication',
        "User $username logged out from IP: $ip"
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

// If auto-logout, redirect with auto parameter
if (isset($_GET['auto'])) {
    header("Location: /admin/login.php?timeout=1&auto=1");
} else {
    header("Location: /admin/login.php?logout=1");
}
exit();
