<?php
require_once('../initialize_coreT2.php');
require_once(__DIR__ . '/inc/log_audit_trial.php');

if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect if already logged in
if (isset($_SESSION['userdata'])) {
    header("Location: /admin/dashboard.php");
    exit();
}

$error_message = "";

// ✅ Only show session expired alert 
if (isset($_GET['auto']) && isset($_GET['timeout'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "warning",
                title: "Session Expired",
                text: "You have been logged out due to inactivity. Please login again.",
                showConfirmButton: true,
                confirmButtonText: "Login",
                timer: 4000,
                timerProgressBar: true
            });
        });
    </script>';
}

// ✅ Show success message for manual logout
if (isset($_GET['logout'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Logged Out",
                text: "You have been logged out successfully.",
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>';
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

// --- Login processing ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error_message = "Please enter both username and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($user['status'] !== 'Active') {
                $error_message = "Your account is inactive. Please contact admin.";
                // ✅ Log to both tables
                log_to_both_tables(
                    $user['user_id'], 
                    'Login Failed - Inactive', 
                    'Authentication', 
                    'Inactive user tried login',
                    'Failed'
                );
            } elseif (!password_verify($password, $user['password_hash'])) {
                $error_message = "Invalid username or password.";
                // ✅ Log to both tables
                log_to_both_tables(
                    $user['user_id'], 
                    'Login Failed - Wrong Password', 
                    'Authentication', 
                    'Incorrect password from IP: ' . $_SERVER['REMOTE_ADDR'],
                    'Failed'
                );
            } else {
                // Successful login
                session_regenerate_id(true);

                $_SESSION['userdata'] = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'] ?? 'User',
                    'role' => $user['role'] ?? 'Member'
                ];

                $_SESSION['last_activity'] = time();
                $_SESSION['session_start'] = time();
                $_SESSION['login_success'] = "Welcome back, " . ($user['full_name'] ?? 'User') . "!";

                // ✅ Log successful login to both tables
                log_to_both_tables(
                    $user['user_id'],
                    'Login',
                    'Authentication',
                    'User logged in successfully from IP: ' . $_SERVER['REMOTE_ADDR'],
                    'Success'
                );

                $redirect_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                    . "://" . $_SERVER['HTTP_HOST'] . "/admin/dashboard.php";
                header("Location: " . $redirect_url);
                exit();
            }
        } else {
            $error_message = "Invalid username or password.";
            // ✅ Log unknown user to both tables
            log_to_both_tables(
                0, 
                'Login Failed - Unknown User', 
                'Authentication', 
                'Unknown username: ' . $username . ' from IP: ' . $_SERVER['REMOTE_ADDR'],
                'Failed'
            );
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", sans-serif;
        }

        .login-card {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .system-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="text-center mb-3">
            <img src="<?= validate_image($_settings->info('logo') ?? 'dist/img/logo.jpg') ?>" class="system-logo" alt="Logo">
            <h4><?= $_settings->info('system_name') ?? ' System' ?></h4>
            <small class="text-muted"><?= $_settings->info('system_tagline') ?? 'Secure Access Portal' ?></small>
        </div>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <hr>
        </form>
    </div>

    <?php if (!empty($error_message)) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '<?= addslashes($error_message) ?>',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
</body>

</html>