@extends('layouts.app')

@section('title', 'Data Cover')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan kegiatan pembelajaran')

@section('content')
    <div class="app">

        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">
                    <span class="person"></span>
                    <span class="paper"></span>
                </div>
                <div>JURNAL MENGAJAR<br>HARIAN GURU</div>
            </div>

            <div class="section-label">MENU UTAMA</div>
            <nav class="nav">
                <a class="nav-item" href="#">Dashboard</a>
                <a class="nav-item" href="#">Rekapitulasi Absensi Siswa</a>
                <a class="nav-item" href="#">Kalender Akademik</a>
                <a class="nav-item" href="#">Jurnal Harian Guru</a>
                <a class="nav-item" href="#">Bahan Ajar Guru</a>
            </nav>

            <div class="section-label">PENGATURAN</div>
            <nav class="nav">
                <a class="nav-item active" href="#">Data Cover</a>
                <a class="nav-item" href="/dataguru">Data Guru</a>
                <a class="nav-item" href="/datakelas">Data Kelas</a>
                <a class="nav-item" href="/datapengajaran">Data Pengajaran</a>
                <a class="nav-item" href="/eventsekolah">Event Sekolah</a>
                <a class="nav-item" href="/panduanpenggunaan">Panduan Penggunaan</a>
            </nav>

            <div class="sidebar-footer">
                © 2026 Jurnal Mengajar Guru
            </div>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="profile">
                    <div class="avatar">A</div>
                    <div class="profile-name">
                        Admin Kurikulum<br>
                        ♟ Admin
                    </div>
                </div>
                <div class="logout">
                    <span class="logout-icon">⇥</span>
                    Keluar
                </div>
            </header>

            <section class="content">
                <h1>Data Cover</h1>
                <p class="subtitle">
                    Atur identitas dan format halaman depan jurnal mengajar guru.
                </p>

                <div class="settings-card">
                    <div class="settings-inner">
                        <h2 class="settings-title">Pengaturan identitas</h2>
                        <p class="settings-description">
                            Perubahan langsung ditampilkan pada pratinjau cover
                        </p>

                        <div class="field-row">
                            <div class="field">
                                <label class="field-label">
                                    Pemerintah Kota / Kabupaten
                                </label>
                                <input class="input" value="PEMERINTAH KOTA BANJARMASIN" readonly>
                            </div>

                            <div class="field">
                                <label class="field-label">Dinas</label>
                                <input class="input" value="DINAS PENDIDIKAN" readonly>
                            </div>
                        </div>

                        <div class="school-field">
                            <label class="field-label">Nama Sekolah</label>
                            <input class="input" value="SMP NEGERI 15 BANJARMASIN" readonly>
                        </div>

                        <label class="field-label upload-label">
                            Logo sekolah / Tut Wuri Handayani
                        </label>

                        <div class="upload-box">
                            <div class="upload-inner">
                                <svg class="cloud-icon" viewBox="0 0 32 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 21H6.5C3.5 21 1.5 18.8 1.5 16
                                         C1.5 13.2 3.7 11 6.5 11
                                         C7.4 6.6 11 4 15.5 4
                                         C20.1 4 23.4 7 24 11
                                         C27.6 10.9 30 13.1 30 16.2
                                         C30 19 27.8 21 25 21H23" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16 26V13M11.5 17.5L16 13L20.5 17.5" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <div class="upload-title">Upload Logo</div>
                                <div class="upload-text">
                                    Klik untuk memilih file atau seret file ke sini
                                </div>
                                <div class="upload-text">
                                    Format PNG, JPG - Maksimal 5 MB
                                </div>
                            </div>
                        </div>

                        <p class="help-text">
                            Unggah logo resmi berformat PNG atau JPG untuk ditampilkan pada cover.
                        </p>

                        <div class="button-row">
                            <button class="save-button" type="button">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="main-footer">
                <span>© 2026 Jurnal Mengajar Guru</span>
                <span>V.01.00</span>
            </footer>
    </div>
@endsection