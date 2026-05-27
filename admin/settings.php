<?php
$page_title = "Settings";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<form class="space-y-4" action="dashboard.php" method="POST">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <h1 class="page-title">Branch Settings</h1>
            <p class="page-subtitle mt-1">Manage branding, contact and theme.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="save" class="w-3.5 h-3.5"></i> Save Changes</button>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-4">
        <!-- Branding Card (Left) -->
        <div class="section-card">
            <div class="section-header">
                <div>
                    <h3 class="font-semibold text-sm">Branding</h3>
                </div>
            </div>
            <div class="section-body space-y-4">
                <div>
                    <label class="form-label">Branch Logo</label>
                    <label class="border border-dashed border-border rounded-md p-5 flex flex-col items-center gap-2 cursor-pointer hover:border-primary transition">
                        <div class="h-16 w-16 rounded-md bg-primary-soft text-primary flex items-center justify-center">
                            <i data-lucide="upload" class="w-5 h-5"></i>
                        </div>
                        <div class="text-xs text-muted-foreground">Upload PNG (max 1MB)</div>
                        <input name="logo" type="file" class="hidden" accept="image/png" />
                    </label>
                </div>
                <div>
                    <label class="form-label">Brand Name</label>
                    <input name="brand_name" class="form-input" value="S.K.D Computer Education" />
                </div>
                <div>
                    <label class="form-label">Theme Color</label>
                    <div class="flex gap-2">
                        <?php
                        $colors = ["#2563eb", "#0ea5e9", "#6366f1", "#0891b2", "#8b5cf6"];
                        foreach ($colors as $c): ?>
                            <button type="button" class="h-8 w-8 rounded-md border-2 border-border transition-transform hover:scale-105" style="background: <?php echo $c; ?>"></button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Settings Panels (Right) -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Contact settings -->
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <h3 class="font-semibold text-sm">Contact</h3>
                    </div>
                </div>
                <div class="section-body">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Contact Number</label>
                            <input name="contact_phone" class="form-input" value="+91 98220 11111" />
                        </div>
                        <div>
                            <label class="form-label">WhatsApp Number</label>
                            <input name="whatsapp_phone" class="form-input" value="+91 98220 11111" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Email</label>
                            <input name="contact_email" type="email" class="form-input" value="pune@skd.com" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Address</label>
                            <textarea name="contact_address" class="form-textarea" rows="2">Camp, Pune, Maharashtra 411001</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipt & Certificate -->
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <h3 class="font-semibold text-sm">Receipt & Certificate</h3>
                    </div>
                </div>
                <div class="section-body">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Receipt Footer</label>
                            <input name="receipt_footer" class="form-input" value="Thank you for joining S.K.D Education." />
                        </div>
                        <div>
                            <label class="form-label">Certificate Signatory</label>
                            <input name="cert_signatory" class="form-input" value="Director, S.K.D Education" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Terms (printed on ID)</label>
                            <textarea name="id_terms" class="form-textarea" rows="2">This ID card is non-transferable and must be carried during institute hours.</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
include '../includes/footer.php';
?>
