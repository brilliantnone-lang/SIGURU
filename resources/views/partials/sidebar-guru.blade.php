<div class="sidebar">
    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="logo-icon">
            <i class="bi bi-journal-bookmark-fill"></i>
        </div>
        <div class="sidebar-brand-text">
            <h6>Jurnal Mengajar</h6>
            <h5>HARIAN GURU</h5>
        </div>
    </div>

    {{-- Menu Utama --}}
    <div class="sidebar-section">Menu Utama</div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.rekap-absensi') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i> Rekapitulasi Absensi Siswa
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.kalender') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Kalender Akademik
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.jurnal') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Jurnal Harian Guru
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.bahan-ajar') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Bahan Ajar Guru
            </a>
        </li>
    </ul>

    {{-- Pengaturan --}}
    <div class="sidebar-section">Pengaturan</div>
    <ul class="sidebar-menu" style="padding-bottom: 24px;">
        <li>
            <a href="#" class="{{ request()->routeIs('admin.data-cover') ? 'active' : '' }}">
                <i class="bi bi-bookmark-star"></i> Data Cover
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Data Guru
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                <i class="bi bi-door-open"></i> Data Kelas
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i> Data Pengaturan
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.event') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Event Sekolah
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->routeIs('admin.panduan') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i> Panduan Penggunaan
            </a>
        </li>
    </ul>
</div>