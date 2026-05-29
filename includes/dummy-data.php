<?php
/**
 * SKD Admission System — Branding & Mock Data
 *
 * Priority: Session (real DB) → Mock fallback (development without DB)
 * When a user is logged in (session set by config/auth.php), branding
 * variables are loaded from $_SESSION. Otherwise mock data is used.
 */

// ─── SESSION-BASED BRANDING (Production) ─────────────────────────────────────
// These vars are injected here so all pages (header/sidebar/navbar/body)
// can read them without re-querying the DB on every include.

if (!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // ── Staff or Branch Session ──
    $db_branch_name     = $_SESSION['branch_name']     ?? 'Head Office';
    $db_brand_name      = $_SESSION['brand_name']      ?? 'S.K.D Computer Education';
    $db_branch_logo     = $_SESSION['branch_logo']     ?? 'assets/images/skd-logo.png';
    $db_branch_contact  = $_SESSION['branch_contact']  ?? '07073139662';
    $db_branch_whatsapp = $_SESSION['branch_whatsapp'] ?? '07073139662';
    $db_branch_email    = $_SESSION['branch_email']    ?? 'shivkadass.k.d@gmail.com';
    $db_branch_address  = $_SESSION['branch_address']  ?? 'Nerul, Navi Mumbai';
    $db_branch_color    = $_SESSION['branch_color']    ?? '#2563eb';

    // ── Current logged-in identity ──
    $current_role       = $_SESSION['role']         ?? 'branch';
    $current_username   = $_SESSION['username']     ?? '';
    $current_branch_id  = $_SESSION['branch_id']    ?? null;

    // ── Student Session extras ──
    $current_student_id   = $_SESSION['student_id']   ?? null;
    $current_student_name = $_SESSION['student_name'] ?? null;

} else {
    // ─── MOCK FALLBACK — Used when no session / during local preview ─────────
    // Keeps pages renderable during development before DB is connected.

    $db_branch_name     = 'Nerul Branch';
    $db_brand_name      = 'S.K.D Computer Education';
    $db_branch_logo     = 'assets/images/skd-logo.png';
    $db_branch_contact  = '07073139662';
    $db_branch_whatsapp = '07073139662';
    $db_branch_email    = 'shivkadass.k.d@gmail.com';
    $db_branch_address  = 'Nerul Station Complex, F-114, Nerul West, Navi Mumbai';
    $db_branch_color    = '#2563eb';

    $current_role       = 'super_admin';
    $current_username   = 'admin';
    $current_branch_id  = null;
    $current_student_id   = null;
    $current_student_name = null;
}

// ─── MOCK DATA ARRAYS (kept for template pages / development preview) ─────────
// These arrays are not queried in production — they exist only so that
// existing frontend templates don't break before CRUD is implemented.

$mock_branches = [
    'Nerul Branch' => [
        'id'         => 2,
        'name'       => 'Nerul Branch',
        'brand_name' => 'S.K.D Computer Education',
        'logo'       => 'assets/images/skd-logo.png',
        'contact'    => '07073139662',
        'whatsapp'   => '07073139662',
        'email'      => 'shivkadass.k.d@gmail.com',
        'address'    => 'Nerul Station Complex, F-114, Nerul West, Navi Mumbai, Maharashtra 400706',
        'color'      => '#2563eb',
        'username'   => 'skdnerul',
        'status'     => 'Active',
    ],
    'NCA Chopanki' => [
        'id'         => 3,
        'name'       => 'NCA Chopanki',
        'brand_name' => 'NCA COACHING CENTER',
        'logo'       => 'assets/images/skd-logo.png',
        'contact'    => '9876543211',
        'whatsapp'   => '9876543211',
        'email'      => 'ncacoaching@gmail.com',
        'address'    => 'MUSTAK MARKET CHOPANKI ALWAR (RAJ.)',
        'color'      => '#0891b2',
        'username'   => 'nca',
        'status'     => 'Active',
    ],
    'A1 Bhiwadi' => [
        'id'         => 4,
        'name'       => 'A1 Bhiwadi',
        'brand_name' => 'A1 Computer Education',
        'logo'       => 'assets/images/skd-logo.png',
        'contact'    => '9876543212',
        'whatsapp'   => '9876543212',
        'email'      => 'a1computer@gmail.com',
        'address'    => 'CENTER MARKET BHIWADI (RAJ.)',
        'color'      => '#6366f1',
        'username'   => 'a1computer',
        'status'     => 'Active',
    ],
];

