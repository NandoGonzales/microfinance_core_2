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

// Check if user is logged in
if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata']['user_id'])) {
    // Store the current URL to redirect back after login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    
    // Redirect to login
    header("Location: login.php");
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
        
        // Redirect to login with timeout flag
        header("Location: /admin/login.php?timeout=1");
        exit();
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>