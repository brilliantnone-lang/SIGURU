@extends('layouts.app')

@section('title', 'Data Guru - Jurnal Mengajar Guru')

@section('content')

    <div class="guru-heading-row">
        <div>
            <h1>Data Guru</h1>
            <p class="subtitle">Kelola profil dan informasi tenaga pendidik sekolah.</p>
        </div>
        <button class="add-guru-button" type="button">
            <span aria-hidden="true">＋</span> Tambah Guru
        </button>
    </div>

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
                                    <button class="table-action edit" type="button" aria-label="Edit guru">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru">▤</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Data dummy untuk tampilan awal --}}
                        <tr>
                            <td>Siti Rahmawati, S.Pd.</td>
                            <td>198506122009032004</td>
                            <td>Bahasa Indonesia</td>
                            <td>0812-5443-2180</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Ahmad Fauzi, S.Pd.</td>
                            <td>198204152008011012</td>
                            <td>Matematika</td>
                            <td>0812-5560-9912</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Nurul Hidayah, S.Pd.</td>
                            <td>199003112015032001</td>
                            <td>IPA</td>
                            <td>0813-4876-1124</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Budi Santoso, S.Pd.</td>
                            <td>198707192011011006</td>
                            <td>Bahasa Inggris</td>
                            <td>0812-4873-2201</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Dewi Anggraini, S.Pd.</td>
                            <td>198906081020132003</td>
                            <td>IPS</td>
                            <td>0852-4957-1148</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Muhammad Rizky, S.Pd.</td>
                            <td>19891108201401003</td>
                            <td>PJOK</td>
                            <td>0813-5123-8921</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Rina Wulandari, S.Pd.</td>
                            <td>198610242012032005</td>
                            <td>Seni Budaya</td>
                            <td>0821-6634-9087</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Fajar Maulana, S.Pd.</td>
                            <td>199102172016011004</td>
                            <td>PKn</td>
                            <td>0812-7781-4482</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Lilis Kartika, S.Pd.</td>
                            <td>198803062010012006</td>
                            <td>Prakarya</td>
                            <td>0851-9204-3376</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                        <tr>
                            <td>Andi Pratama, S.Pd.</td>
                            <td>199005122017031002</td>
                            <td>TIK</td>
                            <td>0813-6452-7810</td>
                            <td><div class="guru-actions"><button class="table-action edit" type="button">✎</button><button class="table-action delete" type="button">▤</button></div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="guru-table-footer">
            <span>Menampilkan 1-10 dari 45 Guru</span>
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
    /* ====== CSS khusus halaman Data Guru ====== */
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

    .guru-table thead { background: #F0F6F2; }

    .guru-table th {
        padding: 12px 10px;
        color: #5D756B;
        text-align: left;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
    }

    .guru-table th:first-child { border-radius: 5px 0 0 5px; }
    .guru-table th:last-child { border-radius: 0 5px 5px 0; text-align: center; }

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
        padding: 0;
        border: 0;
        background: transparent;
        font-size: 16px;
        line-height: 1;
        cursor: pointer;
    }

    .table-action.edit { color: #16834F; }
    .table-action.delete { color: #D83A43; }

    .guru-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
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
        .guru-heading-row { align-items: flex-start; flex-direction: column; }
        .guru-table-card { padding: 12px; }
        .guru-table-footer { align-items: flex-start; flex-direction: column; }
    }
</style>
@endpush