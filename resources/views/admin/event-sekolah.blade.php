@extends('layouts.app')

@section('title', 'Event Sekolah - Jurnal Mengajar Guru')

@section('content')

<div class="event-heading-row">
    <div>
        <h1>Event Sekolah</h1>
        <p class="subtitle">Masukkan Kegiatan Sekolah yang Diluar Pembelajaran</p>
    </div>
    <a href="{{ route('admin.event.create') }}" class="add-event-button" style="text-decoration: none;">
        <span aria-hidden="true">＋</span> Tambah Event
    </a>
</div>

{{-- Notifikasi --}}
@if(session('success'))
<div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">
    {{ session('error') }}
</div>
@endif

<div class="event-table-card">
    <div class="event-table-wrap">
        <table class="event-table">
            <thead>
                <tr>
                    <th>Waktu Pelaksanaan</th>
                    <th>Keterangan & Guru Terlibat</th>
                    <th>Jam Pelajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events ?? [] as $e)
                <tr>
                    <td>
                        @if($e->is_rutin)
                        <span style="font-weight:700; color:#0A4C2E; background:#dcfce7; padding:4px 8px; border-radius:4px; font-size:10px;">
                            Rutin: {{ ucfirst($e->hari_rutin) }}
                        </span>
                        @else
                        <span style="font-weight:600;">
                            {{ \Carbon\Carbon::parse($e->tanggal_mulai)->translatedFormat('d M Y') }}
                            @if($e->tanggal_selesai && $e->tanggal_selesai != $e->tanggal_mulai)
                            - {{ \Carbon\Carbon::parse($e->tanggal_selesai)->translatedFormat('d M Y') }}
                            @endif
                        </span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $e->nama_event }}</strong>
                        @if($e->deskripsi)
                        <br><small style="color:#5D756B;">{{ $e->deskripsi }}</small>
                        @endif

                        {{-- Badge guru terlibat --}}
                        @if($e->is_all_guru)
                        <div style="margin-top:6px;">
                            <span style="background:#39765f; color:#fff; font-size:10px;
                                                     padding:3px 9px; border-radius:10px; font-weight:600;">
                                👥 Semua Guru
                            </span>
                        </div>
                        @elseif($e->gurus->isNotEmpty())
                        <div style="margin-top:6px; display:flex; flex-wrap:wrap; gap:4px;">
                            @foreach($e->gurus as $g)
                            <span style="background:#E8F6F0; color:#0A4C2E; font-size:10px;
                                                         padding:2px 7px; border-radius:10px;">
                                {{ $g->user->name ?? '-' }} 
                            </span>
                            @endforeach
                        </div>
                        @else
                        <div style="margin-top:6px;">
                            <span style="color:#aaa; font-size:10px;">Belum ada guru terlibat</span>
                        </div>
                        @endif
                    </td>
                    <td>
                        @if($e->is_full_day)
                        <span style="color:#c2410c; font-weight:600;">Full Day (Seharian)</span>
                        @else
                        Jam ke-{{ $e->jam_mulai_ke }} s/d Jam ke-{{ $e->jam_selesai_ke }}
                        @endif
                    </td>
                    <td>
                        <div class="event-actions">
                            <a href="{{ route('admin.event.edit', $e->id) }}" class="table-action edit"
                                title="Edit event">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <form action="{{ route('admin.event.destroy', $e->id) }}" method="POST" class="delete-form"
                                style="display:inline; margin:0; padding:0;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="table-action delete" title="Hapus event"
                                    onclick="showDeleteModal(this)">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:40px; color:#888;">Belum ada event sekolah.
                        Silakan tambah baru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="event-table-footer">
        <span>Menampilkan {{ count($events ?? []) }} event sekolah</span>
    </div>
</div>

