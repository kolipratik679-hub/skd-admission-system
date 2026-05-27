<?php
$page_title = "Certificates";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Certificates</h1>
        <p class="page-subtitle mt-1">Generate and download course certificates.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <button class="btn btn-primary btn-sm"><i data-lucide="plus" class="w-3.5 h-3.5"></i> Generate Certificate</button>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Recent Certificates -->
    <div class="section-card lg:col-span-2">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Recent Certificates</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Type</th>
                        <th>Issued</th>
                        <th>Status</th>
                        <th class="text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $certs = [
                        ['name' => 'Rahul Sharma', 'sid' => 'SKD-2025-0142', 'course' => 'DCA', 'type' => 'Completion', 'date' => '20 May 2026', 'status' => 'Issued'],
                        ['name' => 'Priya Nair', 'sid' => 'SKD-2025-0141', 'course' => 'Tally Prime', 'type' => 'Bonafide', 'date' => '19 May 2026', 'status' => 'Issued'],
                        ['name' => 'Aman Verma', 'sid' => 'SKD-2025-0140', 'course' => 'Web Design', 'type' => 'Completion', 'date' => '18 May 2026', 'status' => 'Issued'],
                        ['name' => 'Sneha Patil', 'sid' => 'SKD-2025-0139', 'course' => 'ADCA', 'type' => 'Provisional', 'date' => '17 May 2026', 'status' => 'Issued'],
                        ['name' => 'Karan Mehta', 'sid' => 'SKD-2025-0138', 'course' => 'CCC', 'type' => 'Completion', 'date' => '16 May 2026', 'status' => 'Issued'],
                        ['name' => 'Diya Joshi', 'sid' => 'SKD-2025-0137', 'course' => 'Python', 'type' => 'Bonafide', 'date' => '15 May 2026', 'status' => 'Issued'],
                    ];
                    foreach ($certs as $c): ?>
                        <tr>
                            <td>
                                <div class="font-medium"><?php echo $c['name']; ?></div>
                                <div class="text-xs text-muted-foreground"><?php echo $c['sid']; ?></div>
                            </td>
                            <td><?php echo $c['course']; ?></td>
                            <td>
                                <span class="badge-soft badge-info">
                                    <?php echo $c['type']; ?>
                                </span>
                            </td>
                            <td class="text-muted-foreground"><?php echo $c['date']; ?></td>
                            <td>
                                <span class="badge-soft badge-success">
                                    <?php echo $c['status']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="flex justify-end gap-1">
                                    <button class="btn btn-ghost btn-sm" title="Download"><i data-lucide="download" class="w-3.5 h-3.5"></i></button>
                                    <button class="btn btn-ghost btn-sm" title="Print"><i data-lucide="printer" class="w-3.5 h-3.5"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Certificate Preview -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h3 class="font-semibold text-sm">Preview</h3>
            </div>
        </div>
        <div class="section-body space-y-4">
            <div id="certificate-print-area" class="border-2 border-primary/20 rounded-md p-6 bg-gradient-to-br from-primary-soft/30 to-white text-center space-y-3 bg-white">
                <img src="../assets/images/skd-logo.png" class="h-12 w-12 mx-auto object-contain" alt="Logo" />
                <div class="text-[10px] uppercase tracking-[0.3em] text-muted-foreground">Certificate of</div>
                <div class="text-xl font-bold text-primary">Completion</div>
                <div class="text-sm text-foreground">This is to certify that</div>
                <div class="text-lg font-semibold text-foreground">Rahul Sharma</div>
                <div class="text-xs text-muted-foreground">has successfully completed the course</div>
                <div class="text-sm font-medium text-foreground">Diploma in Computer Applications</div>
                <div class="border-t border-border pt-3 flex justify-between text-[10px] text-muted-foreground">
                    <span>Issued: 20 May 2026</span>
                    <span>S.K.D Education</span>
                </div>
            </div>
            <button class="btn btn-primary w-full no-print" onclick="window.print()"><i data-lucide="download" class="w-3.5 h-3.5"></i> Print / Download PDF</button>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
