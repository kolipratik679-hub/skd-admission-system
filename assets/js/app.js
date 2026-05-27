/**
 * S.K.D Admission System — Shared JS
 * Pure vanilla JS. No frameworks or runtime dependencies.
 */

// ─── Initialize Lucide Icons ─────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    initSidebar();
    initTabs();
    initPrintButtons();
    initUploadLabels();
    initActiveLinks();
});

// ─── Mobile Sidebar Toggle ───────────────────────────────────────────────────
function initSidebar() {
    const sidebar    = document.getElementById('sidebar');
    const toggle     = document.getElementById('sidebar-toggle');
    const backdrop   = document.getElementById('sidebar-backdrop');

    if (!sidebar || !toggle || !backdrop) return;

    toggle.addEventListener('click', function () {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
    });

    backdrop.addEventListener('click', function () {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    });
}

// ─── Tab Panels (Student Profile, etc.) ─────────────────────────────────────
function initTabs() {
    const tabButtons = document.querySelectorAll('[data-target]');
    if (!tabButtons.length) return;

    tabButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            // Deactivate all tabs
            tabButtons.forEach(function (b) {
                b.classList.remove('border-primary', 'text-primary');
                b.classList.add('border-transparent', 'text-muted-foreground');
            });
            // Activate clicked tab
            btn.classList.add('border-primary', 'text-primary');
            btn.classList.remove('border-transparent', 'text-muted-foreground');

            // Hide all panels
            var target = btn.getAttribute('data-target');
            document.querySelectorAll('.tab-panel').forEach(function (p) {
                p.classList.add('hidden');
            });

            // Show target panel
            var panel = document.getElementById('tab-' + target);
            if (panel) panel.classList.remove('hidden');
        });
    });
}

// ─── Print Button Handlers ───────────────────────────────────────────────────
function initPrintButtons() {
    document.querySelectorAll('[data-action="print"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            window.print();
        });
    });
}

// ─── Upload Label File Trigger ───────────────────────────────────────────────
function initUploadLabels() {
    document.querySelectorAll('.upload-label').forEach(function (label) {
        label.addEventListener('click', function () {
            var input = label.querySelector('input[type="file"]');
            if (input) input.click();
        });

        var input = label.querySelector('input[type="file"]');
        if (input) {
            input.addEventListener('change', function () {
                var filenameEl = label.querySelector('.upload-filename');
                if (filenameEl && input.files.length) {
                    filenameEl.textContent = input.files[0].name;
                }
            });
        }
    });
}

// ─── Active Sidebar Link Highlighting ────────────────────────────────────────
function initActiveLinks() {
    var currentPath = window.location.pathname.split('/').pop() || 'index.php';

    document.querySelectorAll('.sidebar-link').forEach(function (link) {
        var href = link.getAttribute('href');
        if (!href) return;
        var linkPage = href.split('/').pop();
        if (linkPage === currentPath) {
            link.classList.add('active');
        }
    });
}

// ─── Search Filter (client-side table filter) ────────────────────────────────
function filterTable(inputId, tableId) {
    var input  = document.getElementById(inputId);
    var table  = document.getElementById(tableId);
    if (!input || !table) return;

    input.addEventListener('keyup', function () {
        var filter = input.value.toLowerCase();
        var rows   = table.querySelectorAll('tbody tr');
        rows.forEach(function (row) {
            var text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}
