<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>

    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}"
            href="{{ route('kepsek.dashboard') }}">
            Dashboard
        </a>

        <a class="nav-item {{ request()->routeIs('kepsek.rekapitulasi-absensi.*') ? 'active' : '' }}"
            href="{{ route('kepsek.rekapitulasi-absensi.index') }}">
            Rekapitulasi Absensi Siswa
        </a>

        <a class="nav-item {{ request()->routeIs('kepsek.validasi-jurnal.*') ? 'active' : '' }}"
            href="{{ route('kepsek.validasi-jurnal.index') }}">
            Validasi Jurnal
        </a>

        <a class="nav-item {{ request()->routeIs('kepsek.bahan-ajar.*') ? 'active' : '' }}"
            href="{{ route('kepsek.bahan-ajar.index') }}">
            Bahan Ajar
        </a>

        <a class="nav-item {{ request()->routeIs('kepsek.kalender') ? 'active' : '' }}"
            href="{{ route('kepsek.kalender') }}">
            Kalender Akademik
        </a>
    </nav>

    <div class="section-label">PENGATURAN</div>

    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('kepsek.profil') ? 'active' : '' }}"
            href="{{ route('kepsek.profil') }}">
            Profil Saya
        </a>
    </nav>

    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('kepsek.panduan') ? 'active' : '' }}"
            href="{{ route('kepsek.panduan') }}">
            Panduan Penggunaan
        </a>
    </nav>
</aside>