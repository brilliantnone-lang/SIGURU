@extends('layouts.app')

@section('title', 'Data Kelas - Jurnal Mengajar Guru')

@section('content')

<div class="kelas-heading-row">
    <div>
        <h1>Data Kelas</h1>
        <p class="subtitle">Kelola data kelas dan siswa</p>
    </div>
    <a href="{{ route('admin.kelas.create') }}" class="add-kelas-button" style="text-decoration: none;">
        <span aria-hidden="true">＋</span> Tambah Kelas
    </a>
</div>

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

<div class="kelas-table-card">
    <div class="kelas-table-wrap">
        <table class="kelas-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Kapasitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas ?? [] as $i => $k)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $k->nama_kelas }}</td>
                    <td>{{ $k->kapasitas }} Siswa</td>
                    <td>
                        <div class="kelas-actions">
                            {{-- Tambah Siswa --}}
                            <a href="{{ route('admin.murid.index', ['kelas_id' => $k->id]) }}" class="table-action add-siswa" title="Lihat / Tambah Siswa">

                            {{-- Edit Kelas --}}
                            <a href="{{ route('admin.kelas.edit', $k->id) }}" class="table-action edit" title="Edit kelas">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            {{-- Hapus Kelas --}}
                            <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?');" style="display:inline; margin:0; padding:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-action delete" title="Hapus kelas">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:40px; color:#888;">Belum ada data kelas. Silakan tambah baru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="kelas-table-footer">
        <span>Menampilkan {{ count($kelas ?? []) }} data kelas</span>
    </div>
</div>

@endsection

@push('styles')
<style>
    .kelas-heading-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .kelas-heading-row h1 {
        margin: 0 0 5px;
        font-size: 26px;
    }

    .kelas-heading-row .subtitle {
        margin: 0;
        font-size: 14px;
    }

    .add-kelas-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        padding: 0 16px;
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

    .kelas-table-card {
        width: 100%;
        padding: 12px;
        border: 1px solid #E1ECE6;
        border-radius: 10px;
        background: #FFFFFF;
    }

    .kelas-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .kelas-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
        color: #173D2B;
        font-size: 12px;
        white-space: nowrap;
    }

    .kelas-table thead {
        background: #FFFFFF;
    }

    .kelas-table th {
        padding: 12px 10px;
        color: #173D2B;
        text-align: left;
        font-size: 10px;
        font-weight: 700;
    }

    .kelas-table th:last-child {
        text-align: center;
    }

    .kelas-table td {
        padding: 7px 10px;
        border-bottom: 1px solid #E8EFEB;
        vertical-align: middle;
    }

    .kelas-table tbody tr:nth-child(even) {
        background: #F8FAF9;
    }

    .kelas-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 14px;
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
        font-size: 17px;
        line-height: 1;
        cursor: pointer;
        transition: background .15s ease;
    }

    .table-action.add-siswa {
        border-color: #C5C900;
        color: #C5C900;
        font-size: 16px;
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

    .kelas-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 18px;
        color: #40574F;
        font-size: 12px;
    }

    @media (max-width: 700px) {
        .kelas-heading-row {
            align-items: flex-start;
            flex-direction: column;
        }

        .kelas-table-card {
            padding: 12px;
        }

        .kelas-table-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush