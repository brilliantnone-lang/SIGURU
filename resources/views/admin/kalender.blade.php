
@extends('layouts.app')

@section('title', 'Kalender Akademik - SIGURU')

@section('content')
<div class="admin-kalender">

    <div class="kalender-heading">
        <div>
            <h1>Kalender Akademik</h1>
            <p>Mengelola dokumen kalender akademik sekolah</p>
        </div>

        <button type="button" class="btn-tambah-kalender" id="btnBukaForm">
            <span>＋</span> Tambah Kalender
        </button>
    </div>

    {{-- Form tambah kalender: frontend saja --}}
    <div class="kalender-modal" id="kalenderModal" hidden>
        <div class="kalender-modal-card">
            <div class="kalender-modal-heading">
                <h2>Tambah Kalender Akademik</h2>
                <button type="button" class="btn-tutup-modal" id="btnTutupForm"
                    aria-label="Tutup">&times;</button>
            </div>

            <form id="formKalender">
                <div class="kalender-form-group">
                    <label for="tahunAjaran">Tahun Ajaran</label>
                    <input type="text" id="tahunAjaran"
                        placeholder="Contoh: 2026/2027" required>
                </div>

                <div class="kalender-form-group">
                    <label for="fileKalender">Dokumen Kalender Akademik</label>
                    <input type="file" id="fileKalender"
                        accept=".pdf,.doc,.docx" required>
                    <small>Format PDF atau Word.</small>
                </div>

                <div class="kalender-form-actions">
                    <button type="button" class="btn-batal" id="btnBatalForm">
                        Batal
                    </button>
                    <button type="submit" class="btn-simpan-kalender">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel kalender --}}
    <section class="kalender-table-panel">
        <div class="kalender-table-scroll">
            <table class="kalender-table">
                <thead>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="kalenderTableBody">
                    <tr>
                        <td>2025/2026</td>
                        <td>
                            <span class="nama-file-kalender">
                                Kalender Akademik 2025-2026 Revisi.pdf
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn-lihat-kalender"
                                data-file="Kalender Akademik 2025-2026 Revisi.pdf">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Pratinjau sederhana --}}
    <div class="kalender-modal" id="detailKalenderModal" hidden>
        <div class="kalender-modal-card">
            <div class="kalender-modal-heading">
                <h2>Detail Kalender Akademik</h2>
                <button type="button" class="btn-tutup-modal"
                    id="btnTutupDetail" aria-label="Tutup">&times;</button>
            </div>
            <p class="detail-nama-file" id="detailNamaFile"></p>
            <p class="detail-catatan">
                Pratinjau dokumen akan tersedia setelah file dihubungkan
                dengan penyimpanan aplikasi.
            </p>
        </div>
    </div>

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
.btn-simpan-kalender:hover,
.btn-lihat-kalender:hover {
    background: #285c45;
}

/* Tabel */

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
    font-size: 10px;
    text-align: center;
}

.kalender-table thead {
    background: #f0f5f2;
}

.kalender-table th {
    padding: 9px 10px;
    color: #52665c;
    font-size: 10px;
    font-weight: 600;
}

.kalender-table td {
    padding: 10px;
    color: #394c42;
    border-bottom: 1px solid #edf1ee;
}

.kalender-table tbody tr:last-child td {
    border-bottom: none;
}

.kalender-table th:first-child,
.kalender-table td:first-child {
    width: 20%;
}

.kalender-table th:last-child,
.kalender-table td:last-child {
    width: 15%;
}

.nama-file-kalender {
    overflow-wrap: anywhere;
}

.btn-lihat-kalender {
    padding: 5px 10px;
    color: #fff;
    background: #39765c;
    border: none;
    border-radius: 4px;
    font: inherit;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
}

/* Modal */

.kalender-modal[hidden] {
    display: none !important;
}

.kalender-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(20, 35, 28, 0.45);
}

.kalender-modal-card {
    width: 100%;
    max-width: 440px;
    padding: 20px;
    background: #fff;
    border: 1px solid #e1e8e3;
    border-radius: 9px;
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.14);
}

.kalender-modal-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
}

.kalender-modal-heading h2 {
    margin: 0;
    color: #243b30;
    font-size: 17px;
}

.btn-tutup-modal {
    width: 30px;
    height: 30px;
    color: #52665c;
    background: #f2f5f3;
    border: none;
    border-radius: 5px;
    font-size: 23px;
    cursor: pointer;
}

.kalender-form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
    margin-bottom: 16px;
}

.kalender-form-group label {
    color: #34493d;
    font-size: 12px;
    font-weight: 600;
}

.kalender-form-group input {
    width: 100%;
    min-height: 38px;
    padding: 9px;
    color: #34493d;
    background: #fff;
    border: 1px solid #d7e1da;
    border-radius: 5px;
    font: inherit;
    font-size: 12px;
}

.kalender-form-group small,
.detail-catatan {
    color: #718078;
    font-size: 11px;
}

.kalender-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 20px;
}

.btn-batal,
.btn-simpan-kalender {
    min-height: 35px;
    padding: 0 14px;
    border-radius: 5px;
    font: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.btn-batal {
    color: #46564d;
    background: #fff;
    border: 1px solid #d5dfd8;
}

.btn-simpan-kalender {
    color: #fff;
    background: #39765c;
    border: 1px solid #39765c;
}

.detail-nama-file {
    padding: 10px;
    color: #34493d;
    background: #f0f5f2;
    border-radius: 5px;
    font-size: 12px;
    overflow-wrap: anywhere;
}

@media (max-width: 600px) {
    .kalender-heading {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-tambah-kalender {
        align-self: flex-start;
    }

    .kalender-heading h1 {
        font-size: 22px;
    }

    .kalender-table-panel {
        padding: 8px;
    }

    .kalender-table {
        min-width: 430px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('kalenderModal');
    const detailModal = document.getElementById('detailKalenderModal');
    const form = document.getElementById('formKalender');

    function bukaModal(element) {
        element.hidden = false;
    }

    function tutupModal(element) {
        element.hidden = true;
    }

    document.getElementById('btnBukaForm').addEventListener('click', function () {
        bukaModal(modal);
    });

    document.getElementById('btnTutupForm').addEventListener('click', function () {
        tutupModal(modal);
    });

    document.getElementById('btnBatalForm').addEventListener('click', function () {
        tutupModal(modal);
    });

    document.getElementById('btnTutupDetail').addEventListener('click', function () {
        tutupModal(detailModal);
    });

    document.querySelectorAll('.btn-lihat-kalender').forEach(function (button) {
        button.addEventListener('click', function () {
            document.getElementById('detailNamaFile').textContent =
                this.dataset.file;
            bukaModal(detailModal);
        });
    });

    [modal, detailModal].forEach(function (element) {
        element.addEventListener('click', function (event) {
            if (event.target === element) {
                tutupModal(element);
            }
        });
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        alert('Form tampilan berhasil diuji. Penyimpanan dokumen belum dihubungkan ke backend.');
        form.reset();
        tutupModal(modal);
    });
});
</script>
@endsection
