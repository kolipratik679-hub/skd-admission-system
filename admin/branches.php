<?php
$page_title = "Branches";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

// In production, this list comes from the MySQL branches table
$branch_list = isset($mock_branches) ? $mock_branches : [];
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Branches & Login Accounts</h1>
        <p class="page-subtitle mt-1">Manage institutional branches, independent branding, and login credentials.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button onclick="openBranchModal()" class="btn btn-primary btn-sm"><i data-lucide="plus" class="w-3.5 h-3.5"></i> Add New Branch</button>
    </div>
</div>

<div class="section-card">
    <!-- Filters & Search -->
    <div class="section-header flex-col sm:flex-row gap-3">
        <div class="flex items-center gap-2 bg-muted rounded-md px-3 py-1.5 w-full max-w-sm">
            <i data-lucide="search" class="w-3.5 h-3.5 text-muted-foreground"></i>
            <input id="branch-search" placeholder="Search branches by name, city or username..." class="bg-transparent outline-none text-sm flex-1" />
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <select id="status-filter" class="form-select w-full sm:w-auto" onchange="filterBranchList()">
                <option value="All">All statuses</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table id="branches-table" class="data-table">
            <thead>
                <tr>
                    <th>Branch / Institution</th>
                    <th>Contact Details</th>
                    <th>Account Username</th>
                    <th>Theme / Color</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($branch_list as $b): ?>
                    <tr class="branch-row" data-status="<?php echo $b['status']; ?>">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-md flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: <?php echo $b['color']; ?>">
                                    <?php echo strtoupper(substr($b['name'], 0, 2)); ?>
                                </div>
                                <div class="leading-tight">
                                    <div class="font-medium text-foreground"><?php echo $b['name']; ?></div>
                                    <div class="text-[10px] text-muted-foreground"><?php echo $b['brand_name']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-xs space-y-0.5">
                                <div class="flex items-center gap-1.5 text-foreground"><i data-lucide="phone" class="w-3 h-3 text-muted-foreground"></i> <?php echo $b['contact']; ?></div>
                                <div class="flex items-center gap-1.5 text-muted-foreground"><i data-lucide="mail" class="w-3 h-3"></i> <?php echo $b['email']; ?></div>
                            </div>
                        </td>
                        <td>
                            <div class="font-mono text-xs text-foreground bg-muted py-0.5 px-2 rounded inline-block">
                                <?php echo $b['username']; ?>
                            </div>
                        </td>
                        <td>
                            <span class="inline-flex items-center gap-1.5 text-xs text-muted-foreground">
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
                                <button onclick='openBranchModal(<?php echo json_encode($b); ?>)' class="btn btn-ghost btn-sm" title="Edit Credentials & Details"><i data-lucide="edit-3" class="w-3.5 h-3.5"></i></button>
                                <button onclick="triggerDeleteBranch('<?php echo $b['name']; ?>')" class="btn btn-ghost btn-sm text-destructive" title="Remove Branch"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- Visually Polished Empty State -->
                <tr id="empty-state-row" style="display: none;">
                    <td colspan="6" class="p-8 text-center">
                        <div class="h-12 w-12 rounded-full bg-muted flex items-center justify-center mx-auto text-muted-foreground mb-3">
                            <i data-lucide="building-2" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-semibold text-sm text-foreground">No branches found</h4>
                        <p class="text-xs text-muted-foreground mt-0.5">Try altering your search or status filter criteria.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ─── REUSABLE BRANCH EDITOR DIALOG MODAL ─── -->
