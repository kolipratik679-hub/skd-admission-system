<?php
require_once '../config/auth.php';
require_staff();

$page_title = "Settings Configuration";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

// In production, fetch settings values directly from MySQL settings table for the active branch
$settings_logo = isset($db_branch_logo) ? $db_branch_logo : 'assets/images/skd-logo.png';
$settings_brand = isset($db_brand_name) ? $db_brand_name : 'S.K.D Computer Education';
$settings_contact = isset($db_branch_contact) ? $db_branch_contact : '+91 98220 11111';
$settings_whatsapp = isset($db_branch_whatsapp) ? $db_branch_whatsapp : '+91 98220 11111';
$settings_email = isset($db_branch_email) ? $db_branch_email : 'camp@skdedu.com';
$settings_address = isset($db_branch_address) ? $db_branch_address : 'Pune Camp, Pune, Maharashtra 411001';
$settings_color = isset($db_branch_color) ? $db_branch_color : '#2563eb';
?>

<form id="settings-form" class="space-y-4" action="settings.php" method="POST" enctype="multipart/form-data">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <h1 class="page-title">Branch Settings</h1>
            <p class="page-subtitle mt-1">Configure your independent branch branding identity, print formats, and theme color profiles.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="save" class="w-3.5 h-3.5"></i> Save All Settings</button>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Brand Style & Logos (Left Col) -->
        <div class="space-y-4">
            <div class="section-card">
                <div class="section-header">
                    <h3 class="font-semibold text-sm">Visual Identity</h3>
                </div>
                <div class="section-body space-y-4">
                    <!-- Dynamic Branch Logo Upload -->
                    <div>
                        <label class="form-label">Branch Logo *</label>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-12 w-12 rounded bg-muted flex items-center justify-center border border-border shrink-0">
                                <img src="<?php echo $base_path . $settings_logo; ?>" class="h-10 w-10 object-contain" alt="Current Logo" />
                            </div>
                            <div class="leading-tight">
                                <div class="text-xs font-semibold text-foreground">Current Logo</div>
                                <div class="text-[10px] text-muted-foreground">skd-logo.png</div>
                            </div>
                        </div>
                        <label class="upload-label border border-dashed border-border rounded-md p-4 flex flex-col items-center gap-1 cursor-pointer hover:border-primary transition text-center">
                            <div class="h-8 w-8 rounded-full bg-primary-soft text-primary flex items-center justify-center">
                                <i data-lucide="image" class="w-4 h-4"></i>
                            </div>
                            <div class="text-[10px] font-semibold text-foreground upload-filename">Upload New Logo (PNG only)</div>
                            <div class="text-[9px] text-muted-foreground upload-status">Maximum file size 1MB</div>
                            <input name="logo" type="file" class="hidden" accept="image/png" />
                        </label>
                    </div>

                    <!-- Brand Name -->
                    <div>
                        <label class="form-label">Brand Name / Institute *</label>
                        <input name="brand_name" class="form-input" value="<?php echo $settings_brand; ?>" required />
                    </div>

                    <!-- Theme Color Picker -->
                    <div>
                        <label class="form-label">Active Theme Color *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="theme_color" id="theme-color-picker" class="h-10 w-14 border border-border rounded p-0.5 cursor-pointer bg-transparent" value="<?php echo $settings_color; ?>">
                            <div class="leading-tight">
                                <div class="text-xs font-semibold text-foreground" id="color-hex-text"><?php echo $settings_color; ?></div>
                                <span class="text-[10px] text-muted-foreground">Sets button & navigation badges</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact & Legal Settings (Right 2 cols) -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Contact settings -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="font-semibold text-sm">Contact & Location</h3>
                </div>
                <div class="section-body">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Primary Contact Number *</label>
                            <input name="contact_phone" class="form-input" value="<?php echo $settings_contact; ?>" required />
                        </div>
                        <div>
                            <label class="form-label">WhatsApp Support Number *</label>
                            <input name="whatsapp_phone" class="form-input" value="<?php echo $settings_whatsapp; ?>" required />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Public Enquiry Email Address *</label>
                            <input name="contact_email" type="email" class="form-input" value="<?php echo $settings_email; ?>" required />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Branch Postal Address *</label>
                            <textarea name="contact_address" class="form-textarea" rows="2" required><?php echo $settings_address; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipt & ID Print Config -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="font-semibold text-sm">Receipt & Print Formatting</h3>
                </div>
                <div class="section-body">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Receipt Footer Note *</label>
                            <input name="receipt_footer" class="form-input" value="Thank you for choosing S.K.D Education for your professional training." required />
                        </div>
                        <div>
                            <label class="form-label">Official Certificate Signatory *</label>
                            <input name="cert_signatory" class="form-input" value="Director, S.K.D Computer Education" required />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">ID Card Legal Terms & Conditions *</label>
                            <textarea name="id_terms" class="form-textarea" rows="2" required>This card is the property of S.K.D Computer Education. Loss must be reported immediately. Must be presented on request.</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Keep color input hex code displayed nicely
    document.getElementById('theme-color-picker').addEventListener('input', function() {
        document.getElementById('color-hex-text').textContent = this.value.toUpperCase();
    });

    // Simulated submit state
    document.getElementById('settings-form').addEventListener('submit', function (e) {
        e.preventDefault();
        showLoader("Updating active branch configurations...", 1200);
        setTimeout(() => {
            showNotificationToast("Active branch settings updated successfully.", 'success');
        }, 1200);
    });
</script>

<?php
include '../includes/footer.php';
?>
