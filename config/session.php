<?php
/**
 * SKD Admission System — Session Management
 * Handles secure session initialization and helpers.
 */

require_once __DIR__ . '/config.php';

/**
 * Start the application session securely.
 * Called once at the top of auth.php — never call directly.
 */
function session_boot(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_name(SESSION_NAME);
        session_set_cookie_params([
            'lifetime' => SESSION_LIFETIME,
            'path'     => '/',
            'secure'   => false,      // set true in production with HTTPS
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
        session_start();
    }
}

/**
 * Returns true if any user (admin, branch, or student) is logged in.
 */
function is_logged_in(): bool
{
    return !empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Returns the role of the currently active session.
 * Possible values: 'super_admin' | 'branch' | 'student' | null
 */
function session_role(): ?string
{
    return $_SESSION['role'] ?? null;
}

/**
 * Set admin / branch login session variables.
 * Called after successful credentials check.
 */
function set_staff_session(array $branch): void
{
    session_regenerate_id(true);

    $_SESSION['logged_in']      = true;
    $_SESSION['role']           = $branch['role'];           // 'super_admin' | 'branch'
    $_SESSION['user_id']        = $branch['id'];
    $_SESSION['username']       = $branch['username'];
    $_SESSION['branch_id']      = ($branch['role'] === 'super_admin') ? null : $branch['id'];
    $_SESSION['branch_name']    = $branch['branch_name'];
    $_SESSION['brand_name']     = $branch['brand_name'];
    $_SESSION['branch_color']   = $branch['primary_color'];
    $_SESSION['branch_logo']    = $branch['logo'] ?? 'assets/images/skd-logo.png';
    $_SESSION['branch_contact'] = $branch['phone'];
    $_SESSION['branch_whatsapp']= $branch['whatsapp'] ?? $branch['phone'];
    $_SESSION['branch_email']   = $branch['email'];
    $_SESSION['branch_address'] = $branch['address'];
}

/**
 * Set student login session variables.
 * Called after successful student_id + mobile verification.
 */
function set_student_session(array $student): void
{
    session_regenerate_id(true);

    $_SESSION['logged_in']    = true;
    $_SESSION['role']         = 'student';
    $_SESSION['student_id']   = $student['student_id'];
    $_SESSION['student_name'] = $student['full_name'];
    $_SESSION['branch_id']    = $student['branch_id'];

    // Branding: load from joined branch row if available
    if (!empty($student['primary_color'])) {
        $_SESSION['branch_color']   = $student['primary_color'];
        $_SESSION['branch_name']    = $student['branch_name'];
        $_SESSION['brand_name']     = $student['brand_name'];
        $_SESSION['branch_logo']    = $student['logo'] ?? 'assets/images/skd-logo.png';
        $_SESSION['branch_contact'] = $student['phone'];
        $_SESSION['branch_whatsapp']= $student['whatsapp'] ?? $student['phone'];
        $_SESSION['branch_email']   = $student['email'];
        $_SESSION['branch_address'] = $student['address'];
    }
}

/**
 * Destroy the session completely and redirect to login page.
 */
function session_destroy_all(string $redirect = '../login.php'): void
{
    session_boot();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
    header('Location: ' . $redirect);
    exit;
}

/**
 * Flash message: set a one-time message in session.
 */
function flash_set(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Flash message: get and clear one-time message.
 * Returns ['type' => ..., 'message' => ...] or null.
 */
function flash_get(): ?array
{
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
