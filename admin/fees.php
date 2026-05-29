<?php
require_once '../config/auth.php';
require_staff();

$page_title = "Fees Management";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Fees Management</h1>
        <p class="page-subtitle mt-1">Collect payments and issue receipts.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button class="btn btn-primary btn-sm"><i data-lucide="plus" class="w-3.5 h-3.5"></i> Collect Payment</button>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat Cards -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Collected Today</div>
                <div class="text-2xl font-semibold mt-2">₹62,400</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-success)_15%,white)] text-success">
                <i data-lucide="wallet" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">This Month</div>
                <div class="text-2xl font-semibold mt-2">₹4.82L</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-primary-soft text-primary">
                <i data-lucide="trending-up" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Pending</div>
                <div class="text-2xl font-semibold mt-2">₹1.14L</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-destructive)_12%,white)] text-destructive">
                <i data-lucide="alert-circle" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card col-span-2 lg:col-span-1">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Receipts Issued</div>
                <div class="text-2xl font-semibold mt-2">248</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-muted text-foreground">
                <i data-lucide="printer" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Recent Payments -->
    <div class="section-card lg:col-span-2">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Recent Payments</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Receipt</th>
                        <th>Student</th>
                        <th>Amount</th>
                        <th>Mode</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $payments = [
                        ['id' => '#RCPT2405', 'name' => 'Rahul Sharma', 'sid' => 'SKD-2025-0142', 'amt' => '₹5,000', 'mode' => 'UPI', 'date' => '25 May 2026', 'status' => 'Paid'],
                        ['id' => '#RCPT2404', 'name' => 'Priya Nair', 'sid' => 'SKD-2025-0141', 'amt' => '₹6,000', 'mode' => 'Cash', 'date' => '24 May 2026', 'status' => 'Paid'],
                        ['id' => '#RCPT2403', 'name' => 'Aman Verma', 'sid' => 'SKD-2025-0140', 'amt' => '₹7,000', 'mode' => 'Card', 'date' => '23 May 2026', 'status' => 'Partial'],
                        ['id' => '#RCPT2402', 'name' => 'Sneha Patil', 'sid' => 'SKD-2025-0139', 'amt' => '₹8,000', 'mode' => 'UPI', 'date' => '22 May 2026', 'status' => 'Paid'],
                        ['id' => '#RCPT2401', 'name' => 'Karan Mehta', 'sid' => 'SKD-2025-0138', 'amt' => '₹9,000', 'mode' => 'Bank', 'date' => '21 May 2026', 'status' => 'Paid'],
                        ['id' => '#RCPT2400', 'name' => 'Diya Joshi', 'sid' => 'SKD-2025-0137', 'amt' => '₹10,000', 'mode' => 'Cash', 'date' => '20 May 2026', 'status' => 'Paid'],
                    ];
                    foreach ($payments as $p): ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td>
                                <div class="font-medium"><?php echo $p['name']; ?></div>
                                <div class="text-xs text-muted-foreground"><?php echo $p['sid']; ?></div>
                            </td>
                            <td class="font-semibold"><?php echo $p['amt']; ?></td>
                            <td><?php echo $p['mode']; ?></td>
                            <td class="text-muted-foreground"><?php echo $p['date']; ?></td>
                            <td>
                                <span class="badge-soft badge-<?php echo ($p['status'] === 'Paid' ? 'success' : 'warning'); ?>">
                                    <?php echo $p['status']; ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-ghost btn-sm" title="Print"><i data-lucide="printer" class="w-3.5 h-3.5"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Receipt Preview (Right column) -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Receipt Preview</h3>
            </div>
        </div>
        <div class="section-body">
            <div id="receipt-print-area" class="border border-border rounded-md p-4 text-sm space-y-3 bg-white">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-bold text-base text-foreground">S.K.D Computer Education</div>
                        <div class="text-xs text-muted-foreground">Pune Camp Branch</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-muted-foreground">Receipt</div>
                        <div class="font-semibold">#RCPT2405</div>
                    </div>
                </div>
                <div class="border-t border-border pt-3 space-y-1.5 text-foreground">
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Student</span>
                        <span class="font-medium">Rahul Sharma</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Course</span>
                        <span class="font-medium">DCA</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Mode</span>
                        <span class="font-medium">UPI</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Date</span>
                        <span class="font-medium">25 May 2026</span>
                    </div>
                </div>
                <div class="border-t border-border pt-3 flex justify-between text-base">
                    <span class="font-semibold">Total Paid</span>
                    <span class="font-bold text-primary">₹5,000</span>
                </div>
                <button class="btn btn-primary w-full no-print" onclick="window.print()"><i data-lucide="printer" class="w-3.5 h-3.5"></i> Print Receipt</button>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
