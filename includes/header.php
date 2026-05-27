<?php
// Resolve base path: subfolder pages (admin/, branch/, portal/) need '../'
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
$is_subfolder = $current_dir !== 'skd-admission' && $current_dir !== '';
$base_path = $is_subfolder ? '../' : './';
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="S.K.D Admission System — Lightweight multi-branch admission management system for S.K.D Computer Education.">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' — S.K.D Admission' : 'S.K.D Admission System'; ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $base_path; ?>assets/images/favicon.ico" type="image/x-icon">

    <!-- Production CSS (compiled Tailwind v4 — no build tools required) -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/styles.css">

    <style>
        /* Print: hide UI chrome, show only content */
        @media print {
            .no-print { display: none !important; }
            #sidebar, #sidebar-backdrop { display: none !important; }
            body { background: white !important; color: black !important; }
            main { padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-background text-foreground antialiased font-sans min-h-screen">
