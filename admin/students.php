<?php
require_once '../config/auth.php';
require_staff();

$page_title = "Students Admissions Directory";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

// In production, loaded dynamically from MySQL table
$students_list = isset($mock_students) ? $mock_students : [];
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Admitted Students</h1>
        <p class="page-subtitle mt-1">Directory of all institutional student enrollments, fees statuses, and academic documents.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="new-admission.php" class="btn btn-primary btn-sm"><i data-lucide="user-plus" class="w-3.5 h-3.5"></i> New Admission</a>
    </div>
</div>

<div class="section-card">
    <!-- Advanced Filter & Search Toolbar -->
    <div class="section-header flex-col xl:flex-row gap-3 flex-wrap">
        <div class="flex items-center gap-2 bg-muted rounded-md px-3 py-1.5 flex-1 min-w-[200px] max-w-sm">
            <i data-lucide="search" class="w-3.5 h-3.5 text-muted-foreground"></i>
            <input id="student-search" placeholder="Search by name, ID or mobile..." class="bg-transparent outline-none text-sm flex-1" />
        </div>
        <div class="flex gap-2 flex-wrap sm:flex-nowrap w-full xl:w-auto xl:ml-auto">
            <!-- Branch Filter -->
            <select id="filter-branch" class="form-select w-full sm:w-auto" onchange="runAdvancedFilters()">
                <option value="All">All Branches</option>
                <?php 
                $unique_branches = [];
                foreach ($students_list as $s) $unique_branches[] = $s['branch'];
                foreach (array_unique($unique_branches) as $b): ?>
                    <option value="<?php echo $b; ?>"><?php echo $b; ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Course Filter -->
            <select id="filter-course" class="form-select w-full sm:w-auto" onchange="runAdvancedFilters()">
                <option value="All">All Courses</option>
                <?php 
                $unique_courses = [];
                foreach ($students_list as $s) $unique_courses[] = $s['course'];
                foreach (array_unique($unique_courses) as $c): ?>
                    <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Fee Status Filter -->
            <select id="filter-fee" class="form-select w-full sm:w-auto" onchange="runAdvancedFilters()">
                <option value="All">All Fees Status</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Partial/Unpaid</option>
            </select>

            <!-- Date Filter Placeholder -->
            <input type="date" id="filter-date" class="form-input w-full sm:w-auto text-xs py-1" onchange="runAdvancedFilters()" title="Admission Date Filter" />

            <button onclick="clearAllFilters()" class="btn btn-outline btn-sm" title="Clear Filters"><i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i></button>
        </div>
    </div>
    
    <!-- Students Data Table -->
    <div class="overflow-x-auto">
        <table id="students-table" class="data-table">
            <thead>
                <tr>
                    <th class="w-10"><input type="checkbox" class="rounded border-border" /></th>
                    <th>Student Profile</th>
                    <th>Mobile</th>
                    <th>Course Enrollment</th>
                    <th>Assigned Branch</th>
                    <th>Balance Fee</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students_list as $s): 
                    $balance = $s['fees_balance'];
                    $fee_badge_color = ($balance == 0) ? 'success' : 'warning';
                    $fee_badge_text = ($balance == 0) ? 'Paid' : '₹' . number_format($balance);
                ?>
                    <tr class="student-row" 
                        data-branch="<?php echo $s['branch']; ?>" 
                        data-course="<?php echo $s['course']; ?>"
                        data-fee="<?php echo ($balance == 0) ? 'Paid' : 'Unpaid'; ?>"
                        data-date="<?php echo date('Y-m-d', strtotime($s['admission_date'])); ?>">
                        
                        <td><input type="checkbox" class="rounded border-border" /></td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full bg-primary-soft text-primary text-xs font-semibold flex items-center justify-center shrink-0">
                                    <?php 
                                    $words = explode(" ", $s['name']);
                                    $initials = "";
                                    foreach ($words as $w) {
                                        if (isset($w[0])) $initials .= $w[0];
                                    }
                                    echo strtoupper(substr($initials, 0, 2));
                                    ?>
                                </div>
                                <div class="leading-tight">
                                    <a href="student-profile.php?id=<?php echo $s['id']; ?>" class="font-semibold text-foreground hover:text-primary hover:underline"><?php echo $s['name']; ?></a>
                                    <div class="text-[10px] text-muted-foreground mt-0.5"><?php echo $s['id']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-xs text-foreground"><?php echo $s['mobile']; ?></span></td>
                        <td>
                            <div class="leading-tight">
                                <div class="text-xs font-medium text-foreground"><?php echo $s['course']; ?></div>
                                <div class="text-[10px] text-muted-foreground mt-0.5"><?php echo $s['duration']; ?></div>
                            </div>
                        </td>
                        <td><span class="text-xs font-medium text-foreground"><?php echo $s['branch']; ?></span></td>
                        <td>
                            <span class="badge-soft badge-<?php echo $fee_badge_color; ?>">
                                <?php echo $fee_badge_text; ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-1">
                                <a href="student-profile.php?id=<?php echo $s['id']; ?>" class="btn btn-ghost btn-sm" title="View Profile"><i data-lucide="eye" class="w-3.5 h-3.5"></i></a>
                                <a href="id-cards.php?id=<?php echo $s['id']; ?>" class="btn btn-ghost btn-sm" title="Print ID Card"><i data-lucide="id-card" class="w-3.5 h-3.5"></i></a>
                                <a href="certificates.php?id=<?php echo $s['id']; ?>" class="btn btn-ghost btn-sm" title="Certificates"><i data-lucide="award" class="w-3.5 h-3.5"></i></a>
                                <button onclick="triggerDeleteStudent('<?php echo $s['name']; ?>')" class="btn btn-ghost btn-sm text-destructive" title="Delete Admission"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
                <!-- Polished empty state row inside table -->
                <tr id="empty-state-row" style="display: none;">
                    <td colspan="7" class="p-8 text-center">
                        <div class="h-12 w-12 rounded-full bg-muted flex items-center justify-center mx-auto text-muted-foreground mb-3">
                            <i data-lucide="users-round" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-semibold text-sm text-foreground">No students found</h4>
                        <p class="text-xs text-muted-foreground mt-0.5">We couldn't find any registered students matching the active filter criteria.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function runAdvancedFilters() {
        const query = document.getElementById('student-search').value.toLowerCase();
        const branch = document.getElementById('filter-branch').value;
        const course = document.getElementById('filter-course').value;
        const fee = document.getElementById('filter-fee').value;
        const date = document.getElementById('filter-date').value;

        const rows = document.querySelectorAll('.student-row');
        let count = 0;

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const rowBranch = row.getAttribute('data-branch');
            const rowCourse = row.getAttribute('data-course');
            const rowFee = row.getAttribute('data-fee');
            const rowDate = row.getAttribute('data-date');

            let matches = true;

            if (query && !rowText.includes(query)) matches = false;
            if (branch !== 'All' && rowBranch !== branch) matches = false;
            if (course !== 'All' && rowCourse !== course) matches = false;
            if (fee !== 'All' && rowFee !== fee) matches = false;
            if (date && rowDate !== date) matches = false;

            if (matches) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('empty-state-row').style.display = (count === 0) ? '' : 'none';
    }

    function clearAllFilters() {
        document.getElementById('student-search').value = '';
        document.getElementById('filter-branch').value = 'All';
        document.getElementById('filter-course').value = 'All';
        document.getElementById('filter-fee').value = 'All';
        document.getElementById('filter-date').value = '';
        runAdvancedFilters();
    }

    function triggerDeleteStudent(name) {
        triggerConfirmDialog(
            "Delete Student Record?",
            `Are you sure you want to permanently delete student "${name}"? This deletes all associated profiles, marks, fees, and certificates.`,
            function () {
                showLoader("Deleting student record...", 1000);
                setTimeout(() => {
                    showNotificationToast(`Student "${name}" deleted.`, 'destructive');
                }, 1000);
            }
        );
    }

    // Connect real-time typing filter
    document.getElementById('student-search').addEventListener('keyup', runAdvancedFilters);
</script>

<?php
include '../includes/footer.php';
?>
