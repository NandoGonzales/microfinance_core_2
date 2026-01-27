<?php
// check_auth.php - Include this at the top of every protected page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata']['user_id'])) {
    // Store the current URL to redirect back after login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    
    // ✅ FIXED: Use relative path
    header("Location: login.php");
    exit();
}
?>