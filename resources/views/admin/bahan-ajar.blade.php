@extends('layouts.app')

@section('title', 'Bahan Ajar Guru - SIGURU')

@section('content')
<div class="admin-bahan-ajar">

    <div class="bahan-ajar-heading">
        <h1>Bahan Ajar Guru</h1>
        <p>Melihat bahan ajar yang digunakan guru</p>
    </div>

    {{-- Filter --}}
    <form action="{{ route('admin.bahan-ajar.index') }}" method="GET" class="bahan-ajar-filter">
        <div class="bahan-filter-field">
            <label for="filterGuruBahan">Guru</label>
            <select id="filterGuruBahan" name="guru_id">
                <option value="">Semua Guru</option>
                @foreach($gurus as $g)
                <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                    {{ $g->user->name ?? '-' }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="bahan-filter-field">
            <label for="filterMapelBahan">Mata Pelajaran</label>
            <select id="filterMapelBahan" name="mata_pelajaran_id">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($mataPelajarans as $mapel)
                <option value="{{ $mapel->id }}" {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                    {{ $mapel->nama_mata_pelajaran }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bahan-filter-button">
            <i class="bi bi-search"></i> Tampilkan
        </button>
    </form>

    {{-- Daftar bahan ajar --}}
    <section class="bahan-ajar-panel">
        <div class="bahan-ajar-panel-heading">
            <span aria-hidden="true">▱</span>
            <h2>Daftar Bahan Ajar Guru</h2>
        </div>

        <div class="bahan-ajar-table-scroll">
            <table class="bahan-ajar-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>File Bahan Ajar</th>
                        <th>Waktu Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahanAjar as $i => $b)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $b->guru->user->name ?? '-' }}</td>
                        <td>{{ $b->guru->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
                        <td>
                            <div class="bahan-file-list">
                                <div class="bahan-file-item">
                                    <span class="bahan-file-icon file-pdf">PDF</span>
                                    <a href="{{ asset('storage/' . $b->path_file) }}" target="_blank" class="bahan-file-name" style="color:#145b3c; text-decoration:none;">
                                        {{ $b->nama_file }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>{{ $b->created_at->translatedFormat('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px; color:#888;">Belum ada bahan ajar yang diunggah oleh guru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bahan-ajar-footer">
            <span>Menampilkan {{ count($bahanAjar) }} bahan ajar</span>
        </div>
    </section>

</div>

<style>
    .admin-bahan-ajar {
        width: 100%;
        min-width: 0;
        color: #263b35;
        font-family: inherit;
    }

    .admin-bahan-ajar *,
    .admin-bahan-ajar *::before,
    .admin-bahan-ajar *::after {
        box-sizing: border-box;
    }

    .bahan-ajar-heading {
        margin-bottom: 16px;
    }

    .bahan-ajar-heading h1 {
        margin: 0;
        color: #17211f;
        font-size: 25px;
        font-weight: 700;
        line-height: 1.35;
    }

    .bahan-ajar-heading p {
        margin: 3px 0 0;
        color: #52665e;
        font-size: 13px;
    }

    /* Filter */
    .bahan-ajar-filter {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        align-items: end;
        gap: 16px;
        margin-bottom: 10px;
        padding: 14px;
        background: #fff;
        border: 1px solid #dfe5e2;
        border-radius: 7px;
        box-shadow: 0 2px 3px rgba(30, 50, 40, 0.04);
    }

    .bahan-filter-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
        min-width: 0;
    }

    .bahan-filter-field label {
        color: #40534b;
        font-size: 11px;
        font-weight: 600;
    }

    .bahan-filter-field select {
        width: 100%;
        min-width: 0;
        height: 34px;
        padding: 0 9px;
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

    /* Panel dan tabel */
    .bahan-ajar-panel {
        min-width: 0;
        padding: 12px;
        background: #fff;
        border: 1px solid #e0e7e4;
        border-radius: 7px;
    }

    .bahan-ajar-panel-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
    }

    .bahan-ajar-panel-heading>span {
        color: #26935c;
        font-size: 19px;
    }

    .bahan-ajar-panel-heading h2 {
        margin: 0;
        color: #263b35;
        font-size: 15px;
        font-weight: 700;
    }

    .bahan-ajar-table-scroll {
        width: 100%;
        overflow-x: auto;
    }

    .bahan-ajar-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 10px;
    }

    .bahan-ajar-table thead {
        background: #fff;
    }

    .bahan-ajar-table th {
        padding: 9px 7px;
        color: #30483c;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .bahan-ajar-table td {
        padding: 8px 7px;
        color: #35443c;
        border-bottom: 1px solid #f0f2f1;
        vertical-align: middle;
    }

    .bahan-ajar-table tbody tr:last-child td {
        border-bottom: none;
    }

    .bahan-ajar-table tbody tr:hover {
        background: #fafcfb;
    }

    /* Daftar file */
    .bahan-file-list {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 190px;
    }

    .bahan-file-item {
        display: flex;
        align-items: center;
        gap: 5px;
        min-width: 0;
    }

    .bahan-file-icon {
        display: inline-flex;
        flex: 0 0 11px;
        width: 11px;
        height: 14px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        color: #fff;
        background: #d85d52;
        border-radius: 2px;
        font-size: 4px;
        font-weight: 700;
    }

    .bahan-file-name {
        overflow-wrap: anywhere;
        line-height: 1.4;
    }

    /* Footer */
    .bahan-ajar-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 12px;
        padding: 5px 3px 10px;
    }

    .bahan-ajar-footer>span {
        color: #52665e;
        font-size: 11px;
    }

    /* Responsif */
    @media (max-width: 760px) {
        .bahan-ajar-filter {
            grid-template-columns: 1fr;
        }

        .bahan-filter-button {
            width: 100%;
        }
    }
</style>
@endsection