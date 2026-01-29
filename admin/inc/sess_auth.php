<?php
// ✅ Include system initialization and global functions
require_once(__DIR__ . '/../../initialize_coreT2.php');

// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Session timeout configuration (2 minutes = 120 seconds for testing, use 1800 for production)
define('SESSION_TIMEOUT', 120);

// Get current page URL
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$link .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// ====== SESSION TIMEOUT FUNCTIONS ======

/**
 * Check if session has timed out
 */
function checkSessionTimeout()
{
    // If no userdata, session is invalid
    if (!isset($_SESSION['userdata'])) {
        return false;
    }

    // Initialize last_activity if not set
    if (!isset($_SESSION['last_activity'])) {
        $_SESSION['last_activity'] = time();
        $_SESSION['session_start'] = time();
        return true;
    }

    $current_time = time();
    $last_activity = $_SESSION['last_activity'];

    // Check if session has expired (2 minutes)
    if (($current_time - $last_activity) > SESSION_TIMEOUT) {
        return false;
    }

    // Update last activity time
    $_SESSION['last_activity'] = $current_time;
    return true;
}

/**
 * ✅ Log to BOTH tables
 */
function log_to_both_tables($user_id, $action, $module, $remarks, $status = 'Success') {
    global $conn;
    
    // Log to audit_trail
    log_audit($user_id, $action, $module, null, $remarks);
    
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

/**
 * Handle session timeout logout
 */
function handleSessionTimeout()
{
    global $conn;
    
    $user_id = $_SESSION['userdata']['user_id'] ?? 0;
    $username = $_SESSION['userdata']['full_name'] ?? 'Unknown';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

    // ✅ Log to BOTH tables
    log_to_both_tables(
        $user_id,
        'Session Expired',
        'Authentication',
        "User $username session expired due to inactivity from IP: $ip",
        'Failed'
    );

    // Clear all session data
    $_SESSION = [];

    // Destroy session cookie
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

    // Destroy the session
    session_destroy();

    // ✅ Use absolute URL
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    header("Location: $base_url/admin/login.php?timeout=1&auto=1");
    exit();
}

// ====== AUTHENTICATION CHECKS ======

// Skip session timeout check for login page
$is_login_page = strpos($link, 'login.php') !== false;

// Check session timeout only if NOT on login page
if (!$is_login_page && isset($_SESSION['userdata'])) {
    if (!checkSessionTimeout()) {
        handleSessionTimeout();
    }
}

// 🔹 1. Ensure session userdata exists
if (!isset($_SESSION['userdata']) && !$is_login_page) {
    log_audit(
        null,                        
        'Unauthorized Access',       
        'Authentication',            
        null,                        
        'Attempted access to: ' . $link
    );

    // ✅ Use absolute URL
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    header("Location: $base_url/admin/login.php");
    exit();
}

// 🔹 2. User already logged in but visiting login.php → redirect to dashboard
if (isset($_SESSION['userdata']) && $is_login_page) {
    log_audit(
        $_SESSION['userdata']['user_id'] ?? 0,
        'Re-login Attempt',
        'Authentication',
        null,
        'User attempted to visit login page while logged in.'
    );

    // ✅ Use absolute URL
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    header("Location: $base_url/admin/dashboard.php");
    exit();
}

// 🔹 3. Add session info for JavaScript (optional)
if (isset($_SESSION['userdata']) && isset($_SESSION['last_activity'])) {
    $remaining_time = SESSION_TIMEOUT - (time() - $_SESSION['last_activity']);
    $remaining_time = max(0, $remaining_time);

    $_SESSION['session_info'] = [
        'remaining_seconds' => $remaining_time,
        'timeout_warning' => ($remaining_time <= 30)
    ];
}
?>