<div id="branch-modal" class="fixed inset-0 bg-black/40 z-40 flex items-center justify-center hidden">
    <div class="bg-card w-full max-w-lg rounded-lg border border-border shadow-lg overflow-hidden m-4">
        <div class="px-5 py-4 border-b border-border flex items-center justify-between">
            <h3 id="modal-title" class="font-semibold text-sm">Add New Branch</h3>
            <button onclick="closeBranchModal()" class="text-muted-foreground hover:text-foreground"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form id="branch-form" class="p-5 space-y-4" action="branches.php" method="POST" enctype="multipart/form-data">
            <!-- Hidden context ID for editing -->
            <input type="hidden" name="branch_id" id="form-branch-id" value="">

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Branch Name *</label>
                    <input type="text" name="name" id="form-name" class="form-input" placeholder="e.g. Pune Camp" required>
                </div>
                <div>
                    <label class="form-label">Brand Name / Institute *</label>
                    <input type="text" name="brand_name" id="form-brand-name" class="form-input" placeholder="e.g. S.K.D Computer Education" required>
                </div>
                <div>
                    <label class="form-label">Contact Phone *</label>
                    <input type="text" name="contact" id="form-contact" class="form-input" placeholder="+91" required>
                </div>
                <div>
                    <label class="form-label">WhatsApp Phone *</label>
                    <input type="text" name="whatsapp" id="form-whatsapp" class="form-input" placeholder="+91">
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Address *</label>
                    <textarea name="address" id="form-address" class="form-textarea" rows="2" placeholder="Full Postal Address" required></textarea>
                </div>
                <div class="sm:col-span-2 border-t border-border pt-3">
                    <h4 class="text-xs font-semibold text-foreground uppercase tracking-wider mb-2">Account Login Credentials</h4>
                </div>
                <div>
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" id="form-username" class="form-input" placeholder="e.g. camp_pune" required>
                </div>
                <div>
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" id="form-password" class="form-input" placeholder="••••••••" required>
                </div>
                <div class="border-t border-border pt-3 sm:col-span-2">
                    <h4 class="text-xs font-semibold text-foreground uppercase tracking-wider mb-2">Branding Styles & Status</h4>
                </div>
                <div>
                    <label class="form-label">Brand Theme Color *</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="color" id="form-color" class="h-9 w-12 border border-border rounded p-0.5 cursor-pointer bg-transparent" value="#2563eb">
                        <span class="text-xs text-muted-foreground">Select color theme</span>
                    </div>
                </div>
                <div>
                    <label class="form-label">Status *</label>
                    <select name="status" id="form-status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Upload Institute Logo</label>
                    <label class="border border-dashed border-border rounded-md p-4 flex flex-col items-center gap-1 cursor-pointer hover:border-primary hover:bg-primary-soft/10 transition">
                        <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center">
                            <i data-lucide="image" class="w-4 h-4"></i>
                        </div>
                        <div class="text-[11px] text-muted-foreground"><span class="upload-filename">Upload PNG logo (max 1MB)</span></div>
                        <input name="logo" type="file" class="hidden" accept="image/png">
                    </label>
                </div>
            </div>

            <div class="border-t border-border pt-4 flex justify-end gap-2 text-xs">
                <button type="button" onclick="closeBranchModal()" class="btn btn-outline py-2 px-4">Cancel</button>
                <button type="submit" class="btn btn-primary py-2 px-4"><i data-lucide="save" class="w-3.5 h-3.5"></i> Save Branch</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Local filter function
    function filterBranchList() {
        const statusVal = document.getElementById('status-filter').value;
        const rows = document.querySelectorAll('.branch-row');
        let count = 0;

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (statusVal === 'All' || status === statusVal) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('empty-state-row').style.display = (count === 0) ? '' : 'none';
    }

    // Dynamic Modal Handlers
    function openBranchModal(branchData = null) {
        const modal = document.getElementById('branch-modal');
        const title = document.getElementById('modal-title');
        const form = document.getElementById('branch-form');
        
        modal.classList.remove('hidden');

        if (branchData) {
            title.textContent = "Edit Branch & Login Details";
            document.getElementById('form-branch-id').value = branchData.id;
            document.getElementById('form-name').value = branchData.name;
            document.getElementById('form-brand-name').value = branchData.brand_name;
            document.getElementById('form-contact').value = branchData.contact;
            document.getElementById('form-whatsapp').value = branchData.whatsapp || '';
            document.getElementById('form-address').value = branchData.address;
            document.getElementById('form-username').value = branchData.username;
            document.getElementById('form-password').value = branchData.password;
            document.getElementById('form-color').value = branchData.color;
            document.getElementById('form-status').value = branchData.status;
        } else {
            title.textContent = "Add New Branch";
            form.reset();
            document.getElementById('form-branch-id').value = '';
        }
    }

    function closeBranchModal() {
        document.getElementById('branch-modal').classList.add('hidden');
    }

    function triggerDeleteBranch(name) {
        triggerConfirmDialog(
            "Delete Branch?",
            `Are you sure you want to delete branch "${name}"? This will disable all admissions and accounts associated with it.`,
            function () {
                showLoader("Deleting branch...", 1000);
                setTimeout(() => {
                    showNotificationToast(`Branch "${name}" has been deleted successfully.`, 'success');
                }, 1000);
            }
        );
    }

    // Setup simulated submit success
    document.getElementById('branch-form').addEventListener('submit', function (e) {
        e.preventDefault();
        closeBranchModal();
        showLoader("Saving branch details...", 1200);
        setTimeout(() => {
            showNotificationToast("Branch account details saved successfully.", 'success');
        }, 1200);
    });

    // Custom search binding for branch
    document.getElementById('branch-search').addEventListener('keyup', function () {
        var query = this.value.toLowerCase();
        var rows = document.querySelectorAll('.branch-row');
        var count = 0;

        rows.forEach(row => {
            var text = row.textContent.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('empty-state-row').style.display = (count === 0) ? '' : 'none';
    });
</script>

<?php
include '../includes/footer.php';
?>
