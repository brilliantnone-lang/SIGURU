@extends('layouts.app')

@section('title', 'Bahan Ajar Guru')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<div class="bahan-ajar-page">

    {{-- Header --}}
    <div class="bahan-ajar-header">
        <div>
            <h2>Bahan Ajar Guru</h2>
            <p>Simpan dan kelola seluruh materi pembelajaran dalam satu tempat.</p>
        </div>

        <a href="{{ route('guru.unggah-bahan-ajar') }}" class="btn-upload-bahan">
            <i class="bi bi-plus-lg"></i>
            Unggah Bahan Ajar
        </a>
    </div>

    {{-- Informasi Jumlah Bahan Ajar --}}
    <div class="bahan-summary">
        <div class="summary-icon">
            <i class="bi bi-files"></i>
        </div>
        <div>
            <h3>2 Bahan Ajar Tersimpan</h3>
            <p>Masukkan semua dokumen pendukung pembelajaran untuk memudahkan anda</p>
        </div>
    </div>

    {{-- Daftar Bahan Ajar --}}
    <section class="bahan-card">
        <div class="bahan-card-heading">
            <i class="bi bi-files"></i>
            <div>
                <h3>Daftar Bahan Ajar</h3>
                <p>Dokumen dan modul yang telah Anda unggah</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="bahan-table">
                <thead>
                    <tr>
                        <th>Nama Materi</th>
                        <th>Kelas &amp; Mata Pelajaran</th>
                        <th>Tanggal Unggah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Modul Ajar Teks Deskripsi</strong>
                            <small>modul-teks-deskripsi.pdf</small>
                        </td>
                        <td>
                            <strong>Kelas VII</strong>
                            <small>Bahasa Indonesia</small>
                        </td>
                        <td class="upload-date">12 Agustus 2026</td>
                        <td>
                            <div class="bahan-actions">
                                <a href="#" class="bahan-action action-download" title="Unduh bahan ajar">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="{{ route('guru.edit-bahan-ajar') }}" class="bahan-action action-edit" title="Edit bahan ajar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="bahan-action action-delete" title="Hapus bahan ajar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Modul Ajar Kata Kerja</strong>
                            <small>modul-teks-deskripsi.pdf</small>
                        </td>
                        <td>
                            <strong>Kelas VII</strong>
                            <small>Bahasa Indonesia</small>
                        </td>
                        <td class="upload-date">12 Agustus 2026</td>
                        <td>
                            <div class="bahan-actions">
                                <a href="#" class="bahan-action action-download" title="Unduh bahan ajar">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="{{ route('guru.edit-bahan-ajar') }}" class="bahan-action action-edit" title="Edit bahan ajar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="bahan-action action-delete" title="Hapus bahan ajar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</div>

<style>
    .bahan-ajar-page {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    .bahan-ajar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }

    .bahan-ajar-header h2 {
        margin: 0 0 7px;
        font-size: 26px;
        font-weight: 650;
        color: #111;
    }

    .bahan-ajar-header p {
        margin: 0;
        font-size: 12px;
        color: #888;
    }

    .btn-upload-bahan {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 13px;
        border-radius: 6px;
        background: #39765f;
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 550;
        white-space: nowrap;
    }

    .btn-upload-bahan:hover {
        background: #2e624e;
        color: #fff;
    }

    .bahan-summary {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 67px;
        padding: 11px 19px;
        margin-bottom: 17px;
        border: 1px solid #c8f5b8;
        border-radius: 9px;
        background: #f3ffed;
    }

    .summary-icon {
        width: 41px;
        height: 42px;
        min-width: 41px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #d7f4cc;
        border-radius: 7px;
        background: #fff;
        color: #39765f;
        font-size: 25px;
    }

    .bahan-summary h3 {
        margin: 0 0 3px;
        font-size: 18px;
        font-weight: 650;
        color: #39765f;
    }

    .bahan-summary p {
        margin: 0;
        font-size: 10px;
        color: #899b88;
    }

    .bahan-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #b9d0c5;
        border-radius: 8px;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .15);
    }

    .bahan-card-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 10px 18px 8px;
    }

    .bahan-card-heading > i {
        color: #39765f;
        font-size: 25px;
    }

    .bahan-card-heading h3 {
        margin: 0 0 3px;
        font-size: 18px;
        font-weight: 650;
        color: #111;
    }

    .bahan-card-heading p {
        margin: 0;
        font-size: 12px;
        color: #999;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .bahan-table {
        width: 100%;
        border-collapse: collapse;
    }

    .bahan-table thead {
        background: #e1eee8;
    }

    .bahan-table th {
        padding: 6px 10px;
        text-align: left;
        color: #39765f;
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 650;
        white-space: nowrap;
    }

    .bahan-table th:nth-child(3),
    .bahan-table td:nth-child(3),
    .bahan-table th:nth-child(4),
    .bahan-table td:nth-child(4) {
        text-align: center;
    }

    .bahan-table td {
        padding: 8px 5px;
        border-bottom: 1px solid #e5e5e5;
        font-size: 11px;
        vertical-align: middle;
    }

    .bahan-table tbody tr:last-child td {
        border-bottom: none;
    }

    .bahan-table td strong {
        display: block;
        margin-bottom: 3px;
        font-size: 11px;
        font-weight: 650;
        color: #222;
    }

    .bahan-table td small {
        display: block;
        font-size: 10px;
        color: #999;
    }

    .bahan-table td.upload-date {
        color: #888;
        font-size: 11px;
        white-space: nowrap;
    }

    .bahan-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
    }

    .bahan-action {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 31px;
        height: 31px;
        padding: 0;
        border: 1px solid;
        border-radius: 7px;
        background: #fff;
        text-decoration: none;
        font-size: 19px;
        cursor: pointer;
    }

    .action-download {
        border-color: #b7c7bf;
        color: #39765f;
    }

    .action-edit {
        border-color: #aebfb5;
        color: #39765f;
    }

    .action-delete {
        border-color: #ff7777;
        color: #ff3333;
    }

    .bahan-action:hover {
        background: #f4f8f5;
    }

    @media (max-width: 700px) {
        .bahan-ajar-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .bahan-ajar-header h2 {
            font-size: 22px;
        }

        .bahan-summary {
            padding: 10px;
        }

        .bahan-summary h3 {
            font-size: 15px;
        }

        .bahan-table {
            min-width: 570px;
        }
    }
</style>
@endsection
