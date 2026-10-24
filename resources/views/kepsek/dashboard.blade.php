
@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah')

@section('sidebar')
    <a href="{{ route('kepsek.dashboard') }}" class="active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<style>
    .kepsek-dashboard {
        width: 100%;
        min-width: 0;
        color: #26332f;
        font-family: inherit;
    }

    .kepsek-dashboard *,
    .kepsek-dashboard *::before,
    .kepsek-dashboard *::after {
        box-sizing: border-box;
    }

    /* Heading */
    .kepsek-heading {
        margin-bottom: 16px;
    }

    .kepsek-heading h3 {
        margin: 0;
        color: #17211f;
        font-size: 25px;
        font-weight: 700;
    }

    .kepsek-heading p {
        margin: 3px 0 0;
        color: #52665e;
        font-size: 12px;
    }

    /* Statistik */
    .kepsek-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 15px;
    }

    .kepsek-stat-card {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
        min-height: 76px;
        padding: 11px;
        background: #fff;
        border: 1px solid #edf0ef;
        border-radius: 9px;
        box-shadow: 0 2px 6px rgba(38, 51, 47, 0.05);
    }

    .kepsek-stat-icon {
        display: flex;
        flex: 0 0 32px;
        width: 32px;
        height: 32px;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        font-size: 16px;
    }

    .kepsek-stat-icon i {
        line-height: 1;
    }

    .stat-green {
        color: #25834b;
        background: #e5f6eb;
    }

    .stat-blue {
        color: #2784df;
        background: #e5f1ff;
    }

    .stat-orange {
        color: #f28b26;
        background: #fff0df;
    }

    .stat-red {
        color: #e74b53;
        background: #ffe8e9;
    }

    .kepsek-stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .kepsek-stat-label {
        color: #68756f;
        font-size: 9px;
        line-height: 1.4;
    }

    .kepsek-stat-info strong {
        margin-top: 1px;
        color: #17211f;
        font-size: 21px;
        font-weight: 700;
        line-height: 1.25;
    }

    .kepsek-stat-info small {
        margin-top: 2px;
        color: #8a9590;
        font-size: 8px;
    }

    /* Layout dua kolom */
    .kepsek-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(280px, 1fr);
        gap: 10px;
        align-items: stretch;
    }

    .kepsek-panel {
        min-width: 0;
        padding: 12px;
        background: #fff;
        border: 1px solid #e6ece9;
        border-radius: 8px;
    }

    .kepsek-panel-heading {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 14px;
    }

    .kepsek-panel-heading > i {
        color: #299b6b;
        font-size: 13px;
    }

    .kepsek-panel-heading h4 {
        margin: 0;
        color: #263b35;
        font-size: 12px;
        font-weight: 700;
    }

    /* Grafik absensi */
    .kepsek-chart-panel {
        min-height: 320px;
    }

    .kepsek-chart {
        display: grid;
        grid-template-columns: 25px minmax(0, 1fr);
        gap: 5px;
        height: 225px;
    }

    .kepsek-y-axis {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-end;
        padding: 0 0 25px;
        color: #84918a;
        font-size: 8px;
    }

    .kepsek-chart-area {
        position: relative;
        min-width: 0;
        height: 100%;
        padding-bottom: 25px;
    }

    .kepsek-grid-lines {
        position: absolute;
        inset: 0 0 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
    }

    .kepsek-grid-lines span {
        display: block;
        width: 100%;
        border-top: 1px solid #edf1ef;
    }

    .kepsek-bar-groups {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
        height: 100%;
    }

    .kepsek-week {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        min-width: 0;
        height: 100%;
    }

    .kepsek-bars {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        gap: 3px;
        width: 100%;
        height: calc(100% - 25px);
        border-bottom: 1px solid #dfe7e3;
    }

    .kepsek-bar {
        position: relative;
        width: min(15%, 13px);
        min-width: 5px;
        border-radius: 2px 2px 0 0;
    }

    .kepsek-bar span {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 7px;
        font-weight: 600;
        white-space: nowrap;
    }

    .bar-hadir {
        background: #159653;
    }

    .bar-hadir span {
        color: #159653;
    }

    .bar-sakit {
        background: #2387df;
    }

    .bar-sakit span {
        color: #2387df;
    }

    .bar-izin {
        background: #f0a11c;
    }

    .bar-izin span {
        color: #bd7b0b;
    }

    .bar-alpa {
        background: #e33c43;
    }

    .bar-alpa span {
        color: #e33c43;
    }

    .kepsek-week-label {
        padding-top: 7px;
        color: #738078;
        font-size: 8px;
        text-align: center;
        white-space: nowrap;
    }

    .kepsek-chart-legend {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        margin-top: 8px;
    }

    .kepsek-legend-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #6d7973;
        font-size: 9px;
    }

    .kepsek-legend-dot {
        width: 7px;
        height: 7px;
        border-radius: 1px;
    }

    /* Jurnal teratas */
    .kepsek-journal-panel {
        min-height: 320px;
    }

    .kepsek-journal-list {
        display: flex;
        flex-direction: column;
    }

    .kepsek-journal-item {
        display: grid;
        grid-template-columns: 30px minmax(0, 1fr) auto;
        align-items: start;
        gap: 6px;
        padding: 7px 0;
        border-bottom: 1px solid #edf0ef;
    }

    .kepsek-journal-item:last-child {
        border-bottom: none;
    }

    .kepsek-journal-date {
        color: #69776f;
        font-size: 8px;
        line-height: 1.5;
        text-align: center;
    }

    .kepsek-journal-date strong {
        display: block;
        color: #34433c;
        font-size: 10px;
    }

    .kepsek-journal-detail {
        min-width: 0;
    }

    .kepsek-journal-detail strong {
        display: block;
        overflow-wrap: anywhere;
        color: #34443c;
        font-size: 9px;
        font-weight: 700;
        line-height: 1.4;
    }

    .kepsek-journal-detail span {
        display: block;
        margin-top: 1px;
        color: #7a8780;
        font-size: 8px;
        line-height: 1.35;
    }

    .kepsek-status {
        display: inline-block;
        max-width: 100px;
        padding: 3px 5px;
        border-radius: 10px;
        font-size: 7px;
        line-height: 1.3;
        text-align: center;
        white-space: nowrap;
    }

    .status-belum {
        color: #b96a00;
        background: #fff0d9;
    }

    .status-valid {
        color: #18804b;
        background: #dff5e8;
    }

    .status-revisi {
        color: #7541b4;
        background: #eee5ff;
    }

    .status-tolak {
        color: #b92d35;
        background: #ffe5e6;
    }

    /* Responsif */
    @media (max-width: 1050px) {
        .kepsek-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .kepsek-main-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 600px) {
        .kepsek-heading h3 {
            font-size: 22px;
        }

        .kepsek-stat-card {
            gap: 7px;
            padding: 9px;
        }

        .kepsek-stat-icon {
            flex-basis: 28px;
            width: 28px;
            height: 28px;
        }

        .kepsek-stat-info strong {
            font-size: 19px;
        }

        .kepsek-panel {
            padding: 9px;
        }

        .kepsek-journal-item {
            grid-template-columns: 28px minmax(0, 1fr);
        }

        .kepsek-status {
            grid-column: 2;
            justify-self: start;
            margin-top: 1px;
        }

        .kepsek-chart-legend {
            gap: 10px;
        }
    }
