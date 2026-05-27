<?php
$page_title = "Branch Dashboard";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Branch Dashboard</h1>
        <p class="page-subtitle mt-1">Pune Camp · Today, 25 May 2026</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="../admin/new-admission.php" class="btn btn-primary btn-sm"><i data-lucide="plus" class="w-3.5 h-3.5"></i> Quick Admission</a>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat Cards -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Total Students</div>
                <div class="text-2xl font-semibold mt-2">412</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-primary-soft text-primary">
                <i data-lucide="graduation-cap" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">New Admissions</div>
                <div class="text-2xl font-semibold mt-2">18</div>
                <div class="text-xs text-success mt-1">+4 today</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-success)_15%,white)] text-success">
                <i data-lucide="users" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Pending Fees</div>
                <div class="text-2xl font-semibold mt-2">₹38K</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-destructive)_12%,white)] text-destructive">
                <i data-lucide="alert-circle" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card col-span-2 lg:col-span-1">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Certificates</div>
                <div class="text-2xl font-semibold mt-2">62</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-muted text-foreground">
                <i data-lucide="award" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Recent Students Table -->
    <div class="section-card lg:col-span-2">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Recent Students</h3>
            </div>
            <a href="../admin/students.php" class="text-xs text-primary font-medium hover:underline">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Fee</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $recents = [
                        ['name' => 'Rahul Sharma', 'sid' => 'SKD-2025-0142', 'course' => 'DCA', 'fee' => 'Paid', 'date' => '25 May', 'init' => 'RS'],
                        ['name' => 'Priya Nair', 'sid' => 'SKD-2025-0141', 'course' => 'Tally', 'fee' => 'Partial', 'date' => '24 May', 'init' => 'PN'],
                        ['name' => 'Aman Verma', 'sid' => 'SKD-2025-0140', 'course' => 'Web', 'fee' => 'Pending', 'date' => '23 May', 'init' => 'AV'],
                        ['name' => 'Sneha Patil', 'sid' => 'SKD-2025-0139', 'course' => 'ADCA', 'fee' => 'Paid', 'date' => '22 May', 'init' => 'SP'],
                        ['name' => 'Karan Mehta', 'sid' => 'SKD-2025-0138', 'course' => 'CCC', 'fee' => 'Paid', 'date' => '21 May', 'init' => 'KM'],
                        ['name' => 'Diya Joshi', 'sid' => 'SKD-2025-0137', 'course' => 'Python', 'fee' => 'Paid', 'date' => '20 May', 'init' => 'DJ'],
                    ];
                    foreach ($recents as $r): ?>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-primary-soft text-primary text-xs font-semibold flex items-center justify-center shrink-0">
                                        <?php echo $r['init']; ?>
                                    </div>
                                    <div>
                                        <div class="font-medium"><?php echo $r['name']; ?></div>
                                        <div class="text-xs text-muted-foreground"><?php echo $r['sid']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $r['course']; ?></td>
                            <td>
                                <span class="badge-soft badge-<?php echo ($r['fee'] === 'Paid' ? 'success' : ($r['fee'] === 'Partial' ? 'warning' : 'danger')); ?>">
                                    <?php echo $r['fee']; ?>
                                </span>
                            </td>
                            <td class="text-muted-foreground whitespace-nowrap"><?php echo $r['date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Side Cards -->
    <div class="space-y-4">
        <!-- Notifications -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="font-semibold text-sm">Notifications</h3>
            </div>
            <div class="section-body">
                <ul class="space-y-3 text-sm">
                    <?php
                    $alerts = [
                        ['t' => '5 fees pending today', 'c' => 'danger'],
                        ['t' => '3 certificates ready to issue', 'c' => 'info'],
                        ['t' => 'Monthly report due tomorrow', 'c' => 'warning'],
                    ];
                    foreach ($alerts as $a): ?>
                        <li class="flex items-start gap-3">
                            <i data-lucide="bell" class="w-4 h-4 mt-0.5 text-primary shrink-0"></i>
                            <span class="text-left text-foreground"><?php echo $a['t']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="font-semibold text-sm">Recent Payments</h3>
            </div>
            <div class="section-body">
                <ul class="space-y-3 text-sm">
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <li class="flex justify-between">
                            <span class="text-foreground">Rahul Sharma <span class="text-xs text-muted-foreground">· UPI</span></span>
                            <span class="font-semibold text-success">+₹5,000</span>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
