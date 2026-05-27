<?php
$page_title = "My Profile";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Welcome, Rahul</h1>
        <p class="page-subtitle mt-1">Here's a summary of your admission and academic status.</p>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Stat Cards -->
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Course</div>
                <div class="text-2xl font-semibold mt-2">DCA</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-primary-soft text-primary">
                <i data-lucide="graduation-cap" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Fees</div>
                <div class="text-2xl font-semibold mt-2">Paid</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-[color-mix(in_oklab,var(--color-success)_15%,white)] text-success">
                <i data-lucide="wallet" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
    <div class="stat-card col-span-2 lg:col-span-1">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Certificates</div>
                <div class="text-2xl font-semibold mt-2">2</div>
            </div>
            <div class="h-10 w-10 rounded-md flex items-center justify-center bg-muted text-foreground">
                <i data-lucide="award" class="w-[18px] h-[18px]"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Student profile panel (Left) -->
    <div class="section-card">
        <div class="section-body">
            <div class="text-center">
                <div class="h-24 w-24 mx-auto rounded-full bg-primary-soft text-primary text-3xl font-bold flex items-center justify-center mb-3">RS</div>
                <div class="font-semibold text-base text-foreground">Rahul Sharma</div>
                <div class="text-xs text-muted-foreground mb-2">SKD-2025-0142</div>
                <span class="badge-soft badge-success">Active</span>
            </div>
            <div class="mt-5 space-y-2.5 text-sm text-left">
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="phone" class="w-3.5 h-3.5 shrink-0"></i> +91 98765 43210
                </div>
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="mail" class="w-3.5 h-3.5 shrink-0"></i> rahul@email.com
                </div>
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0"></i> Pune, Maharashtra
                </div>
            </div>
        </div>
    </div>

    <!-- Admission Details (Right) -->
    <div class="lg:col-span-2">
        <div class="section-card h-full">
            <div class="section-header">
                <h3 class="font-semibold text-sm">Admission Details</h3>
            </div>
            <div class="section-body">
                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <?php
                    $details = [
                        ['Course', 'Diploma in Computer Applications'],
                        ['Duration', '6 months'],
                        ['Branch', 'Pune Camp'],
                        ['Admission Date', '12 Jan 2025'],
                        ['Father', 'Suresh Sharma'],
                        ['Mother', 'Meera Sharma'],
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

<!-- Branch Contact -->
<div class="section-card">
    <div class="section-header">
        <h3 class="font-semibold text-sm">Branch Contact</h3>
    </div>
    <div class="section-body">
        <div class="grid sm:grid-cols-3 gap-4 text-sm text-left">
            <div>
                <div class="text-xs text-muted-foreground">Phone</div>
                <div class="font-medium text-foreground">+91 98220 11111</div>
            </div>
            <div>
                <div class="text-xs text-muted-foreground">Email</div>
                <div class="font-medium text-foreground">pune@skd.com</div>
            </div>
            <div>
                <div class="text-xs text-muted-foreground">Address</div>
                <div class="font-medium text-foreground">Camp, Pune 411001</div>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
