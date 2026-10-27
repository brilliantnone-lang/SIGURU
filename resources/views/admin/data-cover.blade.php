@extends('layouts.app')

@section('title', 'Data Cover - Jurnal Mengajar Guru')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:flex-start; gap:15px; margin-bottom:18px;">
    <div>
        <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Data Cover Jurnal</h1>
        <p style="margin:0; font-size:12px; color:#555;">Kelola cover jurnal per tahun ajaran dan semester</p>
    </div>
    <a href="{{ route('admin.data-cover.create') }}" style="display:inline-flex; align-items:center; gap:7px; padding:8px 12px; border-radius:5px; background:#39765f; color:#fff; text-decoration:none; font-size:12px; font-weight:500;">
        <i class="bi bi-plus-lg"></i> Tambah Cover
    </a>
</div>

@if(session('success'))
<div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">
    {{ session('success') }}
</div>
@endif

{{-- TAMBAHKAN INI UNTUK MENANGKAP ERROR --}}
@if(session('error'))
<div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">
    {{ session('error') }}
</div>
@endif

<div class="cover-table-card">
    <table class="cover-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun Ajaran</th>
                <th>Semester</th>
                <th>Nama Sekolah</th>
                <th>Kepala Sekolah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($covers as $i => $cover)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $cover->tahun_ajaran }}</td>
                <td>{{ $cover->semester }}</td>
                <td>{{ $cover->nama_sekolah }}</td>
                <td>{{ $cover->nama_kepsek }}</td>
                <td>
                    <div style="display:flex; gap:8px; justify-content:center;">
                        <a href="{{ route('admin.data-cover.edit', ['data_cover' => $cover->id]) }}" style="color:#16834F; font-size:16px;" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.data-cover.destroy', $cover->id) }}" method="POST" onsubmit="return confirm('Hapus cover ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:#D83A43; font-size:16px; background:none; border:none; padding:0; cursor:pointer;" title="Hapus">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:#888;">Belum ada cover jurnal. Silakan tambah baru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('styles')
<style>
    .cover-table-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #E1ECE6;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .cover-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cover-table thead {
        background: #F0F6F2;
    }

    .cover-table th {
        padding: 12px 10px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #173D2B;
        text-transform: uppercase;
    }

    .cover-table td {
        padding: 12px 10px;
        font-size: 13px;
        color: #40574F;
        border-bottom: 1px solid #E8EFEB;
    }

    .cover-table td:last-child {
        text-align: center;
    }
</style>
@endpush