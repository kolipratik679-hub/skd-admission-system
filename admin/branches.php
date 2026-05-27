<?php
$page_title = "Branches";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$branches = [
    ['name' => 'Pune Camp', 'contact' => '+91 98220 11111', 'email' => 'pune@skd.com', 'color' => '#2563eb', 'status' => 'Active'],
    ['name' => 'Mumbai Central', 'contact' => '+91 98220 22222', 'email' => 'mumbai@skd.com', 'color' => '#0ea5e9', 'status' => 'Active'],
    ['name' => 'Nashik Road', 'contact' => '+91 98220 33333', 'email' => 'nashik@skd.com', 'color' => '#6366f1', 'status' => 'Active'],
    ['name' => 'Aurangabad', 'contact' => '+91 98220 44444', 'email' => 'abad@skd.com', 'color' => '#3b82f6', 'status' => 'Active'],
    ['name' => 'Nagpur', 'contact' => '+91 98220 55555', 'email' => 'nagpur@skd.com', 'color' => '#8b5cf6', 'status' => 'Inactive'],
    ['name' => 'Kolhapur', 'contact' => '+91 98220 66666', 'email' => 'kop@skd.com', 'color' => '#06b6d4', 'status' => 'Active'],
];
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Branches</h1>
        <p class="page-subtitle mt-1">Manage all branches, branding and credentials.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button class="btn btn-primary btn-sm"><i data-lucide="plus" class="w-3.5 h-3.5"></i> Add Branch</button>
    </div>
</div>

<div class="section-card">
    <div class="section-header flex-col sm:flex-row gap-3">
        <div class="flex items-center gap-2 bg-muted rounded-md px-3 py-1.5 w-full max-w-sm">
            <i data-lucide="search" class="w-3.5 h-3.5 text-muted-foreground"></i>
            <input placeholder="Search branches..." class="bg-transparent outline-none text-sm flex-1" />
        </div>
        <select class="form-select w-auto">
            <option>All status</option>
            <option>Active</option>
            <option>Inactive</option>
        </select>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Branch</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Brand Color</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($branches as $b): ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-md flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: <?php echo $b['color']; ?>">
                                    <?php echo strtoupper(substr($b['name'], 0, 2)); ?>
                                </div>
                                <div>
                                    <div class="font-medium"><?php echo $b['name']; ?></div>
                                    <div class="text-xs text-muted-foreground">S.K.D Education</div>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $b['contact']; ?></td>
                        <td class="text-muted-foreground"><?php echo $b['email']; ?></td>
                        <td>
                            <span class="inline-flex items-center gap-2 text-xs">
                                <span class="h-3 w-3 rounded-full shrink-0" style="background: <?php echo $b['color']; ?>"></span>
                                <?php echo $b['color']; ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge-soft badge-<?php echo ($b['status'] === 'Active' ? 'success' : 'muted'); ?>">
                                <?php echo $b['status']; ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-1 justify-end">
                                <button class="btn btn-ghost btn-sm" title="Edit"><i data-lucide="edit-2" class="w-3.5 h-3.5"></i></button>
                                <button class="btn btn-ghost btn-sm text-destructive" title="Delete"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                                <button class="btn btn-ghost btn-sm" title="More"><i data-lucide="more-horizontal" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="section-header flex justify-between items-center" style="border-top: 1px solid var(--color-border); border-bottom: 0;">
        <span class="text-xs text-muted-foreground">Showing 1–6 of 24 branches</span>
        <div class="flex gap-1">
            <button class="btn btn-outline btn-sm">Prev</button>
            <button class="btn btn-outline btn-sm">Next</button>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
