
import './bootstrap';

// =========================================
// SIGURU - MOBILE SIDEBAR
// =========================================

document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.getElementById('mobileMenuToggle');
    const sidebar = document.querySelector('.sidebar');
    const appBody = document.querySelector('.app-body');

    if (!menuButton || !sidebar || !appBody) return;

    function openMenu() {
        document.body.classList.add('mobile-menu-open');
        menuButton.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        document.body.classList.remove('mobile-menu-open');
        menuButton.setAttribute('aria-expanded', 'false');
    }

    menuButton.addEventListener('click', function () {
        const isOpen = document.body.classList.contains('mobile-menu-open');

        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Tutup jika area di luar sidebar ditekan
    appBody.addEventListener('click', function (event) {
        if (
            document.body.classList.contains('mobile-menu-open') &&
            !sidebar.contains(event.target)
        ) {
            closeMenu();
        }
    });

    // Tutup setelah memilih menu
    sidebar.querySelectorAll('.nav-item').forEach(function (item) {
        item.addEventListener('click', closeMenu);
    });

    // Tutup dengan tombol Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });

    // Kembali ke tampilan desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth > 992) {
            closeMenu();
        }
    });
});