</style>

<div class="kepsek-dashboard">

    {{-- Heading --}}
    <div class="kepsek-heading">
        <h3>Dashboard</h3>
        <p>Ringkasan kegiatan pembelajaran</p>
    </div>

    {{-- Statistik --}}
    <div class="kepsek-stats">

        <div class="kepsek-stat-card">
            <div class="kepsek-stat-icon stat-green">
                <i class="bi bi-journal-check"></i>
            </div>
            <div class="kepsek-stat-info">
                <span class="kepsek-stat-label">Total Jurnal</span>
                <strong>156</strong>
                <small>jurnal</small>
            </div>
        </div>

        <div class="kepsek-stat-card">
            <div class="kepsek-stat-icon stat-blue">
                <i class="bi bi-collection"></i>
            </div>
            <div class="kepsek-stat-info">
                <span class="kepsek-stat-label">Total Bahan Ajar</span>
                <strong>48</strong>
                <small>dokumen</small>
            </div>
        </div>

        <div class="kepsek-stat-card">
            <div class="kepsek-stat-icon stat-orange">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="kepsek-stat-info">
                <span class="kepsek-stat-label">Jurnal Hari Ini</span>
                <strong>8</strong>
                <small>jurnal</small>
            </div>
        </div>

        <div class="kepsek-stat-card">
            <div class="kepsek-stat-icon stat-red">
                <i class="bi bi-exclamation-circle"></i>
            </div>
            <div class="kepsek-stat-info">
                <span class="kepsek-stat-label">Belum Divalidasi</span>
                <strong>24</strong>
                <small>jurnal</small>
            </div>
        </div>

    </div>

    {{-- Grafik dan jurnal --}}
    <div class="kepsek-main-grid">

        {{-- Rekapitulasi Absensi --}}
        <section class="kepsek-panel kepsek-chart-panel">

            <div class="kepsek-panel-heading">
                <i class="bi bi-grid-3x3"></i>
                <h4>Rekapitulasi Absensi Siswa</h4>
            </div>

            <div class="kepsek-chart">

                <div class="kepsek-y-axis">
                    <span>100</span>
                    <span>75</span>
                    <span>50</span>
                    <span>25</span>
                    <span>0</span>
                </div>

                <div class="kepsek-chart-area">

                    <div class="kepsek-grid-lines">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="kepsek-bar-groups">

                        {{-- Minggu 1 --}}
                        <div class="kepsek-week">
                            <div class="kepsek-bars">
                                <div class="kepsek-bar bar-hadir" style="height: 65%;">
                                    <span>65</span>
                                </div>
                                <div class="kepsek-bar bar-sakit" style="height: 12%;"></div>
                                <div class="kepsek-bar bar-izin" style="height: 8%;"></div>
                                <div class="kepsek-bar bar-alpa" style="height: 25%;">
                                    <span>25</span>
                                </div>
                            </div>
                            <span class="kepsek-week-label">Minggu 1</span>
                        </div>

                        {{-- Minggu 2 --}}
                        <div class="kepsek-week">
                            <div class="kepsek-bars">
                                <div class="kepsek-bar bar-hadir" style="height: 82%;">
                                    <span>82</span>
                                </div>
                                <div class="kepsek-bar bar-sakit" style="height: 10%;"></div>
                                <div class="kepsek-bar bar-izin" style="height: 15%;"></div>
                                <div class="kepsek-bar bar-alpa" style="height: 28%;">
                                    <span>28</span>
                                </div>
                            </div>
                            <span class="kepsek-week-label">Minggu 2</span>
                        </div>

                        {{-- Minggu 3 --}}
                        <div class="kepsek-week">
                            <div class="kepsek-bars">
                                <div class="kepsek-bar bar-hadir" style="height: 72%;">
                                    <span>72</span>
                                </div>
                                <div class="kepsek-bar bar-sakit" style="height: 9%;"></div>
                                <div class="kepsek-bar bar-izin" style="height: 14%;"></div>
                                <div class="kepsek-bar bar-alpa" style="height: 20%;"></div>
                            </div>
                            <span class="kepsek-week-label">Minggu 3</span>
                        </div>

                        {{-- Minggu 4 --}}
                        <div class="kepsek-week">
                            <div class="kepsek-bars">
                                <div class="kepsek-bar bar-hadir" style="height: 45%;">
                                    <span>45</span>
                                </div>
                                <div class="kepsek-bar bar-sakit" style="height: 12%;"></div>
                                <div class="kepsek-bar bar-izin" style="height: 18%;"></div>
                                <div class="kepsek-bar bar-alpa" style="height: 22%;"></div>
                            </div>
                            <span class="kepsek-week-label">Minggu 4</span>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Legenda --}}
            <div class="kepsek-chart-legend">
                <span class="kepsek-legend-item">
                    <span class="kepsek-legend-dot bar-hadir"></span>
                    Hadir
                </span>
                <span class="kepsek-legend-item">
                    <span class="kepsek-legend-dot bar-sakit"></span>
                    Sakit
                </span>
                <span class="kepsek-legend-item">
                    <span class="kepsek-legend-dot bar-izin"></span>
                    Izin
                </span>
                <span class="kepsek-legend-item">
                    <span class="kepsek-legend-dot bar-alpa"></span>
                    Alpa
                </span>
            </div>

        </section>

        {{-- 10 Jurnal Teratas --}}
        <section class="kepsek-panel kepsek-journal-panel">

            <div class="kepsek-panel-heading">
                <i class="bi bi-card-list"></i>
                <h4>10 Jurnal Teratas</h4>
            </div>

            <div class="kepsek-journal-list">

                @php
                    $jurnals = [
                        ['26 Sep', 'Siti Rahma, S.Pd.', 'Matematika · Kelas VII-A', 'Belum Divalidasi', 'status-belum'],
                        ['26 Sep', 'Budi Santoso, S.Pd.', 'IPA · Kelas VIII-B', 'Tervalidasi', 'status-valid'],
                        ['29 Sep', 'Aisyah Putri, S.Pd.', 'Bahasa Indonesia · Kelas IX-A', 'Perlu Perbaikan', 'status-revisi'],
                        ['28 Sep', 'Rizki Maulana, S.Pd.', 'IPS · Kelas VII-B', 'Perlu Perbaikan', 'status-revisi'],
                        ['26 Sep', 'Dewi Lestari, S.Pd.', 'Bahasa Inggris · Kelas VIII-A', 'Sudah Direvisi', 'status-valid'],
                        ['27 Sep', 'Hendra Saputra, S.Pd.', 'PJOK · Kelas IX-B', 'Tervalidasi', 'status-valid'],
                        ['28 Sep', 'Nadia Permata, S.Pd.', 'Seni Budaya · Kelas VII-C', 'Belum Divalidasi', 'status-belum'],
                        ['29 Sep', 'Maya Kartika, S.Pd.', 'PPKn · Kelas VIII-C', 'Tervalidasi', 'status-valid'],
                        ['30 Sep', 'Rizal Agustina, S.Pd.', 'Bahasa Indonesia · Kelas IX-C', 'Perlu Perbaikan', 'status-revisi'],
                        ['30 Sep', 'Muhammad Arif, S.Pd.', 'Matematika · Kelas VII-D', 'Tervalidasi', 'status-valid'],
                    ];
                @endphp

                @foreach ($jurnals as $jurnal)
                    <div class="kepsek-journal-item">

                        <div class="kepsek-journal-date">
                            {{ $jurnal[0] }}
                        </div>

                        <div class="kepsek-journal-detail">
                            <strong>{{ $jurnal[1] }}</strong>
                            <span>{{ $jurnal[2] }}</span>
                        </div>

                        <span class="kepsek-status {{ $jurnal[4] }}">
                            {{ $jurnal[3] }}
                        </span>

                    </div>
                @endforeach

            </div>

        </section>

    </div>
</div>
@endsection