$mock_students = [
    [
        'id'             => 'SKD2026-0001',
        'name'           => 'Rahul Sharma',
        'gender'         => 'Male',
        'dob'            => '14 May 2002',
        'father'         => 'Ramesh Sharma',
        'mother'         => 'Sunita Sharma',
        'mobile'         => '9876543210',
        'email'          => 'rahul@example.com',
        'branch'         => 'Nerul Branch',
        'course'         => 'DCA',
        'duration'       => '6 Months',
        'admission_date' => '10 Jan 2026',
        'photo'          => 'assets/images/placeholder-avatar.png',
        'fees_total'     => 15000,
        'fees_paid'      => 15000,
        'fees_discount'  => 0,
        'fees_balance'   => 0,
        'status'         => 'Active',
    ],
    [
        'id'             => 'SKD2026-0002',
        'name'           => 'Priya Nair',
        'gender'         => 'Female',
        'dob'            => '22 Aug 2003',
        'father'         => 'Suresh Nair',
        'mother'         => 'Meena Nair',
        'mobile'         => '9876543211',
        'email'          => 'priya@example.com',
        'branch'         => 'Nerul Branch',
        'course'         => 'Tally Prime',
        'duration'       => '3 Months',
        'admission_date' => '15 Jan 2026',
        'photo'          => 'assets/images/placeholder-avatar.png',
        'fees_total'     => 8000,
        'fees_paid'      => 4000,
        'fees_discount'  => 0,
        'fees_balance'   => 4000,
        'status'         => 'Active',
    ],
    [
        'id'             => 'SKD2026-0003',
        'name'           => 'Aman Verma',
        'gender'         => 'Male',
        'dob'            => '05 Nov 2001',
        'father'         => 'Rajesh Verma',
        'mother'         => 'Kavita Verma',
        'mobile'         => '9876543212',
        'email'          => 'aman@example.com',
        'branch'         => 'Nerul Branch',
        'course'         => 'Web Design',
        'duration'       => '6 Months',
        'admission_date' => '01 Feb 2026',
        'photo'          => 'assets/images/placeholder-avatar.png',
        'fees_total'     => 18000,
        'fees_paid'      => 18000,
        'fees_discount'  => 0,
        'fees_balance'   => 0,
        'status'         => 'Active',
    ],
    [
        'id'             => 'SKD2026-0004',
        'name'           => 'Kiran Mehta',
        'gender'         => 'Male',
        'dob'            => '18 Mar 2004',
        'father'         => 'Vijay Mehta',
        'mother'         => 'Asha Mehta',
        'mobile'         => '9876543213',
        'email'          => 'kiran@example.com',
        'branch'         => 'Nerul Branch',
        'course'         => 'CCC',
        'duration'       => '3 Months',
        'admission_date' => '10 Feb 2026',
        'photo'          => 'assets/images/placeholder-avatar.png',
        'fees_total'     => 4500,
        'fees_paid'      => 4500,
        'fees_discount'  => 0,
        'fees_balance'   => 0,
        'status'         => 'Completed',
    ],
    [
        'id'             => 'SKD2026-0005',
        'name'           => 'Sneha Patil',
        'gender'         => 'Female',
        'dob'            => '30 Jul 2003',
        'father'         => 'Ganesh Patil',
        'mother'         => 'Rekha Patil',
        'mobile'         => '9876543214',
        'email'          => 'sneha@example.com',
        'branch'         => 'NCA Chopanki',
        'course'         => 'ADCA',
        'duration'       => '12 Months',
        'admission_date' => '20 Jan 2026',
        'photo'          => 'assets/images/placeholder-avatar.png',
        'fees_total'     => 25000,
        'fees_paid'      => 17000,
        'fees_discount'  => 500,
        'fees_balance'   => 7500,
        'status'         => 'Active',
    ],
];

$mock_certificates = [
    [
        'student_id'       => 'SKD2026-0001',
        'student_name'     => 'Rahul Sharma',
        'course'           => 'DCA',
        'certificate_name' => 'Rahul_Sharma_DCA_Completion.pdf',
        'issue_date'       => '20 May 2026',
        'file_size'        => '245 KB',
        'uploaded_by'      => 'admin',
        'file_type'        => 'pdf',
    ],
    [
        'student_id'       => 'SKD2026-0002',
        'student_name'     => 'Priya Nair',
        'course'           => 'Tally Prime',
        'certificate_name' => 'Priya_Nair_Tally_Bonafide.png',
        'issue_date'       => '19 May 2026',
        'file_size'        => '1.2 MB',
        'uploaded_by'      => 'skdnerul',
        'file_type'        => 'png',
    ],
];

// Active branch for template rendering (uses session data if available)
$active_branch = [
    'name'     => $db_branch_name,
    'brand_name' => $db_brand_name,
    'logo'     => $db_branch_logo,
    'contact'  => $db_branch_contact,
    'whatsapp' => $db_branch_whatsapp,
    'email'    => $db_branch_email,
    'address'  => $db_branch_address,
    'color'    => $db_branch_color,
];
