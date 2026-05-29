<?php
/**
 * SKD Admission System — Authentication & Route Guards
 * Middleware functions to protect pages based on role.
 *
 * Usage (at the very top of any protected page):
 *   require_once '../config/auth.php';
 *   require_admin();   // only super_admin
 *   require_staff();   // super_admin OR branch
 *   require_branch();  // only branch
 *   require_student(); // only student
 */

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/functions.php';

// Boot the session immediately when auth.php is included.
session_boot();

// ─── Staff Login ──────────────────────────────────────────────────────────────

/**
 * Validate username + password against the branches table.
 * Returns the branch row array on success, or null on failure.
 */
function auth_login_staff(string $username, string $password): ?array
{
    $stmt = db()->prepare(
        "SELECT b.*, b.name AS branch_name
         FROM branches b
         WHERE b.username = :username AND b.status = 'Active'
         LIMIT 1"
    );
    $stmt->execute([':username' => trim($username)]);
    $branch = $stmt->fetch();

    if (!$branch || !password_verify($password, $branch['password'])) {
        return null;
    }

    return $branch;
}

// ─── Student Login ────────────────────────────────────────────────────────────

/**
 * Validate student_id + mobile against the students table (passwordless).
 * Returns the student row (with joined branch branding) on success, or null.
 */
function auth_login_student(string $student_id, string $mobile): ?array
{
    $stmt = db()->prepare(
        "SELECT s.*, s.full_name,
                b.name         AS branch_name,
                b.brand_name,
                b.primary_color,
                b.logo,
                b.phone,
                b.whatsapp,
                b.email,
                b.address
         FROM students s
         JOIN branches b ON s.branch_id = b.id
         WHERE s.student_id = :sid
           AND s.mobile     = :mobile
           AND s.status     = 'Active'
         LIMIT 1"
    );
    $stmt->execute([
        ':sid'    => strtoupper(trim($student_id)),
        ':mobile' => trim($mobile),
    ]);
    return $stmt->fetch() ?: null;
}

// ─── Route Guard Middleware ───────────────────────────────────────────────────

/**
 * Allow only super_admin. Redirects others to login.
 */
function require_admin(): void
{
    if (!is_logged_in() || session_role() !== 'super_admin') {
        _redirect_to_login();
    }
}

/**
 * Allow super_admin or branch users (staff).
 * Branch users only see their own data — enforcement happens in queries.
 */
function require_staff(): void
{
    if (!is_logged_in() || !in_array(session_role(), ['super_admin', 'branch'], true)) {
        _redirect_to_login();
    }
}

/**
 * Allow only branch users. Redirects super_admin to admin dashboard.
 */
function require_branch(): void
{
    if (!is_logged_in()) {
        _redirect_to_login();
    }
    if (session_role() === 'super_admin') {
        // Super admin can visit, but redirect to their own dashboard
        _redirect_up('admin/dashboard.php');
    }
    if (session_role() !== 'branch') {
        _redirect_to_login();
    }
}

/**
 * Allow only students. Redirects non-students to student login.
 */
function require_student(): void
{
    if (!is_logged_in() || session_role() !== 'student') {
        _redirect_to_student_login();
    }
}

// ─── Helpers ─────────────────────────────────────────────────────────────────

/**
 * Detect the directory depth of the current file and build a redirect path.
 */
function _redirect_to_login(): void
{
    $depth = _get_depth();
    $path  = str_repeat('../', $depth) . 'login.php';
    header('Location: ' . $path);
    exit;
}

function _redirect_to_student_login(): void
{
    $depth = _get_depth();
    $path  = str_repeat('../', $depth) . 'student-login.php';
    header('Location: ' . $path);
    exit;
}

function _redirect_up(string $target): void
{
    $depth = _get_depth();
    $path  = str_repeat('../', $depth) . $target;
    header('Location: ' . $path);
    exit;
}

/**
 * Returns how many directory levels deep the calling script is,
 * relative to the project root.
 */
function _get_depth(): int
{
    $root   = realpath(ROOT_PATH);
    $caller = realpath(dirname($_SERVER['SCRIPT_FILENAME']));
    if (!$root || !$caller) return 1;

    $rel = str_replace($root, '', $caller);
    $rel = trim(str_replace(['/', '\\'], '/', $rel), '/');
    return ($rel === '') ? 0 : count(explode('/', $rel));
}

/**
 * Returns the branch_id filter for SQL queries.
 * Super admin gets null (no restriction); branch users get their own ID.
 */
function get_branch_filter(): ?int
{
    if (session_role() === 'super_admin') return null;
    return isset($_SESSION['branch_id']) ? (int) $_SESSION['branch_id'] : null;
}
