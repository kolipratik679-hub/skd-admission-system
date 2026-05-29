<?php
/**
 * SKD Admission System — Database Seeder
 *
 * Inserts branches (super admin + 3 branches) and 10 sample students
 * with properly hashed passwords using PHP's password_hash().
 *
 * ─── HOW TO RUN ───────────────────────────────────────────────────────────────
 * Option A — Browser:   http://localhost/skd-admission/database/seed.php
 * Option B — CLI:       php database/seed.php
 *
 * IMPORTANT: Delete or protect this file after seeding in production!
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

// --- Bootstrap ----------------------------------------------------------------
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/config/functions.php';

// Prevent running in CLI accidentally without confirmation
if (PHP_SAPI !== 'cli' && !isset($_GET['confirm'])) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>SKD Seeder</title>
        <meta charset="UTF-8">
        <style>
            body { font-family: sans-serif; max-width: 600px; margin: 60px auto; }
            .btn { background: #2563eb; color: white; padding: 10px 24px;
                   border: none; border-radius: 6px; font-size: 16px; cursor: pointer; text-decoration: none; display: inline-block; }
            .warn { background: #fef3c7; border: 1px solid #f59e0b; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        </style>
    </head>
    <body>
        <h2>🌱 SKD Admission System — Seeder</h2>
        <div class="warn">⚠️ This will insert seed data into your database. Run only once.</div>
        <a href="?confirm=1" class="btn">▶ Run Seeder Now</a>
    </body>
    </html>';
    exit;
}

$pdo = db();
$log = [];
$errors = [];

function log_ok(string $msg): void  { global $log;    $log[]    = "✅ $msg"; }
function log_err(string $msg): void { global $errors; $errors[] = "❌ $msg"; }

// --- Truncate existing seed data ---------------------------------------------
try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("TRUNCATE TABLE whatsapp_logs");
    $pdo->exec("TRUNCATE TABLE documents");
    $pdo->exec("TRUNCATE TABLE certificates");
    $pdo->exec("TRUNCATE TABLE fees");
    $pdo->exec("TRUNCATE TABLE students");
    $pdo->exec("TRUNCATE TABLE branches");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    log_ok("Cleared existing data.");
} catch (PDOException $e) {
    log_err("Could not clear tables: " . $e->getMessage());
}

// =============================================================================
// BRANCHES (includes super admin)
// =============================================================================
$branches = [
    [
        'name'          => 'Head Office',
        'brand_name'    => 'S.K.D Computer Education',
        'logo'          => 'assets/images/skd-logo.png',
        'phone'         => '07073139662',
        'whatsapp'      => '07073139662',
        'email'         => 'shivkadass.k.d@gmail.com',
        'address'       => 'Nerul Station Complex, First, F-114, Nerul West, Navi Mumbai, Maharashtra 400706',
        'primary_color' => '#2563eb',
        'username'      => 'admin',
        'password'      => 'admin@123',
        'role'          => 'super_admin',
        'status'        => 'Active',
    ],
    [
        'name'          => 'Nerul Branch',
        'brand_name'    => 'S.K.D Computer Education',
        'logo'          => 'assets/images/skd-logo.png',
        'phone'         => '07073139662',
        'whatsapp'      => '07073139662',
        'email'         => 'shivkadass.k.d@gmail.com',
        'address'       => 'Nerul Station Complex, First, F-114, Nerul West, Navi Mumbai, Maharashtra 400706',
        'primary_color' => '#2563eb',
        'username'      => 'skdnerul',
        'password'      => '123456',
        'role'          => 'branch',
        'status'        => 'Active',
    ],
    [
        'name'          => 'NCA Chopanki',
        'brand_name'    => 'NCA COACHING CENTER',
        'logo'          => 'assets/images/skd-logo.png',
        'phone'         => '9876543211',
        'whatsapp'      => '9876543211',
        'email'         => 'ncacoaching@gmail.com',
        'address'       => 'MUSTAK MARKET CHOPANKI ALWAR (RAJ.)',
        'primary_color' => '#0891b2',
        'username'      => 'nca',
        'password'      => '123456',
        'role'          => 'branch',
        'status'        => 'Active',
    ],
    [
        'name'          => 'A1 Bhiwadi',
        'brand_name'    => 'A1 Computer Education',
        'logo'          => 'assets/images/skd-logo.png',
        'phone'         => '9876543212',
        'whatsapp'      => '9876543212',
        'email'         => 'a1computer@gmail.com',
        'address'       => 'CENTER MARKET BHIWADI (RAJ.)',
        'primary_color' => '#6366f1',
        'username'      => 'a1computer',
        'password'      => '123456',
        'role'          => 'branch',
        'status'        => 'Active',
    ],
];

$insertBranch = $pdo->prepare("
    INSERT INTO branches (name, brand_name, logo, phone, whatsapp, email, address, primary_color, username, password, role, status)
    VALUES (:name, :brand_name, :logo, :phone, :whatsapp, :email, :address, :primary_color, :username, :password, :role, :status)
");

$branchIds = [];
foreach ($branches as $b) {
    try {
        $insertBranch->execute([
            ':name'          => $b['name'],
            ':brand_name'    => $b['brand_name'],
            ':logo'          => $b['logo'],
            ':phone'         => $b['phone'],
            ':whatsapp'      => $b['whatsapp'],
            ':email'         => $b['email'],
            ':address'       => $b['address'],
            ':primary_color' => $b['primary_color'],
            ':username'      => $b['username'],
            ':password'      => password_hash($b['password'], PASSWORD_DEFAULT),
            ':role'          => $b['role'],
            ':status'        => $b['status'],
        ]);
        $branchIds[$b['username']] = (int) $pdo->lastInsertId();
        log_ok("Branch inserted: {$b['name']} ({$b['username']})");
    } catch (PDOException $e) {
        log_err("Branch failed [{$b['username']}]: " . $e->getMessage());
    }
}

// =============================================================================
// STUDENTS (10 students across 3 branches)
// =============================================================================
$nerul  = $branchIds['skdnerul']    ?? 2;
$nca    = $branchIds['nca']         ?? 3;
$a1     = $branchIds['a1computer']  ?? 4;

$students = [
    // Nerul Branch
    ['student_id'=>'SKD2026-0001','full_name'=>'Rahul Sharma',   'gender'=>'Male',  'dob'=>'2002-05-14','father_name'=>'Ramesh Sharma',  'mother_name'=>'Sunita Sharma',  'mobile'=>'9876543210','email'=>'rahul@example.com',  'branch_id'=>$nerul,'course'=>'DCA',        'duration'=>'6 Months','total_fees'=>15000,'admission_date'=>'2026-01-10','status'=>'Active'],
    ['student_id'=>'SKD2026-0002','full_name'=>'Priya Nair',     'gender'=>'Female','dob'=>'2003-08-22','father_name'=>'Suresh Nair',    'mother_name'=>'Meena Nair',     'mobile'=>'9876543211','email'=>'priya@example.com',  'branch_id'=>$nerul,'course'=>'Tally Prime','duration'=>'3 Months','total_fees'=>8000, 'admission_date'=>'2026-01-15','status'=>'Active'],
    ['student_id'=>'SKD2026-0003','full_name'=>'Aman Verma',     'gender'=>'Male',  'dob'=>'2001-11-05','father_name'=>'Rajesh Verma',   'mother_name'=>'Kavita Verma',   'mobile'=>'9876543212','email'=>'aman@example.com',   'branch_id'=>$nerul,'course'=>'Web Design', 'duration'=>'6 Months','total_fees'=>18000,'admission_date'=>'2026-02-01','status'=>'Active'],
    ['student_id'=>'SKD2026-0004','full_name'=>'Kiran Mehta',    'gender'=>'Male',  'dob'=>'2004-03-18','father_name'=>'Vijay Mehta',    'mother_name'=>'Asha Mehta',     'mobile'=>'9876543213','email'=>'kiran@example.com',  'branch_id'=>$nerul,'course'=>'CCC',        'duration'=>'3 Months','total_fees'=>4500, 'admission_date'=>'2026-02-10','status'=>'Completed'],
    // NCA Chopanki Branch
    ['student_id'=>'SKD2026-0005','full_name'=>'Sneha Patil',    'gender'=>'Female','dob'=>'2003-07-30','father_name'=>'Ganesh Patil',   'mother_name'=>'Rekha Patil',    'mobile'=>'9876543214','email'=>'sneha@example.com',  'branch_id'=>$nca,  'course'=>'ADCA',       'duration'=>'12 Months','total_fees'=>25000,'admission_date'=>'2026-01-20','status'=>'Active'],
    ['student_id'=>'SKD2026-0006','full_name'=>'Vishal Sharma',  'gender'=>'Male',  'dob'=>'2002-12-11','father_name'=>'Ashok Sharma',   'mother_name'=>'Poonam Sharma',  'mobile'=>'9876543215','email'=>'vishal@example.com', 'branch_id'=>$nca,  'course'=>'DCA',        'duration'=>'6 Months','total_fees'=>15000,'admission_date'=>'2026-01-25','status'=>'Active'],
    ['student_id'=>'SKD2026-0007','full_name'=>'Pooja Yadav',    'gender'=>'Female','dob'=>'2004-04-22','father_name'=>'Mohan Yadav',    'mother_name'=>'Savita Yadav',   'mobile'=>'9876543216','email'=>'pooja@example.com',  'branch_id'=>$nca,  'course'=>'MS Office',  'duration'=>'3 Months','total_fees'=>6000, 'admission_date'=>'2026-02-05','status'=>'Active'],
    // A1 Bhiwadi Branch
    ['student_id'=>'SKD2026-0008','full_name'=>'Arjun Singh',    'gender'=>'Male',  'dob'=>'2001-09-08','father_name'=>'Harbhajan Singh','mother_name'=>'Manjit Kaur',    'mobile'=>'9876543217','email'=>'arjun@example.com',  'branch_id'=>$a1,   'course'=>'ADCA',       'duration'=>'12 Months','total_fees'=>25000,'admission_date'=>'2026-01-18','status'=>'Active'],
    ['student_id'=>'SKD2026-0009','full_name'=>'Divya Agarwal',  'gender'=>'Female','dob'=>'2003-01-25','father_name'=>'Sunil Agarwal',  'mother_name'=>'Neha Agarwal',   'mobile'=>'9876543218','email'=>'divya@example.com',  'branch_id'=>$a1,   'course'=>'Tally Prime','duration'=>'3 Months','total_fees'=>8000, 'admission_date'=>'2026-02-12','status'=>'Active'],
    ['student_id'=>'SKD2026-0010','full_name'=>'Ravi Kumar',     'gender'=>'Male',  'dob'=>'2002-06-17','father_name'=>'Santosh Kumar',  'mother_name'=>'Anita Kumar',    'mobile'=>'9876543219','email'=>'ravi@example.com',   'branch_id'=>$a1,   'course'=>'CCC',        'duration'=>'3 Months','total_fees'=>4500, 'admission_date'=>'2026-02-20','status'=>'Completed'],
];

$insertStudent = $pdo->prepare("
    INSERT INTO students
        (student_id, full_name, gender, dob, father_name, mother_name,
         mobile, email, branch_id, course, duration, total_fees,
         admission_date, status)
    VALUES
        (:student_id, :full_name, :gender, :dob, :father_name, :mother_name,
         :mobile, :email, :branch_id, :course, :duration, :total_fees,
         :admission_date, :status)
");

foreach ($students as $s) {
    try {
        $insertStudent->execute($s);
        log_ok("Student inserted: {$s['student_id']} — {$s['full_name']}");
    } catch (PDOException $e) {
        log_err("Student failed [{$s['student_id']}]: " . $e->getMessage());
    }
}

// =============================================================================
// FEES (sample payments for first 4 students)
// =============================================================================
$fees = [
    ['student_id'=>'SKD2026-0001','receipt_no'=>'RCPT-2026-AA0001','amount'=>15000,'discount'=>0,   'paid_date'=>'2026-01-10','mode'=>'UPI',          'status'=>'Success'],
    ['student_id'=>'SKD2026-0002','receipt_no'=>'RCPT-2026-BB0002','amount'=>4000, 'discount'=>0,   'paid_date'=>'2026-01-15','mode'=>'Cash',         'status'=>'Success'],
    ['student_id'=>'SKD2026-0005','receipt_no'=>'RCPT-2026-CC0005','amount'=>12000,'discount'=>500, 'paid_date'=>'2026-01-20','mode'=>'Bank Transfer', 'status'=>'Success'],
    ['student_id'=>'SKD2026-0005','receipt_no'=>'RCPT-2026-CC0006','amount'=>5000, 'discount'=>0,   'paid_date'=>'2026-03-01','mode'=>'UPI',          'status'=>'Pending'],
    ['student_id'=>'SKD2026-0008','receipt_no'=>'RCPT-2026-DD0008','amount'=>25000,'discount'=>1000,'paid_date'=>'2026-01-18','mode'=>'Cheque',        'status'=>'Success'],
];

$insertFee = $pdo->prepare("
    INSERT INTO fees (student_id, receipt_no, amount, discount, paid_date, mode, status)
    VALUES (:student_id, :receipt_no, :amount, :discount, :paid_date, :mode, :status)
");

foreach ($fees as $f) {
    try {
        $insertFee->execute($f);
        log_ok("Fee inserted: {$f['receipt_no']} for {$f['student_id']}");
    } catch (PDOException $e) {
        log_err("Fee failed [{$f['receipt_no']}]: " . $e->getMessage());
    }
}

// =============================================================================
// WHATSAPP LOGS (sample log entries)
// =============================================================================
$waLogs = [
    ['branch_id'=>$nerul,'student_id'=>'SKD2026-0001','recipient'=>'9876543210','message'=>'Welcome to SKD Computer Education! Your admission is confirmed. Student ID: SKD2026-0001.','status'=>'Sent'],
    ['branch_id'=>$nerul,'student_id'=>'SKD2026-0002','recipient'=>'9876543211','message'=>'Dear Priya, your fee payment of ₹4,000 has been received. Receipt: RCPT-2026-BB0002.','status'=>'Sent'],
    ['branch_id'=>$nca,  'student_id'=>'SKD2026-0005','recipient'=>'9876543214','message'=>'Dear Sneha, your fee payment of ₹12,000 has been received. Balance due: ₹8,000.','status'=>'Sent'],
    ['branch_id'=>$a1,   'student_id'=>'SKD2026-0008','recipient'=>'9876543217','message'=>'Dear Arjun, your ADCA admission is confirmed at A1 Computer Education. Student ID: SKD2026-0008.','status'=>'Sent'],
];

$insertLog = $pdo->prepare("
    INSERT INTO whatsapp_logs (branch_id, student_id, recipient, message, status)
    VALUES (:branch_id, :student_id, :recipient, :message, :status)
");

foreach ($waLogs as $log_row) {
    try {
        $insertLog->execute($log_row);
        log_ok("WhatsApp log inserted for {$log_row['student_id']}");
    } catch (PDOException $e) {
        log_err("WA log failed: " . $e->getMessage());
    }
}

// =============================================================================
// OUTPUT
// =============================================================================
if (PHP_SAPI === 'cli') {
    foreach ($log as $msg)    echo $msg . PHP_EOL;
    foreach ($errors as $err) echo $err . PHP_EOL;
    echo PHP_EOL . (empty($errors) ? "✅ Seeding complete!" : "⚠️ Seeding finished with errors.") . PHP_EOL;
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SKD Seeder — Results</title>
    <style>
        body  { font-family: system-ui, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 20px; }
        h2    { color: #1e3a5f; }
        .log  { background: #f0fdf4; border: 1px solid #86efac; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; }
        .err  { background: #fef2f2; border: 1px solid #fca5a5; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; }
        li    { margin: 4px 0; font-size: 14px; }
        .cred { background: #eff6ff; border: 1px solid #93c5fd; padding: 16px; border-radius: 8px; }
        .cred table { width: 100%; border-collapse: collapse; }
        .cred th, .cred td { text-align: left; padding: 6px 10px; border-bottom: 1px solid #dbeafe; font-size: 14px; }
        .cred th { color: #1d4ed8; font-weight: 600; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; background: #dbeafe; color: #1e40af; }
    </style>
</head>
<body>
    <h2>🌱 SKD Admission System — Seeder Results</h2>

    <?php if (!empty($log)): ?>
    <div class="log">
        <strong>Operations:</strong>
        <ul><?php foreach ($log as $m) echo "<li>$m</li>"; ?></ul>
    </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
    <div class="err">
        <strong>Errors:</strong>
        <ul><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul>
    </div>
    <?php endif; ?>

    <div class="cred">
        <strong>🔑 Login Credentials</strong><br><br>
        <table>
            <tr><th>Role</th><th>Username</th><th>Password</th><th>Redirect</th></tr>
            <tr><td><span class="badge">Super Admin</span></td><td>admin</td><td>admin@123</td><td>/admin/dashboard.php</td></tr>
            <tr><td><span class="badge">Branch 1</span></td><td>skdnerul</td><td>123456</td><td>/branch/dashboard.php</td></tr>
            <tr><td><span class="badge">Branch 2</span></td><td>nca</td><td>123456</td><td>/branch/dashboard.php</td></tr>
            <tr><td><span class="badge">Branch 3</span></td><td>a1computer</td><td>123456</td><td>/branch/dashboard.php</td></tr>
            <tr><td colspan="4"><em>Student Login (Student ID + Mobile): e.g. SKD2026-0001 + 9876543210</em></td></tr>
        </table>
        <br>
        <strong style="color:#dc2626;">⚠️ Delete or restrict access to this file after seeding in production!</strong>
    </div>
</body>
</html>
<?php } ?>
