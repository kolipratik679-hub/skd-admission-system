<?php
require_once '../config/auth.php';
require_staff();

$page_title = "Certificates Management";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

// In production, load certificate links from mysql certificates table joined with students table
$certs_list = isset($mock_certificates) ? $mock_certificates : [];
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Certificate Uploads</h1>
        <p class="page-subtitle mt-1">Upload, replace, and distribute verified course completion, bonafide, and provisional certificates.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button onclick="openUploadModal()" class="btn btn-primary btn-sm"><i data-lucide="upload" class="w-3.5 h-3.5"></i> Upload New Certificate</button>
    </div>
</div>

<!-- Main Section Grid -->
<div class="grid lg:grid-cols-3 gap-6">
    <!-- Active Certificates list (Left 2 cols) -->
    <div class="lg:col-span-2 space-y-4">
        <div class="section-card">
            <div class="section-header flex-col sm:flex-row gap-3">
                <h3 class="font-semibold text-sm">Issued Certificates</h3>
                <div class="flex items-center gap-2 bg-muted rounded-md px-3 py-1.5 w-full max-w-xs ml-auto">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-muted-foreground"></i>
                    <input id="cert-search" placeholder="Search by student or course..." class="bg-transparent outline-none text-sm flex-1" />
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="certs-table" class="data-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Uploaded File</th>
                            <th>Date Issued</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($certs_list as $index => $c): ?>
                            <tr class="cert-row" data-id="<?php echo $c['student_id']; ?>">
                                <td><span class="font-mono text-xs text-foreground font-semibold"><?php echo $c['student_id']; ?></span></td>
                                <td><div class="font-medium text-foreground"><?php echo $c['student_name']; ?></div></td>
                                <td><span class="badge-soft badge-info"><?php echo $c['course']; ?></span></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <?php 
                                        $icon = ($c['file_type'] === 'pdf') ? 'file-text' : 'image';
                                        $color = ($c['file_type'] === 'pdf') ? 'text-destructive' : 'text-primary';
                                        ?>
                                        <i data-lucide="<?php echo $icon; ?>" class="w-4 h-4 shrink-0 <?php echo $color; ?>"></i>
                                        <span class="text-xs truncate max-w-[140px] text-foreground" title="<?php echo $c['certificate_name']; ?>"><?php echo $c['certificate_name']; ?></span>
                                    </div>
                                </td>
                                <td><span class="text-xs text-muted-foreground"><?php echo $c['issue_date']; ?></span></td>
                                <td>
                                    <div class="flex items-center justify-end gap-1">
                                        <button onclick='previewCertificateFile(<?php echo json_encode($c); ?>)' class="btn btn-ghost btn-sm" title="Preview File"><i data-lucide="eye" class="w-3.5 h-3.5"></i></button>
                                        <button onclick="triggerSimulatedDownload('<?php echo $c['certificate_name']; ?>')" class="btn btn-ghost btn-sm" title="Download"><i data-lucide="download" class="w-3.5 h-3.5"></i></button>
                                        <button onclick='openReplaceModal(<?php echo json_encode($c); ?>)' class="btn btn-ghost btn-sm text-warning" title="Replace File"><i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i></button>
                                        <button onclick="triggerDeleteCert('<?php echo $c['student_name']; ?>')" class="btn btn-ghost btn-sm text-destructive" title="Delete"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- Empty State -->
                        <tr id="empty-certs-row" style="display: none;">
                            <td colspan="6" class="p-8 text-center">
                                <div class="h-12 w-12 rounded-full bg-muted flex items-center justify-center mx-auto text-muted-foreground mb-3">
                                    <i data-lucide="award" class="w-6 h-6"></i>
                                </div>
                                <h4 class="font-semibold text-sm text-foreground">No certificates uploaded</h4>
                                <p class="text-xs text-muted-foreground mt-0.5">There are no files matching your filters.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Sidebar — Interactive File Preview Area -->
    <div class="space-y-4">
        <div class="section-card">
            <div class="section-header">
                <h3 class="font-semibold text-sm">Interactive Preview</h3>
            </div>
            <div class="section-body text-center py-6 space-y-4 flex flex-col items-center justify-center min-h-[300px] border border-dashed border-border rounded-lg bg-card" id="preview-outer-container">
                <!-- Idle State -->
                <div id="preview-idle-state" class="space-y-3">
                    <div class="h-14 w-14 rounded-full bg-primary-soft text-primary flex items-center justify-center mx-auto">
                        <i data-lucide="eye" class="w-6 h-6 animate-pulse"></i>
                    </div>
                    <div class="leading-tight">
                        <h4 class="font-medium text-sm text-foreground">No certificate selected</h4>
                        <p class="text-xs text-muted-foreground mt-1 max-w-[200px] mx-auto">Click the eye action button on any record to load the live document preview.</p>
                    </div>
                </div>

                <!-- Active Preview State -->
                <div id="preview-active-state" class="hidden w-full space-y-4 px-2">
                    <div class="border border-border rounded-md bg-muted p-2 h-48 flex items-center justify-center relative overflow-hidden" id="file-render-viewport">
                        <!-- Render dynamic icon or mock image -->
                        <div class="text-center space-y-2">
                            <i data-lucide="file-text" id="preview-icon" class="w-12 h-12 text-primary mx-auto"></i>
                            <div id="preview-filename" class="text-xs font-semibold text-foreground truncate max-w-[220px]">filename.pdf</div>
                            <div id="preview-size" class="text-[10px] text-muted-foreground">Size: 240 KB</div>
                        </div>
                    </div>
                    <div class="text-left bg-muted/55 rounded-md p-3 text-xs space-y-2">
                        <div class="flex justify-between border-b border-border pb-1">
                            <span class="text-muted-foreground">Student Name</span>
                            <span class="font-semibold text-foreground" id="meta-student">Rahul Sharma</span>
                        </div>
                        <div class="flex justify-between border-b border-border pb-1">
                            <span class="text-muted-foreground">Course</span>
                            <span class="font-semibold text-foreground" id="meta-course">DCA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Uploaded By</span>
                            <span class="font-medium text-foreground" id="meta-by">Super Admin</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button id="preview-download-btn" class="btn btn-primary btn-sm flex-1"><i data-lucide="download" class="w-3.5 h-3.5"></i> Download</button>
                        <button onclick="resetPreviewViewport()" class="btn btn-outline btn-sm"><i data-lucide="x" class="w-3.5 h-3.5"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ─── REUSABLE CERTIFICATE UPLOAD MODAL ─── -->
