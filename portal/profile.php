<?php
require_once '../config/auth.php';
require_student();

$page_title = "My Profile Portal";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

// In production, loaded dynamically from MySQL table joined with the active student session ID
$my_id = 'SKD-2025-0142';
$target_student = null;
if (isset($mock_students)) {
    foreach ($mock_students as $s) {
        if ($s['id'] === $my_id) {
            $target_student = $s;
            break;
        }
    }
}

// Fallback if not found
if (!$target_student && isset($mock_students[0])) {
    $target_student = $mock_students[0];
}

// Identify active branch and styles
$branch_name_val = $target_student['branch'];
$target_branch = isset($mock_branches[$branch_name_val]) ? $mock_branches[$branch_name_val] : $active_branch;

// Dynamic branding parameters
$my_branch_name = $target_branch['name'];
$my_logo        = $target_branch['logo'];
$my_color       = $target_branch['color'];
$my_phone       = $target_branch['contact'];
$my_email       = $target_branch['email'];
$my_address     = $target_branch['address'];
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Welcome, <?php echo explode(" ", $target_student['name'])[0]; ?>!</h1>
        <p class="page-subtitle mt-1">Access your registered course profile, fee transaction histories, and verified academic documents.</p>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Stat Cards -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Registered Course</div>
                <div class="text-xl font-bold mt-2 text-foreground"><?php echo $target_student['course']; ?></div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-primary-soft text-primary">
                <i data-lucide="graduation-cap" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Fees Balance</div>
                <div class="text-xl font-bold mt-2 <?php echo ($target_student['fees_balance'] == 0) ? 'text-success' : 'text-warning'; ?>">
                    <?php echo ($target_student['fees_balance'] == 0) ? 'Paid In Full' : '₹' . number_format($target_student['fees_balance']); ?>
                </div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-muted text-foreground">
                <i data-lucide="wallet" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card col-span-2 lg:col-span-1">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Status</div>
                <div class="text-xl font-bold mt-2 text-foreground"><?php echo $target_student['status']; ?></div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-primary-soft text-primary">
                <i data-lucide="shield-check" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Student profile panel (Left) -->
    <div class="section-card">
        <div class="section-body">
            <div class="text-center">
                <div class="h-24 w-24 mx-auto rounded-full bg-primary-soft text-primary text-3xl font-bold flex items-center justify-center mb-3">
                    <?php 
                    $words = explode(" ", $target_student['name']);
                    $initials = "";
                    foreach ($words as $w) if (isset($w[0])) $initials .= $w[0];
                    echo strtoupper(substr($initials, 0, 2));
                    ?>
                </div>
                <div class="font-semibold text-base text-foreground"><?php echo $target_student['name']; ?></div>
                <div class="text-xs text-muted-foreground mb-2"><?php echo $my_id; ?></div>
                <span class="badge-soft badge-success"><?php echo $target_student['status']; ?> Student</span>
            </div>
            <div class="mt-5 space-y-2.5 text-sm text-left border-t border-border pt-4">
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="phone" class="w-3.5 h-3.5 shrink-0"></i> <?php echo $target_student['mobile']; ?>
                </div>
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="mail" class="w-3.5 h-3.5 shrink-0"></i> <?php echo $target_student['email']; ?>
                </div>
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0"></i> <?php echo $target_student['branch']; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Admission Details (Right) -->
    <div class="lg:col-span-2">
        <div class="section-card h-full">
            <div class="section-header">
                <h3 class="font-semibold text-sm">Enrollment Details</h3>
            </div>
            <div class="section-body">
                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <?php
                    $details = [
                        ['Course', $target_student['course']],
                        ['Duration', $target_student['duration']],
                        ['Enrolled Branch', $target_student['branch']],
                        ['Admission Date', $target_student['admission_date']],
                        ['Father\'s Name', $target_student['father']],
                        ['Mother\'s Name', $target_student['mother']],
                    ];
                    foreach ($details as $row): ?>
                        <div class="flex justify-between border-b border-border pb-2">
                            <span class="text-muted-foreground text-left"><?php echo $row[0]; ?></span>
                            <span class="font-medium text-right text-foreground"><?php echo $row[1]; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Branch Contact info -->
<div class="section-card">
    <div class="section-header">
        <h3 class="font-semibold text-sm">Assigned Branch Support Contact</h3>
    </div>
    <div class="section-body">
        <div class="grid sm:grid-cols-3 gap-4 text-sm text-left">
            <div>
                <div class="text-xs text-muted-foreground">Helpline Phone</div>
                <div class="font-semibold text-foreground mt-0.5"><?php echo $my_phone; ?></div>
            </div>
            <div>
                <div class="text-xs text-muted-foreground">Branch Email</div>
                <div class="font-semibold text-foreground mt-0.5"><?php echo $my_email; ?></div>
            </div>
            <div>
                <div class="text-xs text-muted-foreground">Address</div>
                <div class="font-semibold text-foreground mt-0.5"><?php echo $my_address; ?></div>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
