<?php
$page_title = "My Certificates";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$certs = [
    ['t' => 'Course Completion', 'd' => '20 May 2026', 's' => 'Issued'],
    ['t' => 'Bonafide', 'd' => '15 Mar 2026', 's' => 'Issued'],
    ['t' => 'Provisional', 'd' => '10 May 2026', 's' => 'Pending'],
];
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">My Certificates</h1>
        <p class="page-subtitle mt-1">Downloadable certificates issued by your branch.</p>
    </div>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($certs as $c): ?>
        <div class="section-card">
            <div class="section-body">
                <div class="h-32 rounded-md bg-gradient-to-br from-primary-soft to-white flex items-center justify-center mb-3 border border-border">
                    <i data-lucide="award" class="text-primary w-9 h-9"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <div class="font-semibold text-sm text-foreground"><?php echo $c['t']; ?></div>
                    <span class="badge-soft badge-<?php echo ($c['s'] === 'Issued' ? 'success' : 'warning'); ?>">
                        <?php echo $c['s']; ?>
                    </span>
                </div>
                <div class="text-xs text-muted-foreground mb-3 text-left">Issued on <?php echo $c['d']; ?></div>
                <button <?php echo ($c['s'] !== 'Issued') ? 'disabled' : ''; ?> class="btn btn-primary w-full disabled:opacity-50 transition">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i> Download
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
include '../includes/footer.php';
?>
