<?php
// Identify current panel type (admin, branch, portal)
$current_script = $_SERVER['SCRIPT_NAME'];
$current_page = basename($current_script);
$current_dir = basename(dirname($current_script));

$is_subfolder = $current_dir !== 'skd-admission' && $current_dir !== '';
$base_path = $is_subfolder ? '../' : './';

// Load centralized dynamic branding variables
$display_brand_name = isset($db_brand_name) ? $db_brand_name : 'S.K.D Computer Education';
$display_branch_name = isset($db_branch_name) ? $db_branch_name : 'Pune Camp';
$display_logo_path = isset($db_branch_logo) ? $db_branch_logo : 'assets/images/skd-logo.png';

// Check which nav menu to display based on folder (role-based)
$nav_items = [];
$panel_title = "";
$panel_subtitle = "";

if ($current_dir === 'admin') {
    // ─── SUPER ADMIN SIDEBAR ───
    $panel_title = "S.K.D Admission";
    $panel_subtitle = "Super Admin";
    $nav_items = [
        ['to' => 'dashboard.php', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
        ['to' => 'branches.php', 'label' => 'Branches', 'icon' => 'building-2'],
        ['to' => 'students.php', 'label' => 'Students', 'icon' => 'graduation-cap'],
        ['to' => 'fees.php', 'label' => 'Fees', 'icon' => 'wallet'],
        ['to' => 'certificates.php', 'label' => 'Certificates', 'icon' => 'award'],
        ['to' => 'id-cards.php', 'label' => 'ID Cards', 'icon' => 'id-card'],
        ['to' => 'reports.php', 'label' => 'Reports', 'icon' => 'bar-chart-3'],
        ['to' => 'whatsapp-logs.php', 'label' => 'WhatsApp Logs', 'icon' => 'message-square'],
        ['to' => 'settings.php', 'label' => 'Settings', 'icon' => 'settings'],
    ];
    $logout_url = '../login.php';
} elseif ($current_dir === 'branch') {
    // ─── BRANCH USER SIDEBAR ───
    $panel_title = $display_branch_name;
    $panel_subtitle = "Branch Panel";
    $nav_items = [
        ['to' => 'dashboard.php', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
        ['to' => '../admin/new-admission.php', 'label' => 'New Admission', 'icon' => 'user-plus'],
        ['to' => '../admin/students.php', 'label' => 'Students', 'icon' => 'graduation-cap'],
        ['to' => '../admin/fees.php', 'label' => 'Fees', 'icon' => 'wallet'],
        ['to' => '../admin/certificates.php', 'label' => 'Certificates', 'icon' => 'award'],
        ['to' => '../admin/id-cards.php', 'label' => 'ID Cards', 'icon' => 'id-card'],
        ['to' => '../admin/settings.php', 'label' => 'Settings', 'icon' => 'settings'],
    ];
    $logout_url = '../login.php';
} elseif ($current_dir === 'portal') {
    // ─── STUDENT PORTAL SIDEBAR ───
    $panel_title = "Student Portal";
    $panel_subtitle = $display_branch_name;
    $nav_items = [
        ['to' => 'profile.php', 'label' => 'Profile', 'icon' => 'user'],
        ['to' => 'fees.php', 'label' => 'Fees', 'icon' => 'wallet'],
        ['to' => 'id-card.php', 'label' => 'ID Card', 'icon' => 'id-card'],
        ['to' => 'certificates.php', 'label' => 'Certificates', 'icon' => 'award'],
    ];
    $logout_url = '../student-login.php';
}
?>
<div class="min-h-screen flex bg-background w-full">
<!-- Sidebar -->
<aside id="sidebar" class="fixed lg:static z-40 inset-y-0 left-0 w-64 bg-sidebar border-r border-sidebar-border flex flex-col transition-transform -translate-x-full lg:translate-x-0 no-print shrink-0">
    <div class="h-16 flex items-center gap-2.5 px-5 border-b border-sidebar-border">
        <img src="<?php echo $base_path . $display_logo_path; ?>" alt="Logo" class="h-9 w-9 object-contain">
        <div class="leading-tight flex-1 min-w-0">
            <div class="text-[13px] font-semibold text-sidebar-foreground truncate"><?php echo $panel_title; ?></div>
            <div class="text-[10px] uppercase tracking-wider text-muted-foreground truncate"><?php echo $panel_subtitle; ?></div>
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
            
            // Resolve correct URL
            $url = $is_subfolder ? $item['to'] : (strpos($item['to'], '../') === 0 ? substr($item['to'], 3) : $current_dir . '/' . $item['to']);
        ?>
            <a href="<?php echo $url; ?>" class="sidebar-link <?php echo $active_class; ?>">
                <i data-lucide="<?php echo $item['icon']; ?>" class="w-[18px] h-[18px]"></i>
                <span><?php echo $item['label']; ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="p-3 border-t border-sidebar-border">
        <button onclick="triggerLogoutConfirm()" class="sidebar-link w-full text-left bg-transparent border-0 cursor-pointer">
            <i data-lucide="log-out" class="w-[18px] h-[18px]"></i>
            <span>Logout</span>
        </button>
    </div>
</aside>
