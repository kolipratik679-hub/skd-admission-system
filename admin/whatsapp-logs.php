<?php
$page_title = "WhatsApp Logs";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="page-title">WhatsApp Logs</h1>
        <p class="page-subtitle mt-1">Track admission, fee and certificate messages.</p>
    </div>
</div>

<div class="section-card">
    <div class="section-header flex-col sm:flex-row gap-3">
        <div class="flex items-center gap-2 bg-muted rounded-md px-3 py-1.5 w-full max-w-sm">
            <i data-lucide="search" class="w-3.5 h-3.5 text-muted-foreground"></i>
            <input placeholder="Search by student or mobile..." class="bg-transparent outline-none text-sm flex-1" />
        </div>
        <select class="form-select w-auto">
            <option>All types</option>
            <option>Admission</option>
            <option>Fee Receipt</option>
            <option>Certificate</option>
            <option>Reminder</option>
        </select>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Student</th>
                    <th>Mobile</th>
                    <th>Type</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $students = ["Rahul Sharma","Priya Nair","Aman Verma","Sneha Patil","Karan Mehta","Diya Joshi","Aarav Singh","Isha Kapoor"];
                $types = ["Admission","Fee Receipt","Certificate","Reminder","Admission","Fee Receipt","Reminder","Certificate"];
                $status = ["Delivered","Delivered","Delivered","Delivered","Failed","Delivered","Pending","Delivered"];
                $shorts = ["Rahul","Priya","Aman","Sneha","Karan","Diya","Aarav","Isha"];

                for ($i = 0; $i < 8; $i++): ?>
                    <tr>
                        <td class="text-muted-foreground whitespace-nowrap"><?php echo (10 - $i); ?>:42</td>
                        <td class="font-medium"><?php echo $students[$i]; ?></td>
                        <td>+91 9876<?php echo $i; ?>43210</td>
                        <td>
                            <span class="badge-soft badge-info">
                                <?php echo $types[$i]; ?>
                            </span>
                        </td>
                        <td class="text-muted-foreground max-w-xs truncate">
                            <i data-lucide="message-square" class="inline w-3 h-3 mr-1 text-success align-middle"></i>
                            Hi <?php echo $shorts[$i]; ?>, your receipt is ready...
                        </td>
                        <td>
                            <span class="badge-soft badge-<?php echo ($status[$i] === 'Delivered' ? 'success' : ($status[$i] === 'Pending' ? 'warning' : 'danger')); ?>">
                                <?php echo $status[$i]; ?>
                            </span>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
