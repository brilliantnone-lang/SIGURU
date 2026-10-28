@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah')

@section('content')
<style>
    .kepsek-dashboard { width: 100%; min-width: 0; color: #26332f; font-family: inherit; }
    .kepsek-dashboard *, .kepsek-dashboard *::before, .kepsek-dashboard *::after { box-sizing: border-box; }
    
    .kepsek-heading { margin-bottom: 16px; }
    .kepsek-heading h3 { margin: 0; color: #17211f; font-size: 25px; font-weight: 700; }
    .kepsek-heading p { margin: 3px 0 0; color: #52665e; font-size: 12px; }
    
    .kepsek-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; margin-bottom: 15px; }
    .kepsek-stat-card { display: flex; align-items: center; gap: 10px; min-width: 0; min-height: 76px; padding: 11px; background: #fff; border: 1px solid #edf0ef; border-radius: 9px; box-shadow: 0 2px 6px rgba(38, 51, 47, 0.05); }
    .kepsek-stat-icon { display: flex; flex: 0 0 32px; width: 32px; height: 32px; align-items: center; justify-content: center; border-radius: 9px; font-size: 16px; }
    .kepsek-stat-icon i { line-height: 1; }
    .stat-green { color: #25834b; background: #e5f6eb; }
    .stat-blue { color: #2784df; background: #e5f1ff; }
    .stat-orange { color: #f28b26; background: #fff0df; }
    .stat-red { color: #e74b53; background: #ffe8e9; }
    
    .kepsek-stat-info { display: flex; flex-direction: column; min-width: 0; }
    .kepsek-stat-label { color: #68756f; font-size: 9px; line-height: 1.4; }
    .kepsek-stat-info strong { margin-top: 1px; color: #17211f; font-size: 21px; font-weight: 700; line-height: 1.25; }
    .kepsek-stat-info small { margin-top: 2px; color: #8a9590; font-size: 8px; }
    
    .kepsek-main-grid { display: grid; grid-template-columns: minmax(0, 1.65fr) minmax(280px, 1fr); gap: 10px; align-items: stretch; }
    .kepsek-panel { min-width: 0; padding: 12px; background: #fff; border: 1px solid #e6ece9; border-radius: 8px; }
    .kepsek-panel-heading { display: flex; align-items: center; gap: 7px; margin-bottom: 14px; }
    .kepsek-panel-heading > i { color: #299b6b; font-size: 13px; }
    .kepsek-panel-heading h4 { margin: 0; color: #263b35; font-size: 12px; font-weight: 700; }
    
    /* Grafik */
    .kepsek-chart-panel { min-height: 320px; }
    .kepsek-chart { display: grid; grid-template-columns: 25px minmax(0, 1fr); gap: 5px; height: 225px; }
    .kepsek-y-axis { display: flex; flex-direction: column; justify-content: space-between; align-items: flex-end; padding: 0 0 25px; color: #84918a; font-size: 8px; }
    .kepsek-chart-area { position: relative; min-width: 0; height: 100%; padding-bottom: 25px; }
    .kepsek-grid-lines { position: absolute; inset: 0 0 25px; display: flex; flex-direction: column; justify-content: space-between; pointer-events: none; }
    .kepsek-grid-lines span { display: block; width: 100%; border-top: 1px solid #edf1ef; }
    .kepsek-bar-groups { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 8px; height: 100%; }
    .kepsek-week { display: flex; flex-direction: column; justify-content: flex-end; align-items: center; min-width: 0; height: 100%; }
    .kepsek-bars { display: flex; align-items: flex-end; justify-content: center; gap: 3px; width: 100%; height: calc(100% - 25px); border-bottom: 1px solid #dfe7e3; }
    .kepsek-bar { position: relative; width: min(15%, 13px); min-width: 5px; border-radius: 2px 2px 0 0; }
    .kepsek-bar span { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); font-size: 7px; font-weight: 600; white-space: nowrap; }
    
    .bar-hadir { background: #159653; }
    .bar-hadir span { color: #159653; }
    .bar-sakit { background: #2387df; }
    .bar-sakit span { color: #2387df; }
    .bar-izin { background: #f0a11c; }
    .bar-izin span { color: #bd7b0b; }
    .bar-alpa { background: #e33c43; }
    .bar-alpa span { color: #e33c43; }
    
    .kepsek-week-label { padding-top: 7px; color: #738078; font-size: 8px; text-align: center; white-space: nowrap; }
    .kepsek-chart-legend { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; margin-top: 8px; }
    .kepsek-legend-item { display: inline-flex; align-items: center; gap: 5px; color: #6d7973; font-size: 9px; }
    .kepsek-legend-dot { width: 7px; height: 7px; border-radius: 1px; }
    
    /* Jurnal */
    .kepsek-journal-panel { min-height: 320px; }
    .kepsek-journal-list { display: flex; flex-direction: column; }
    .kepsek-journal-item { display: grid; grid-template-columns: 35px minmax(0, 1fr) auto; align-items: start; gap: 8px; padding: 8px 0; border-bottom: 1px solid #edf0ef; }
    .kepsek-journal-item:last-child { border-bottom: none; }
    .kepsek-journal-date { color: #69776f; font-size: 8px; line-height: 1.5; text-align: center; }
    .kepsek-journal-date strong { display: block; color: #34433c; font-size: 11px; }
    .kepsek-journal-detail { min-width: 0; }
    .kepsek-journal-detail strong { display: block; overflow-wrap: anywhere; color: #34443c; font-size: 10px; font-weight: 700; line-height: 1.4; }
    .kepsek-journal-detail span { display: block; margin-top: 1px; color: #7a8780; font-size: 9px; line-height: 1.35; }
    
    .kepsek-status { display: inline-block; max-width: 100px; padding: 3px 5px; border-radius: 10px; font-size: 8px; line-height: 1.3; text-align: center; white-space: nowrap; }
    .status-belum { color: #b96a00; background: #fff0d9; }
    .status-valid { color: #18804b; background: #dff5e8; }
    .status-revisi { color: #7541b4; background: #eee5ff; }
    
    @media (max-width: 1050px) {
        .kepsek-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .kepsek-main-grid { grid-template-columns: minmax(0, 1fr); }
    }
    @media (max-width: 600px) {
        .kepsek-heading h3 { font-size: 22px; }
        .kepsek-stat-card { gap: 7px; padding: 9px; }
        .kepsek-stat-icon { flex-basis: 28px; width: 28px; height: 28px; }
        .kepsek-stat-info strong { font-size: 19px; }
        .kepsek-panel { padding: 9px; }
        .kepsek-journal-item { grid-template-columns: 35px minmax(0, 1fr); }
        .kepsek-status { grid-column: 2; justify-self: start; margin-top: 3px; }
    }
</style>

<div class="kepsek-dashboard">

    <div class="kepsek-heading">
        <h3>Dashboard</h3>
        <p>Ringkasan kegiatan pembelajaran</p>
    </div>

    {{-- Statistik --}}
    <div class="kepsek-stats">
        <div class="kepsek-stat-card">
            <div class="kepsek-stat-icon stat-green"><i class="bi bi-journal-check"></i></div>
            <div class="kepsek-stat-info">
                <span class="kepsek-stat-label">Total Jurnal</span>
                <strong>{{ $totalJurnal }}</strong>
                <small>jurnal</small>
            </div>
        </div>
        <div class="kepsek-stat-card">
            <div class="kepsek-stat-icon stat-blue"><i class="bi bi-collection"></i></div>
            <div class="kepsek-stat-info">
                <span class="kepsek-stat-label">Total Bahan Ajar</span>
                <strong>{{ $totalBahanAjar }}</strong>
                <small>dokumen</small>
            </div>
        </div>
        <div class="kepsek-stat-card">
            <div class="kepsek-stat-icon stat-orange"><i class="bi bi-calendar-check"></i></div>
            <div class="kepsek-stat-info">
                <span class="kepsek-stat-label">Jurnal Hari Ini</span>
                <strong>{{ $jurnalHariIni }}</strong>
                <small>jurnal</small>
            </div>
        </div>
        <div class="kepsek-stat-card">
            <div class="kepsek-stat-icon stat-red"><i class="bi bi-exclamation-circle"></i></div>
            <div class="kepsek-stat-info">
                <span class="kepsek-stat-label">Belum Divalidasi</span>
                <strong>{{ $belumDivalidasi }}</strong>
                <small>jurnal</small>
            </div>
        </div>
    </div>

    {{-- Grafik dan jurnal --}}
    <div class="kepsek-main-grid">
        <section class="kepsek-panel kepsek-chart-panel">
            <div class="kepsek-panel-heading">
                <i class="bi bi-grid-3x3"></i>
                <h4>Rekapitulasi Absensi Siswa (4 Minggu Terakhir)</h4>
            </div>

            <div class="kepsek-chart">
                <div class="kepsek-y-axis">
                    <span>{{ $maxVal }}</span>
                    <span>{{ round($maxVal * 0.75) }}</span>
                    <span>{{ round($maxVal * 0.5) }}</span>
                    <span>{{ round($maxVal * 0.25) }}</span>
                    <span>0</span>
                </div>

                <div class="kepsek-chart-area">
                    <div class="kepsek-grid-lines"><span></span><span></span><span></span><span></span><span></span></div>
                    <div class="kepsek-bar-groups">
                        @foreach($chartData as $data)
                            <div class="kepsek-week">
                                <div class="kepsek-bars">
                                    {{-- Hitung tinggi bar, jika 0 beri tinggi minimal 2% --}}
                                    <div class="kepsek-bar bar-hadir" style="height: {{ $data['hadir'] > 0 ? ($data['hadir'] / $maxVal) * 100 : 2 }}%;">
                                        @if($data['hadir'] > 0) <span>{{ $data['hadir'] }}</span> @endif
                                    </div>
                                    <div class="kepsek-bar bar-sakit" style="height: {{ $data['sakit'] > 0 ? ($data['sakit'] / $maxVal) * 100 : 2 }}%;">
                                        @if($data['sakit'] > 0) <span>{{ $data['sakit'] }}</span> @endif
                                    </div>
                                    <div class="kepsek-bar bar-izin" style="height: {{ $data['izin'] > 0 ? ($data['izin'] / $maxVal) * 100 : 2 }}%;">
                                        @if($data['izin'] > 0) <span>{{ $data['izin'] }}</span> @endif
                                    </div>
                                    <div class="kepsek-bar bar-alpa" style="height: {{ $data['alpa'] > 0 ? ($data['alpa'] / $maxVal) * 100 : 2 }}%;">
                                        @if($data['alpa'] > 0) <span>{{ $data['alpa'] }}</span> @endif
                                    </div>
                                </div>
                                <span class="kepsek-week-label">{{ $data['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="kepsek-chart-legend">
                <span class="kepsek-legend-item"><span class="kepsek-legend-dot bar-hadir"></span> Hadir</span>
                <span class="kepsek-legend-item"><span class="kepsek-legend-dot bar-sakit"></span> Sakit</span>
                <span class="kepsek-legend-item"><span class="kepsek-legend-dot bar-izin"></span> Izin</span>
                <span class="kepsek-legend-item"><span class="kepsek-legend-dot bar-alpa"></span> Alpa</span>
            </div>
        </section>

        <section class="kepsek-panel kepsek-journal-panel">
            <div class="kepsek-panel-heading">
                <i class="bi bi-card-list"></i>
                <h4>10 Jurnal Teratas</h4>
            </div>
            <div class="kepsek-journal-list">
                @forelse($jurnals as $j)
                    <div class="kepsek-journal-item">
                        <div class="kepsek-journal-date">
                            <strong>{{ $j->tanggal->format('d M') }}</strong>
                        </div>
                        <div class="kepsek-journal-detail">
                            <strong>{{ $j->guru->user->name ?? '-' }}</strong>
                            <span>{{ $j->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }} · Kelas {{ $j->kelas->nama_kelas ?? '-' }}</span>
                        </div>
                        @if($j->status_validasi === 'valid')
                            <span class="kepsek-status status-valid">Tervalidasi</span>
                        @elseif($j->status_validasi === 'menunggu_revisi')
                            <span class="kepsek-status status-revisi">Perlu Revisi</span>
                        @else
                            <span class="kepsek-status status-belum">Belum Divalidasi</span>
                        @endif
                    </div>
                @empty
                    <p style="text-align:center; font-size:11px; color:#888; padding:20px 0;">Belum ada jurnal.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection