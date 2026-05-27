<?php
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
$is_subfolder = $current_dir !== 'skd-admission' && $current_dir !== '';
$base_path = $is_subfolder ? '../' : './';

$branch_name = "Head Office";
$branch_color = "#2563eb";

if ($current_dir === 'branch') {
    $branch_name = "Pune Camp";
    $branch_color = "#0ea5e9";
}

$is_student = ($current_dir === 'portal');
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
                <input placeholder="Search students, branches, courses..." class="bg-transparent outline-none text-sm flex-1">
            </div>
            <?php endif; ?>
        </div>
        <div class="flex items-center gap-3">
            <?php if (!$is_student): ?>
            <button class="btn btn-ghost btn-sm relative">
                <i data-lucide="bell" class="w-[18px] h-[18px]"></i>
                <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-destructive"></span>
            </button>
            <div class="hidden sm:flex items-center gap-2 pl-3 border-l border-border">
                <div class="h-9 w-9 rounded-md flex items-center justify-center text-white text-xs font-bold" style="background: <?php echo $branch_color; ?>;">
                    <?php echo strtoupper(substr($branch_name, 0, 2)); ?>
                </div>
                <div class="leading-tight text-left">
                    <div class="text-xs font-semibold"><?php echo $branch_name; ?></div>
                    <div class="text-[10px] text-muted-foreground">Branch Identity</div>
                </div>
                <i data-lucide="chevron-down" class="w-[14px] h-[14px] text-muted-foreground"></i>
            </div>
            <?php else: ?>
            <div class="flex items-center gap-3 ml-auto">
                <div class="h-9 w-9 rounded-full bg-primary-soft flex items-center justify-center text-primary font-semibold text-sm">RS</div>
                <div class="hidden sm:block leading-tight text-left">
                    <div class="text-xs font-semibold">Rahul Sharma</div>
                    <div class="text-[10px] text-muted-foreground">SKD-2025-0142</div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <main class="flex-1 p-4 lg:p-6 space-y-6 overflow-x-hidden">
