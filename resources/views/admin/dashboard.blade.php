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

            {{-- Jurnal --}}
            <div class="admin-stat-card">
                <div class="admin-stat-icon icon-journal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                        <path d="M8 7h8M8 11h8" />
                    </svg>
                </div>
                <div class="admin-stat-info">
                    <span>Jurnal</span>
                    <strong>127/300</strong>
                    <small>Jurnal terkumpul</small>
                </div>
            </div>

            {{-- Guru --}}
            <div class="admin-stat-card">
                <div class="admin-stat-icon icon-teacher">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="10" cy="7" r="4" />
                        <path d="M20 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="admin-stat-info">
                    <span>Guru</span>
                    <strong>24</strong>
                    <small>Guru terdaftar</small>
                </div>
            </div>

            {{-- Mata Pelajaran --}}
            <div class="admin-stat-card">
                <div class="admin-stat-icon icon-subject">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                        <path d="M8 7h8M8 11h6" />
                    </svg>
                </div>
                <div class="admin-stat-info">
                    <span>Mata Pelajaran</span>
                    <strong>12</strong>
                    <small>Mata pelajaran</small>
                </div>
            </div>

            {{-- Kelas --}}
            <div class="admin-stat-card">
                <div class="admin-stat-icon icon-class">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 21h18" />
                        <path d="M5 21V7l8-4v18" />
                        <path d="M19 21V11l-6-4" />
                        <path d="M8 9v.01M8 12v.01M8 15v.01M8 18v.01" />
                        <path d="M16 13v.01M16 16v.01M16 19v.01" />
                    </svg>
                </div>
                <div class="admin-stat-info">
                    <span>Kelas</span>
                    <strong>15</strong>
                    <small>Kelas terdaftar</small>
                </div>
            </div>

            {{-- Siswa --}}
            <div class="admin-stat-card">
                <div class="admin-stat-icon icon-student">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 10v6" />
                        <path d="M2 10l10-5 10 5-10 5-10-5Z" />
                        <path d="M6 12v5c3.5 3 8.5 3 12 0v-5" />
                    </svg>
                </div>
                <div class="admin-stat-info">
                    <span>Siswa</span>
                    <strong>450</strong>
                    <small>Siswa terdaftar</small>
                </div>
            </div>

        </div>


    </div>


    {{-- Konten Dashboard --}}
    <div class="admin-dashboard-grid">

        <div class="admin-dashboard-left">

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
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Putri Anjaya, S.Pd.</td>
                                <td>Bahasa Indonesia</td>
                                <td>VII A</td>
                                <td>01 Okt 2026</td>
                                <td><span class="admin-status status-approved">Tervalidasi</span></td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>Siti Rahma, S.Pd.</td>
                                <td>Matematika</td>
                                <td>VIII B</td>
                                <td>01 Okt 2026</td>
                                <td><span class="admin-status status-approved">Tervalidasi</span></td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>Andi Pratama, S.Pd.</td>
                                <td>IPA</td>
                                <td>IX C</td>
                                <td>30 Sep 2026</td>
                                <td><span class="admin-status status-revision">Perlu Perbaikan</span></td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>Rina Marlina, S.Pd.</td>
                                <td>IPS</td>
                                <td>VII B</td>
                                <td>30 Sep 2026</td>
                                <td><span class="admin-status status-approved">Tervalidasi</span></td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>Dewi Lestari, S.Pd.</td>
                                <td>Bahasa Inggris</td>
                                <td>VIII A</td>
                                <td>29 Sep 2026</td>
                                <td><span class="admin-status status-pending">Belum Divalidasi</span></td>
                            </tr>
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
                                <th>Kelas</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Putri Anjaya, S.Pd.</td>
                                <td>Bahasa Indonesia</td>
                                <td>VII</td>
                                <td>01 Okt 2026</td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>Siti Rahma, S.Pd.</td>
                                <td>Matematika</td>
                                <td>VIII</td>
                                <td>01 Okt 2026</td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>Andi Pratama, S.Pd.</td>
                                <td>IPA</td>
                                <td>IX</td>
                                <td>30 Sep 2026</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>Rina Marlina, S.Pd.</td>
                                <td>IPS</td>
                                <td>VII</td>
                                <td>30 Sep 2026</td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>Dewi Lestari, S.Pd.</td>
                                <td>Bahasa Inggris</td>
                                <td>VIII</td>
                                <td>29 Sep 2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>


        {{-- Rekapitulasi Absensi --}}
        <section class="admin-panel admin-attendance-panel">
            <div class="admin-panel-heading">
                <span class="panel-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path d="M8 7h8M8 11h8M8 15h4" />
                    </svg>
                </span>
                <h2>Rekapitulasi Absensi Siswa</h2>
            </div>

            <div class="admin-attendance-list">

                {{-- Hadir --}}
                <div class="admin-attendance-card attendance-present">
                    <span class="attendance-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="m8 12 2.5 2.5L16 9" />
                        </svg>
                    </span>
                    <span class="attendance-label">Hadir</span>
                    <strong>320</strong>
                </div>

                {{-- Sakit --}}
                <div class="admin-attendance-card attendance-sick">
                    <span class="attendance-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M10 3H8a2 2 0 0 0-2 2v2" />
                            <path d="M6 17v2a2 2 0 0 0 2 2h2" />
                            <path d="M14 3h2a2 2 0 0 1 2 2v2" />
                            <path d="M18 17v2a2 2 0 0 1-2 2h-2" />
                            <path d="M12 8v8M8 12h8" />
                        </svg>
                    </span>
                    <span class="attendance-label">Sakit</span>
                    <strong>30</strong>
                </div>

                {{-- Izin --}}
                <div class="admin-attendance-card attendance-permission">
                    <span class="attendance-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6M8 13h8M8 17h5" />
                        </svg>
                    </span>
                    <span class="attendance-label">Izin</span>
                    <strong>20</strong>
                </div>

                {{-- Alpha --}}
                <div class="admin-attendance-card attendance-absent">
                    <span class="attendance-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="m9 9 6 6M15 9l-6 6" />
                        </svg>
                    </span>
                    <span class="attendance-label">Alpha</span>
                    <strong>80</strong>
                </div>

            </div>
        </section>

    </div>

    </div>

    <style>
        /* ========================================
       DASHBOARD ADMIN SIGURU
       Semua selector dibatasi ke admin-dashboard
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

        /* ========================================
       HEADING DASHBOARD
    ======================================== */

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

        /* ========================================
       STATISTIK
    ======================================== */

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

        /* ========================================
       LAYOUT KONTEN
    ======================================== */

        .admin-dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(250px, 0.95fr);
            align-items: stretch;
            gap: 9px;
        }

        .admin-dashboard-left {
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 0;
        }

        .admin-panel {
            min-width: 0;
            padding: 10px;
            background: #fff;
            border: 1px solid #dfe7e5;
            border-radius: 8px;
        }

        .admin-panel-heading {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 8px;
        }

        .admin-panel-heading h2 {
            margin: 0;
            color: #263b35;
            font-size: 13px;
            font-weight: 700;
        }

        /* Ikon pada judul panel */

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

        /* ========================================
       TABEL
    ======================================== */

        .admin-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            text-align: left;
        }

        .admin-table thead {
            background: #eaf6ef;
        }

        .admin-table th {
            padding: 7px 5px;
            color: #28684c;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .admin-table td {
            padding: 6px 5px;
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

        /* ========================================
       STATUS JURNAL
    ======================================== */

        .admin-status {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 8px;
            line-height: 1.3;
            white-space: nowrap;
        }

        .status-approved {
            background: #dff5e8;
            color: #18804b;
        }

        .status-revision {
            background: #eee5ff;
            color: #7541b4;
        }

        .status-pending {
            background: #fff0d9;
            color: #b86b00;
        }

        /* ========================================
       BAHAN AJAR
    ======================================== */

        .admin-material-panel {
            flex: 1;
        }

        /* ========================================
       REKAP ABSENSI
    ======================================== */

        .admin-attendance-panel {
            padding: 12px 10px;
        }

        .admin-attendance-panel .admin-panel-heading {
            margin-bottom: 20px;
        }

        .admin-attendance-list {
            display: flex;
            flex-direction: column;
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

        /* Ikon SVG absensi */

        .attendance-icon {
            display: flex;
            flex: 0 0 19px;
            width: 19px;
            height: 19px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
        }

        .attendance-icon svg {
            display: block;
            width: 15px;
            height: 15px;
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
            font-size: 17px;
            font-weight: 700;
        }

        /* Hadir */

        .attendance-present {
            background: #e7f7ed;
        }

        .attendance-present .attendance-icon {
            background: #169653;
        }

        /* Sakit */

        .attendance-sick {
            background: #fff4e3;
        }

        .attendance-sick .attendance-icon {
            background: #e99b00;
        }

        .attendance-sick strong {
            color: #57411d;
        }

        /* Izin */

        .attendance-permission {
            background: #e5f2ff;
        }

        .attendance-permission .attendance-icon {
            background: #1688e8;
        }

        /* Alpha */

        .attendance-absent {
            background: #ffe8e8;
        }

        .attendance-absent .attendance-icon {
            background: #e33338;
        }

        .attendance-absent strong {
            color: #633033;
        }

        /* ========================================
       RESPONSIF
    ======================================== */

        @media (max-width: 1100px) {
            .admin-statistics {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .admin-dashboard-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .admin-attendance-list {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .admin-dashboard-heading h1 {
                font-size: 23px;
            }

            .admin-statistics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .admin-stat-card {
                gap: 7px;
                padding: 9px;
            }

            .admin-stat-info strong {
                font-size: 19px;
            }

            .admin-attendance-list {
                grid-template-columns: minmax(0, 1fr);
            }

            .admin-panel {
                padding: 8px;
            }
        }
    </style>

@endsection