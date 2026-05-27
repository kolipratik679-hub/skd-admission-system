<?php
// Identify current panel type (admin, branch, portal)
$current_script = $_SERVER['SCRIPT_NAME'];
$current_page = basename($current_script);
$current_dir = basename(dirname($current_script));

$is_subfolder = $current_dir !== 'skd-admission' && $current_dir !== '';
$base_path = $is_subfolder ? '../' : './';

// Check which nav menu to display
$nav_items = [];
$panel_title = "";
$panel_subtitle = "";

if ($current_dir === 'admin') {
    $panel_title = "S.K.D Admission";
    $panel_subtitle = "Super Admin";
    $nav_items = [
        ['to' => 'dashboard.php', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
        ['to' => 'branches.php', 'label' => 'Branches', 'icon' => 'building-2'],
        ['to' => 'users.php', 'label' => 'Users', 'icon' => 'users'],
        ['to' => 'students.php', 'label' => 'Students', 'icon' => 'graduation-cap'],
        ['to' => 'fees.php', 'label' => 'Fees', 'icon' => 'wallet'],
        ['to' => 'certificates.php', 'label' => 'Certificates', 'icon' => 'award'],
        ['to' => 'id-cards.php', 'label' => 'ID Cards', 'icon' => 'id-card'],
        ['to' => 'whatsapp-logs.php', 'label' => 'WhatsApp Logs', 'icon' => 'message-square'],
        ['to' => 'reports.php', 'label' => 'Reports', 'icon' => 'bar-chart-3'],
        ['to' => 'settings.php', 'label' => 'Settings', 'icon' => 'settings'],
    ];
    $logout_url = '../login.php';
} elseif ($current_dir === 'branch') {
    $panel_title = "S.K.D Admission";
    $panel_subtitle = "Branch Panel";
    $nav_items = [
        ['to' => 'dashboard.php', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
        ['to' => '../admin/new-admission.php', 'label' => 'New Admission', 'icon' => 'graduation-cap'],
        ['to' => '../admin/students.php', 'label' => 'Students', 'icon' => 'users'],
        ['to' => '../admin/fees.php', 'label' => 'Fees', 'icon' => 'wallet'],
        ['to' => '../admin/certificates.php', 'label' => 'Certificates', 'icon' => 'award'],
        ['to' => '../admin/settings.php', 'label' => 'Settings', 'icon' => 'settings'],
    ];
    $logout_url = '../login.php';
} elseif ($current_dir === 'portal') {
    $panel_title = "Student Portal";
    $panel_subtitle = "S.K.D Education";
    $nav_items = [
        ['to' => 'profile.php', 'label' => 'Profile', 'icon' => 'user'],
        ['to' => 'fees.php', 'label' => 'Fees', 'icon' => 'wallet'],
        ['to' => 'id-card.php', 'label' => 'ID Card', 'icon' => 'id-card'],
        ['to' => 'certificates.php', 'label' => 'Certificates', 'icon' => 'award'],
    ];
    $logout_url = '../student-login.php';
}
?>
<div class="min-h-screen flex bg-background">
<!-- Sidebar -->
<aside id="sidebar" class="fixed lg:static z-40 inset-y-0 left-0 w-64 bg-sidebar border-r border-sidebar-border flex flex-col transition-transform -translate-x-full lg:translate-x-0 no-print shrink-0">
    <div class="h-16 flex items-center gap-2.5 px-5 border-b border-sidebar-border">
        <img src="<?php echo $base_path; ?>assets/images/skd-logo.png" alt="S.K.D" class="h-9 w-9 object-contain">
        <div class="leading-tight">
            <div class="text-[13px] font-semibold text-sidebar-foreground"><?php echo $panel_title; ?></div>
            <div class="text-[10px] uppercase tracking-wider text-muted-foreground"><?php echo $panel_subtitle; ?></div>
        </div>
    </div>
    <nav class="flex-1 overflow-y-auto p-3 space-y-1">
        <div class="px-2 pt-2 pb-1 text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">Menu</div>
        <?php foreach ($nav_items as $item): 
            // Determine active status
            $item_page = basename($item['to']);
            
            // Check if we are directly matching basename
            $is_active = ($current_page === $item_page && strpos($item['to'], '../') === false);
            
            // Handle cross-folder active matching (like admin pages accessed from branch folder)
            if (strpos($item['to'], '../admin/') !== false) {
                if ($current_dir === 'admin' && $current_page === $item_page) {
                    $is_active = true;
                }
            }
            
            // Handle students list highlighters for new-admission and profile views
            if ($item_page === 'students.php') {
                if ($current_dir === 'admin' && ($current_page === 'new-admission.php' || $current_page === 'student-profile.php')) {
                    $is_active = true;
                }
            }
            
            $active_class = $is_active ? 'active' : '';
        ?>
            <a href="<?php echo $is_subfolder ? $item['to'] : (strpos($item['to'], '../') === 0 ? substr($item['to'], 3) : $current_dir . '/' . $item['to']); ?>" class="sidebar-link <?php echo $active_class; ?>">
                <i data-lucide="<?php echo $item['icon']; ?>" class="w-[18px] h-[18px]"></i>
                <span><?php echo $item['label']; ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="p-3 border-t border-sidebar-border">
        <a href="<?php echo $logout_url; ?>" class="sidebar-link">
            <i data-lucide="log-out" class="w-[18px] h-[18px]"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>
