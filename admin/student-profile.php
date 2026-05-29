<?php
require_once '../config/auth.php';
require_staff();

$student_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'SKD-2025-0142';
$page_title = "Student Profile";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Student Profile</h1>
        <p class="page-subtitle mt-1"><?php echo $student_id; ?></p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="id-cards.php?id=<?php echo $student_id; ?>" class="btn btn-outline btn-sm"><i data-lucide="id-card" class="w-3.5 h-3.5"></i> Print ID</a>
        <a href="certificates.php?id=<?php echo $student_id; ?>" class="btn btn-outline btn-sm"><i data-lucide="award" class="w-3.5 h-3.5"></i> Certificate</a>
        <button class="btn btn-primary btn-sm"><i data-lucide="edit-2" class="w-3.5 h-3.5"></i> Edit</button>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Profile Card (Left) -->
    <div class="section-card">
        <div class="section-body">
            <div class="flex flex-col items-center text-center">
                <div class="h-24 w-24 rounded-full bg-primary-soft text-primary text-2xl font-bold flex items-center justify-center mb-3">RS</div>
                <div class="text-lg font-semibold">Rahul Sharma</div>
                <div class="text-xs text-muted-foreground mb-2"><?php echo $student_id; ?></div>
                <span class="badge-soft badge-success">Active Student</span>
                
                <div class="w-full mt-5 space-y-2.5 text-sm text-left">
                    <div class="flex items-center gap-2 text-muted-foreground">
                        <i data-lucide="phone" class="w-3.5 h-3.5 shrink-0"></i> +91 98765 43210
                    </div>
                    <div class="flex items-center gap-2 text-muted-foreground">
                        <i data-lucide="mail" class="w-3.5 h-3.5 shrink-0"></i> rahul@email.com
                    </div>
                    <div class="flex items-center gap-2 text-muted-foreground">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0"></i> Pune, Maharashtra
                    </div>
                    <div class="flex items-center gap-2 text-muted-foreground">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 shrink-0"></i> Joined 12 Jan 2025
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Panels (Right) -->
    <div class="lg:col-span-2 space-y-4">
        <!-- Quick Stats grid -->
        <div class="grid grid-cols-3 gap-3">
            <div class="card-surface p-3 text-center">
                <div class="text-[10px] uppercase tracking-wider text-muted-foreground">Course</div>
                <div class="text-sm font-semibold mt-1">DCA</div>
            </div>
            <div class="card-surface p-3 text-center">
                <div class="text-[10px] uppercase tracking-wider text-muted-foreground">Branch</div>
                <div class="text-sm font-semibold mt-1">Pune Camp</div>
            </div>
            <div class="card-surface p-3 text-center">
                <div class="text-[10px] uppercase tracking-wider text-muted-foreground">Duration</div>
                <div class="text-sm font-semibold mt-1">6 mo</div>
            </div>
        </div>

        <!-- Section Card with Tabs -->
        <div class="section-card">
            <!-- Tabs Headers -->
            <div class="px-4 border-b border-border flex gap-1 overflow-x-auto no-print">
                <button data-target="overview" class="tab-btn px-4 py-3 text-sm font-medium border-b-2 border-primary text-primary whitespace-nowrap transition">
                    Overview
                </button>
                <button data-target="fees" class="tab-btn px-4 py-3 text-sm font-medium border-b-2 border-transparent text-muted-foreground hover:text-foreground whitespace-nowrap transition">
                    Fees
                </button>
                <button data-target="documents" class="tab-btn px-4 py-3 text-sm font-medium border-b-2 border-transparent text-muted-foreground hover:text-foreground whitespace-nowrap transition">
                    Documents
                </button>
                <button data-target="certificates" class="tab-btn px-4 py-3 text-sm font-medium border-b-2 border-transparent text-muted-foreground hover:text-foreground whitespace-nowrap transition">
                    Certificates
                </button>
            </div>
            
            <div class="p-5">
                <!-- Overview Panel -->
                <div id="tab-overview" class="tab-panel space-y-3">
                    <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                        <?php
                        $overview_details = [
                            ['k' => 'Father', 'v' => 'Suresh Sharma'],
                            ['k' => 'Mother', 'v' => 'Meera Sharma'],
                            ['k' => 'DOB', 'v' => '12 Aug 2003'],
                            ['k' => 'Gender', 'v' => 'Male'],
                            ['k' => 'Admission Date', 'v' => '12 Jan 2025'],
                            ['k' => 'Fees', 'v' => '₹15,000'],
                            ['k' => 'Discount', 'v' => '₹500'],
                            ['k' => 'Balance', 'v' => '₹0'],
                        ];
                        foreach ($overview_details as $item): ?>
                            <div class="flex justify-between border-b border-border pb-2">
                                <span class="text-muted-foreground"><?php echo $item['k']; ?></span>
                                <span class="font-medium"><?php echo $item['v']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Fees Panel -->
                <div id="tab-fees" class="tab-panel space-y-3 hidden">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Receipt</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Mode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 3; $i++): ?>
                                    <tr>
                                        <td>#RCPT<?php echo 1000 + $i; ?></td>
                                        <td><?php echo (10 + $i); ?> Jan 2025</td>
                                        <td class="font-semibold">₹5,000</td>
                                        <td>UPI</td>
                                        <td><span class="badge-soft badge-success">Paid</span></td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Documents Panel -->
                <div id="tab-documents" class="tab-panel hidden">
                    <div class="grid sm:grid-cols-3 gap-3">
                        <?php foreach (['Photo.jpg', 'Aadhaar.pdf', 'Marksheet.pdf'] as $d): ?>
                            <div class="border border-border rounded-md p-4 text-center text-sm">
                                <div class="h-14 w-14 mx-auto rounded-md bg-muted flex items-center justify-center mb-2 text-muted-foreground font-bold text-xs uppercase">
                                    <?php echo pathinfo($d, PATHINFO_EXTENSION); ?>
                                </div>
                                <div class="font-medium truncate"><?php echo $d; ?></div>
                                <button class="btn btn-outline btn-sm mt-2 w-full">Download</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Certificates Panel -->
                <div id="tab-certificates" class="tab-panel hidden">
                    <div class="space-y-2">
                        <?php foreach (['Course Completion', 'Bonafide', 'Provisional'] as $c): ?>
                            <div class="flex items-center justify-between border border-border rounded-md p-3">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="award" class="text-primary w-[18px] h-[18px]"></i>
                                    <span class="font-medium text-sm"><?php echo $c; ?></span>
                                </div>
                                <button class="btn btn-outline btn-sm">Download</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fee Summary Card -->
        <div class="section-card">
            <div class="section-body">
                <h4 class="font-semibold text-sm mb-3">Fee Summary</h4>
                <div class="grid grid-cols-3 text-sm">
                    <div>
                        <div class="text-xs text-muted-foreground">Total</div>
                        <div class="font-semibold text-lg">₹15,000</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted-foreground">Paid</div>
                        <div class="font-semibold text-lg text-success">₹15,000</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted-foreground">Balance</div>
                        <div class="font-semibold text-lg">₹0</div>
                    </div>
                </div>
                <div class="h-2 bg-muted rounded-full mt-3 overflow-hidden">
                    <div class="h-full bg-success" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include '../includes/footer.php';
?>

