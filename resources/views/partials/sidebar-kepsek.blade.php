<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">
            <i class="bi bi-journal-bookmark-fill"></i>
        </div>
        <div class="sidebar-brand-text">
            <h6>Jurnal Mengajar</h6>
            <h5>HARIAN GURU</h5>
        </div>
    </div>

    <div class="sidebar-section">Menu Utama</div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('kepsek.dashboard') }}" class="{{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('kepsek.validasi.*') ? 'active' : '' }}">
                <i class="bi bi-check2-square"></i> Validasi Jurnal
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('kepsek.bahan-ajar.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Bahan Ajar
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('kepsek.kalender') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Kalender Akademik
            </a>
        </li>
    </ul>

    <div class="sidebar-section">Pengaturan</div>
    <ul class="sidebar-menu" style="padding-bottom: 24px;">
        <li>
            <a href="#" class="{{ request()->routeIs('kepsek.panduan') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i> Panduan Penggunaan
            </a>
        </li>
    </ul>
</div>