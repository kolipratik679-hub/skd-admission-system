<?php
require_once '../config/auth.php';
require_student();

$page_title = "My Certificates";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

// In production, load the active student certificates from MySQL joined table
$my_id = 'SKD-2025-0142';
$my_certs = [];
if (isset($mock_certificates)) {
    foreach ($mock_certificates as $c) {
        if ($c['student_id'] === $my_id) {
            $my_certs[] = $c;
        }
    }
}
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">My Certificates</h1>
        <p class="page-subtitle mt-1">Download verified certificates uploaded by your branch director.</p>
    </div>
</div>

<?php if (empty($my_certs)): ?>
    <!-- Reusable empty state -->
    <div class="section-card py-12 text-center max-w-md mx-auto mt-6">
        <div class="h-14 w-14 rounded-full bg-muted flex items-center justify-center mx-auto text-muted-foreground mb-4">
            <i data-lucide="award" class="w-7 h-7"></i>
        </div>
        <h3 class="font-semibold text-base text-foreground">No Certificates Found</h3>
        <p class="text-xs text-muted-foreground mt-1 max-w-[280px] mx-auto">Your course certificates have not been uploaded by the admin yet. Please check back later or contact your branch.</p>
    </div>
<?php else: ?>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($my_certs as $c): ?>
            <div class="section-card">
                <div class="section-body">
                    <div class="h-32 rounded-md bg-gradient-to-br from-primary-soft to-white flex flex-col items-center justify-center mb-3 border border-border">
                        <i data-lucide="award" class="text-primary w-9 h-9 animate-bounce"></i>
                        <span class="text-[9px] uppercase tracking-wider text-muted-foreground mt-2">Verified Document</span>
                    </div>
                    <div class="flex items-center justify-between mb-1">
                        <div class="font-semibold text-sm text-foreground truncate max-w-[170px]" title="<?php echo $c['certificate_name']; ?>">
                            <?php echo str_replace('_', ' ', pathinfo($c['certificate_name'], PATHINFO_FILENAME)); ?>
                        </div>
                        <span class="badge-soft badge-success">
                            Verified
                        </span>
                    </div>
                    <div class="text-[10px] text-muted-foreground mb-3 text-left">Issued on <?php echo $c['issue_date']; ?> · <?php echo $c['file_size']; ?></div>
                    <button onclick="triggerSimulatedDownload('<?php echo $c['certificate_name']; ?>')" class="btn btn-primary w-full transition">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i> Download Certificate
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
    function triggerSimulatedDownload(filename) {
        showLoader("Fetching secure certificate download link...", 800);
        setTimeout(() => {
            showNotificationToast(`File "${filename}" has been downloaded.`, 'success');
        }, 800);
    }
</script>

<?php
include '../includes/footer.php';
?>
