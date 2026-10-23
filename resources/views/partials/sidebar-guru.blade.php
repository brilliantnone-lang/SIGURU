<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"
           href="{{ route('guru.dashboard') }}">
            Dashboard
        </a>

        <a class="nav-item {{ request()->routeIs('guru.jurnal.*') ? 'active' : '' }}"
           href="{{ route('guru.jurnal-harian') }}">
            Jurnal Mengajar
        </a>

        <a class="nav-item {{ request()->routeIs('guru.presensi.*') ? 'active' : '' }}"
           href="{{ route('guru.presensi-siswa') }}">
            Presensi Siswa
        </a>

        <a class="nav-item {{ request()->routeIs('guru.bahan-ajar.*') ? 'active' : '' }}"
           href="{{ route('guru.bahan-ajar') }}">
            Bahan Ajar
        </a>

        <a class="nav-item {{ request()->routeIs('guru.kalender') ? 'active' : '' }}"
           href="{{ route('guru.kalender') }}">
            Kalender Akademik
        </a>
    </nav>

    <div class="section-label">PENGATURAN</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('guru.profil') ? 'active' : '' }}"
           href="{{ route('guru.profil-saya') }}">
            Profil Saya
        </a>

        <a class="nav-item {{ request()->routeIs('guru.panduan') ? 'active' : '' }}"
           href="{{ route('guru.panduan') }}">
            Panduan Penggunaan
        </a>
    </nav>
</aside>