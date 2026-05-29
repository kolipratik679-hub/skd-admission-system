<?php
require_once '../config/auth.php';
require_admin();

$page_title = "Overview";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$recent = [
    ['id' => 'SKD-2025-0142', 'name' => 'Rahul Sharma', 'course' => 'DCA', 'branch' => 'Pune Camp', 'fee' => 'Paid', 'when' => '2 min ago'],
    ['id' => 'SKD-2025-0141', 'name' => 'Priya Nair', 'course' => 'Tally Prime', 'branch' => 'Nashik', 'fee' => 'Partial', 'when' => '18 min ago'],
    ['id' => 'SKD-2025-0140', 'name' => 'Aman Verma', 'course' => 'Web Design', 'branch' => 'Mumbai', 'fee' => 'Pending', 'when' => '1 hr ago'],
    ['id' => 'SKD-2025-0139', 'name' => 'Sneha Patil', 'course' => 'ADCA', 'branch' => 'Pune Camp', 'fee' => 'Paid', 'when' => '2 hr ago'],
    ['id' => 'SKD-2025-0138', 'name' => 'Karan Mehta', 'course' => 'CCC', 'branch' => 'Aurangabad', 'fee' => 'Paid', 'when' => '3 hr ago'],
];

$months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
$bars = [42, 55, 48, 70, 62, 80, 92, 75, 88, 95, 84, 110];
$max = max($bars);
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Overview</h1>
        <p class="page-subtitle mt-1">A snapshot of admissions, fees and branch activity.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button class="btn btn-outline btn-sm"><i data-lucide="download" class="w-3.5 h-3.5"></i> Export</button>
        <a href="new-admission.php" class="btn btn-primary btn-sm"><i data-lucide="plus" class="w-3.5 h-3.5"></i> New Admission</a>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
    <!-- Stat Card 1 -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Total Branches</div>
                <div class="text-2xl font-semibold mt-2">24</div>
                <div class="text-xs text-success mt-1">+2 this month</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-primary-soft text-primary">
                <i data-lucide="building-2" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <!-- Stat Card 2 -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Total Students</div>
                <div class="text-2xl font-semibold mt-2">6,248</div>
                <div class="text-xs text-success mt-1">+128 this week</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-primary-soft text-primary">
                <i data-lucide="graduation-cap" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <!-- Stat Card 3 -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Today Admissions</div>
                <div class="text-2xl font-semibold mt-2">38</div>
                <div class="text-xs text-success mt-1">+12% vs avg</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-success)_15%,white)] text-success">
                <i data-lucide="users" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <!-- Stat Card 4 -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Fees Collected</div>
                <div class="text-2xl font-semibold mt-2">₹4.82L</div>
                <div class="text-xs text-success mt-1">+₹62K today</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-success)_15%,white)] text-success">
                <i data-lucide="wallet" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <!-- Stat Card 5 -->
    <div class="stat-card col-span-2 lg:col-span-1">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Pending Fees</div>
                <div class="text-2xl font-semibold mt-2">₹1.14L</div>
                <div class="text-xs text-destructive mt-1">32 students</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-destructive)_12%,white)] text-destructive">
                <i data-lucide="alert-circle" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Admissions Trend -->
    <div class="section-card lg:col-span-2">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Admissions Trend</h3>
                <p class="text-xs text-muted-foreground mt-0.5">Last 12 months</p>
            </div>
            <button class="btn btn-ghost btn-sm">Year <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i></button>
        </div>
        <div class="section-body">
            <div class="h-64 flex items-end gap-2 px-1">
                <?php foreach ($bars as $i => $v): ?>
                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                        <div class="w-full rounded-t-md bg-gradient-to-t from-primary to-primary/60" style="height: <?php echo ($v / $max) * 80; ?>%" title="<?php echo $v; ?> admissions"></div>
                        <div class="text-[10px] text-muted-foreground"><?php echo $months[$i]; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Branch Activity -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Branch Activity</h3>
                <p class="text-xs text-muted-foreground mt-0.5">Top 5 branches</p>
            </div>
        </div>
        <div class="section-body">
            <div class="space-y-3">
                <?php
                $branches_activity = [
                    ['n' => 'Pune Camp', 'v' => 92, 'c' => '#2563eb'],
                    ['n' => 'Mumbai Central', 'v' => 78, 'c' => '#0ea5e9'],
                    ['n' => 'Nashik Road', 'v' => 64, 'c' => '#6366f1'],
                    ['n' => 'Aurangabad', 'v' => 51, 'c' => '#3b82f6'],
                    ['n' => 'Nagpur', 'v' => 38, 'c' => '#8b5cf6'],
                ];
                foreach ($branches_activity as $b): ?>
                    <div>
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="font-medium"><?php echo $b['n']; ?></span>
                            <span class="text-muted-foreground"><?php echo $b['v']; ?>%</span>
                        </div>
                        <div class="h-1.5 bg-muted rounded-full overflow-hidden">
                            <div class="h-full rounded-full" style="width: <?php echo $b['v']; ?>%; background: <?php echo $b['c']; ?>"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Recent Admissions Table -->
    <div class="section-card lg:col-span-2">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Recent Admissions</h3>
            </div>
            <a href="students.php" class="text-xs font-medium text-primary hover:underline">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Branch</th>
                        <th>Fee</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent as $r): ?>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-primary-soft text-primary text-xs font-semibold flex items-center justify-center shrink-0">
                                        <?php 
                                        $words = explode(" ", $r['name']);
                                        $initials = "";
                                        foreach ($words as $w) {
                                            $initials .= $w[0];
                                        }
                                        echo $initials;
                                        ?>
                                    </div>
                                    <div>
                                        <a href="student-profile.php?id=<?php echo $r['id']; ?>" class="font-medium hover:text-primary hover:underline"><?php echo $r['name']; ?></a>
                                        <div class="text-xs text-muted-foreground"><?php echo $r['id']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $r['course']; ?></td>
                            <td><?php echo $r['branch']; ?></td>
                            <td>
                                <span class="badge-soft badge-<?php echo ($r['fee'] === 'Paid' ? 'success' : ($r['fee'] === 'Partial' ? 'warning' : 'danger')); ?>">
                                    <?php echo $r['fee']; ?>
                                </span>
                            </td>
                            <td class="text-xs text-muted-foreground whitespace-nowrap"><?php echo $r['when']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Quick Actions</h3>
            </div>
        </div>
        <div class="section-body">
            <div class="grid grid-cols-2 gap-3">
                <?php
                $quick_actions = [
                    ['l' => 'New Admission', 'to' => 'new-admission.php'],
                    ['l' => 'Add Branch', 'to' => 'branches.php'],
                    ['l' => 'Collect Fees', 'to' => 'fees.php'],
                    ['l' => 'Generate Certificate', 'to' => 'certificates.php'],
                    ['l' => 'Print ID Card', 'to' => 'id-cards.php'],
                    ['l' => 'View Reports', 'to' => 'reports.php'],
                ];
                foreach ($quick_actions as $a): ?>
                    <a href="<?php echo $a['to']; ?>" class="rounded-md border border-border bg-card hover:bg-muted px-3 py-4 text-sm font-medium text-center transition">
                        <?php echo $a['l']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
