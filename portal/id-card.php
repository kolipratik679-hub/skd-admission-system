<?php
require_once '../config/auth.php';
require_student();

$page_title = "My ID Card";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

// In production, loaded dynamically from MySQL table joined with the active student session ID
$my_id = 'SKD-2025-0142';
$target_student = null;
if (isset($mock_students)) {
    foreach ($mock_students as $s) {
        if ($s['id'] === $my_id) {
            $target_student = $s;
            break;
        }
    }
}

// Fallback if not found
if (!$target_student && isset($mock_students[0])) {
    $target_student = $mock_students[0];
}

// Identify active branch and styles
$branch_name_val = $target_student['branch'];
$target_branch = isset($mock_branches[$branch_name_val]) ? $mock_branches[$branch_name_val] : $active_branch;

// Dynamic branding parameters
$id_branch_name = $target_branch['name'];
$id_brand_name  = $target_branch['brand_name'];
$id_logo        = $target_branch['logo'];
$id_color       = $target_branch['color'];
$id_phone       = $target_branch['contact'];
$id_address     = $target_branch['address'];
?>

<style>
    @media print {
        #id-cards-container {
            display: flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            gap: 24px !important;
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
        }
        .id-card-element {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            page-break-inside: avoid !important;
        }
    }
</style>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">My ID Card</h1>
        <p class="page-subtitle mt-1">View, print or download your verified digital student ID card.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap no-print">
        <button onclick="triggerSimulatedDownload('<?php echo $target_student['name']; ?>_ID.pdf')" class="btn btn-outline btn-sm"><i data-lucide="download" class="w-3.5 h-3.5"></i> Download PDF</button>
        <button class="btn btn-primary btn-sm" onclick="window.print()"><i data-lucide="printer" class="w-3.5 h-3.5"></i> Print Card</button>
    </div>
</div>

