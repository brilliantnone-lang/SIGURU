@extends('layouts.app')

@section('title', 'Jurnal Harian Guru - SIGURU')

@section('content')
<div class="admin-jurnal">

    <div class="jurnal-heading">
        <h1>Jurnal Harian Guru</h1>
        <p>Melihat catatan kegiatan mengajar guru</p>
    </div>

    {{-- Filter jurnal (Menggunakan GET agar terbaca di URL) --}}
    <form action="{{ route('admin.jurnal.index') }}" method="GET" class="jurnal-filter">
        <div class="jurnal-filter-field">
            <label for="filterGuru">Guru</label>
            <select id="filterGuru" name="guru_id">
                <option value="">Semua Guru</option>
                @foreach($gurus as $g)
                <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                    {{ $g->user->name ?? '-' }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="jurnal-filter-field">
            <label for="filterStatus">Status Validasi</label>
            <select id="filterStatus" name="status_validasi">
                <option value="">Semua Status</option>
                <option value="belum_valid" {{ request('status_validasi') == 'belum_valid' ? 'selected' : '' }}>Belum Divalidasi</option>
                <option value="valid" {{ request('status_validasi') == 'valid' ? 'selected' : '' }}>Tervalidasi</option>
                <option value="menunggu_revisi" {{ request('status_validasi') == 'menunggu_revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                <option value="sudah_revisi" {{ request('status_validasi') == 'sudah_revisi' ? 'selected' : '' }}>Sudah Direvisi</option>
            </select>
        </div>

        <button type="submit" class="bahan-filter-button">
            <i class="bi bi-search"></i> Tampilkan
        </button>
    </form>

    {{-- Tabel daftar jurnal --}}
    <section class="jurnal-table-panel">

        <div class="jurnal-table-heading">
            <span aria-hidden="true">▤</span>
            <h2>Daftar Jurnal Harian Guru</h2>
        </div>

        <div class="jurnal-table-scroll">
            <table class="jurnal-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nama Guru</th>
                        <th>Kelas & Mapel</th>
                        <th>Jam</th>
                        <th>Pokok Bahasan</th>
                        <th>Status Validasi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($jurnals as $i => $j)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $j->tanggal->translatedFormat('d M Y') }}</td>
                        <td>
                            {{ $j->guru->user->name ?? '-' }}
                            @if($j->guruPendamping)
                            <br><small style="color:#5D756B;">(Pendamping: {{ $j->guruPendamping->user->name }})</small>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $j->kelas->nama_kelas }}</strong><br>
                            <small>{{ $j->jadwal->mataPelajaran->nama_mata_pelajaran ?? 'Mapel' }}</small>
                        </td>
                        <td>Jam ke-{{ $j->jam_mulai_ke }}@if($j->jam_selesai_ke != $j->jam_mulai_ke) - {{ $j->jam_selesai_ke }}@endif</td>
                        <td>{{ $j->pokok_bahasan }}</td>
                        <td>
                            @if($j->status_validasi === 'valid')
                            <span class="jurnal-status status-valid">Tervalidasi</span>
                            @elseif($j->status_validasi === 'menunggu_revisi')
                            <span class="jurnal-status status-revisi">Perlu Revisi</span>
                            @elseif($j->status_validasi === 'sudah_revisi')
                            <span class="jurnal-status status-pending" style="background:#cce5ff; color:#004085;">Sudah Direvisi</span>
                            @else
                            <span class="jurnal-status status-pending">Belum Divalidasi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#888;">Belum ada data jurnal yang sesuai dengan filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="jurnal-table-footer">
            <span>Menampilkan {{ count($jurnals) }} jurnal</span>
        </div>

    </section>

</div>

<style>
    .admin-jurnal {
        width: 100%;
        min-width: 0;
        color: #263b35;
        font-family: inherit;
    }

    .admin-jurnal *,
    .admin-jurnal *::before,
    .admin-jurnal *::after {
        box-sizing: border-box;
    }

    .jurnal-heading {
        margin-bottom: 10px;
    }

    .jurnal-heading h1 {
        margin: 0;
        color: #17211f;
        font-size: 25px;
        font-weight: 700;
        line-height: 1.35;
    }

    .jurnal-heading p {
        margin: 3px 0 0;
        color: #52665e;
        font-size: 12px;
    }

    .jurnal-filter {
        display: grid;
        grid-template-columns: 1.5fr 1.5fr auto;
        align-items: end;
        gap: 12px;
        margin-bottom: 15px;
        padding: 11px;
        background: #fff;
        border: 1px solid #e0e7e4;
        border-radius: 7px;
    }

    .jurnal-filter-field {
        display: flex;
        flex-direction: column;
        min-width: 0;
        gap: 5px;
    }

    .jurnal-filter-field label {
        color: #40534b;
        font-size: 11px;
        font-weight: 600;
    }

    .jurnal-filter-field select {
        width: 100%;
        min-width: 0;
        height: 32px;
        padding: 0 8px;
        color: #46574f;
        background: #fff;
        border: 1px solid #dce4e0;
        border-radius: 5px;
        font: inherit;
        font-size: 11px;
    }

    .bahan-filter-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-width: 95px;
        height: 34px;
        padding: 0 13px;
        color: #fff;
        background: #145b3c;
        border: none;
        border-radius: 5px;
        font: inherit;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    .bahan-filter-button:hover {
        background: #10482f;
    }

    .jurnal-table-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e0e7e4;
        border-radius: 7px;
    }

    .jurnal-table-heading {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 11px 12px 8px;
    }

    .jurnal-table-heading>span {
        color: #29845a;
        font-size: 15px;
    }

    .jurnal-table-heading h2 {
        margin: 0;
        color: #284239;
        font-size: 12px;
        font-weight: 700;
    }

    .jurnal-table-scroll {
        width: 100%;
        overflow-x: auto;
        padding: 0 10px;
    }

    .jurnal-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 10px;
    }

    .jurnal-table thead {
        background: #edf6f0;
    }

    .jurnal-table th {
        padding: 8px 7px;
        color: #52685c;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .jurnal-table td {
        padding: 7px;
        color: #36463e;
        border-bottom: 1px solid #edf0ee;
        white-space: nowrap;
    }

    .jurnal-table tbody tr:last-child td {
        border-bottom: none;
    }

    .jurnal-table tbody tr:hover {
        background: #f8fbf9;
    }

    .jurnal-status {
        display: inline-block;
        padding: 4px 7px;
        border-radius: 4px;
        font-size: 9px;
        line-height: 1.2;
        white-space: nowrap;
    }

    .status-valid {
        color: #247448;
        background: #d8f2e2;
    }

    .status-pending {
        color: #956900;
        background: #fff0c9;
    }

    .status-revisi {
        color: #b83e48;
        background: #ffe0e1;
    }

    .jurnal-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px;
    }

    .jurnal-table-footer>span {
        color: #53665c;
        font-size: 10px;
    }
</style>
@endsection