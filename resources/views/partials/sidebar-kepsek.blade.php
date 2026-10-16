<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}" href="{{ route('kepsek.dashboard') }}">Dashboard</a>
        <a class="nav-item" href="#">Validasi Jurnal</a>
        <a class="nav-item" href="#">Bahan Ajar</a>
        <a class="nav-item" href="#">Kalender Akademik</a>
    </nav>

    <div class="section-label">PENGATURAN</div>
    <nav class="nav">
        <a class="nav-item" href="#">Panduan Penggunaan</a>
    </nav>
</aside>