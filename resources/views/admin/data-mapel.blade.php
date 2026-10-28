@extends('layouts.app')

@section('title', 'Data Mata Pelajaran - Jurnal Mengajar Guru')

@section('content')
    <div class="guru-heading-row">
        <div>
            <h1>Data Mata Pelajaran</h1>
            <p class="subtitle">Kelola daftar mata pelajaran yang diajarkan di sekolah.</p>
        </div>
        
        <a href="{{ route('admin.mapel.create') }}" class="add-guru-button" style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Tambah Mapel
        </a>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">{{ session('error') }}</div>
    @endif

    <div class="guru-table-card">
        <div class="guru-table-wrap">
            <table class="guru-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel as $i => $m)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="font-weight: 600;">{{ $m->nama_mata_pelajaran }}</td>
                            <td>
                                <div class="guru-actions">
                                    <a href="{{ route('admin.mapel.edit', $m->id) }}" class="table-action edit" title="Edit mapel">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mapel ini?');" style="display:inline; margin:0; padding:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action delete" title="Hapus mapel">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; padding:40px; color:#888;">Belum ada data mata pelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="guru-table-footer">
            <span>Menampilkan {{ count($mapel) }} mata pelajaran</span>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Menggunakan CSS yang sama dengan Data Guru agar konsisten */
    .guru-heading-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 22px; }
    .guru-heading-row h1 { margin: 0 0 5px; font-size: 26px; }
    .guru-heading-row .subtitle { margin: 0; font-size: 14px; }
    .add-guru-button { display: inline-flex; align-items: center; justify-content: center; gap: 7px; min-height: 40px; padding: 0 16px; border: 0; border-radius: 6px; background: #0A4C2E; color: #FFFFFF; font: inherit; font-size: 12px; font-weight: 600; white-space: nowrap; cursor: pointer; }
    .guru-table-card { width: 100%; padding: 24px; border: 1px solid #E1ECE6; border-radius: 10px; background: #FFFFFF; }
    .guru-table-wrap { width: 100%; overflow-x: auto; }
    .guru-table { width: 100%; border-collapse: collapse; table-layout: auto; color: #173D2B; font-size: 13px; }
    .guru-table thead { background: #F0F6F2; }
    .guru-table th { padding: 12px 10px; color: #5D756B; text-align: left; text-transform: uppercase; font-size: 10px; font-weight: 700; }
    .guru-table td { padding: 12px 10px; border-bottom: 1px solid #E8EFEB; vertical-align: middle; }
    .guru-actions { display: flex; justify-content: center; align-items: center; gap: 14px; }
    .table-action { display: inline-flex; align-items: center; justify-content: center; width: 31px; height: 31px; padding: 0; border: 1px solid; border-radius: 7px; background: #fff; font-size: 15px; line-height: 1; cursor: pointer; transition: background .15s ease; }
    .table-action.edit { border-color: #aebfb5; color: #39765f; }
    .table-action.delete { border-color: #ff7777; color: #ff3333; }
    .table-action:hover { background: #f4f8f5; }
    .guru-table-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 22px; color: #40574F; font-size: 12px; }
</style>
@endpush