<div id="upload-modal" class="fixed inset-0 bg-black/40 z-40 flex items-center justify-center hidden">
    <div class="bg-card w-full max-w-md rounded-lg border border-border shadow-lg overflow-hidden m-4">
        <div class="px-5 py-4 border-b border-border flex items-center justify-between">
            <h3 class="font-semibold text-sm">Upload Certificate</h3>
            <button onclick="closeUploadModal()" class="text-muted-foreground hover:text-foreground"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form id="upload-form" class="p-5 space-y-4" action="certificates.php" method="POST" enctype="multipart/form-data">
            <div>
                <label class="form-label">Select Student *</label>
                <select name="student_id" class="form-select" required>
                    <option value="">Choose student...</option>
                    <?php if (isset($mock_students)): ?>
                        <?php foreach ($mock_students as $s): ?>
                            <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?> (<?php echo $s['id']; ?> — <?php echo $s['course']; ?>)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <!-- Drag and Drop Zone -->
            <div>
                <label class="form-label">Certificate File (PDF, PNG, JPG, WEBP) *</label>
                <label class="upload-label border-2 border-dashed border-border rounded-lg p-6 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-primary transition">
                    <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center shrink-0">
                        <i data-lucide="file-up" class="w-5 h-5"></i>
                    </div>
                    <div class="text-xs font-semibold text-foreground upload-filename">Drag & Drop or Click to Browse</div>
                    <div class="text-[10px] text-muted-foreground upload-status">Maximum file size 5MB</div>
                    <input type="file" name="certificate_file" class="hidden" accept="image/*,.pdf" required />
                </label>
            </div>

            <div class="border-t border-border pt-4 flex justify-end gap-2 text-xs">
                <button type="button" onclick="closeUploadModal()" class="btn btn-outline py-2 px-4">Cancel</button>
                <button type="submit" class="btn btn-primary py-2 px-4"><i data-lucide="upload-cloud" class="w-3.5 h-3.5"></i> Begin Upload</button>
            </div>
        </form>
    </div>
</div>

