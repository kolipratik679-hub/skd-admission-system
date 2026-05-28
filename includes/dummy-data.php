<?php
/**
 * S.K.D Admission System — Centralized Dummy Data & Branding Setup
 * This file serves as the single source of truth for mock data,
 * making future database integration extremely simple.
 */

// ─── 1. SIMULATED BRANDS / BRANCHES ──────────────────────────────────────────
$mock_branches = [
    'Pune Camp' => [
        'id' => 1,
        'name' => 'Pune Camp',
        'brand_name' => 'S.K.D Computer Education',
        'logo' => 'assets/images/skd-logo.png',
        'contact' => '+91 98220 11111',
        'whatsapp' => '+91 98220 11111',
        'email' => 'camp@skdedu.com',
        'address' => '1st Floor, Camp, Near Victory Theatre, Pune, Maharashtra 411001',
        'color' => '#2563eb', // Blue
        'username' => 'camp_pune',
        'password' => 'camp@123',
        'status' => 'Active'
    ],
    'Mumbai Central' => [
        'id' => 2,
        'name' => 'Mumbai Central',
        'brand_name' => 'S.K.D IT Institute',
        'logo' => 'assets/images/skd-logo.png',
        'contact' => '+91 98220 22222',
        'whatsapp' => '+91 98220 22222',
        'email' => 'mumbai@skdedu.com',
        'address' => 'Sector 3, Opp Station, Mumbai Central, Mumbai 400008',
        'color' => '#0ea5e9', // Sky Blue
        'username' => 'mumbai_ctr',
        'password' => 'mumbai@123',
        'status' => 'Active'
    ],
    'Nashik Road' => [
        'id' => 3,
        'name' => 'Nashik Road',
        'brand_name' => 'S.K.D Academy',
        'logo' => 'assets/images/skd-logo.png',
        'contact' => '+91 98220 33333',
        'whatsapp' => '+91 98220 33333',
        'email' => 'nashik@skdedu.com',
        'address' => 'Nashik Road, Above HDFC Bank, Nashik, Maharashtra 422101',
        'color' => '#6366f1', // Indigo
        'username' => 'nashik_rd',
        'password' => 'nashik@123',
        'status' => 'Active'
    ],
    'Aurangabad' => [
        'id' => 4,
        'name' => 'Aurangabad',
        'brand_name' => 'S.K.D Info Tech',
        'logo' => 'assets/images/skd-logo.png',
        'contact' => '+91 98220 44444',
        'whatsapp' => '+91 98220 44444',
        'email' => 'abad@skdedu.com',
        'address' => 'Cidco, Near Bus Stand, Aurangabad 431003',
        'color' => '#3b82f6', // Light Blue
        'username' => 'abad_tech',
        'password' => 'abad@123',
        'status' => 'Active'
    ],
    'Nagpur' => [
        'id' => 5,
        'name' => 'Nagpur',
        'brand_name' => 'S.K.D Training Center',
        'logo' => 'assets/images/skd-logo.png',
        'contact' => '+91 98220 55555',
        'whatsapp' => '+91 98220 55555',
        'email' => 'nagpur@skdedu.com',
        'address' => 'Sadar, Residency Road, Nagpur 440001',
        'color' => '#8b5cf6', // Violet
        'username' => 'nagpur_trn',
        'password' => 'nagpur@123',
        'status' => 'Inactive'
    ]
];

// ─── 2. SIMULATED ACTIVE SESSION IDENTITY ───────────────────────────────────
// In actual backend integration, these will read from session storage (e.g. $_SESSION['branch'])
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));

if ($current_dir === 'branch') {
    // Default logged in branch for branch user
    $active_branch_key = 'Pune Camp';
} else {
    // Super admin default head office simulated identity
    $active_branch_key = 'Pune Camp';
}

$active_branch = $mock_branches[$active_branch_key];

// Dynamic Branding placeholders
$db_branch_name    = $active_branch['name'];
$db_brand_name     = $active_branch['brand_name'];
$db_branch_logo    = $active_branch['logo'];
$db_branch_contact = $active_branch['contact'];
$db_branch_whatsapp= $active_branch['whatsapp'];
$db_branch_email   = $active_branch['email'];
$db_branch_address = $active_branch['address'];
$db_branch_color   = $active_branch['color'];

