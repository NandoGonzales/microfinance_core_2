<?php
require_once('../initialize_coreT2.php');
require_once(__DIR__ . '/inc/log_audit_trial.php');

if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect if already logged in
if (isset($_SESSION['userdata'])) {
    // 🔴 FIXED: Use absolute path
    header("Location: /admin/dashboard.php");
    exit();
}

$error_message = "";

// Show timeout message if redirected due to session expiration
if (isset($_GET['timeout'])) {
    $error_message = "Your session has expired due to inactivity. Please login again.";
}

// Show auto-logout message if redirected due to inactivity
if (isset($_GET['auto'])) {
    echo '<script>
        Swal.fire({
            icon: "info",
            title: "Auto Logout",
            text: "You were automatically logged out due to 2 minutes of inactivity.",
            timer: 3000,
            showConfirmButton: false
        });
    </script>';
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
                log_audit_trial($user['user_id'], 'Login Failed - Inactive', 'Authentication', 'Inactive user tried login');
            } elseif (!password_verify($password, $user['password_hash'])) {
                $error_message = "Invalid username or password.";
                log_audit_trial($user['user_id'], 'Login Failed - Wrong Password', 'Authentication', 'Incorrect password');
            } else {
                // Successful login
                session_regenerate_id(true);

                // Set user data
                $_SESSION['userdata'] = [
                    'user_id' => $user['user_id'],
                    'full_name' => $user['full_name'] ?? 'User',
                    'role' => $user['role'] ?? 'Member'
                ];

                // Initialize session timeout tracking
                $_SESSION['last_activity'] = time();  // Crucial for timeout
                $_SESSION['session_start'] = time();  // Session start time

                $_SESSION['login_success'] = "Welcome back, " . ($user['full_name'] ?? 'User') . "!";

                // Log successful login
                log_audit_trial(
                    $user['user_id'],
                    'Login',
                    'Authentication',
                    'User logged in successfully from IP: ' . $_SERVER['REMOTE_ADDR']
                );

                $redirect_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                    . "://" . $_SERVER['HTTP_HOST'] . "/admin/dashboard.php";
                header("Location: " . $redirect_url);
                exit();
            }
        } else {
            $error_message = "Invalid username or password.";
            log_audit_trial(0, 'Login Failed - Unknown User', 'Authentication', 'Unknown username: ' . $username);
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

    <!-- SweetAlert for errors -->
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