<!-- ─── REUSABLE REPLACE MODAL ─── -->
<div id="replace-modal" class="fixed inset-0 bg-black/40 z-40 flex items-center justify-center hidden">
    <div class="bg-card w-full max-w-md rounded-lg border border-border shadow-lg overflow-hidden m-4">
        <div class="px-5 py-4 border-b border-border flex items-center justify-between">
            <h3 class="font-semibold text-sm">Replace Certificate File</h3>
            <button onclick="closeReplaceModal()" class="text-muted-foreground hover:text-foreground"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form id="replace-form" class="p-5 space-y-4" action="certificates.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="replace_student_id" id="replace-student-id" value="">
            
            <div class="bg-warning-soft/40 border border-warning/30 rounded-md p-3 text-xs text-warning flex items-start gap-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0"></i>
                <div>
                    <strong>Warning:</strong> Replacing this file will permanently delete the previous certificate document for <span id="replace-student-name-text">this student</span>.
                </div>
            </div>

            <!-- Drag and Drop Zone -->
            <div>
                <label class="form-label">New Certificate File *</label>
                <label class="upload-label border-2 border-dashed border-border rounded-lg p-6 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-primary transition">
                    <div class="h-10 w-10 rounded-full bg-warning-soft text-warning flex items-center justify-center shrink-0">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    </div>
                    <div class="text-xs font-semibold text-foreground upload-filename">Drag & Drop new file here</div>
                    <div class="text-[10px] text-muted-foreground upload-status">Supported: PDF, PNG, JPG, WEBP</div>
                    <input type="file" name="new_certificate_file" class="hidden" accept="image/*,.pdf" required />
                </label>
            </div>

            <div class="border-t border-border pt-4 flex justify-end gap-2 text-xs">
                <button type="button" onclick="closeReplaceModal()" class="btn btn-outline py-2 px-4">Cancel</button>
                <button type="submit" class="btn btn-warning py-2 px-4 text-white"><i data-lucide="save" class="w-3.5 h-3.5"></i> Replace File</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Document Upload & Modal Handlers
    function openUploadModal() {
        document.getElementById('upload-modal').classList.remove('hidden');
    }
    function closeUploadModal() {
        document.getElementById('upload-modal').classList.add('hidden');
        document.getElementById('upload-form').reset();
    }

    function openReplaceModal(c) {
        document.getElementById('replace-modal').classList.remove('hidden');
        document.getElementById('replace-student-id').value = c.student_id;
        document.getElementById('replace-student-name-text').textContent = c.student_name + " (" + c.course + ")";
    }
    function closeReplaceModal() {
        document.getElementById('replace-modal').classList.add('hidden');
        document.getElementById('replace-form').reset();
    }

    // Simulated downloads
    function triggerSimulatedDownload(filename) {
        showLoader("Preparing certificate for secure download...", 800);
        setTimeout(() => {
            showNotificationToast(`File "${filename}" downloaded successfully.`, 'success');
        }, 800);
    }

    // Dynamic Preview Viewport Handlers
    function previewCertificateFile(c) {
        document.getElementById('preview-idle-state').classList.add('hidden');
        document.getElementById('preview-active-state').classList.remove('hidden');

        document.getElementById('preview-filename').textContent = c.certificate_name;
        document.getElementById('preview-size').textContent = "Size: " + c.file_size;
        document.getElementById('meta-student').textContent = c.student_name;
        document.getElementById('meta-course').textContent = c.course;
        document.getElementById('meta-by').textContent = c.uploaded_by;

        const iconEl = document.getElementById('preview-icon');
        if (c.file_type === 'pdf') {
            iconEl.setAttribute('data-lucide', 'file-text');
            iconEl.className = 'w-12 h-12 text-destructive mx-auto animate-bounce';
        } else {
            iconEl.setAttribute('data-lucide', 'image');
            iconEl.className = 'w-12 h-12 text-primary mx-auto animate-bounce';
        }
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Bind download action dynamically
        document.getElementById('preview-download-btn').onclick = function() {
            triggerSimulatedDownload(c.certificate_name);
        };
    }

    function resetPreviewViewport() {
        document.getElementById('preview-active-state').classList.add('hidden');
        document.getElementById('preview-idle-state').classList.remove('hidden');
    }

    function triggerDeleteCert(name) {
        triggerConfirmDialog(
            "Delete Certificate Document?",
            `Are you sure you want to permanently delete the certificate file uploaded for "${name}"? The student will no longer see this in their portal.`,
            function () {
                showLoader("Deleting certificate...", 1000);
                setTimeout(() => {
                    showNotificationToast(`Certificate for ${name} removed.`, 'warning');
                    resetPreviewViewport();
                }, 1000);
            }
        );
    }

    // Simulated forms action trigger
    document.getElementById('upload-form').addEventListener('submit', function (e) {
        e.preventDefault();
        closeUploadModal();
        showLoader("Uploading secure document...", 1500);
        setTimeout(() => {
            showNotificationToast("Certificate document uploaded and linked successfully.", 'success');
        }, 1500);
    });

    document.getElementById('replace-form').addEventListener('submit', function (e) {
        e.preventDefault();
        closeReplaceModal();
        showLoader("Replacing certificate document...", 1400);
        setTimeout(() => {
            showNotificationToast("Certificate document replaced successfully.", 'success');
        }, 1400);
    });

    // Custom client-side filter
    document.getElementById('cert-search').addEventListener('keyup', function () {
        var query = this.value.toLowerCase();
        var rows = document.querySelectorAll('.cert-row');
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

        document.getElementById('empty-certs-row').style.display = (count === 0) ? '' : 'none';
    });
</script>

<?php
include '../includes/footer.php';
?>