// ─── 3. SIMULATED STUDENTS DATABASE ──────────────────────────────────────────
$mock_students = [
    [
        'id' => 'SKD-2025-0142',
        'name' => 'Rahul Sharma',
        'gender' => 'Male',
        'dob' => '12 Aug 2003',
        'father' => 'Suresh Sharma',
        'mother' => 'Meera Sharma',
        'mobile' => '+91 98765 43210',
        'email' => 'rahul@email.com',
        'branch' => 'Pune Camp',
        'course' => 'DCA',
        'duration' => '6 Months',
        'admission_date' => '12 Jan 2025',
        'photo' => 'assets/images/placeholder-avatar.png',
        'fees_total' => 15000,
        'fees_paid' => 15000,
        'fees_discount' => 500,
        'fees_balance' => 0,
        'status' => 'Active'
    ],
    [
        'id' => 'SKD-2025-0141',
        'name' => 'Priya Nair',
        'gender' => 'Female',
        'dob' => '22 Oct 2004',
        'father' => 'K. Nair',
        'mother' => 'Sunita Nair',
        'mobile' => '+91 98765 43211',
        'email' => 'priya@email.com',
        'branch' => 'Pune Camp',
        'course' => 'Tally Prime',
        'duration' => '3 Months',
        'admission_date' => '10 Jan 2025',
        'photo' => 'assets/images/placeholder-avatar.png',
        'fees_total' => 8000,
        'fees_paid' => 4000,
        'fees_discount' => 0,
        'fees_balance' => 4000,
        'status' => 'Active'
    ],
    [
        'id' => 'SKD-2025-0140',
        'name' => 'Aman Verma',
        'gender' => 'Male',
        'dob' => '05 Jan 2002',
        'father' => 'Ramesh Verma',
        'mother' => 'Sharda Verma',
        'mobile' => '+91 98765 43212',
        'email' => 'aman@email.com',
        'branch' => 'Mumbai Central',
        'course' => 'Web Design',
        'duration' => '6 Months',
        'admission_date' => '08 Jan 2025',
        'photo' => 'assets/images/placeholder-avatar.png',
        'fees_total' => 18000,
        'fees_paid' => 18000,
        'fees_discount' => 1000,
        'fees_balance' => 0,
        'status' => 'Active'
    ],
    [
        'id' => 'SKD-2025-0139',
        'name' => 'Sneha Patil',
        'gender' => 'Female',
        'dob' => '15 Nov 2003',
        'father' => 'Vijay Patil',
        'mother' => 'Lata Patil',
        'mobile' => '+91 98765 43213',
        'email' => 'sneha@email.com',
        'branch' => 'Nashik Road',
        'course' => 'ADCA',
        'duration' => '12 Months',
        'admission_date' => '05 Jan 2025',
        'photo' => 'assets/images/placeholder-avatar.png',
        'fees_total' => 25000,
        'fees_paid' => 10000,
        'fees_discount' => 1500,
        'fees_balance' => 13500,
        'status' => 'Active'
    ],
    [
        'id' => 'SKD-2025-0138',
        'name' => 'Karan Mehta',
        'gender' => 'Male',
        'dob' => '30 Jul 2002',
        'father' => 'Pradeep Mehta',
        'mother' => 'Anjali Mehta',
        'mobile' => '+91 98765 43214',
        'email' => 'karan@email.com',
        'branch' => 'Pune Camp',
        'course' => 'CCC',
        'duration' => '3 Months',
        'admission_date' => '02 Jan 2025',
        'photo' => 'assets/images/placeholder-avatar.png',
        'fees_total' => 4500,
        'fees_paid' => 4500,
        'fees_discount' => 0,
        'fees_balance' => 0,
        'status' => 'Completed'
    ]
];

// ─── 4. SIMULATED CERTIFICATES DATABASE ──────────────────────────────────────
$mock_certificates = [
    [
        'student_id' => 'SKD-2025-0142',
        'student_name' => 'Rahul Sharma',
        'course' => 'DCA',
        'certificate_name' => 'Rahul_Sharma_DCA_Completion.pdf',
        'issue_date' => '20 May 2026',
        'file_size' => '245 KB',
        'uploaded_by' => 'Super Admin',
        'file_type' => 'pdf'
    ],
    [
        'student_id' => 'SKD-2025-0141',
        'student_name' => 'Priya Nair',
        'course' => 'Tally Prime',
        'certificate_name' => 'Priya_Nair_Tally_Bonafide.png',
        'issue_date' => '19 May 2026',
        'file_size' => '1.2 MB',
        'uploaded_by' => 'Pune Camp',
        'file_type' => 'png'
    ],
    [
        'student_id' => 'SKD-2025-0140',
        'student_name' => 'Aman Verma',
        'course' => 'Web Design',
        'certificate_name' => 'Aman_Verma_Web_Design.jpg',
        'issue_date' => '18 May 2026',
        'file_size' => '840 KB',
        'uploaded_by' => 'Mumbai Central',
        'file_type' => 'jpg'
    ]
];