{{-- POPUP KONFIRMASI HAPUS --}}
<div class="delete-modal-overlay" id="deleteModal" style="display: none;">
    <div class="delete-modal">
        <div class="delete-modal-header"></div>
        <div class="delete-modal-content">
            <div class="delete-icon">
                <i class="bi bi-trash"></i>
            </div>
            <h3>Hapus Event?</h3>
            <p>Apakah kamu yakin ingin menghapus event sekolah ini?</p>
            <div class="delete-modal-actions">
                <button type="button" class="delete-cancel-button" onclick="closeDeleteModal()">Batal</button>
                <button type="button" class="delete-confirm-button" onclick="confirmDelete()">Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .event-heading-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 18px;
    }

    .event-heading-row h1 {
        margin: 0 0 5px;
        font-size: 26px;
        font-weight: 650;
        color: #111;
    }

    .event-heading-row .subtitle {
        margin: 0;
        font-size: 12px;
        color: #555;
    }

    .add-event-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border: 0;
        border-radius: 5px;
        background: #39765f;
        color: #fff;
        text-decoration: none;
        font-family: inherit;
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
        cursor: pointer;
        transition: background .15s ease;
    }

    .add-event-button:hover {
        background: #285b46;
        color: #fff;
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
        font-size: 11px;
    }

    .event-table thead {
        background: #E8F6F0;
    }

    .event-table th {
        padding: 10px 8px;
        color: #0A4C2E;
        font-size: 10px;
        font-weight: 700;
        text-align: center;
    }

    .event-table td {
        padding: 12px 8px;
        border-bottom: 1px solid #E8EFEB;
        vertical-align: middle;
        overflow-wrap: break-word;
    }

    .event-table tbody tr:nth-child(even) {
        background: #FAFCFB;
    }

    .event-table th:nth-child(1),
    .event-table td:nth-child(1) {
        width: 22%;
        text-align: center;
    }

    .event-table th:nth-child(2),
    .event-table td:nth-child(2) {
        width: 38%;
    }

    .event-table th:nth-child(3),
    .event-table td:nth-child(3) {
        width: 25%;
        text-align: center;
    }

    .event-table th:nth-child(4),
    .event-table td:nth-child(4) {
        width: 15%;
        text-align: center;
    }

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
        width: 31px;
        height: 31px;
        padding: 0;
        border: 1px solid;
        border-radius: 7px;
        background: #fff;
        font-size: 15px;
        line-height: 1;
        cursor: pointer;
        transition: background .15s ease;
    }

    .table-action.edit {
        border-color: #aebfb5;
        color: #39765f;
    }

    .table-action.delete {
        border-color: #ff7777;
        color: #ff3333;
    }

    .table-action:hover {
        background: #f4f8f5;
    }

    .event-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 20px 14px 0;
        color: #40574F;
        font-size: 11px;
    }

    .delete-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(0, 0, 0, 0.25);
    }

    .delete-modal {
        width: 90%;
        max-width: 470px;
        background: #fff;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        animation: modalAppear 0.25s ease;
    }

    .delete-modal-header {
        height: 30px;
        background: #FF0000;
    }

    .delete-modal-content {
        padding: 10px 20px 20px;
        text-align: center;
    }

    .delete-icon {
        font-size: 65px;
        color: #FF0000;
        margin-bottom: 8px;
    }

    .delete-modal-content h3 {
        color: #FF0000;
        font-size: 27px;
        font-weight: bold;
        margin: 0 0 10px;
    }

    .delete-modal-content p {
        color: #666;
        margin-bottom: 20px;
    }

    .delete-modal-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .delete-cancel-button,
    .delete-confirm-button {
        width: 120px;
        height: 48px;
        border: none;
        border-radius: 16px;
        font-size: 17px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.2s;
    }

    .delete-cancel-button {
        background: #eee;
        color: #555;
    }

    .delete-cancel-button:hover {
        background: #ddd;
    }

    .delete-confirm-button {
        background: #FF0000;
        color: #fff;
    }

    .delete-confirm-button:hover {
        background: #cc0000;
    }

    @keyframes modalAppear {
        from {
            transform: scale(0.92);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media (max-width: 700px) {
        .event-heading-row {
            align-items: flex-start;
            flex-direction: row;
            justify-content: space-between;
            gap: 10px;
        }

        .event-heading-row>div {
            min-width: 0;
        }

        .event-heading-row h1 {
            font-size: 22px;
        }

        .add-event-button {
            flex-shrink: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let selectedDeleteForm = null;

    function showDeleteModal(button) {
        selectedDeleteForm = button.closest('form');
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        selectedDeleteForm = null;
    }

    function confirmDelete() {
        if (selectedDeleteForm) selectedDeleteForm.submit();
    }
    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) closeDeleteModal();
    });
</script>
@endpush