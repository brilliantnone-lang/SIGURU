@extends('layouts.app')

@section('title', 'Kalender Akademik - SIGURU')

@section('content')
<div class="admin-kalender">

    <div class="kalender-heading">
        <div>
            <h1>Kalender Akademik</h1>
            <p>Mengelola dokumen kalender akademik sekolah</p>
        </div>
        <a href="{{ route('admin.kalender.create') }}" class="btn-tambah-kalender" style="text-decoration:none;">
            <span>＋</span> Tambah Kalender
        </a>
    </div>

    @if(session('success'))
    <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">
        {{ session('success') }}
    </div>
    @endif

    <section class="kalender-table-panel">
        <div class="kalender-table-scroll">
            <table class="kalender-table">
                <thead>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Periode Aktif</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kalenders as $k)
                    <tr>
                        <td><strong>{{ $k->tahun_ajaran }}</strong></td>
                        <td><span style="background:#E1ECE6; padding:3px 8px; border-radius:4px; font-size:10px; font-weight:600;">{{ $k->semester }}</span></td>
                        <td style="font-size:11px;">
                            {{ $k->tanggal_mulai->format('d M Y') }} - {{ $k->tanggal_selesai->format('d M Y') }}
                        </td>
                        <td>
                            <span class="nama-file-kalender">{{ $k->nama_file }}</span>
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; justify-content:center;">
                                <a href="{{ asset('storage/' . $k->path_file) }}" target="_blank" class="btn-lihat-kalender" style="text-decoration:none; background:#39765c;">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.kalender.edit', $k->id) }}" class="btn-lihat-kalender" style="text-decoration:none; background:#f59e0b;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.kalender.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kalender ini?');" style="display:inline; margin:0; padding:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding:5px 10px; background:#ef4444; color:#fff; border:none; border-radius:4px; font-size:10px; font-weight:600; cursor:pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px; color:#888;">Belum ada dokumen kalender akademik.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>

<style>
    .admin-kalender {
        width: 100%;
        min-width: 0;
        color: #263b35;
        font-family: inherit;
    }

    .admin-kalender *,
    .admin-kalender *::before,
    .admin-kalender *::after {
        box-sizing: border-box;
    }

    .kalender-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 17px;
    }

    .kalender-heading h1 {
        margin: 0;
        color: #17211f;
        font-size: 25px;
        font-weight: 700;
        line-height: 1.35;
    }

    .kalender-heading p {
        margin: 3px 0 0;
        color: #52665e;
        font-size: 12px;
    }

    .btn-tambah-kalender {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 36px;
        padding: 0 13px;
        color: #fff;
        background: #39765c;
        border: 1px solid #39765c;
        border-radius: 5px;
        font: inherit;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-tambah-kalender span {
        font-size: 18px;
        line-height: 1;
    }

    .btn-tambah-kalender:hover,
    .btn-lihat-kalender:hover {
        filter: brightness(0.9);
    }

    .kalender-table-panel {
        padding: 12px;
        background: #fff;
        border: 1px solid #e2eae5;
        border-radius: 5px;
    }

    .kalender-table-scroll {
        width: 100%;
        overflow-x: auto;
    }

    .kalender-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        text-align: center;
    }

    .kalender-table thead {
        background: #f0f5f2;
    }

    .kalender-table th {
        padding: 10px;
        color: #52665c;
        font-size: 11px;
        font-weight: 600;
    }

    .kalender-table td {
        padding: 12px;
        color: #394c42;
        border-bottom: 1px solid #edf1ee;
    }

    .kalender-table tbody tr:last-child td {
        border-bottom: none;
    }

    .nama-file-kalender {
        overflow-wrap: anywhere;
    }

    .btn-lihat-kalender {
        padding: 5px 10px;
        color: #fff;
        border: none;
        border-radius: 4px;
        font: inherit;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
    }
</style>
@endsection