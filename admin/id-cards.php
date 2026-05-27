<?php
$student_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'SKD-2025-0142';
$page_title = "ID Cards";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<!-- Print-specific styles for ID Card sizing -->
<style>
    @media print {
        #id-cards-container {
            display: flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            gap: 20px !important;
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
        }
        .id-card-element {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
            page-break-inside: avoid !important;
        }
    }
</style>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">ID Card Design</h1>
        <p class="page-subtitle mt-1">Printable double-sided student ID card.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap no-print">
        <button class="btn btn-outline btn-sm"><i data-lucide="download" class="w-3.5 h-3.5"></i> Download</button>
        <button class="btn btn-primary btn-sm" onclick="window.print()"><i data-lucide="printer" class="w-3.5 h-3.5"></i> Print</button>
    </div>
</div>

<div class="section-card">
    <div id="id-cards-container" class="grid md:grid-cols-2 gap-8 py-8 justify-center">
        <!-- Front side of ID card -->
        <div class="space-y-3">
            <div class="text-xs uppercase tracking-wider text-muted-foreground text-center font-medium no-print">Front</div>
            <div class="id-card-element w-[340px] h-[540px] rounded-2xl overflow-hidden border border-border bg-card shadow-card mx-auto flex flex-col text-foreground">
                <div class="h-24 px-4 flex items-center gap-2.5 shrink-0" style="background: var(--gradient-primary)">
                    <img src="../assets/images/skd-logo.png" class="h-12 w-12 bg-white rounded-md p-1 object-contain shrink-0" alt="Logo" />
                    <div class="text-white text-left leading-tight">
                        <div class="text-[11px] uppercase tracking-wider opacity-80">S.K.D Computer</div>
                        <div class="font-bold text-base leading-tight">Education</div>
                        <div class="text-[10px] opacity-80">Pune Camp Branch</div>
                    </div>
                </div>
                <div class="flex-1 flex flex-col items-center px-5 py-4 text-center">
                    <div class="h-28 w-28 rounded-full bg-primary-soft text-primary text-3xl font-bold flex items-center justify-center -mt-12 border-4 border-card shrink-0">RS</div>
                    <div class="mt-3 text-lg font-semibold">Rahul Sharma</div>
                    <div class="text-xs text-muted-foreground">Student</div>
                    <div class="mt-4 w-full text-left text-sm space-y-1.5">
                        <div class="flex justify-between border-b border-border pb-1"><span class="text-muted-foreground">ID</span><span class="font-medium"><?php echo $student_id; ?></span></div>
                        <div class="flex justify-between border-b border-border pb-1"><span class="text-muted-foreground">Course</span><span class="font-medium">DCA (6 mo)</span></div>
                        <div class="flex justify-between border-b border-border pb-1"><span class="text-muted-foreground">Valid</span><span class="font-medium">Jan 2025 – Jul 2025</span></div>
                        <div class="flex justify-between border-b border-border pb-1"><span class="text-muted-foreground">Mobile</span><span class="font-medium">+91 98765 43210</span></div>
                    </div>
                    <div class="mt-auto pt-3 w-full shrink-0">
                        <div class="h-12 bg-muted rounded flex items-center justify-center text-[10px] text-muted-foreground">— Signature —</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back side of ID card -->
        <div class="space-y-3">
            <div class="text-xs uppercase tracking-wider text-muted-foreground text-center font-medium no-print">Back</div>
            <div class="id-card-element w-[340px] h-[540px] rounded-2xl overflow-hidden border border-border bg-card shadow-card mx-auto flex flex-col text-foreground">
                <div class="h-24 px-4 flex items-center gap-2.5 shrink-0" style="background: var(--gradient-primary)">
                    <img src="../assets/images/skd-logo.png" class="h-12 w-12 bg-white rounded-md p-1 object-contain shrink-0" alt="Logo" />
                    <div class="text-white text-left leading-tight">
                        <div class="text-[11px] uppercase tracking-wider opacity-80">S.K.D Computer</div>
                        <div class="font-bold text-base leading-tight">Education</div>
                        <div class="text-[10px] opacity-80">Pune Camp Branch</div>
                    </div>
                </div>
                <div class="flex-1 flex flex-col px-5 py-4 text-sm">
                    <div class="text-xs uppercase tracking-wider text-muted-foreground mb-2 text-left font-semibold">Terms & Conditions</div>
                    <ul class="text-xs text-muted-foreground space-y-1.5 list-disc pl-4 text-left">
                        <li>This card is non-transferable.</li>
                        <li>Must be carried during institute hours.</li>
                        <li>Report loss to the branch immediately.</li>
                        <li>Return on course completion.</li>
                    </ul>
                    
                    <div class="mt-6 flex items-center gap-3">
                        <!-- Barcode/QR block simulator -->
                        <div class="h-20 w-20 grid grid-cols-6 grid-rows-6 gap-px bg-foreground p-1 shrink-0">
                            <?php for ($i = 0; $i < 36; $i++): ?>
                                <div class="<?php echo (rand(0, 100) > 45) ? 'bg-foreground' : 'bg-card'; ?>"></div>
                            <?php endfor; ?>
                        </div>
                        <div class="text-xs text-left">
                            <div class="font-medium text-foreground">Scan for verification</div>
                            <div class="text-muted-foreground mt-1">skd.edu/v/<?php echo $student_id; ?></div>
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-3 text-[10px] text-muted-foreground text-center">
                        S.K.D Computer Education · Pune · +91 98220 11111
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
