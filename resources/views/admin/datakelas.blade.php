@extends('layouts.app')

@section('title', 'Data Kelas - Jurnal Mengajar Guru')

@section('content')

    <div class="kelas-heading-row">
        <div>
            <h1>Data Kelas</h1>
            <p class="subtitle">Kelola data kelas dan siswa</p>
        </div>
        <button class="add-kelas-button" type="button">
            <span aria-hidden="true">＋</span> Tambah Kelas
        </button>
    </div>

    <div class="kelas-table-card">
        <div class="kelas-table-wrap">
            <table class="kelas-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas ?? [] as $i => $k)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $k->nama_kelas }}</td>
                            <td>
                                <div class="kelas-actions">
                                    <button class="table-action add-siswa" type="button" aria-label="Tambah siswa">♟+</button>
                                    <button class="table-action edit" type="button" aria-label="Edit kelas">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus kelas">▤</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Data dummy untuk tampilan awal --}}
                        <tr><td>1</td><td>VII-A</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>2</td><td>VII-B</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>3</td><td>VII-C</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>4</td><td>VIII-A</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>5</td><td>VIII-B</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>6</td><td>VIII-C</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>7</td><td>IX-A</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>8</td><td>IX-B</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>9</td><td>IX-C</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                        <tr><td>10</td><td>VII-A</td><td><div class="kelas-actions"><button class="table-action add-siswa" type="button">♟+</button><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="kelas-table-footer">
            <span>Menampilkan 1-10 dari 57 Kelas</span>
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
    /* ====== CSS khusus halaman Data Kelas ====== */
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

    .kelas-table thead { background: #FFFFFF; }

    .kelas-table th {
        padding: 12px 10px;
        color: #173D2B;
        text-align: left;
        font-size: 10px;
        font-weight: 700;
    }

    .kelas-table th:first-child { border-radius: 5px 0 0 5px; }
    .kelas-table th:last-child { border-radius: 0 5px 5px 0; text-align: center; }

    .kelas-table td {
        padding: 7px 10px;
        border-bottom: 1px solid #E8EFEB;
        vertical-align: middle;
    }

    .kelas-table tbody tr:nth-child(even) { background: #F8FAF9; }

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
        padding: 0;
        border: 0;
        background: transparent;
        font-size: 16px;
        line-height: 1;
        cursor: pointer;
    }

    .table-action.add-siswa { color: #C5C900; }
    .table-action.edit { color: #16834F; }
    .table-action.delete { color: #D83A43; }

    .kelas-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 18px;
        color: #40574F;
        font-size: 12px;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .page-button {
        min-width: 28px;
        height: 28px;
        padding: 0 7px;
        border: 1px solid #D8E2DC;
        border-radius: 5px;
        background: #FFFFFF;
        color: #173D2B;
        font: inherit;
        font-size: 11px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
        cursor: pointer;
    }

    .page-button.active {
        background: #B9F4B2;
        border-color: #70C86B;
        color: #173D2B;
    }

    @media (max-width: 700px) {
        .kelas-heading-row { align-items: flex-start; flex-direction: column; }
        .kelas-table-card { padding: 12px; }
        .kelas-table-footer { align-items: flex-start; flex-direction: column; }
    }
</style>
@endpush