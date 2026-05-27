<?php
$page_title = "Users";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$users = [
    ['name' => 'Rohit Kale', 'role' => 'Super Admin', 'branch' => 'Head Office', 'email' => 'rohit@skd.com', 'status' => 'Active'],
    ['name' => 'Anita Joshi', 'role' => 'Branch Admin', 'branch' => 'Pune Camp', 'email' => 'anita@skd.com', 'status' => 'Active'],
    ['name' => 'Vikas Patil', 'role' => 'Branch User', 'branch' => 'Mumbai', 'email' => 'vikas@skd.com', 'status' => 'Active'],
    ['name' => 'Sunita Rao', 'role' => 'Branch User', 'branch' => 'Nashik', 'email' => 'sunita@skd.com', 'status' => 'Inactive'],
];
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Users</h1>
        <p class="page-subtitle mt-1">Admin and branch staff accounts.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button class="btn btn-primary btn-sm"><i data-lucide="plus" class="w-3.5 h-3.5"></i> Add User</button>
    </div>
</div>

<div class="section-card">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Branch</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-primary-soft text-primary text-xs font-semibold flex items-center justify-center shrink-0">
                                    <?php 
                                    $words = explode(" ", $u['name']);
                                    $initials = "";
                                    foreach ($words as $w) {
                                        $initials .= $w[0];
                                    }
                                    echo $initials;
                                    ?>
                                </div>
                                <span class="font-medium"><?php echo $u['name']; ?></span>
                            </div>
                        </td>
                        <td>
                            <span class="badge-soft badge-<?php echo ($u['role'] === 'Super Admin' ? 'info' : 'muted'); ?>">
                                <?php echo $u['role']; ?>
                            </span>
                        </td>
                        <td><?php echo $u['branch']; ?></td>
                        <td class="text-muted-foreground"><?php echo $u['email']; ?></td>
                        <td>
                            <span class="badge-soft badge-<?php echo ($u['status'] === 'Active' ? 'success' : 'muted'); ?>">
                                <?php echo $u['status']; ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-1">
                                <button class="btn btn-ghost btn-sm" title="Edit"><i data-lucide="edit-2" class="w-3.5 h-3.5"></i></button>
                                <button class="btn btn-ghost btn-sm text-destructive" title="Delete"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
