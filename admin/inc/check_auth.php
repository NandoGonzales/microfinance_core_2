<?php
// check_auth.php - Include this at the top of every protected page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Helper function to log session expiration to BOTH tables
function log_session_expired($user_id, $username) {
    global $conn;
    
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $remarks = "Session expired for user: $username from IP: $ip";
    
    // Log to audit_trail
    try {
        $stmt = $conn->prepare("
            INSERT INTO audit_trail (user_id, action_type, module_name, action_time, ip_address, remarks, compliance_status)
            VALUES (?, 'Session Expired', 'Authentication', NOW(), ?, ?, 'Compliant')
        ");
        $stmt->bind_param("iss", $user_id, $ip, $remarks);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        error_log("Audit trail log error: " . $e->getMessage());
    }
    
    // ✅ Also log to permission_logs
    try {
        $stmt = $conn->prepare("
            INSERT INTO permission_logs (user_id, module_name, action_name, action_status, action_time)
            VALUES (?, 'Authentication', 'Session Expired', 'Failed', NOW())
        ");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        error_log("Permission log error: " . $e->getMessage());
    }
}

// ✅ Get login page path (works from any subdirectory)
function getLoginPath($with_timeout = false) {
    // Get the current script directory
    $current_dir = dirname($_SERVER['SCRIPT_FILENAME']);
    $admin_dir = dirname(dirname(__FILE__)); // /admin directory
    
    // Calculate relative path from current location to /admin/login.php
    $relative_path = '../login.php';
    
    // Count how many levels deep we are from /admin/
    $current_parts = explode('/', str_replace('\\', '/', $current_dir));
    $admin_parts = explode('/', str_replace('\\', '/', $admin_dir));
    
    $depth = count($current_parts) - count($admin_parts);
    
    if ($depth > 0) {
        $relative_path = str_repeat('../', $depth) . 'login.php';
    }
    
    if ($with_timeout) {
        $relative_path .= '?timeout=1';
    }
    
    return $relative_path;
}

// Check if user is logged in
if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata']['user_id'])) {
    // Store the current URL to redirect back after login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    
    // ✅ Redirect to login with correct path
    header("Location: " . getLoginPath());
    exit();
}

// ✅ Check for session timeout
$timeout = 1800; // 30 minutes in seconds (adjust as needed)

if (isset($_SESSION['last_activity'])) {
    $time_since_activity = time() - $_SESSION['last_activity'];
    
    if ($time_since_activity > $timeout) {
        // Get user info before destroying session
        $user_id = $_SESSION['userdata']['user_id'];
        $username = $_SESSION['userdata']['full_name'] ?? $_SESSION['userdata']['username'] ?? 'User';
        
        // Log session expiration
        log_session_expired($user_id, $username);
        
        // Destroy session
        $_SESSION = [];
        session_destroy();
        
        // ✅ Redirect to login with correct path and timeout flag
        header("Location: " . getLoginPath(true));
        exit();
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>