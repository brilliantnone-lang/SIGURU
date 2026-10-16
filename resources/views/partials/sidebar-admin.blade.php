<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
            Dashboard
        </a>
        <a class="nav-item {{ request()->routeIs('admin.rekap-absensi') ? 'active' : '' }}"
           href="{{ route('admin.rekap-absensi') }}">
            Rekapitulasi Absensi Siswa
        </a>
        <a class="nav-item {{ request()->routeIs('admin.kalender') ? 'active' : '' }}"
           href="{{ route('admin.kalender') }}">
            Kalender Akademik
        </a>
        <a class="nav-item {{ request()->routeIs('admin.jurnal') ? 'active' : '' }}"
           href="{{ route('admin.jurnal') }}">
            Jurnal Harian Guru
        </a>
        <a class="nav-item {{ request()->routeIs('admin.bahan-ajar') ? 'active' : '' }}"
           href="{{ route('admin.bahan-ajar') }}">
            Bahan Ajar Guru
        </a>
    </nav>