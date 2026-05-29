/**
 * S.K.D Admission System — Shared Production JS
 * Pure vanilla JS. No frameworks or runtime dependencies.
 */

// ─── Initialize Lucide Icons & Event Handlers ────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    initSidebar();
    initTabs();
    initPrintButtons();
    initUploadLabels();
    initActiveLinks();
    initGlobalSearchFilter();
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
            // Deactivate all sibling buttons
            btn.parentElement.querySelectorAll('[data-target]').forEach(function (b) {
                b.classList.remove('border-primary', 'text-primary');
                b.classList.add('border-transparent', 'text-muted-foreground');
            });
            // Activate clicked button
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
        label.addEventListener('click', function (e) {
            if (e.target.tagName === 'INPUT') return;
            var input = label.querySelector('input[type="file"]');
            if (input) input.click();
        });

        var input = label.querySelector('input[type="file"]');
        if (input) {
            input.addEventListener('change', function () {
                var filenameEl = label.querySelector('.upload-filename');
                var statusText = label.querySelector('.upload-status');
                if (input.files.length) {
                    var file = input.files[0];
                    if (filenameEl) {
                        filenameEl.textContent = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
                    }
                    if (statusText) {
                        statusText.textContent = "Ready to upload";
                        statusText.classList.remove("text-muted-foreground");
                        statusText.classList.add("text-success", "font-medium");
                    }
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

// ─── Global Search / Page Quick Filter ──────────────────────────────────────
function initGlobalSearchFilter() {
    const input = document.getElementById('global-search-filter');
    if (!input) return;

    input.addEventListener('keyup', function () {
        var filter = input.value.toLowerCase();
        // Target whatever table exists on the active screen
        var table = document.querySelector('.data-table');
        if (!table) return;

        var rows = table.querySelectorAll('tbody tr');
        var matched = 0;
        rows.forEach(function (row) {
            var text = row.textContent.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = '';
                matched++;
            } else {
                row.style.display = 'none';
            }
        });

        // Toggle empty state if zero matches
        const emptyState = document.getElementById('empty-state-row');
        if (emptyState) {
            emptyState.style.display = (matched === 0) ? '' : 'none';
        }
    });
}

// ─── SYSTEM TOAST NOTIFICATIONS ──────────────────────────────────────────────
function showNotificationToast(message, type = 'success') {
    const container = document.getElementById('global-toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'pointer-events-auto bg-card border border-border rounded-lg shadow-lg p-3.5 flex items-center gap-3 w-80 translate-y-2 opacity-0 transition-all duration-300';
    
    let colorClass = 'text-success';
    let iconName = 'check-circle';
    if (type === 'warning') {
        colorClass = 'text-warning';
        iconName = 'alert-triangle';
    } else if (type === 'destructive') {
        colorClass = 'text-destructive';
        iconName = 'alert-octagon';
    } else if (type === 'info') {
        colorClass = 'text-primary';
        iconName = 'info';
    }

    toast.innerHTML = `
        <div class="h-8 w-8 rounded-full bg-muted flex items-center justify-center shrink-0 ${colorClass}">
            <i data-lucide="${iconName}" class="w-4 h-4"></i>
        </div>
        <div class="flex-1 text-xs font-medium leading-tight">${message}</div>
        <button class="text-muted-foreground hover:text-foreground shrink-0" onclick="this.parentElement.remove()">
            <i data-lucide="x" class="w-3.5 h-3.5"></i>
        </button>
    `;

    container.appendChild(toast);
    if (typeof lucide !== 'undefined') {
        lucide.createIcons({ attrs: { class: 'w-4 h-4' } });
    }

    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
    }, 10);

    // Auto-remove after 4 seconds
    setTimeout(() => {
        toast.classList.add('translate-y-2', 'opacity-0');
        setTimeout(() => { toast.remove(); }, 300);
    }, 4000);
}

// ─── SYSTEM LOADER SCREEN TRIGGER ────────────────────────────────────────────
function showLoader(message = 'Processing request...', duration = 0) {
    const screen = document.getElementById('global-loading-screen');
    const text = document.getElementById('loading-screen-text');
    if (!screen || !text) return;

    text.textContent = message;
    screen.classList.remove('hidden');

    if (duration > 0) {
        setTimeout(hideLoader, duration);
    }
}

function hideLoader() {
    const screen = document.getElementById('global-loading-screen');
    if (screen) screen.classList.add('hidden');
}

// ─── SYSTEM CONFIRMATION DIALOG TRIGGER ──────────────────────────────────────
function triggerConfirmDialog(title, description, onConfirm) {
    const modal = document.getElementById('global-confirm-modal');
    const titleEl = document.getElementById('confirm-modal-title');
    const descEl = document.getElementById('confirm-modal-desc');
    const cancelBtn = document.getElementById('confirm-modal-cancel');
    const actionBtn = document.getElementById('confirm-modal-action');

    if (!modal || !titleEl || !descEl || !cancelBtn || !actionBtn) return;

    titleEl.textContent = title;
    descEl.textContent = description;
    modal.classList.remove('hidden');

    // Clean listeners
    const newCancel = cancelBtn.cloneNode(true);
    const newAction = actionBtn.cloneNode(true);
    cancelBtn.parentNode.replaceChild(newCancel, cancelBtn);
    actionBtn.parentNode.replaceChild(newAction, actionBtn);

    newCancel.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    newAction.addEventListener('click', function () {
        modal.classList.add('hidden');
        if (typeof onConfirm === 'function') onConfirm();
    });
}

function triggerLogoutConfirm(logoutUrl) {
    // Use the passed URL, or fall back to a sensible default
    var dest = logoutUrl || '../logout.php';

    triggerConfirmDialog(
        "Confirm Logout",
        "Are you sure you want to log out of the SKD Admission System?",
        function () {
            showLoader("Logging out...", 800);
            setTimeout(function() {
                window.location.href = dest;
            }, 800);
        }
    );
}

// ─── DUMMY DATA STATE MANIPULATIONS (for client demonstration) ──────────────
function handleSimulatedSave(formId, successMsg) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        showLoader("Saving changes...", 1200);
        setTimeout(() => {
            showNotificationToast(successMsg, 'success');
        }, 1200);
    });
}
