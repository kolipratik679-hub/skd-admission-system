<?php
$page_title = "New Admission";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<form class="space-y-4" action="students.php" method="POST" enctype="multipart/form-data">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <h1 class="page-title">New Admission</h1>
            <p class="page-subtitle mt-1">Enter student details. All sections are required.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button type="reset" class="btn btn-outline btn-sm"><i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset</button>
            <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="save" class="w-3.5 h-3.5"></i> Save Admission</button>
        </div>
    </div>

    <!-- Personal Details -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Personal Details</h3>
                <p class="text-xs text-muted-foreground mt-0.5">Identity & demographics</p>
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Student ID *</label>
                    <input name="student_id" class="form-input" placeholder="SKD-2025-0143" required />
                </div>
                <div>
                    <label class="form-label">Full Name *</label>
                    <input name="full_name" class="form-input" placeholder="As per ID proof" required />
                </div>
                <div>
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select</option>
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
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-input" placeholder="student@email.com" />
                </div>
                <div>
                    <label class="form-label">Mobile *</label>
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
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Father's Name *</label>
                    <input name="father_name" class="form-input" required />
                </div>
                <div>
                    <label class="form-label">Mother's Name *</label>
                    <input name="mother_name" class="form-input" required />
                </div>
                <div>
                    <label class="form-label">Parent Mobile</label>
                    <input name="parent_mobile" class="form-input" placeholder="+91" />
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Details -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Contact Details</h3>
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Alternate Number</label>
                    <input name="alternate_number" class="form-input" />
                </div>
                <div>
                    <label class="form-label">City</label>
                    <input name="city" class="form-input" />
                </div>
                <div>
                    <label class="form-label">State</label>
                    <input name="state" class="form-input" />
                </div>
                <div class="md:col-span-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-textarea" rows="2"></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Details -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Course Details</h3>
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Course Name *</label>
                    <select name="course_name" class="form-select" required>
                        <option value="">Select course</option>
                        <option value="DCA">DCA</option>
                        <option value="ADCA">ADCA</option>
                        <option value="Tally Prime">Tally Prime</option>
                        <option value="Web Design">Web Design</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Branch *</label>
                    <select name="branch" class="form-select" required>
                        <option value="Pune Camp">Pune Camp</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Nashik">Nashik</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Admission Date *</label>
                    <input name="admission_date" type="date" class="form-input" required />
                </div>
                <div>
                    <label class="form-label">Course Duration</label>
                    <input name="duration" class="form-input" placeholder="6 months" />
                </div>
                <div>
                    <label class="form-label">Total Fees *</label>
                    <input name="total_fees" type="number" class="form-input" placeholder="15000" required />
                </div>
                <div>
                    <label class="form-label">Discount</label>
                    <input name="discount" type="number" class="form-input" placeholder="0" />
                </div>
            </div>
        </div>
    </div>

    <!-- Uploads -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Uploads</h3>
            </div>
        </div>
        <div class="section-body">
            <div class="grid md:grid-cols-2 gap-4">
                <!-- Photo Upload -->
                <label class="border border-dashed border-border rounded-md p-6 flex flex-col items-center justify-center gap-2 text-center cursor-pointer hover:border-primary hover:bg-primary-soft/40 transition">
                    <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <div class="text-sm font-medium">Student Photo</div>
                    <div class="text-xs text-muted-foreground">PNG/JPG up to 2 MB</div>
                    <button type="button" class="btn btn-outline btn-sm mt-1 pointer-events-none"><i data-lucide="upload" class="w-3.5 h-3.5"></i> Browse</button>
                    <input name="student_photo" type="file" class="hidden" accept="image/*" />
                </label>
                <!-- ID Proof Upload -->
                <label class="border border-dashed border-border rounded-md p-6 flex flex-col items-center justify-center gap-2 text-center cursor-pointer hover:border-primary hover:bg-primary-soft/40 transition">
                    <div class="h-10 w-10 rounded-full bg-primary-soft text-primary flex items-center justify-center">
                        <i data-lucide="file-up" class="w-5 h-5"></i>
                    </div>
                    <div class="text-sm font-medium">ID Proof</div>
                    <div class="text-xs text-muted-foreground">PNG/JPG/PDF up to 2 MB</div>
                    <button type="button" class="btn btn-outline btn-sm mt-1 pointer-events-none"><i data-lucide="upload" class="w-3.5 h-3.5"></i> Browse</button>
                    <input name="id_proof" type="file" class="hidden" accept="image/*,.pdf" />
                </label>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-2">
        <a href="students.php" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary"><i data-lucide="save" class="w-3.5 h-3.5"></i> Save Admission</button>
    </div>
</form>

<?php
include '../includes/footer.php';
?>
