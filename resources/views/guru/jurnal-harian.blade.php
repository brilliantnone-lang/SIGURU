
@extends('layouts.app')

@section('title', 'Jurnal Harian Guru')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<div class="jurnal-page">

    {{-- Header Halaman --}}
    <div class="jurnal-page-header">
        <div>
            <h2>Jurnal Harian Guru</h2>
            <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
        </div>

        <a href="{{ route('guru.tambah-jurnal') }}" class="btn-tambah-jurnal">
            <i class="bi bi-plus-lg"></i>
            Tambah Jurnal
        </a>
    </div>

    {{-- Validasi Jurnal --}}
    <section class="jurnal-section validation-section">
        <div class="section-heading">
            <h3>Validasi Jurnal</h3>
            <p>Rekap, Ekspor, dan Status Jurnal Anda</p>
        </div>

        <div class="table-responsive">
            <table class="jurnal-table validation-table">
                <thead>
                    <tr>
                        <th>Semester</th>
                        <th>Tahun Ajaran</th>
                        <th>Status Jurnal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ganjil</td>
                        <td>2026/2027</td>
                        <td>
                            <span class="validation-status status-review">
                                Sedang Berjalan
                            </span>
                        </td>
                        <td>
                            <span class="action-placeholder">—</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Genap</td>
                        <td>2025/2026</td>
                        <td>
                            <span class="validation-status status-revision">
                                Perlu Perbaikan
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('guru.catatan-revisi') }}" class="btn-table-action btn-revision">
                                Lihat Catatan Perbaikan
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Ganjil</td>
                        <td>2025/2026</td>
                        <td>
                            <span class="validation-status status-validated">
                                Sudah Divalidasi
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn-table-action btn-export">
                                Ekspor PDF <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Riwayat Jurnal --}}
    <section class="jurnal-section history-section">
        <div class="history-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Riwayat Jurnal</h3>
                <p>10 catatan jurnal tersimpan</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="jurnal-table history-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kelas/Jam</th>
                        <th>Pokok Bahasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1 OKT 2026</td>
                        <td>
                            <strong>Kelas VIII A</strong>
                            <small>Jam ke 1-2 Bahasa Indonesia</small>
                        </td>
                        <td>Menelaah teks deskripsi dan ciri-cirinya</td>
                        <td><span class="history-status">Tuntas</span></td>
                        <td>
                            <div class="history-actions">
                                <a href="{{ route('guru.lihat-jurnal') }}" class="icon-action action-detail" title="Lihat jurnal">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('guru.edit-jurnal') }}" class="icon-action action-edit" title="Edit jurnal">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="icon-action action-delete" title="Hapus jurnal">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>30 SPT 2026</td>
                        <td>
                            <strong>Kelas VIII C</strong>
                            <small>Jam ke 3-4</small>
                        </td>
                        <td>Menelaah struktur dan unsur kebahasaan teks laporan</td>
                        <td><span class="history-status">Tuntas</span></td>
                        <td>
                            <div class="history-actions">
                                <a href="{{ route('guru.lihat-jurnal') }}" class="icon-action action-detail" title="Lihat jurnal">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('guru.edit-jurnal') }}" class="icon-action action-edit" title="Edit jurnal">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="icon-action action-delete" title="Hapus jurnal">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>30 SPT 2026</td>
                        <td>
                            <strong>Kelas VII D</strong>
                            <small>Jam ke 7-8 Bahasa Indonesia</small>
                        </td>
                        <td>Mengidentifikasi unsur-unsur teks berita</td>
                        <td><span class="history-status">Tuntas</span></td>
                        <td>
                            <div class="history-actions">
                                <a href="{{ route('guru.lihat-jurnal') }}" class="icon-action action-detail" title="Lihat jurnal">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('guru.edit-jurnal') }}" class="icon-action action-edit" title="Edit jurnal">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="icon-action action-delete" title="Hapus jurnal">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>29 SPT 2026</td>
                        <td>
                            <strong>Kelas VIII C</strong>
                            <small>Jam ke 1-2 Bahasa Indonesia</small>
                        </td>
                        <td>Menyusun teks eksposisi berdasarkan gagasan dan fakta</td>
                        <td><span class="history-status">Tuntas</span></td>
                        <td>
                            <div class="history-actions">
                                <a href="{{ route('guru.lihat-jurnal') }}" class="icon-action action-detail" title="Lihat jurnal">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('guru.edit-jurnal') }}" class="icon-action action-edit" title="Edit jurnal">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="icon-action action-delete" title="Hapus jurnal">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>29 SPT 2026</td>
                        <td>
                            <strong>Kelas IX A</strong>
                            <small>Jam ke 3-4 Bahasa Indonesia</small>
                        </td>
                        <td>Menyusun pidato persuasif dan teknik berbicara</td>
                        <td><span class="history-status">Tuntas</span></td>
                        <td>
                            <div class="history-actions">
                                <a href="{{ route('guru.lihat-jurnal') }}" class="icon-action action-detail" title="Lihat jurnal">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('guru.edit-jurnal') }}" class="icon-action action-edit" title="Edit jurnal">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="icon-action action-delete" title="Hapus jurnal">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="history-footer">
            <span>Menampilkan 1-5 dari 48 Jurnal</span>

            <div class="pagination-list">
                <button type="button" disabled aria-label="Halaman sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="page-active">1</button>
                <button type="button">2</button>
                <button type="button">3</button>
                <button type="button">4</button>
                <button type="button">5</button>
                <span>...</span>
            </div>
        </div>
    </section>

