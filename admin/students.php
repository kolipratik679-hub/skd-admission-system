<?php
$page_title = "Students";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$names = ["Rahul Sharma","Priya Nair","Aman Verma","Sneha Patil","Karan Mehta","Diya Joshi","Aarav Singh","Isha Kapoor","Vivaan Roy","Anaya Iyer"];
$courses = ["DCA","Tally Prime","Web Design","ADCA","CCC","Python","Graphic Design","MS Office","DTP","Hardware"];
$fees = ["Paid","Partial","Pending","Paid","Paid","Partial","Pending","Paid","Paid","Partial"];
$branches = ["Pune Camp","Nashik","Mumbai","Pune Camp","Aurangabad","Nagpur","Mumbai","Kolhapur","Pune Camp","Nashik"];

$students = [];
for ($i = 0; $i < 10; $i++) {
    $students[] = [
        'id' => 'SKD-2025-01' . (30 + $i),
        'name' => $names[$i],
        'mobile' => '+91 9876' . $i . $i . '3210',
        'course' => $courses[$i],
        'fee' => $fees[$i],
        'branch' => $branches[$i]
    ];
}
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Students</h1>
        <p class="page-subtitle mt-1">Search, filter and manage all admissions.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="new-admission.php" class="btn btn-primary btn-sm"><i data-lucide="plus" class="w-3.5 h-3.5"></i> New Admission</a>
    </div>
</div>

<div class="section-card">
    <div class="section-header flex-col lg:flex-row gap-3 flex-wrap">
        <div class="flex items-center gap-2 bg-muted rounded-md px-3 py-1.5 flex-1 min-w-[200px] max-w-sm">
            <i data-lucide="search" class="w-3.5 h-3.5 text-muted-foreground"></i>
            <input placeholder="Search by name, ID or mobile..." class="bg-transparent outline-none text-sm flex-1" />
        </div>
        <div class="flex gap-2 flex-wrap sm:flex-nowrap">
            <select class="form-select w-auto">
                <option>All Branches</option>
                <option>Pune Camp</option>
                <option>Mumbai</option>
                <option>Nashik</option>
            </select>
            <select class="form-select w-auto">
                <option>All Courses</option>
                <option>DCA</option>
                <option>ADCA</option>
                <option>Tally Prime</option>
            </select>
            <select class="form-select w-auto">
                <option>Fee Status</option>
                <option>Paid</option>
                <option>Partial</option>
                <option>Pending</option>
            </select>
            <button class="btn btn-outline btn-sm"><i data-lucide="filter" class="w-3.5 h-3.5"></i></button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-10"><input type="checkbox" class="rounded border-border" /></th>
                    <th>Student</th>
                    <th>Mobile</th>
                    <th>Course</th>
                    <th>Branch</th>
                    <th>Fee</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><input type="checkbox" class="rounded border-border" /></td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full bg-primary-soft text-primary text-xs font-semibold flex items-center justify-center shrink-0">
                                    <?php 
                                    $words = explode(" ", $s['name']);
                                    $initials = "";
                                    foreach ($words as $w) {
                                        $initials .= $w[0];
                                    }
                                    echo $initials;
                                    ?>
                                </div>
                                <div>
                                    <a href="student-profile.php?id=<?php echo $s['id']; ?>" class="font-medium hover:text-primary hover:underline"><?php echo $s['name']; ?></a>
                                    <div class="text-xs text-muted-foreground"><?php echo $s['id']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $s['mobile']; ?></td>
                        <td><?php echo $s['course']; ?></td>
                        <td><?php echo $s['branch']; ?></td>
                        <td>
                            <span class="badge-soft badge-<?php echo ($s['fee'] === 'Paid' ? 'success' : ($s['fee'] === 'Partial' ? 'warning' : 'danger')); ?>">
                                <?php echo $s['fee']; ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-1">
                                <a href="student-profile.php?id=<?php echo $s['id']; ?>" class="btn btn-ghost btn-sm" title="View"><i data-lucide="eye" class="w-3.5 h-3.5"></i></a>
                                <button class="btn btn-ghost btn-sm" title="Edit"><i data-lucide="edit-2" class="w-3.5 h-3.5"></i></button>
                                <a href="id-cards.php?id=<?php echo $s['id']; ?>" class="btn btn-ghost btn-sm" title="ID Card"><i data-lucide="id-card" class="w-3.5 h-3.5"></i></a>
                                <a href="certificates.php?id=<?php echo $s['id']; ?>" class="btn btn-ghost btn-sm" title="Certificate"><i data-lucide="award" class="w-3.5 h-3.5"></i></a>
                                <button class="btn btn-ghost btn-sm text-destructive" title="Delete"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="section-header flex flex-col sm:flex-row justify-between items-center gap-3" style="border-top: 1px solid var(--color-border); border-bottom: 0;">
        <span class="text-xs text-muted-foreground">Showing 1–10 of 6,248</span>
        <div class="flex gap-1">
            <button class="btn btn-outline btn-sm">Prev</button>
            <button class="btn btn-primary btn-sm">1</button>
            <button class="btn btn-outline btn-sm">2</button>
            <button class="btn btn-outline btn-sm">3</button>
            <button class="btn btn-outline btn-sm">Next</button>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
