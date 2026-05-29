<?php
require_once '../config/auth.php';
require_student();

$page_title = "My Fees Transactions";
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

$total_fee = $target_student['fees_total'];
$paid_fee  = $target_student['fees_paid'];
$balance_fee = $target_student['fees_balance'];
$discount  = $target_student['fees_discount'];

// Calculate paid percentage
$net_payable = $total_fee - $discount;
$percent_paid = ($net_payable > 0) ? round(($paid_fee / $net_payable) * 100) : 100;
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">My Fees Account</h1>
        <p class="page-subtitle mt-1">Real-time payment history receipts, balance statements, and approved fee structures.</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6 mt-6">
    <!-- Summary Cards -->
    <div class="lg:col-span-1 space-y-4">
        <div class="section-card">
            <div class="section-header">
                <h3 class="font-semibold text-sm">Fees Payment Summary</h3>
            </div>
            <div class="section-body space-y-4">
                <div class="grid grid-cols-2 gap-4 text-left">
                    <div>
                        <div class="text-[10px] uppercase text-muted-foreground tracking-wider">Total Fee</div>
                        <div class="text-xl font-bold text-foreground mt-0.5">₹<?php echo number_format($total_fee); ?></div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase text-muted-foreground tracking-wider">Discount Approved</div>
                        <div class="text-xl font-bold text-foreground mt-0.5">₹<?php echo number_format($discount); ?></div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase text-muted-foreground tracking-wider">Paid Amount</div>
                        <div class="text-xl font-bold text-success mt-0.5">₹<?php echo number_format($paid_fee); ?></div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase text-muted-foreground tracking-wider">Balance Due</div>
                        <div class="text-xl font-bold <?php echo ($balance_fee == 0) ? 'text-foreground' : 'text-warning'; ?> mt-0.5">
                            ₹<?php echo number_format($balance_fee); ?>
                        </div>
                    </div>
                </div>
                
                <div class="pt-2">
                    <div class="flex justify-between text-xs font-semibold mb-1">
                        <span class="text-muted-foreground">Progress Paid</span>
                        <span class="text-primary"><?php echo $percent_paid; ?>%</span>
                    </div>
                    <div class="h-2 bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-primary" style="width: <?php echo $percent_paid; ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History Table -->
    <div class="lg:col-span-2">
        <div class="section-card">
            <div class="section-header">
                <h3 class="font-semibold text-sm">Receipt Transaction History</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Receipt ID</th>
                            <th>Date Paid</th>
                            <th>Amount Paid</th>
                            <th>Payment Mode</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mock payments matching student stats -->
                        <?php if ($paid_fee > 0): ?>
                            <tr>
                                <td><span class="font-mono text-xs font-semibold text-foreground">#RCPT-8802</span></td>
                                <td class="text-muted-foreground text-xs">12 Jan 2025</td>
                                <td class="font-bold text-foreground">₹<?php echo number_format($paid_fee); ?></td>
                                <td>UPI / GPay</td>
                                <td><span class="badge-soft badge-success">Success</span></td>
                                <td>
                                    <div class="flex justify-end">
                                        <button onclick="triggerSimulatedReceipt('#RCPT-8802')" class="btn btn-outline btn-sm py-1 px-2.5 text-xs"><i data-lucide="download" class="w-3.5 h-3.5"></i> Download Receipt</button>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="p-6 text-center text-xs text-muted-foreground">No payments recorded yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function triggerSimulatedReceipt(receiptId) {
        showLoader("Generating secure invoice PDF receipt...", 800);
        setTimeout(() => {
            showNotificationToast(`Receipt ${receiptId} downloaded successfully.`, 'success');
        }, 800);
    }
</script>

<?php
include '../includes/footer.php';
?>
