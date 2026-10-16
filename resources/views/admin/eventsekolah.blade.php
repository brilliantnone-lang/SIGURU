@extends('layouts.app')

@section('title', 'Event Sekolah - Jurnal Mengajar Guru')

@section('content')

    <div class="event-heading-row">
        <div>
            <h1>Event Sekolah</h1>
            <p class="subtitle">Masukkan Kegiatan Sekolah yang Diluar Pembelajaran</p>
        </div>
        <button class="add-event-button" type="button">
            <span aria-hidden="true">＋</span> Tambah Event
        </button>
    </div>

    <div class="event-table-card">
        <div class="event-table-wrap">
            <table class="event-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jam Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events ?? [] as $e)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($e->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                            <td>{{ $e->nama_event }}</td>
                            <td>
                                @if($e->is_full_day)
                                    Semua Jam
                                @else
                                    Jam ke-{{ $e->jam_mulai_ke }} – Jam ke-{{ $e->jam_selesai_ke }}
                                @endif
                            </td>
                            <td>
                                <div class="event-actions">
                                    <button class="table-action edit" type="button" aria-label="Edit event">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus event">▤</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Data dummy --}}
                        <tr><td>17 Agustus 2026</td><td>Upacara Hari Kemerdekaan</td><td>Semua Jam</td><td><div class="event-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>25 Agustus 2026</td><td>Kegiatan Bimtek Guru</td><td>Jam ke-1 – Jam ke-4</td><td><div class="event-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>1 September 2026</td><td>Rapat Koordinasi Sekolah</td><td>Jam ke-1 – Jam ke-2</td><td><div class="event-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>10 September 2026</td><td>Kegiatan Sekolah</td><td>Semua Jam</td><td><div class="event-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>20 September 2026</td><td>Kegiatan Peringatan Sekolah</td><td>Semua Jam</td><td><div class="event-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="event-table-footer">
            <span>Menampilkan 1-5 dari 48 event sekolah</span>
            <div class="pagination" aria-label="Pagination">
                <button class="page-button" type="button">‹</button>
                <button class="page-button active" type="button">1</button>
                <button class="page-button" type="button">2</button>
                <button class="page-button" type="button">3</button>
                <button class="page-button" type="button">4</button>
                <button class="page-button" type="button">5</button>
                <span>…</span>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* ====== CSS khusus halaman Event Sekolah ====== */
    .event-heading-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .event-heading-row h1 {
        margin: 0 0 4px;
        font-size: 26px;
    }

    .event-heading-row .subtitle {
        margin: 0;
        font-size: 14px;
    }

    .add-event-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 36px;
        padding: 0 14px;
        border: 0;
        border-radius: 6px;
        background: #0A4C2E;
        color: #FFFFFF;
        font: inherit;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
    }

    .event-table-card {
        width: 100%;
        padding: 7px 4px 16px;
        border: 1px solid #E1ECE6;
        border-radius: 8px;
        background: #FFFFFF;
    }

    .event-table-wrap {
        width: 100%;
        overflow-x: auto;
        padding: 0;
    }

    .event-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        color: #173D2B;
        font-size: 10px;
    }

    .event-table thead { background: #E8F6F0; }

    .event-table th {
        padding: 10px 8px;
        color: #0A4C2E;
        font-size: 9px;
        font-weight: 700;
        text-align: center;
    }

    .event-table td {
        padding: 11px 8px;
        border-bottom: 1px solid #E8EFEB;
        vertical-align: middle;
        overflow-wrap: break-word;
    }

    .event-table tbody tr:nth-child(even) { background: #FAFCFB; }

    /* Lebar kolom */
    .event-table th:nth-child(1), .event-table td:nth-child(1) { width: 20%; text-align: center; }
    .event-table th:nth-child(2), .event-table td:nth-child(2) { width: 34%; }
    .event-table th:nth-child(3), .event-table td:nth-child(3) { width: 20%; }
    .event-table th:nth-child(4), .event-table td:nth-child(4) { width: 16%; text-align: center; }

    .event-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .table-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: 0;
        background: transparent;
        font-size: 13px;
        line-height: 1;
        cursor: pointer;
    }

    .table-action.edit { color: #16834F; }
    .table-action.delete { color: #D83A43; }

    .event-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 66px 14px 0;
        color: #40574F;
        font-size: 11px;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .page-button {
        min-width: 24px;
        height: 24px;
        padding: 0 7px;
        border: 1px solid #D8E2DC;
        border-radius: 5px;
        background: #FFFFFF;
        color: #173D2B;
        font: inherit;
        font-size: 10px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
        cursor: pointer;
    }

    .page-button.active {
        background: #B9F4B2;
        border-color: #70C86B;
        color: #173D2B;
    }

    @media (max-width: 700px) {
        .event-heading-row { align-items: flex-start; flex-direction: column; }
        .event-table-card { padding: 8px; }
        .event-table { min-width: 520px; }
        .event-table-footer { margin: 22px 4px 0; flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush