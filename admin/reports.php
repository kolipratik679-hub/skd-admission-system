<?php
require_once '../config/auth.php';
require_admin();

$page_title = "Reports & Analytics";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Reports & Analytics</h1>
        <p class="page-subtitle mt-1">Export admission, fee and branch performance reports.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button class="btn btn-outline btn-sm"><i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i> Excel</button>
        <button class="btn btn-primary btn-sm" onclick="window.print()"><i data-lucide="download" class="w-3.5 h-3.5"></i> Export PDF</button>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat Cards -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Admissions (Month)</div>
                <div class="text-2xl font-semibold mt-2">384</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-muted text-foreground">
                <i data-lucide="graduation-cap" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Fees Collected</div>
                <div class="text-2xl font-semibold mt-2">₹4.82L</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-success)_15%,white)] text-success">
                <i data-lucide="wallet" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Active Branches</div>
                <div class="text-2xl font-semibold mt-2">22 / 24</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-muted text-foreground">
                <i data-lucide="building-2" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card col-span-2 lg:col-span-1">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Active Students</div>
                <div class="text-2xl font-semibold mt-2">6,248</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-primary-soft text-primary">
                <i data-lucide="users" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-4">
    <!-- Branch Performance -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Branch Performance</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Admissions</th>
                        <th>Fees</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $perf = [
                        ['Pune Camp', 92, '₹1.42L'],
                        ['Mumbai', 78, '₹1.12L'],
                        ['Nashik', 64, '₹98K'],
                        ['Aurangabad', 51, '₹74K'],
                        ['Nagpur', 38, '₹56K'],
                    ];
                    foreach ($perf as $row): ?>
                        <tr>
                            <td class="font-medium"><?php echo $row[0]; ?></td>
                            <td><?php echo $row[1]; ?></td>
                            <td class="text-success font-semibold"><?php echo $row[2]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Monthly Trend -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Monthly Trend</h3>
            </div>
        </div>
        <div class="section-body">
            <div class="h-56 flex items-end gap-3 px-1 justify-between">
                <?php
                $bars = [42,55,48,70,62,80,92,75,88,95,84,110];
                $labels = ["J","F","M","A","M","J","J","A","S","O","N","D"];
                foreach ($bars as $i => $v): ?>
                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                        <div class="w-full rounded-t-md" style="height: <?php echo ($v/1.3); ?>%; background: var(--gradient-primary)"></div>
                        <div class="text-[10px] text-muted-foreground"><?php echo $labels[$i]; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Course Distribution -->
<div class="section-card">
    <div class="section-header">
        <div>
            <h3 class="font-semibold text-sm">Course Distribution</h3>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Enrolled</th>
                    <th>Completed</th>
                    <th>Revenue</th>
                    <th>Avg Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $courses_dist = [
                    ["DCA", 420, 310, "₹62L", "4.7"],
                    ["ADCA", 280, 205, "₹50L", "4.6"],
                    ["Tally Prime", 180, 142, "₹22L", "4.5"],
                    ["Web Design", 150, 98, "₹28L", "4.8"],
                    ["Python", 120, 82, "₹24L", "4.7"],
                ];
                foreach ($courses_dist as $row): ?>
                    <tr>
                        <td class="font-medium"><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2]; ?></td>
                        <td class="font-semibold text-primary"><?php echo $row[3]; ?></td>
                        <td class="whitespace-nowrap font-medium text-amber-500"><?php echo $row[4]; ?> ★</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