<div class="section-card">
    <div id="id-cards-container" class="grid md:grid-cols-2 gap-8 py-8 justify-center">
        <!-- Front side of ID card -->
        <div class="space-y-3">
            <div class="text-[10px] uppercase tracking-wider text-muted-foreground text-center font-bold no-print">Front View</div>
            <div class="id-card-element w-[340px] h-[520px] rounded-2xl overflow-hidden border border-border bg-card shadow-card mx-auto flex flex-col text-foreground">
                <div class="h-24 px-4 flex items-center gap-2.5 shrink-0" style="background: linear-gradient(135deg, <?php echo $id_color; ?>e6, <?php echo $id_color; ?>);">
                    <img src="<?php echo $base_path . $id_logo; ?>" class="h-12 w-12 bg-white rounded-md p-1 object-contain shrink-0" alt="Logo" />
                    <div class="text-white text-left leading-tight flex-1 min-w-0">
                        <div class="text-[10px] uppercase tracking-wider opacity-85 truncate"><?php echo $id_brand_name; ?></div>
                        <div class="font-bold text-sm leading-tight truncate"><?php echo $id_branch_name; ?></div>
                        <div class="text-[9px] opacity-75 mt-0.5">Student ID Card</div>
                    </div>
                </div>
                <div class="flex-1 flex flex-col items-center px-6 py-4 text-center">
                    <div class="h-24 w-24 rounded-full bg-primary-soft text-primary text-2xl font-bold flex items-center justify-center -mt-12 border-4 border-card shrink-0">
                        <?php 
                        $words = explode(" ", $target_student['name']);
                        $initials = "";
                        foreach ($words as $w) if (isset($w[0])) $initials .= $w[0];
                        echo strtoupper(substr($initials, 0, 2));
                        ?>
                    </div>
                    <div class="mt-2 text-base font-bold text-foreground"><?php echo $target_student['name']; ?></div>
                    <div class="text-[10px] uppercase tracking-wider text-muted-foreground font-semibold">Student</div>
                    
                    <div class="mt-4 w-full text-left text-xs space-y-2 flex-1">
                        <div class="flex justify-between border-b border-border pb-1.5"><span class="text-muted-foreground">Student ID</span><span class="font-semibold text-foreground font-mono"><?php echo $my_id; ?></span></div>
                        <div class="flex justify-between border-b border-border pb-1.5"><span class="text-muted-foreground">Course Enrolled</span><span class="font-semibold text-foreground"><?php echo $target_student['course']; ?></span></div>
                        <div class="flex justify-between border-b border-border pb-1.5"><span class="text-muted-foreground">Date of Joining</span><span class="font-semibold text-foreground"><?php echo $target_student['admission_date']; ?></span></div>
                        <div class="flex justify-between border-b border-border pb-1.5"><span class="text-muted-foreground">Mobile Contact</span><span class="font-semibold text-foreground"><?php echo $target_student['mobile']; ?></span></div>
                    </div>
                    <div class="mt-auto pt-3 w-full shrink-0 border-t border-border/60">
                        <div class="text-[9px] uppercase tracking-widest text-muted-foreground">Authorized Signature</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back side of ID card -->
        <div class="space-y-3">
            <div class="text-[10px] uppercase tracking-wider text-muted-foreground text-center font-bold no-print">Back View</div>
            <div class="id-card-element w-[340px] h-[520px] rounded-2xl overflow-hidden border border-border bg-card shadow-card mx-auto flex flex-col text-foreground">
                <div class="h-24 px-4 flex items-center gap-2.5 shrink-0" style="background: linear-gradient(135deg, <?php echo $id_color; ?>e6, <?php echo $id_color; ?>);">
                    <img src="<?php echo $base_path . $id_logo; ?>" class="h-12 w-12 bg-white rounded-md p-1 object-contain shrink-0" alt="Logo" />
                    <div class="text-white text-left leading-tight flex-1 min-w-0">
                        <div class="text-[10px] uppercase tracking-wider opacity-85 truncate"><?php echo $id_brand_name; ?></div>
                        <div class="font-bold text-sm leading-tight truncate"><?php echo $id_branch_name; ?></div>
                        <div class="text-[9px] opacity-75 mt-0.5">Student ID Card</div>
                    </div>
                </div>
                <div class="flex-1 flex flex-col px-6 py-4 text-xs">
                    <div class="text-[10px] uppercase tracking-wider text-muted-foreground mb-2 text-left font-bold border-b border-border pb-1">Terms & Instructions</div>
                    <ul class="text-[11px] text-muted-foreground space-y-2 list-disc pl-4 text-left leading-tight">
                        <li>This card is non-transferable and remains valid only during the course duration.</li>
                        <li>It must be visibly carried and presented on request during institute hours.</li>
                        <li>Loss must be reported to the branch coordinator immediately.</li>
                        <li>This card is to be returned upon successful completion of the course.</li>
                    </ul>
                    
                    <div class="mt-4 flex items-center gap-3 bg-muted p-2.5 rounded-lg border border-border">
                        <!-- Barcode/QR block simulator -->
                        <div class="h-16 w-16 grid grid-cols-6 grid-rows-6 gap-px bg-foreground shrink-0">
                            <?php for ($i = 0; $i < 36; $i++): ?>
                                <div class="<?php echo (rand(0, 100) > 40) ? 'bg-foreground' : 'bg-card'; ?>"></div>
                            <?php endfor; ?>
                        </div>
                        <div class="text-left leading-tight">
                            <div class="font-semibold text-xs text-foreground">Verified QR Code</div>
                            <div class="text-[9px] text-muted-foreground mt-1">Verify enrollment online:</div>
                            <div class="text-[9px] font-mono text-primary font-bold mt-0.5">skd.edu/v/<?php echo $my_id; ?></div>
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-3 text-[9px] text-muted-foreground text-center border-t border-border/60">
                        <div><?php echo $id_address; ?></div>
                        <div class="mt-1 font-semibold text-foreground">Tel: <?php echo $id_phone; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function triggerSimulatedDownload(filename) {
        showLoader("Generating secure high-resolution ID print PDF...", 900);
        setTimeout(() => {
            showNotificationToast(`ID Card downloaded as "${filename}".`, 'success');
        }, 900);
    }
</script>

<?php
include '../includes/footer.php';
?>