</div>

<style>
    .jurnal-page {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    .jurnal-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 18px;
    }

    .jurnal-page-header h2 {
        margin: 0 0 5px;
        font-size: 26px;
        font-weight: 650;
        color: #111;
    }

    .jurnal-page-header p {
        margin: 0;
        font-size: 12px;
        color: #555;
    }

    .btn-tambah-jurnal {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 5px;
        background: #39765f;
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
    }

    .btn-tambah-jurnal:hover {
        background: #2e624e;
        color: #fff;
    }

    .jurnal-section {
        background: #fff;
        border: 1px solid #b9d0c5;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .12);
    }

    .validation-section {
        margin-bottom: 21px;
    }

    .section-heading {
        padding: 11px 10px 7px;
    }

    .section-heading h3 {
        margin: 0 0 2px;
        font-size: 18px;
        font-weight: 650;
        color: #111;
    }

    .section-heading p {
        margin: 0;
        font-size: 12px;
        color: #999;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .jurnal-table {
        width: 100%;
        border-collapse: collapse;
    }

    .jurnal-table thead {
        background: #e1eee8;
    }

    .jurnal-table th {
        padding: 5px 12px;
        text-align: left;
        text-transform: uppercase;
        color: #7d8581;
        font-size: 11px;
        font-weight: 650;
        white-space: nowrap;
    }

    .jurnal-table td {
        padding: 6px 12px;
        border-bottom: 1px solid #e3e3e3;
        font-size: 11px;
        vertical-align: middle;
    }

    .jurnal-table tbody tr:last-child td {
        border-bottom: none;
    }

    .validation-table th:last-child,
    .validation-table td:last-child {
        text-align: center;
    }

    .validation-table td:nth-child(2) {
        font-weight: 600;
    }

    .validation-status {
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
    }

    .status-review {
        color: #143fbd;
    }

    .status-revision {
        color: #c64c00;
    }

    .status-validated {
        color: #26734f;
    }

    .action-placeholder {
        color: #aaa;
    }

    .btn-table-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 4px 6px;
        border: 1px solid;
        border-radius: 5px;
        text-decoration: none;
        font-size: 9px;
        white-space: nowrap;
    }

    .btn-revision {
        border-color: #df9b68;
        color: #ad510d;
    }

    .btn-export {
        border-color: #7ba58e;
        color: #367458;
    }

    .history-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 17px 7px;
    }

    .history-heading > i {
        font-size: 24px;
        color: #39765f;
    }

    .history-heading h3 {
        margin: 0 0 2px;
        font-size: 18px;
        font-weight: 650;
        color: #222;
    }

    .history-heading p {
        margin: 0;
        font-size: 12px;
        color: #999;
    }

    .history-table th {
        font-size: 11px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .history-table td {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .history-table td:first-child {
        white-space: nowrap;
        font-weight: 600;
    }

    .history-table td:nth-child(2) {
        min-width: 105px;
    }

    .history-table td:nth-child(2) strong {
        display: block;
        font-size: 11px;
        font-weight: 650;
    }

    .history-table td:nth-child(2) small {
        display: block;
        margin-top: 3px;
        font-size: 10px;
        color: #999;
        white-space: nowrap;
    }

    .history-table td:nth-child(3) {
        min-width: 110px;
        max-width: 150px;
        text-align: center;
        color: #888;
        line-height: 1.5;
        font-size: 11px;
    }

    .history-table th:nth-child(4),
    .history-table td:nth-child(4),
    .history-table th:nth-child(5),
    .history-table td:nth-child(5) {
        text-align: center;
    }

    .history-status {
        display: inline-block;
        min-width: 57px;
        padding: 5px 9px;
        border-radius: 6px;
        background: #96ebc8;
        color: #267454;
        font-size: 11px;
    }

    .history-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .icon-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        padding: 0;
        border: 1px solid;
        border-radius: 5px;
        background: #fff;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
    }

    .action-detail {
        border-color: #a9bdb3;
        color: #39765f;
    }

    .action-edit {
        border-color: #d6a06f;
        color: #c45a09;
    }

    .action-delete {
        border-color: #ed9a9a;
        color: #f04444;
    }

    .icon-action:hover {
        background: #f5f8f6;
    }

    .history-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 10px 9px;
        font-size: 11px;
        color: #52675d;
    }

    .pagination-list {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .pagination-list button {
        min-width: 20px;
        height: 20px;
        padding: 0 3px;
        border: 1px solid #d5d5d5;
        border-radius: 3px;
        background: #fff;
        color: #555;
        font-size: 10px;
        cursor: pointer;
    }

    .pagination-list button:disabled {
        color: #aaa;
        cursor: default;
    }

    .pagination-list .page-active {
        background: #b7edbd;
        border-color: #91d99a;
        color: #28643b;
    }

    .pagination-list span {
        margin-left: 3px;
    }

    @media (max-width: 700px) {
        .jurnal-page-header h2 {
            font-size: 22px;
        }

        .jurnal-page-header p {
            max-width: 230px;
            line-height: 1.5;
        }

        .btn-tambah-jurnal {
            font-size: 10px;
            padding: 8px;
        }

        .validation-table {
            min-width: 520px;
        }

        .history-table {
            min-width: 650px;
        }

        .history-footer {
            flex-wrap: wrap;
        }
    }
</style>
@endsection