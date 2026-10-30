@extends('layouts.app')

@section('title', 'Jurnal Harian Guru')

@section('content')
<div class="jurnal-page">

    <div class="jurnal-page-header">
        <div>
            <h2>Jurnal Harian Guru</h2>
            <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
        </div>
        <a href="{{ route('guru.tambah-jurnal') }}" class="btn-tambah-jurnal">
            <i class="bi bi-plus-lg"></i> Tambah Jurnal
        </a>
    </div>

    @if(session('success'))
    <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">{{ session('error') }}</div>
    @endif

    <section class="jurnal-section history-section">
        <div class="history-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Riwayat Jurnal</h3>
                <p>{{ $jurnals->count() }} catatan jurnal tersimpan</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="jurnal-table history-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kelas/Jam</th>
                        <th>Pokok Bahasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $j)
                    <tr>
                        <td>{{ $j->tanggal->translatedFormat('d M Y') }}</td>
                        <td>
                            <strong>Kelas {{ $j->kelas->nama_kelas ?? '-' }}</strong>
                            <small>Jam ke {{ $j->jam_mulai_ke }}-{{ $j->jam_selesai_ke }} {{ $j->jadwal->mataPelajaran->nama_mata_pelajaran ?? '' }}</small>
                        </td>
                        <td>{{ $j->pokok_bahasan }}</td>
                        <td>
                            @if($j->status_validasi === 'valid')
                            <span class="history-status" style="background:#dcfce7; color:#166534;">Tervalidasi</span>
                            @elseif($j->status_validasi === 'menunggu_revisi')
                            <span class="history-status" style="background:#ffe4e6; color:#be123c;">Perlu Revisi</span>
                            @elseif($j->status_validasi === 'sudah_revisi')
                            <span class="history-status" style="background:#e0f2fe; color:#0369a1;">Sudah Direvisi</span>
                            @else
                            <span class="history-status">Sedang Berjalan</span>
                            @endif
                        </td>
                        <td>
                            <div class="history-actions">
                                <a href="{{ route('guru.lihat-jurnal', $j->id) }}" class="icon-action action-detail" title="Lihat jurnal">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @if($j->status_validasi !== 'valid')
                                <a href="{{ route('guru.edit-jurnal', $j->id) }}" class="icon-action action-edit" title="Edit jurnal">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px; color:#888;">Belum ada jurnal. Silakan tambah jurnal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<style>
    /* Gunakan CSS yang sama dengan desain awal */
    .jurnal-page {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    .jurnal-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 18px;
    }

    .jurnal-page-header h2 {
        margin: 0 0 5px;
        font-size: 26px;
        font-weight: 650;
        color: #111;
    }

    .jurnal-page-header p {
        margin: 0;
        font-size: 12px;
        color: #555;
    }

    .btn-tambah-jurnal {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 5px;
        background: #39765f;
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
    }

    .btn-tambah-jurnal:hover {
        background: #2e624e;
        color: #fff;
    }

    .jurnal-section {
        background: #fff;
        border: 1px solid #b9d0c5;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .12);
    }

    .history-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 17px 7px;
    }

    .history-heading>i {
        font-size: 24px;
        color: #39765f;
    }

    .history-heading h3 {
        margin: 0 0 2px;
        font-size: 18px;
        font-weight: 650;
        color: #222;
    }

    .history-heading p {
        margin: 0;
        font-size: 12px;
        color: #999;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .jurnal-table {
        width: 100%;
        border-collapse: collapse;
    }

    .jurnal-table thead {
        background: #e1eee8;
    }

    .jurnal-table th {
        padding: 5px 12px;
        text-align: left;
        text-transform: uppercase;
        color: #7d8581;
        font-size: 11px;
        font-weight: 650;
        white-space: nowrap;
    }

    .jurnal-table td {
        padding: 6px 12px;
        border-bottom: 1px solid #e3e3e3;
        font-size: 11px;
        vertical-align: middle;
    }

    .history-table td:first-child {
        white-space: nowrap;
        font-weight: 600;
    }

    .history-table td:nth-child(2) strong {
        display: block;
        font-size: 11px;
        font-weight: 650;
    }

    .history-table td:nth-child(2) small {
        display: block;
        margin-top: 3px;
        font-size: 10px;
        color: #999;
        white-space: nowrap;
    }

    .history-status {
        display: inline-block;
        min-width: 57px;
        padding: 5px 9px;
        border-radius: 6px;
        background: #96ebc8;
        color: #267454;
        font-size: 11px;
    }

    .history-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .icon-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        padding: 0;
        border: 1px solid;
        border-radius: 5px;
        background: #fff;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
    }

    .action-detail {
        border-color: #a9bdb3;
        color: #39765f;
    }

    .action-edit {
        border-color: #d6a06f;
        color: #c45a09;
    }

    .icon-action:hover {
        background: #f5f8f6;
    }
</style>
@endsection