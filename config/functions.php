<?php
/**
 * SKD Admission System — Global Helper Functions
 * Pure utility functions used across all pages.
 * No DB calls here — keep this file dependency-free.
 */

// ─── String Helpers ───────────────────────────────────────────────────────────

/**
 * Sanitize a string for safe HTML output.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Sanitize and trim user input.
 */
function clean_input(string $value): string
{
    return trim(strip_tags($value));
}

/**
 * Sanitize a phone number to digits only.
 */
function clean_phone(string $phone): string
{
    return preg_replace('/[^0-9+]/', '', trim($phone));
}

// ─── Student ID Generator ─────────────────────────────────────────────────────

/**
 * Generate the next student ID in format SKD2026-0001.
 * Queries the DB for the current year's count to avoid gaps.
 */
function generate_student_id(): string
{
    $year = date('Y');
    $prefix = STUDENT_ID_PREFIX . $year . '-';

    $stmt = db()->prepare(
        "SELECT COUNT(*) FROM students WHERE student_id LIKE :prefix"
    );
    $stmt->execute([':prefix' => $prefix . '%']);
    $count = (int) $stmt->fetchColumn();

    return $prefix . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
}

// ─── Currency & Number Helpers ────────────────────────────────────────────────

/**
 * Format a number as Indian Rupee. Example: 15000 → ₹15,000
 */
function format_money(float $amount): string
{
    return '₹' . number_format($amount, 0, '.', ',');
}

/**
 * Format a decimal amount with 2 places. Example: 15000 → ₹15,000.00
 */
function format_money_full(float $amount): string
{
    return '₹' . number_format($amount, 2, '.', ',');
}

// ─── Date Helpers ─────────────────────────────────────────────────────────────

/**
 * Format a MySQL date (YYYY-MM-DD) to human-readable (e.g. 01 Jan 2026).
 */
function format_date(string $date): string
{
    if (!$date) return '—';
    $ts = strtotime($date);
    return $ts ? date('d M Y', $ts) : $date;
}

/**
 * Get the current timestamp string for logging.
 */
function now(): string
{
    return date('Y-m-d H:i:s');
}

// ─── Status Badge Helpers ─────────────────────────────────────────────────────

/**
 * Returns Tailwind CSS classes for a student status badge.
 */
function status_badge_class(string $status): string
{
    return match ($status) {
        'Active'    => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'Completed' => 'bg-blue-50 text-blue-700 border border-blue-200',
        'Dropped'   => 'bg-red-50 text-red-700 border border-red-200',
        default     => 'bg-gray-100 text-gray-600',
    };
}

/**
 * Returns Tailwind CSS classes for a fee status badge.
 */
function fee_badge_class(string $status): string
{
    return match ($status) {
        'Success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'Pending' => 'bg-amber-50 text-amber-700 border border-amber-200',
        'Failed'  => 'bg-red-50 text-red-700 border border-red-200',
        default   => 'bg-gray-100 text-gray-600',
    };
}

// ─── File Upload Helpers ──────────────────────────────────────────────────────

/**
 * Get the file extension in lowercase from a filename.
 */
function get_extension(string $filename): string
{
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Format bytes to a human-readable file size string.
 */
function format_filesize(int $bytes): string
{
    if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
    if ($bytes >= 1024)    return round($bytes / 1024, 1) . ' KB';
    return $bytes . ' B';
}

/**
 * Generate the standard normalized filename for a student upload.
 * Example: ('SKD2026-0001', 'photo', 'jpg') → 'SKD2026-0001-photo.jpg'
 */
function student_filename(string $student_id, string $type, string $ext): string
{
    return $student_id . '-' . $type . '.' . $ext;
}

// ─── Redirect Helper ──────────────────────────────────────────────────────────

/**
 * Redirect and exit immediately.
 */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

// ─── JSON Response ────────────────────────────────────────────────────────────

/**
 * Send a JSON response and exit. Used in AJAX endpoints.
 */
function json_response(bool $success, string $message, array $data = []): void
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(
        ['success' => $success, 'message' => $message],
        $data
    ));
    exit;
}

// ─── Receipt Number Generator ─────────────────────────────────────────────────

/**
 * Generate a unique fee receipt number.
 * Format: RCPT-{YEAR}-{random 6-digit number}
 */
function generate_receipt_no(): string
{
    return 'RCPT-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6));
}
