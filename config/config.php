<?php
/**
 * SKD Admission System — Application Configuration
 * Core constants. Update credentials before production deployment.
 */

// ─── Database Credentials ────────────────────────────────────────────────────
define('DB_HOST',    'localhost');
define('DB_NAME',    'skd_admission');
define('DB_USER',    'root');
define('DB_PASS',    'hello brother');
define('DB_CHARSET', 'utf8mb4');

// ─── Application ─────────────────────────────────────────────────────────────
define('APP_NAME',    'S.K.D Admission System');
define('APP_URL',     'http://localhost/skd-admission');
define('APP_VERSION', '1.0.0');

// ─── Paths ───────────────────────────────────────────────────────────────────
define('ROOT_PATH',   dirname(__DIR__));
define('CONFIG_PATH', __DIR__);
define('UPLOAD_PATH', ROOT_PATH . '/uploads/');

// ─── Upload Limits ───────────────────────────────────────────────────────────
define('UPLOAD_MAX_PHOTO',  2 * 1024 * 1024);  // 2MB for photos / scans
define('UPLOAD_MAX_CERT',   5 * 1024 * 1024);  // 5MB for certificates / zip

// ─── Allowed Upload Extensions ───────────────────────────────────────────────
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'webp']);
define('ALLOWED_DOC_TYPES',   ['jpg', 'jpeg', 'png', 'pdf', 'webp']);
define('ALLOWED_CERT_TYPES',  ['jpg', 'jpeg', 'png', 'pdf', 'webp']);

// ─── Session Config ───────────────────────────────────────────────────────────
define('SESSION_NAME',     'skd_session');
define('SESSION_LIFETIME', 3600); // 1 hour

// ─── Student ID Format ────────────────────────────────────────────────────────
// Format: SKD{YEAR}-{4 digit zero-padded counter}
// Example: SKD2026-0001
define('STUDENT_ID_PREFIX', 'SKD');
