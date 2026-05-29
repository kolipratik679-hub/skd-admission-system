<?php
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
$is_subfolder = $current_dir !== 'skd-admission' && $current_dir !== '';
$base_path = $is_subfolder ? '../' : './';

// Use dynamic branding variables from dummy-data.php (which reads from $_SESSION)
$display_branch_name  = isset($db_branch_name)  ? $db_branch_name  : 'Head Office';
$display_branch_color = isset($db_branch_color) ? $db_branch_color : '#2563eb';

// Session-aware role detection
$_nav_role = $_SESSION['role'] ?? null;

if ($current_dir === 'admin' || $_nav_role === 'super_admin') {
    $display_branch_name  = 'Super Admin';
    $display_branch_color = '#2563eb';
}

$is_student = ($current_dir === 'portal' || $_nav_role === 'student');

// Real student identity from session
$_nav_student_name = $_SESSION['student_name'] ?? 'Student';
$_nav_student_id   = $_SESSION['student_id']   ?? '';
$_nav_initials     = strtoupper(substr($_nav_student_name, 0, 1));
// Get second word initial if exists
$_nav_name_parts   = explode(' ', trim($_nav_student_name));
if (count($_nav_name_parts) > 1) {
    $_nav_initials .= strtoupper(substr($_nav_name_parts[1], 0, 1));
}

// Staff display
$_nav_staff_label = 'Branch Identity';
if ($_nav_role === 'super_admin') {
    $_nav_staff_label = 'Super Admin';
} elseif ($_nav_role === 'branch') {
    $_nav_staff_label = $display_branch_name;
}
?>
<!-- Main Content Area Wrapper (starts here, ends in footer.php) -->
<div class="flex-1 min-w-0 flex flex-col">
    <!-- Header -->
    <header class="h-16 bg-card border-b border-border flex items-center justify-between px-4 lg:px-6 sticky top-0 z-30 no-print shrink-0">
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <button id="sidebar-toggle" class="lg:hidden btn btn-ghost btn-sm">
                <i data-lucide="menu" class="w-[18px] h-[18px]"></i>
            </button>
            <?php if (!$is_student): ?>
            <div class="hidden md:flex items-center gap-2 max-w-md flex-1 bg-muted rounded-md px-3 py-1.5">
                <i data-lucide="search" class="w-[16px] h-[16px] text-muted-foreground"></i>
                <input id="global-search-filter" placeholder="Quick filter page listings..." class="bg-transparent outline-none text-sm flex-1">
            </div>
            <?php endif; ?>
        </div>
        <div class="flex items-center gap-3">
            <?php if (!$is_student): ?>
            <button class="btn btn-ghost btn-sm relative" onclick="showNotificationToast('Simulated notification triggered.')">
                <i data-lucide="bell" class="w-[18px] h-[18px]"></i>
                <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-destructive"></span>
            </button>
            <div class="hidden sm:flex items-center gap-2 pl-3 border-l border-border">
                <div class="h-9 w-9 rounded-md flex items-center justify-center text-white text-xs font-bold" style="background: <?php echo $display_branch_color; ?>;">
                    <?php echo strtoupper(substr($display_branch_name, 0, 2)); ?>
                </div>
                <div class="leading-tight text-left">
                    <div class="text-xs font-semibold"><?php echo e($display_branch_name); ?></div>
                    <div class="text-[10px] text-muted-foreground"><?php echo e($_nav_staff_label); ?></div>
                </div>
                <i data-lucide="chevron-down" class="w-[14px] h-[14px] text-muted-foreground"></i>
            </div>
            <?php else: ?>
            <div class="flex items-center gap-3 ml-auto">
                <div class="h-9 w-9 rounded-full bg-primary-soft flex items-center justify-center text-primary font-semibold text-sm"><?php echo e($_nav_initials); ?></div>
                <div class="hidden sm:block leading-tight text-left">
                    <div class="text-xs font-semibold"><?php echo e($_nav_student_name); ?></div>
                    <div class="text-[10px] text-muted-foreground"><?php echo e($_nav_student_id); ?></div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <main class="flex-1 p-4 lg:p-6 space-y-6 overflow-x-hidden">

    <!-- REUSABLE SYSTEM NOTIFICATION / TOAST CONTAINER -->
    <div id="global-toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- REUSABLE SYSTEM CONFIRMATION MODAL -->
    <div id="global-confirm-modal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center hidden">
        <div class="bg-card w-full max-w-sm rounded-lg border border-border shadow-lg p-5 space-y-4 m-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-destructive-soft text-destructive flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 id="confirm-modal-title" class="font-semibold text-sm">Are you sure?</h3>
                    <p id="confirm-modal-desc" class="text-xs text-muted-foreground mt-0.5">This action cannot be undone.</p>
                </div>
            </div>
            <div class="flex justify-end gap-2 text-xs">
                <button id="confirm-modal-cancel" class="btn btn-outline py-1.5 px-3">Cancel</button>
                <button id="confirm-modal-action" class="btn btn-destructive py-1.5 px-3">Confirm</button>
            </div>
        </div>
    </div>

    <!-- REUSABLE LOADING LOADER -->
    <div id="global-loading-screen" class="fixed inset-0 bg-black/20 z-50 flex items-center justify-center hidden">
        <div class="bg-card py-3 px-5 border border-border rounded-md shadow-md flex items-center gap-3">
            <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span id="loading-screen-text" class="text-sm font-medium">Processing request...</span>
        </div>
    </div>
