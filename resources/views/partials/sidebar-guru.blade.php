<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"
           href="{{ route('guru.dashboard') }}">
            Dashboard
        </a>
        <a class="nav-item {{ request()->routeIs('guru.jurnal.*') ? 'active' : '' }}"
           href="#">
            Jurnal Mengajar
        </a>
        <a class="nav-item {{ request()->routeIs('guru.presensi.*') ? 'active' : '' }}"
           href="#">
            Presensi Siswa
        </a>
        <a class="nav-item {{ request()->routeIs('guru.bahan-ajar.*') ? 'active' : '' }}"
           href="#">
            Bahan Ajar
        </a>
        <a class="nav-item {{ request()->routeIs('guru.kalender') ? 'active' : '' }}"
           href="#">
            Kalender Akademik
        </a>
    </nav>

    <div class="section-label">PENGATURAN</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('guru.profil') ? 'active' : '' }}"
           href="#">
            Profil Saya
        </a>
        <a class="nav-item {{ request()->routeIs('guru.panduan') ? 'active' : '' }}"
           href="#">
            Panduan Penggunaan
        </a>
    </nav>
</aside>