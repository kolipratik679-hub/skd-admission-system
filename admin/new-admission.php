<?php
$page_title = "New Admission Form";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<form id="admission-form" class="space-y-4" action="students.php" method="POST" enctype="multipart/form-data">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <h1 class="page-title">New Admission</h1>
            <p class="page-subtitle mt-1">Enter student registration details and upload mandatory verification documents.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button type="reset" class="btn btn-outline btn-sm"><i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Form</button>
            <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="save" class="w-3.5 h-3.5"></i> Save Admission</button>
        </div>
    </div>

    <!-- Personal Details -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Personal Details</h3>
                <p class="text-xs text-muted-foreground mt-0.5">Primary student information</p>
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Student ID / Reg No *</label>
                    <input name="student_id" class="form-input" placeholder="e.g. SKD-2025-0143" required />
                </div>
                <div>
                    <label class="form-label">Full Name *</label>
                    <input name="full_name" class="form-input" placeholder="As per Aadhaar/ID proof" required />
                </div>
                <div>
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Date of Birth *</label>
                    <input name="dob" type="date" class="form-input" required />
                </div>
                <div>
                    <label class="form-label">Email Address</label>
                    <input name="email" type="email" class="form-input" placeholder="student@email.com" />
                </div>
                <div>
                    <label class="form-label">Mobile Number *</label>
                    <input name="mobile" class="form-input" placeholder="+91 98765 43210" required />
                </div>
            </div>
        </div>
    </div>

    <!-- Parent Details -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Parent Details</h3>
                <p class="text-xs text-muted-foreground mt-0.5">Family contact relations</p>
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Father's Full Name *</label>
                    <input name="father_name" class="form-input" placeholder="Father's Name" required />
                </div>
                <div>
                    <label class="form-label">Mother's Full Name *</label>
                    <input name="mother_name" class="form-input" placeholder="Mother's Name" required />
                </div>
                <div>
                    <label class="form-label">Parent / Guardian Contact</label>
                    <input name="parent_mobile" class="form-input" placeholder="+91" />
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Details -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Residential Address</h3>
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Alternate Number</label>
                    <input name="alternate_number" class="form-input" placeholder="Emergency contact" />
                </div>
                <div>
                    <label class="form-label">City *</label>
                    <input name="city" class="form-input" placeholder="e.g. Pune" required />
                </div>
                <div>
                    <label class="form-label">State *</label>
                    <input name="state" class="form-input" placeholder="e.g. Maharashtra" required />
                </div>
                <div class="md:col-span-3">
                    <label class="form-label">Full Address *</label>
                    <textarea name="address" class="form-textarea" rows="2" placeholder="Street Address, Area, Landmark" required></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Course & Branch Details -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Course & Branch Enrollment</h3>
                <p class="text-xs text-muted-foreground mt-0.5">Select course profile and pricing</p>
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Selected Course *</label>
                    <select name="course_name" class="form-select" required>
                        <option value="">Select Course Profile</option>
                        <option value="DCA">DCA (Diploma in Computer Apps)</option>
                        <option value="ADCA">ADCA (Adv Diploma in Computer Apps)</option>
                        <option value="Tally Prime">Tally Prime & GST</option>
                        <option value="Web Design">Web Design & Development</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Target Branch *</label>
                    <select name="branch" class="form-select" required>
                        <option value="">Choose Branch Identity</option>
                        <?php if (isset($mock_branches)): ?>
                            <?php foreach ($mock_branches as $b): ?>
                                <option value="<?php echo $b['name']; ?>"><?php echo $b['name']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Admission Date *</label>
                    <input name="admission_date" type="date" class="form-input" value="<?php echo date('Y-m-d'); ?>" required />
                </div>
                <div>
                    <label class="form-label">Course Duration</label>
                    <input name="duration" class="form-input" placeholder="e.g. 6 Months" />
                </div>
                <div>
                    <label class="form-label">Total Course Fee *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-muted-foreground text-xs">₹</span>
                        <input name="total_fees" type="number" class="form-input pl-6" placeholder="15000" required />
                    </div>
                </div>
                <div>
                    <label class="form-label">Discount Approved</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-muted-foreground text-xs">₹</span>
                        <input name="discount" type="number" class="form-input pl-6" placeholder="0" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MANDATORY DOCUMENT UPLOADS PREPARATION -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Mandatory Document Uploads</h3>
                <p class="text-xs text-muted-foreground mt-0.5">Upload verified student identities (drag & drop ready)</p>
            </div>
        </div>
        <div class="section-body">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- 1. Student Photo -->
                <label class="upload-label border-2 border-dashed border-border rounded-lg p-5 flex flex-col items-center justify-center gap-1.5 text-center cursor-pointer hover:border-primary hover:bg-primary-soft/10 transition">
                    <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center shrink-0">
                        <i data-lucide="user" class="w-4.5 h-4.5"></i>
                    </div>
                    <div class="text-xs font-semibold text-foreground">1. Student Photo *</div>
                    <div class="text-[10px] text-muted-foreground upload-filename truncate max-w-[170px]">PNG/JPG (Max 2MB)</div>
                    <div class="text-[10px] text-muted-foreground upload-status">Select File</div>
                    <input name="student_photo" type="file" class="hidden" accept="image/*" required />
                </label>

                <!-- 2. Aadhaar Card -->
                <label class="upload-label border-2 border-dashed border-border rounded-lg p-5 flex flex-col items-center justify-center gap-1.5 text-center cursor-pointer hover:border-primary hover:bg-primary-soft/10 transition">
                    <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center shrink-0">
                        <i data-lucide="file-digit" class="w-4.5 h-4.5"></i>
                    </div>
                    <div class="text-xs font-semibold text-foreground">2. Aadhaar Card *</div>
                    <div class="text-[10px] text-muted-foreground upload-filename truncate max-w-[170px]">PDF/JPG (Max 2MB)</div>
                    <div class="text-[10px] text-muted-foreground upload-status">Select File</div>
                    <input name="aadhaar_doc" type="file" class="hidden" accept="image/*,.pdf" required />
                </label>

                <!-- 3. Marksheet -->
                <label class="upload-label border-2 border-dashed border-border rounded-lg p-5 flex flex-col items-center justify-center gap-1.5 text-center cursor-pointer hover:border-primary hover:bg-primary-soft/10 transition">
                    <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center shrink-0">
                        <i data-lucide="graduation-cap" class="w-4.5 h-4.5"></i>
                    </div>
                    <div class="text-xs font-semibold text-foreground">3. Academic Marksheet</div>
                    <div class="text-[10px] text-muted-foreground upload-filename truncate max-w-[170px]">PDF/JPG (Max 2MB)</div>
                    <div class="text-[10px] text-muted-foreground upload-status">Select File</div>
                    <input name="marksheet_doc" type="file" class="hidden" accept="image/*,.pdf" />
                </label>

                <!-- 4. Signature -->
                <label class="upload-label border-2 border-dashed border-border rounded-lg p-5 flex flex-col items-center justify-center gap-1.5 text-center cursor-pointer hover:border-primary hover:bg-primary-soft/10 transition">
                    <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center shrink-0">
                        <i data-lucide="pen-tool" class="w-4.5 h-4.5"></i>
                    </div>
                    <div class="text-xs font-semibold text-foreground">4. Student Signature *</div>
                    <div class="text-[10px] text-muted-foreground upload-filename truncate max-w-[170px]">PNG/JPG (Max 1MB)</div>
                    <div class="text-[10px] text-muted-foreground upload-status">Select File</div>
                    <input name="signature_doc" type="file" class="hidden" accept="image/*" required />
                </label>

                <!-- 5. Additional Documents -->
                <label class="upload-label border-2 border-dashed border-border rounded-lg p-5 flex flex-col items-center justify-center gap-1.5 text-center cursor-pointer hover:border-primary hover:bg-primary-soft/10 transition">
                    <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center shrink-0">
                        <i data-lucide="folder-open" class="w-4.5 h-4.5"></i>
                    </div>
                    <div class="text-xs font-semibold text-foreground">5. Extra Documents</div>
                    <div class="text-[10px] text-muted-foreground upload-filename truncate max-w-[170px]">PDF/ZIP (Max 5MB)</div>
                    <div class="text-[10px] text-muted-foreground upload-status">Select File</div>
                    <input name="extra_docs" type="file" class="hidden" accept=".pdf,.zip,.rar" />
                </label>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-2 border-t border-border pt-4">
        <a href="students.php" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Submit Student Registration</button>
    </div>
</form>

<script>
    // Bind simulated submit state
    document.getElementById('admission-form').addEventListener('submit', function (e) {
        e.preventDefault();
        showLoader("Uploading registration forms and files...", 1800);
        setTimeout(() => {
            showNotificationToast("Student registered and documents saved successfully.", 'success');
            setTimeout(() => {
                window.location.href = "students.php";
            }, 1200);
        }, 1800);
    });
</script>

<?php
include '../includes/footer.php';
?>
