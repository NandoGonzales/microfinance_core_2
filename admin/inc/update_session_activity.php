<?php
// update_session_activity.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../initialize_coreT2.php');
header('Content-Type: application/json');

$response = ['success' => false];

if (isset($_SESSION['userdata']) && isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
    $response['success'] = true;
    $response['message'] = 'Session activity updated';
}

echo json_encode($response);
exit();
?>