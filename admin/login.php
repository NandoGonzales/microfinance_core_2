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

// ✅ Show session expired alert with matching style
if (isset($_GET['auto']) && isset($_GET['timeout'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "warning",
                title: "Session Expired",
                html: "<p style=\"color: #856404; font-weight: bold; font-size: 1rem; margin: 10px 0;\">You have been logged out due to 2 minutes of inactivity.</p><p style=\"color: #6c757d; font-size: 0.95rem; margin: 10px 0;\">Please log in again to continue.</p>",
                confirmButtonText: "OK",
                confirmButtonColor: "#059669",
                allowOutsideClick: false,
                background: "#ffffff"
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
                showConfirmButton: false,
                background: "#ffffff"
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $_settings->info('system_name') ?? 'Microfinance HR3' ?> - Login</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "brand-primary": "#059669",
                        "brand-primary-hover": "#047857",
                        "brand-background-main": "#F0FDF4",
                        "brand-border": "#D1FAE5",
                        "brand-text-primary": "#1F2937",
                        "brand-text-secondary": "#4B5563",
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .shape {
            position: absolute;
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .shape-2 { animation-delay: -5s; }
        .shape-3 { animation-delay: -10s; }
        .shape-4 { animation-delay: -15s; }
        .shape-5 { animation-delay: -7s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(10px, -10px) rotate(5deg); }
            50% { transform: translate(-5px, 5px) rotate(-5deg); }
            75% { transform: translate(5px, 10px) rotate(3deg); }
        }

        .login-svg {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .login-svg.active {
            opacity: 1;
        }
    </style>
</head>

<body class="min-h-screen bg-brand-primary relative overflow-hidden">

    <!-- Floating Shapes Background -->
    <div class="absolute inset-0 z-0">
        <div class="shape w-72 h-72 top-[5%] left-[-5%] bg-white/5"></div>
        <div class="shape shape-2 w-96 h-96 bottom-[-20%] left-[15%] bg-white/5"></div>
        <div class="shape shape-3 w-80 h-80 top-[-15%] right-[-10%] bg-white/5"></div>
        <div class="shape shape-4 w-56 h-56 bottom-[5%] right-[10%] bg-white/5"></div>
        <div class="shape shape-5 w-48 h-48 top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-white/5"></div>
    </div>

    <div class="min-h-screen flex relative z-10">

        <!-- Left Panel -->
        <section class="hidden lg:flex w-1/2 items-center justify-center p-12 text-white">
            <div class="flex flex-col items-center w-full py-12">
                <div class="text-center">
                    <img src="<?= validate_image($_settings->info('logo') ?? 'dist/img/logo.jpg') ?>" 
                         alt="System Logo" 
                         class="w-28 h-28 mx-auto object-contain">
                    <h1 class="text-4xl font-bold mt-4"><?= $_settings->info('system_name') ?? 'Microfinance HR' ?></h1>
                    <p class="text-white/80"><?= $_settings->info('system_tagline') ?? 'Human Resource Management' ?></p>
                </div>
                

                <!-- Illustration Carousel (Optional - add your images) -->
                <div class="relative w-full max-w-2xl h-96 my-6">
                    <!-- Add your illustrations here -->
                    <div class="login-svg active absolute inset-0 w-full h-full flex items-center justify-center">
                        <svg class="w-64 h-64 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                        </svg>
                    </div>
                </div>

                <div class="text-center mt-4 max-w-xl">
                    <p class="italic text-white/90 text-lg leading-relaxed">
                        "The strength of the team is each individual member. The strength of each member is the team."
                    </p>
                    <cite class="block text-right mt-2 text-white/60">- Phil Jackson</cite>
                </div>
            </div>
        </section>

        <!-- Right Panel: Login Card -->
        <section class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-8">

                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-brand-text-primary">Welcome Back!</h2>
                    <p class="text-brand-text-secondary mt-1">Please enter your details to sign in.</p>
                </div>

                <form method="POST" action="" id="login-form">
                    <!-- Username -->
                    <div class="relative mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="username">Username</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="username" name="username" type="text" placeholder="Enter your username"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm
                                          focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary
                                          transition-all duration-200"
                                   required autofocus />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="relative mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>

                            <input id="password" name="password" type="password" placeholder="Enter your password"
                                   class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm
                                          focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary
                                          transition-all duration-200"
                                   required />

                            <div id="password-toggle"
                                 class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer select-none transition-transform duration-150">
                                <!-- Eye Open -->
                                <svg id="eye-open" class="h-5 w-5 text-gray-400 hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>

                                <!-- Eye Closed -->
                                <svg id="eye-closed" class="h-5 w-5 text-gray-400 hover:text-brand-primary transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.966 9.966 0 012.257-3.592m3.086-2.16A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.97 9.97 0 01-4.043 5.197M15 12a3 3 0 00-4.5-2.598M9 12a3 3 0 004.5 2.598M3 3l18 18"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Sign In Button -->
                    <button type="submit"
                            class="w-full bg-brand-primary hover:bg-brand-primary-hover text-white font-bold py-3 px-4 rounded-lg
                                   transition-all duration-300 shadow-lg
                                   transform active:translate-y-0 active:scale-[0.99]">
                        Sign In
                    </button>

                    <hr class="my-6 border-gray-200">
                </form>

                <div class="text-center mt-8 text-sm">
                    <p class="text-gray-500">&copy; <?= date('Y') ?> <?= $_settings->info('system_name') ?? 'Microfinance HR' ?>. All Rights Reserved.</p>
                </div>
            </div>
        </section>
    </div>

    <?php if (!empty($error_message)) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '<?= addslashes($error_message) ?>',
                timer: 2500,
                showConfirmButton: false,
                background: '#ffffff',
                confirmButtonColor: '#059669'
            });
        </script>
    <?php endif; ?>

    <script>
        // Password toggle functionality
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('password-toggle');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        passwordToggle.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        });

        // Carousel functionality for illustrations (if you add multiple images)
        const svgs = document.querySelectorAll('.login-svg');
        let currentIndex = 0;

        if (svgs.length > 1) {
            setInterval(() => {
                svgs[currentIndex].classList.remove('active');
                currentIndex = (currentIndex + 1) % svgs.length;
                svgs[currentIndex].classList.add('active');
            }, 5000);
        }
    </script>
</body>
</html>