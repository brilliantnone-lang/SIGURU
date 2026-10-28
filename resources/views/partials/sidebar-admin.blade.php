<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">
            Dashboard
        </a>
        <a class="nav-item {{ request()->routeIs('admin.rekap-absensi.*') ? 'active' : '' }}"
            href="{{ route('admin.rekap-absensi.index') }}">
            Rekapitulasi Absensi Siswa
        </a>
        <a class="nav-item {{ request()->routeIs('admin.kalender.*') ? 'active' : '' }}"
            href="{{ route('admin.kalender.index') }}">
            Kalender Akademik
        </a>
        <a class="nav-item {{ request()->routeIs('admin.jurnal.*') ? 'active' : '' }}"
            href="{{ route('admin.jurnal.index') }}">
            Jurnal Harian Guru
        </a>
        <a class="nav-item {{ request()->routeIs('admin.bahan-ajar.*') ? 'active' : '' }}"
            href="{{ route('admin.bahan-ajar.index') }}">
            Bahan Ajar Guru
        </a>
    </nav>

    <div class="section-label">PENGATURAN</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('admin.data-cover.*') ? 'active' : '' }}"
            href="{{ route('admin.data-cover.index') }}">
            Data Cover
        </a>

        <a class="nav-item {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}"
            href="{{ route('admin.mapel.index') }}">
            Data Mata Pelajaran
        </a>

        <a class="nav-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}"
            href="{{ route('admin.guru.index') }}">
            Data Guru
        </a>
        <a class="nav-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}"
            href="{{ route('admin.kelas.index') }}">
            Data Kelas
        </a>
        <a class="nav-item {{ request()->routeIs('admin.pengajaran.*') ? 'active' : '' }}"
            href="{{ route('admin.pengajaran.index') }}">
            Data Pengajaran
        </a>
        <a class="nav-item {{ request()->routeIs('admin.event.*') ? 'active' : '' }}"
            href="{{ route('admin.event.index') }}">
            Event Sekolah
        </a>
        <a class="nav-item {{ request()->routeIs('admin.panduan') ? 'active' : '' }}"
            href="{{ route('admin.panduan') }}">
            Panduan Penggunaan
        </a>
    </nav>
</aside>