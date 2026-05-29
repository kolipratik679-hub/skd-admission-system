<?php
/**
 * SKD Admission System — Student Portal Login
 * Validates Student ID + Mobile (passwordless) against the students table.
 */

define('ROOT_PATH', dirname(__FILE__));
require_once ROOT_PATH . '/config/auth.php';

// Redirect already-logged-in students to their portal
if (is_logged_in() && session_role() === 'student') {
    header('Location: portal/profile.php'); exit;
}

$error   = '';
$prefill = '';

// ─── POST Handler ─────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = strtoupper(clean_input($_POST['student_id'] ?? ''));
    $mobile     = clean_phone($_POST['mobile'] ?? '');

    if (empty($student_id) || empty($mobile)) {
        $error = 'Please enter both your Student ID and mobile number.';
    } else {
        $student = auth_login_student($student_id, $mobile);

        if ($student) {
            set_student_session($student);
            header('Location: portal/profile.php'); exit;
        } else {
            $error   = 'Student ID and mobile number do not match. Please check your credentials.';
            $prefill = e($student_id);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login — S.K.D Portal</title>
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
    <!-- Left Column: Student Login Form -->
    <div class="flex items-center justify-center p-6 lg:p-12">
        <div class="w-full max-w-md">
            <div class="flex items-center gap-3 mb-8">
                <img src="assets/images/skd-logo.png" alt="S.K.D" class="h-12 w-12 object-contain" />
                <div>
                    <div class="text-base font-bold">S.K.D Admission System</div>
                    <div class="text-xs text-muted-foreground">Student Self-Service Portal</div>
                </div>
            </div>
            <h1 class="text-2xl font-semibold mb-1">Student Portal</h1>
            <p class="text-sm text-muted-foreground mb-7">Login with your Student ID and registered mobile number.</p>

            <?php if ($error): ?>
            <div class="error-box">
                <i data-lucide="alert-circle" style="width:16px;height:16px;flex-shrink:0;"></i>
                <?= $error ?>
            </div>
            <?php endif; ?>

            <form class="space-y-4" action="student-login.php" method="POST" id="student-login-form">
                <div>
                    <label class="form-label" for="student_id">Student ID</label>
                    <div class="relative">
                        <i data-lucide="id-card" class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground w-4 h-4"></i>
                        <input
                            id="student_id"
                            name="student_id"
                            class="form-input pl-9"
                            placeholder="e.g. SKD2026-0001"
                            value="<?= $prefill ?>"
                            required
                            autocomplete="username"
                            style="text-transform:uppercase;"
                        />
                    </div>
                </div>
                <div>
                    <label class="form-label" for="mobile">Mobile Number</label>
                    <div class="relative">
                        <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground w-4 h-4"></i>
                        <input
                            id="mobile"
                            name="mobile"
                            class="form-input pl-9"
                            placeholder="Registered mobile number"
                            required
                            autocomplete="tel"
                            type="tel"
                        />
                    </div>
                </div>
                <button type="submit" id="portal-btn" class="btn btn-primary w-full">Login to Portal</button>
                <div class="text-center text-sm text-muted-foreground pt-2">
                    Staff member? <a href="login.php" class="text-primary font-medium">Admin / branch login</a>
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
                Student Self-Service
            </div>
            <h2 class="text-3xl font-bold leading-tight mb-4">
                Your admission, fees and certificates — all in one portal.
            </h2>
            <p class="text-white/80 text-sm mb-8 leading-relaxed">
                Access your personal profile, fee receipts, ID card, and issued certificates
                — anytime, anywhere.
            </p>
            <div class="grid grid-cols-3 gap-4">
                <div class="rounded-lg bg-white/10 backdrop-blur p-4 border border-white/15">
                    <div class="text-2xl font-bold">📋</div>
                    <div class="text-[11px] text-white/75 mt-1">Profile</div>
                </div>
                <div class="rounded-lg bg-white/10 backdrop-blur p-4 border border-white/15">
                    <div class="text-2xl font-bold">💳</div>
                    <div class="text-[11px] text-white/75 mt-1">Fees</div>
                </div>
                <div class="rounded-lg bg-white/10 backdrop-blur p-4 border border-white/15">
                    <div class="text-2xl font-bold">🏆</div>
                    <div class="text-[11px] text-white/75 mt-1">Certificates</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
    // Auto-uppercase student ID input
    document.getElementById('student_id').addEventListener('input', function() {
        var pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
    });
    // Show loading state on submit
    document.getElementById('student-login-form').addEventListener('submit', function() {
        var btn = document.getElementById('portal-btn');
        btn.textContent = 'Verifying…';
        btn.disabled = true;
    });
</script>
</body>
</html>
