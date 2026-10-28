@extends('layouts.app')

@section('title', 'Dashboard Admin - SIGURU')

@section('content')

<div class="admin-dashboard">

    {{-- Judul Dashboard --}}
    <div class="admin-dashboard-heading">
        <div>
            <h1>Dashboard</h1>
            <p>Ringkasan kegiatan pembelajaran</p>
        </div>
    </div>

    {{-- Kartu Statistik --}}
    <div class="admin-statistics">
        <div class="admin-stat-card">
            <div class="admin-stat-icon icon-journal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                    <path d="M8 7h8M8 11h8" />
                </svg>
            </div>
            <div class="admin-stat-info">
                <span>Jurnal</span>
                <strong>{{ $totalJurnal }}</strong>
                <small>Total jurnal masuk</small>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon icon-teacher">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="10" cy="7" r="4" />
                    <path d="M20 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="admin-stat-info">
                <span>Guru</span>
                <strong>{{ $totalGuru }}</strong>
                <small>Guru terdaftar</small>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon icon-subject">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                    <path d="M8 7h8M8 11h6" />
                </svg>
            </div>
            <div class="admin-stat-info">
                <span>Mata Pelajaran</span>
                <strong>{{ $totalMapel }}</strong>
                <small>Mata pelajaran</small>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon icon-class">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21h18" />
                    <path d="M5 21V7l8-4v18" />
                    <path d="M19 21V11l-6-4" />
                    <path d="M8 9v.01M8 12v.01M8 15v.01M8 18v.01" />
                    <path d="M16 13v.01M16 16v.01M16 19v.01" />
                </svg>
            </div>
            <div class="admin-stat-info">
                <span>Kelas</span>
                <strong>{{ $totalKelas }}</strong>
                <small>Kelas terdaftar</small>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon icon-student">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6" />
                    <path d="M2 10l10-5 10 5-10 5-10-5Z" />
                    <path d="M6 12v5c3.5 3 8.5 3 12 0v-5" />
                </svg>
            </div>
            <div class="admin-stat-info">
                <span>Siswa</span>
                <strong>{{ $totalMurid }}</strong>
                <small>Siswa terdaftar</small>
            </div>
        </div>
    </div>

    {{-- Konten Dashboard --}}
    <div class="admin-dashboard-grid">

        {{-- KIRI --}}
        <div class="admin-dashboard-left">

            {{-- Pengingat Jurnal Hari Ini --}}
            <section class="admin-panel admin-journal-reminder-panel">
                <div class="admin-panel-heading">
                    <span class="panel-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="16" rx="2" />
                            <path d="M16 3v4M8 3v4M3 10h18" />
                        </svg>
                    </span>
                    <h2>Pengingat Jurnal Hari Ini</h2>
                </div>

                <div class="journal-reminder-date">
                    <span class="journal-reminder-calendar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="16" rx="2" />
                            <path d="M16 3v4M8 3v4M3 10h18" />
                        </svg>
                    </span>
                    <div class="journal-reminder-date-text">
                        <strong>{{ now()->translatedFormat('l, d F Y') }}</strong>
                        <span>Jadwal pengisian jurnal hari ini</span>
                    </div>
                    <span class="journal-reminder-count">Belum mengisi: {{ $guruBelumIsi->count() }} guru</span>
                </div>

                <div class="admin-table-wrapper">
                    <table class="admin-table journal-reminder-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Guru</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guruBelumIsi as $index => $namaGuru)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $namaGuru }}</td>
                                <td><span class="journal-reminder-status">Belum mengisi</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="text-align:center; color:#888;">Semua guru sudah mengisi jurnal hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Rekapitulasi Absensi --}}
            <section class="admin-panel admin-attendance-panel">
                <div class="admin-panel-heading">
                    <span class="panel-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="3" width="16" height="18" rx="2" />
                            <path d="M8 7h8M8 11h8M8 15h4" />
                        </svg>
                    </span>
                    <h2>Rekapitulasi Absensi (Hari Ini)</h2>
                </div>

                <div class="admin-attendance-list">
                    <div class="admin-attendance-card attendance-present">
                        <span class="attendance-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9" />
                                <path d="m8 12 2.5 2.5L16 9" />
                            </svg></span>
                        <span class="attendance-label">Hadir</span>
                        <strong>{{ $absenHariIni->hadir ?? 0 }}</strong>
                    </div>

                    <div class="admin-attendance-card attendance-sick">
                        <span class="attendance-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 3H8a2 2 0 0 0-2 2v2" />
                                <path d="M6 17v2a2 2 0 0 0 2 2h2" />
                                <path d="M14 3h2a2 2 0 0 1 2 2v2" />
                                <path d="M18 17v2a2 2 0 0 1-2 2h-2" />
                                <path d="M12 8v8M8 12h8" />
                            </svg></span>
                        <span class="attendance-label">Sakit</span>
                        <strong>{{ $absenHariIni->sakit ?? 0 }}</strong>
                    </div>

                    <div class="admin-attendance-card attendance-permission">
                        <span class="attendance-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <path d="M14 2v6h6M8 13h8M8 17h5" />
                            </svg></span>
                        <span class="attendance-label">Izin</span>
                        <strong>{{ $absenHariIni->izin ?? 0 }}</strong>
                    </div>

                    <div class="admin-attendance-card attendance-absent">
                        <span class="attendance-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9" />
                                <path d="m9 9 6 6M15 9l-6 6" />
                            </svg></span>
                        <span class="attendance-label">Alpa</span>
                        <strong>{{ $absenHariIni->alpa ?? 0 }}</strong>
                    </div>
                </div>
            </section>
        </div>

        {{-- KANAN --}}
        <div class="admin-dashboard-right">

            {{-- Jurnal Terbaru --}}
            <section class="admin-panel">
                <div class="admin-panel-heading">
                    <span class="panel-icon">▤</span>
                    <h2>Jurnal Terbaru</h2>
                </div>

                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Guru</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnalTerbaru as $i => $j)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $j->guru->user->name ?? '-' }}</td>
                                <td>{{ $j->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
                                <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color:#888;">Belum ada jurnal masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Bahan Ajar Terbaru --}}
            <section class="admin-panel admin-material-panel">
                <div class="admin-panel-heading">
                    <span class="panel-icon">▥</span>
                    <h2>Bahan Ajar Terbaru</h2>
                </div>

                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Guru</th>
                                <th>Mata Pelajaran</th>
                                <th>File</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bahanAjarTerbaru as $i => $b)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $b->guru->user->name ?? '-' }}</td>
                                <td>{{ $b->guru->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $b->path_file) }}" target="_blank" style="color:#0A4C2E; text-decoration:underline; font-size:10px;">
                                        {{ Str::limit($b->nama_file, 15) }}
                                    </a>
                                </td>
                                <td>{{ $b->created_at->translatedFormat('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color:#888;">Belum ada bahan ajar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

    </div>

</div>

<style>
    /* ========================================
           DASHBOARD ADMIN SIGURU (CSS DIPERTAHANKAN)
        ======================================== */
    .admin-dashboard {
        width: 100%;
        min-width: 0;
        color: #26332f;
        font-family: inherit;
    }

    .admin-dashboard *,
    .admin-dashboard *::before,
    .admin-dashboard *::after {
        box-sizing: border-box;
    }

    .admin-dashboard-heading {
        margin-bottom: 16px;
    }

    .admin-dashboard-heading h1 {
        margin: 0;
        color: #17211f;
        font-size: 26px;
        font-weight: 700;
        line-height: 1.3;
    }

    .admin-dashboard-heading p {
        margin: 3px 0 0;
        color: #52665e;
        font-size: 13px;
    }

    .admin-statistics {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
        margin-bottom: 14px;
    }

    .admin-stat-card {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
        min-height: 70px;
        padding: 10px;
        background: #fff;
        border: 1px solid #dfe7e5;
        border-radius: 8px;
    }

    .admin-stat-icon {
        display: flex;
        flex: 0 0 27px;
        width: 27px;
        height: 27px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .admin-stat-icon svg {
        display: block;
        width: 22px;
        height: 22px;
        flex-shrink: 0;
    }

    .icon-journal {
        background: #dcf6e8;
        color: #269d69;
    }

    .icon-teacher {
        background: #e0f1ff;
        color: #1688dc;
    }

    .icon-subject {
        background: #f0e3ff;
        color: #9251e8;
    }

    .icon-class {
        background: #fff0d8;
        color: #e99a17;
    }

    .icon-student {
        background: #ffe1e2;
        color: #e6383d;
    }

    .admin-stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .admin-stat-info span {
        margin-bottom: 1px;
        color: #26332f;
        font-size: 10px;
        font-weight: 600;
    }

    .admin-stat-info strong {
        color: #17211f;
        font-size: 21px;
        font-weight: 700;
        line-height: 1.2;
    }

    .admin-stat-info small {
        margin-top: 2px;
        color: #74817d;
        font-size: 9px;
        line-height: 1.3;
    }

    .admin-dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(0, 1fr);
        align-items: stretch;
        gap: 12px;
    }

    .admin-dashboard-left {
        display: flex;
        flex-direction: column;
        gap: 12px;
        min-width: 0;
    }

    .admin-dashboard-right {
        display: flex;
        flex-direction: column;
        gap: 12px;
        min-width: 0;
    }

    .admin-panel {
        min-width: 0;
        padding: 12px;
        background: #fff;
        border: 1px solid #dfe7e5;
        border-radius: 8px;
    }

    .admin-panel-heading {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
    }

    .admin-panel-heading h2 {
        margin: 0;
        color: #263b35;
        font-size: 14px;
        font-weight: 700;
    }

    .panel-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #299b6b;
    }

    .panel-icon svg {
        display: block;
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }

    .admin-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        text-align: left;
    }

    .admin-table thead {
        background: #eaf6ef;
    }

    .admin-table th {
        padding: 8px 6px;
        color: #28684c;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-table td {
        padding: 8px 6px;
        color: #35423d;
        border-bottom: 1px solid #edf0ef;
        white-space: nowrap;
    }

    .admin-table tbody tr:nth-child(even) {
        background: #f8faf9;
    }

    .admin-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Pengingat Jurnal */
    .journal-reminder-date {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px;
        margin-bottom: 10px;
        border-radius: 7px;
        background: #eaf5ef;
        min-width: 0;
    }

    .journal-reminder-calendar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 34px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        color: #299b6b;
        background: #d8eee2;
    }

    .journal-reminder-calendar svg {
        width: 20px;
        height: 20px;
    }

    .journal-reminder-date-text {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
    }

    .journal-reminder-date-text strong {
        color: #263b35;
        font-size: 11px;
        font-weight: 700;
    }

    .journal-reminder-date-text span {
        color: #74817d;
        font-size: 10px;
    }

    .journal-reminder-count {
        padding: 6px 8px;
        border-radius: 20px;
        background: #f9dddd;
        color: #a52d35;
        font-size: 10px;
        font-weight: 700;
        text-align: center;
        white-space: nowrap;
    }

    .journal-reminder-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        background: #f9dddd;
        color: #a52d35;
        font-size: 10px;
        white-space: nowrap;
    }

    /* Absensi */
    .admin-attendance-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .admin-attendance-card {
        display: flex;
        align-items: center;
        gap: 9px;
        min-height: 55px;
        padding: 11px;
        border-radius: 7px;
    }

    .attendance-icon {
        display: flex;
        flex: 0 0 22px;
        width: 22px;
        height: 22px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
    }

    .attendance-icon svg {
        display: block;
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .attendance-label {
        color: #34433e;
        font-size: 12px;
        font-weight: 600;
    }

    .admin-attendance-card strong {
        margin-left: auto;
        color: #26463a;
        font-size: 18px;
        font-weight: 700;
    }

    .attendance-present {
        background: #e7f7ed;
    }

    .attendance-present .attendance-icon {
        background: #169653;
    }

    .attendance-sick {
        background: #fff4e3;
    }

    .attendance-sick .attendance-icon {
        background: #e99b00;
    }

    .attendance-sick strong {
        color: #57411d;
    }

    .attendance-permission {
        background: #e5f2ff;
    }

    .attendance-permission .attendance-icon {
        background: #1688e8;
    }

    .attendance-absent {
        background: #ffe8e8;
    }

    .attendance-absent .attendance-icon {
        background: #e33338;
    }

    .attendance-absent strong {
        color: #633033;
    }

    @media (max-width: 1100px) {
        .admin-statistics {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .admin-dashboard-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 600px) {
        .admin-dashboard-heading h1 {
            font-size: 23px;
        }

        .admin-statistics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .admin-attendance-list {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection