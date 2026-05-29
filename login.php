<?php
/**
 * SKD Admission System — Staff / Admin Login
 * Validates username + password against the branches table (PDO).
 */

define('ROOT_PATH', dirname(__FILE__));
require_once ROOT_PATH . '/config/auth.php';

// Redirect already-logged-in staff to their dashboard
if (is_logged_in()) {
    $role = session_role();
    if ($role === 'super_admin') {
        header('Location: admin/dashboard.php'); exit;
    } elseif ($role === 'branch') {
        header('Location: branch/dashboard.php'); exit;
    }
}

$error   = '';
$success = '';
$prefill = '';

// ─── POST Handler ─────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $branch = auth_login_staff($username, $password);

        if ($branch) {
            set_staff_session($branch);
            flash_set('success', 'Welcome back, ' . e($branch['name']) . '!');

            // Route by role
            if ($branch['role'] === 'super_admin') {
                header('Location: admin/dashboard.php'); exit;
            } else {
                header('Location: branch/dashboard.php'); exit;
            }
        } else {
            $error   = 'Invalid username or password. Please try again.';
            $prefill = e($username);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — S.K.D Admission System</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Tailwind CSS (compiled styles) -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        [data-lucide] {
            display: inline-block;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }
        .error-box {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body class="bg-background text-foreground antialiased font-sans min-h-screen">

<div class="min-h-screen grid lg:grid-cols-2 bg-background">
    <!-- Left Column: Login Form -->
    <div class="flex items-center justify-center p-6 lg:p-12">
        <div class="w-full max-w-md">
            <div class="flex items-center gap-3 mb-8">
                <img src="assets/images/skd-logo.png" alt="S.K.D" class="h-12 w-12 object-contain" />
                <div>
                    <div class="text-base font-bold">S.K.D Admission System</div>
                    <div class="text-xs text-muted-foreground">Multi-Branch Management</div>
                </div>
            </div>
            <h1 class="text-2xl font-semibold mb-1">Welcome back</h1>
            <p class="text-sm text-muted-foreground mb-7">Sign in to access your admin or branch dashboard.</p>

            <?php if ($error): ?>
            <div class="error-box">
                <i data-lucide="alert-circle" style="width:16px;height:16px;flex-shrink:0;"></i>
                <?= $error ?>
            </div>
            <?php endif; ?>

            <form class="space-y-4" action="login.php" method="POST" id="login-form">
                <div>
                    <label class="form-label" for="username">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground w-4 h-4"></i>
                        <input
                            id="username"
                            name="username"
                            class="form-input pl-9"
                            placeholder="Enter your username"
                            value="<?= $prefill ?>"
                            required
                            autocomplete="username"
                        />
                    </div>
                </div>
                <div>
                    <label class="form-label" for="password">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground w-4 h-4"></i>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-input pl-9"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        />
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-muted-foreground">
                        <input name="remember" type="checkbox" class="rounded border-border" /> Remember me
                    </label>
                    <a href="#" class="text-primary font-medium">Forgot password?</a>
                </div>
                <button type="submit" id="submit-btn" class="btn btn-primary w-full">Sign in</button>
                <div class="text-center text-sm text-muted-foreground pt-2">
                    Are you a student? <a href="student-login.php" class="text-primary font-medium">Student login</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Hero Banner -->
    <div class="hidden lg:flex relative overflow-hidden items-center justify-center p-12" style="background: var(--gradient-hero)">
        <div class="absolute inset-0 opacity-20" style="
            background-image: radial-gradient(circle at 20% 20%, white 1px, transparent 1px), radial-gradient(circle at 80% 60%, white 1px, transparent 1px);
            background-size: 40px 40px, 60px 60px;
        "></div>
        <div class="relative max-w-md text-white">
            <div class="inline-block px-3 py-1 rounded-full bg-white/15 backdrop-blur text-xs font-medium mb-5">
                Administrative Console
            </div>
            <h2 class="text-3xl font-bold leading-tight mb-4">
                Manage branches, admissions &amp; fees from one place.
            </h2>
            <p class="text-white/80 text-sm mb-8 leading-relaxed">
                A lightweight, modern admission management system built for multi-branch institutes.
                Fast, mobile-friendly, and ready for your team.
            </p>
            <div class="grid grid-cols-3 gap-4">
                <div class="rounded-lg bg-white/10 backdrop-blur p-4 border border-white/15">
                    <div class="text-2xl font-bold">3</div>
                    <div class="text-[11px] text-white/75 mt-1">Branches</div>
                </div>
                <div class="rounded-lg bg-white/10 backdrop-blur p-4 border border-white/15">
                    <div class="text-2xl font-bold">10+</div>
                    <div class="text-[11px] text-white/75 mt-1">Students</div>
                </div>
                <div class="rounded-lg bg-white/10 backdrop-blur p-4 border border-white/15">
                    <div class="text-2xl font-bold">100%</div>
                    <div class="text-[11px] text-white/75 mt-1">Secure</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
    // Show loading state on submit
    document.getElementById('login-form').addEventListener('submit', function() {
        var btn = document.getElementById('submit-btn');
        btn.textContent = 'Signing in…';
        btn.disabled = true;
    });
</script>
</body>
</html>
