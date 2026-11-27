<aside class="sidebar">
    <div class="section-label">MENU UTAMA</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"
            href="{{ route('guru.dashboard') }}">
            Dashboard
        </a>

        <a class="nav-item {{ request()->routeIs('guru.jurnal-harian', 'guru.edit-jurnal', 'guru.tambah-jurnal', 'guru.lihat-jurnal', 'guru.catatan-revisi', 'guru.jurnal-penggantian') ? 'active' : '' }}"
            href="{{ route('guru.jurnal-harian') }}">
            Jurnal Mengajar
        </a>

        <a class="nav-item {{ request()->routeIs('guru.bahan-ajar','guru.edit-bahan-ajar','guru.unggah-bahan-ajar') ? 'active' : '' }}"
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
        <a class="nav-item {{ request()->routeIs('guru.profil-saya', 'guru.edit-profil') ? 'active' : '' }}"
            href="{{ route('guru.profil-saya') }}">
            Profil Saya
        </a>

        <a class="nav-item {{ request()->routeIs('guru.panduan') ? 'active' : '' }}" href="{{ route('guru.panduan') }}">
            Panduan Penggunaan
        </a>
    </nav>
</aside>