@extends('layouts.app')

@section('title', 'Validasi Jurnal')

@section('content')
<style>
    .validasi-page { width: 100%; min-width: 0; color: #26332f; font-family: inherit; }
    .validasi-page *, .validasi-page *::before, .validasi-page *::after { box-sizing: border-box; }
    .validasi-heading { margin-bottom: 25px; }
    .validasi-heading h3 { margin: 0; color: #17211f; font-size: 24px; font-weight: 700; }
    .validasi-heading p { margin: 3px 0 0; color: #52665e; font-size: 12px; }
    
    .validasi-filter { display: grid; grid-template-columns: 1fr 1fr auto; align-items: end; gap: 14px; margin-bottom: 10px; padding: 12px; background: #fff; border: 1px solid #e1e8e4; border-radius: 8px; box-shadow: 0 2px 5px rgba(38, 51, 47, .04); }
    .validasi-filter-group { display: flex; flex-direction: column; gap: 5px; min-width: 0; }
    .validasi-filter-group label { color: #35483e; font-size: 10px; font-weight: 600; }
    .validasi-filter-group select { width: 100%; min-width: 0; height: 31px; padding: 0 8px; color: #48574f; background-color: #fff; border: 1px solid #dce4df; border-radius: 5px; font-size: 10px; outline: none; }
    .validasi-filter-button { display: inline-flex; align-items: center; justify-content: center; gap: 6px; height: 31px; padding: 0 13px; color: #fff; background: #176b48; border: none; border-radius: 5px; font-size: 10px; font-weight: 600; cursor: pointer; white-space: nowrap; }
    
    .validasi-table-panel { min-width: 0; padding: 12px; background: #fff; border: 1px solid #e2eae5; border-radius: 8px; }
    .validasi-table-heading { display: flex; align-items: center; gap: 7px; margin-bottom: 10px; color: #28684c; }
    .validasi-table-heading h4 { margin: 0; color: #294238; font-size: 12px; font-weight: 700; }
    
    .validasi-table-wrapper { width: 100%; overflow-x: auto; }
    .validasi-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 9px; }
    .validasi-table thead { background: #eaf6ef; }
    .validasi-table th { padding: 8px 6px; color: #28684c; font-size: 9px; font-weight: 700; white-space: nowrap; }
    .validasi-table td { padding: 6px; color: #35423d; border-bottom: 1px solid #edf1ee; vertical-align: middle; }
    .validasi-table tbody tr:nth-child(even) { background: #fbfcfb; }
    
    .validasi-status { display: inline-block; padding: 4px 7px; border-radius: 10px; font-size: 8px; line-height: 1.2; text-align: center; white-space: nowrap; }
    .status-belum { color: #a86600; background: #fff0d9; }
    .status-valid { color: #18804b; background: #dff5e8; }
    .status-revisi { color: #7541b4; background: #eee5ff; }
    .status-direvisi { color: #176b99; background: #dff2ff; }
    
    .validasi-action { min-width: 48px; padding: 4px 10px; color: #fff; background: #176b48; border: none; border-radius: 4px; font-size: 9px; cursor: pointer; text-decoration: none; display: inline-block; }
    .validasi-action:hover { background: #12583b; color: #fff; }
    .validasi-action.disabled { background: #ccc; cursor: not-allowed; }
</style>

<div class="validasi-page">
    <div class="validasi-heading">
        <h3>Validasi Jurnal Harian</h3>
        <p>Periksa dan berikan validasi pada jurnal mengajar guru</p>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('kepsek.validasi-jurnal.index') }}" method="GET" class="validasi-filter">
        <div class="validasi-filter-group">
            <label for="filterKelas">Kelas</label>
            <select id="filterKelas" name="kelas_id">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="validasi-filter-group">
            <label for="filterStatus">Status Validasi</label>
            <select id="filterStatus" name="status_validasi">
                <option value="">Semua Status</option>
                <option value="belum_valid" {{ request('status_validasi') == 'belum_valid' ? 'selected' : '' }}>Sedang Berjalan (Belum Divalidasi)</option>
                <option value="valid" {{ request('status_validasi') == 'valid' ? 'selected' : '' }}>Tervalidasi</option>
                <option value="menunggu_revisi" {{ request('status_validasi') == 'menunggu_revisi' ? 'selected' : '' }}>Perlu Perbaikan</option>
                <option value="sudah_revisi" {{ request('status_validasi') == 'sudah_revisi' ? 'selected' : '' }}>Sudah Direvisi</option>
            </select>
        </div>

        <button type="submit" class="validasi-filter-button">
            <i class="bi bi-search"></i> Tampilkan
        </button>
    </form>

    <section class="validasi-table-panel">
        <div class="validasi-table-heading">
            <i class="bi bi-card-list"></i>
            <h4>Daftar Jurnal Harian Guru</h4>
        </div>

        <div class="validasi-table-wrapper">
            <table class="validasi-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Semester</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Status Validasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $index => $jurnal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $jurnal->tanggal->translatedFormat('d M Y') }}</td>
                            <td>{{ $jurnal->guru->user->name ?? '-' }}</td>
                            <td>{{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
                            <td>{{ $jurnal->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                @if($jurnal->status_validasi === 'valid')
                                    <span class="validasi-status status-valid">Tervalidasi</span>
                                @elseif($jurnal->status_validasi === 'menunggu_revisi')
                                    <span class="validasi-status status-revisi">Perlu Perbaikan</span>
                                @elseif($jurnal->status_validasi === 'sudah_revisi')
                                    <span class="validasi-status status-direvisi">Sudah Direvisi</span>
                                @else
                                    <span class="validasi-status status-belum">Sedang Berjalan</span>
                                @endif
                            </td>
                            <td>
                                {{-- Jika status masih belum_valid, tombol disabled (sesuai permintaan) --}}
                                @if($jurnal->status_validasi === 'belum_valid')
                                    <button class="validasi-action disabled" disabled title="Jurnal belum dikunci oleh guru">Lihat</button>
                                @else
                                    <a href="{{ route('kepsek.validasi-jurnal.show', $jurnal->id) }}" class="validasi-action">Lihat</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:40px; color:#888;">Belum ada data jurnal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection