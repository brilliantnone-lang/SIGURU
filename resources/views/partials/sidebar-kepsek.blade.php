<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}"
           href="{{ route('kepsek.dashboard') }}">
            Dashboard
        </a>
        <a class="nav-item {{ request()->routeIs('kepsek.validasi.*') ? 'active' : '' }}"
           href="#">
            Validasi Jurnal
        </a>
        <a class="nav-item {{ request()->routeIs('kepsek.bahan-ajar.*') ? 'active' : '' }}"
           href="#">
            Bahan Ajar
        </a>
        <a class="nav-item {{ request()->routeIs('kepsek.kalender') ? 'active' : '' }}"
           href="#">
            Kalender Akademik
        </a>
    </nav>

    <div class="section-label">PENGATURAN</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('kepsek.panduan') ? 'active' : '' }}"
           href="#">
            Panduan Penggunaan
        </a>
    </nav>
</aside>