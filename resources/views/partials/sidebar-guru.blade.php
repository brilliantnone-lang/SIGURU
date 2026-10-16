<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" href="{{ route('guru.dashboard') }}">Dashboard</a>
        <a class="nav-item" href="#">Jurnal Mengajar</a>
        <a class="nav-item" href="#">Presensi Siswa</a>
        <a class="nav-item" href="#">Bahan Ajar</a>
        <a class="nav-item" href="#">Kalender Akademik</a>
    </nav>

    <div class="section-label">PENGATURAN</div>
    <nav class="nav">
        <a class="nav-item" href="#">Profil Saya</a>
        <a class="nav-item" href="#">Panduan Penggunaan</a>
    </nav>
</aside>