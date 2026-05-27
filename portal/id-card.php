<?php
$page_title = "My ID Card";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<style>
    @media print {
        #id-card-print-area {
            display: flex !important;
            justify-content: center !important;
            padding: 0 !important;
            margin: 50px 0 !important;
            background: white !important;
        }
        .id-card-view {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
        }
    }
</style>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">My ID Card</h1>
        <p class="page-subtitle mt-1">Download or print your student identity card.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap no-print">
        <button class="btn btn-outline btn-sm" onclick="window.print()"><i data-lucide="printer" class="w-3.5 h-3.5"></i> Print</button>
        <button class="btn btn-primary btn-sm"><i data-lucide="download" class="w-3.5 h-3.5"></i> Download</button>
    </div>
</div>

<div class="section-card">
    <div id="id-card-print-area" class="flex justify-center py-8">
        <div class="id-card-view w-[340px] h-[520px] rounded-2xl overflow-hidden border border-border bg-card shadow-card flex flex-col text-foreground">
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
                    <div class="flex justify-between border-b border-border pb-1"><span class="text-muted-foreground">ID</span><span class="font-medium">SKD-2025-0142</span></div>
                    <div class="flex justify-between border-b border-border pb-1"><span class="text-muted-foreground">Course</span><span class="font-medium">DCA (6 mo)</span></div>
                    <div class="flex justify-between border-b border-border pb-1"><span class="text-muted-foreground">Valid</span><span class="font-medium">Jan – Jul 2025</span></div>
                    <div class="flex justify-between border-b border-border pb-1"><span class="text-muted-foreground">Mobile</span><span class="font-medium">+91 98765 43210</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
