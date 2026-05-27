    </main>
</div>
</div> <!-- End flex layout wrapper from sidebar.php -->

<!-- Mobile Sidebar Backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-black/30 z-30 lg:hidden hidden"></div>

<!-- Shared Application JS -->
<script src="https://unpkg.com/lucide@latest"></script>
<script src="<?php
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
$is_subfolder = $current_dir !== 'skd-admission' && $current_dir !== '';
echo $is_subfolder ? '../' : './';
?>assets/js/app.js"></script>
</body>
</html>
