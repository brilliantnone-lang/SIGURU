@extends('layouts.app')

@section('title', 'Data Guru - Jurnal Mengajar Guru')

@section('content')
    <div class="guru-heading-row">
        <div>
            <h1>Data Guru</h1>
            <p class="subtitle">Kelola profil dan informasi tenaga pendidik sekolah.</p>
        </div>
        
        <a href="{{ route('admin.tambah-guru') }}" class="add-guru-button" style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Tambah Guru
        </a>
    </div>

    {{-- Notifikasi Sukses / Error --}}
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

    {{-- Form Filter --}}
    <form class="guru-filter-card" method="GET" action="{{ route('admin.guru.index') }}">
        <div class="guru-filter-field">
            <label for="filter-jenis-kelamin">Jenis Kelamin</label>
            <div class="guru-filter-select">
                <select id="filter-jenis-kelamin" name="jenis_kelamin">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="Laki-laki" {{ request('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="guru-filter-field">
            <label for="filter-mata-pelajaran">Mata Pelajaran</label>
            <div class="guru-filter-select">
                <select id="filter-mata-pelajaran" name="mata_pelajaran">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach(($mataPelajaran ?? []) as $mapel)
                        <option value="{{ $mapel->id }}" {{ (string) request('mata_pelajaran') === (string) $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mata_pelajaran }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="guru-filter-submit" type="submit">
            <i class="bi bi-search" aria-hidden="true"></i> Tampilkan
        </button>
    </form>

    {{-- Tabel Data Guru --}}
    <div class="guru-table-card">
        <div class="guru-table-wrap">
            <table class="guru-table">
                <thead>
                    <tr>
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th>Mata Pelajaran</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guru ?? [] as $g)
                        <tr>
                            <td>{{ $g->user->name ?? '-' }}</td>
                            <td>{{ $g->nip_guru ?? '-' }}</td>
                            <td>{{ $g->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
                            <td>{{ $g->nomor_telepon ?? '-' }}</td>
                            <td>
                                <div class="guru-actions">
                                    <a href="{{ route('admin.guru.edit', $g->id) }}" class="table-action edit" title="Edit guru">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.guru.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus guru ini?');" style="display:inline; margin:0; padding:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action delete" title="Hapus guru">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:#888;">Belum ada data guru. Silakan tambah baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="guru-table-footer">
            <span>Menampilkan {{ count($guru ?? []) }} data guru</span>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .guru-heading-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .guru-heading-row h1 {
        margin: 0 0 5px;
        font-size: 26px;
    }

    .guru-heading-row .subtitle {
        margin: 0;
        font-size: 14px;
    }

    .add-guru-button {
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

    /* Filter Data Guru */
    .guru-filter-card {
        display: grid;
        grid-template-columns: minmax(180px, 1fr) minmax(180px, 1fr) auto;
        align-items: end;
        gap: 18px;
        width: 100%;
        margin-bottom: 20px;
        padding: 18px 20px;
        border: 1px solid #D8D8D8;
        border-radius: 10px;
        background: #FFFFFF;
        box-shadow: 0 2px 4px rgba(0, 0, 0, .08);
    }

    .guru-filter-field { min-width: 0; }

    .guru-filter-field label {
        display: block;
        margin-bottom: 6px;
        color: #40574F;
        font-size: 13px;
        font-weight: 600;
    }

    .guru-filter-select {
        display: flex;
        align-items: center;
        gap: 8px;
        height: 38px;
        max-width: 100%;
        padding: 0 10px;
        border: 1px solid #D5DAD7;
        border-radius: 6px;
        background: #FFFFFF;
        color: #40574F;
    }

    .guru-filter-select select {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        background: transparent;
        color: #40574F;
        font: inherit;
        font-size: 11px;
        cursor: pointer;
    }

    .guru-filter-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-width: 112px;
        height: 38px;
        padding: 0 15px;
        border: 0;
        border-radius: 5px;
        background: #0A4C2E;
        color: #FFFFFF;
        font: inherit;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
    }

    /* Tabel Data Guru */
    .guru-table-card {
        width: 100%;
        padding: 24px;
        border: 1px solid #E1ECE6;
        border-radius: 10px;
        background: #FFFFFF;
    }

    .guru-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .guru-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
        color: #173D2B;
        font-size: 12px;
        white-space: nowrap;
    }

    .guru-table thead {
        background: #F0F6F2;
    }

    .guru-table th {
        padding: 12px 10px;
        color: #5D756B;
        text-align: left;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
    }

    .guru-table th:last-child {
        text-align: center;
    }

    .guru-table td {
        padding: 12px 10px;
        border-bottom: 1px solid #E8EFEB;
        vertical-align: middle;
    }

    .guru-actions {
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

    .guru-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        color: #40574F;
        font-size: 12px;
    }

    @media (max-width: 700px) {
        .guru-heading-row {
            align-items: flex-start;
            flex-direction: column;
        }
        .guru-filter-card {
            grid-template-columns: 1fr;
        }
        .guru-table-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush