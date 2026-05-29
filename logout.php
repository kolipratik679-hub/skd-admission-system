<?php
/**
 * SKD Admission System — Logout Handler
 * Destroys the active session and redirects to the correct login page.
 */

define('ROOT_PATH', dirname(__FILE__));
require_once ROOT_PATH . '/config/session.php';

session_boot();

// Determine where to redirect after logout
$role = $_SESSION['role'] ?? null;

// Clear all session data
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}
session_destroy();

// Students go to student-login, everyone else to login
if ($role === 'student') {
    header('Location: student-login.php');
} else {
    header('Location: login.php');
}
exit;
