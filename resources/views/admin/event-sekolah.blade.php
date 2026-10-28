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
                        <th>Keterangan</th>
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
                                    <a href="{{ route('admin.event.edit', $e->id) }}" class="table-action edit" title="Edit event">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.event.destroy', $e->id) }}" method="POST" onsubmit="return confirm('Hapus event ini?');" style="display:inline; margin:0; padding:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action delete" title="Hapus event">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; padding:40px; color:#888;">Belum ada event sekolah. Silakan tambah baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="event-table-footer">
            <span>Menampilkan {{ count($events ?? []) }} event sekolah</span>
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
            text-decoration: none;
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

        /* Lebar kolom */
        .event-table th:nth-child(1),
        .event-table td:nth-child(1) {
            width: 25%;
            text-align: center;
        }

        .event-table th:nth-child(2),
        .event-table td:nth-child(2) {
            width: 35%;
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

        @media (max-width: 700px) {
            .event-heading-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .event-table-card {
                padding: 8px;
            }

            .event-table {
                min-width: 520px;
            }

            .event-table-footer {
                margin: 22px 4px 0;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush