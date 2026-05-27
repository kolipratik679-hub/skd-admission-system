<?php
$page_title = "My Fees";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Fees</h1>
        <p class="page-subtitle mt-1">Payment history and balance.</p>
    </div>
</div>

<!-- Summary Card -->
<div class="section-card">
    <div class="section-header">
        <h3 class="font-semibold text-sm">Summary</h3>
    </div>
    <div class="section-body">
        <div class="grid grid-cols-3 text-center gap-4">
            <div>
                <div class="text-xs text-muted-foreground">Total</div>
                <div class="text-2xl font-semibold mt-1">₹15,000</div>
            </div>
            <div>
                <div class="text-xs text-muted-foreground">Paid</div>
                <div class="text-2xl font-semibold mt-1 text-success">₹15,000</div>
            </div>
            <div>
                <div class="text-xs text-muted-foreground">Balance</div>
                <div class="text-2xl font-semibold mt-1">₹0</div>
            </div>
        </div>
        <div class="h-2 bg-muted rounded-full mt-4 overflow-hidden">
            <div class="h-full bg-success" style="width: 100%"></div>
        </div>
    </div>
</div>

<!-- Payment History Table -->
<div class="section-card">
    <div class="section-header">
        <h3 class="font-semibold text-sm">Payment History</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Receipt</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Mode</th>
                    <th>Status</th>
                    <th class="text-right"></th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <tr>
                        <td>#RCPT<?php echo 1000 + $i; ?></td>
                        <td class="text-muted-foreground"><?php echo (10 + $i); ?> Jan 2025</td>
                        <td class="font-medium">₹5,000</td>
                        <td>UPI</td>
                        <td><span class="badge-soft badge-success">Paid</span></td>
                        <td>
                            <div class="flex justify-end">
                                <button class="btn btn-outline btn-sm"><i data-lucide="download" class="w-3.5 h-3.5"></i> Receipt</button>
                            </div>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
