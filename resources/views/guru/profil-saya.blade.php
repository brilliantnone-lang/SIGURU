
@extends('layouts.app')

@section('title', 'Profil Saya')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<div class="profil-page">

    {{-- Header --}}
    <div class="profil-header">
        <h2>Profil {{ Auth::user()->name }}</h2>
        <p>Kelola informasi profil dan keamanan akun Anda</p>
    </div>

    {{-- Kartu Identitas Guru --}}
    <section class="profil-identity">
        <div class="profil-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>

        <div class="identity-info">
            <h3>{{ Auth::user()->name }}</h3>
            <p>Guru Bahasa Indonesia</p>
            <span class="guru-active">
                <i class="bi bi-check-circle"></i>
                Guru Aktif
            </span>
        </div>
    </section>

    {{-- Detail Profil --}}
    <div class="profil-grid">

        {{-- Informasi Pribadi --}}
        <section class="profil-card personal-card">
            <div class="profil-card-header">
                <i class="bi bi-person"></i>
                <div class="card-heading-text">
                    <h3>Informasi Pribadi</h3>
                    <p>Data akun dan identitas guru</p>
                </div>

                <button type="button" class="btn-edit-contact" id="btn-edit-profil">
                    <i class="bi bi-pencil-fill"></i>
                    Edit Kontak
                </button>
            </div>

            <div class="personal-info-grid">
                <div class="personal-info-item">
                    <span>Nama Lengkap</span>
                    <strong>{{ Auth::user()->name }}</strong>
                </div>

                <div class="personal-info-item">
                    <span>NIP</span>
                    <strong>19870512 201403 2 004</strong>
                </div>

                <div class="personal-info-item">
                    <span>Username</span>
                    <strong>{{ Auth::user()->username }}</strong>
                </div>

                <div class="personal-info-item">
                    <span>Nomor Telepon</span>
                    <strong id="display-phone">0812-3456-7890</strong>
                </div>
            </div>
        </section>

        {{-- Mata Pelajaran Linear --}}
        <section class="profil-card subject-card">
            <div class="profil-card-header">
                <i class="bi bi-mortarboard"></i>
                <div class="card-heading-text">
                    <h3>Mata Pelajaran Linear</h3>
                </div>
            </div>

            <p class="subject-description">Penugasan mata pelajaran tetap</p>

            <div class="subject-info">
                <i class="bi bi-book"></i>
                <div>
                    <strong>Bahasa Indonesia</strong>
                    <p>Kelas VII, VIII, IX · Tahun Ajaran 2026/2027</p>
                </div>
                <i class="bi bi-check-circle subject-check"></i>
            </div>
        </section>

    </div>

    {{-- Modal Edit Kontak --}}
    <div class="profil-modal-overlay" id="profil-modal" hidden>
        <div class="profil-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="modal-header">
                <h3 id="modal-title">Edit Kontak</h3>
                <button type="button" id="btn-close-modal" class="btn-close-modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form id="form-edit-profil">
                <label for="input-phone">Nomor Telepon</label>
                <input
                    type="tel"
                    id="input-phone"
                    name="phone"
                    value="0812-3456-7890"
                    placeholder="Masukkan nomor telepon"
                    required
                >

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btn-cancel-modal">
                        Batal
                    </button>
                    <button type="submit" class="btn-save-contact">
                        Simpan
                    </button>
                </div>
                <p class="modal-note">
                    Perubahan ini hanya untuk pratinjau frontend dan belum disimpan ke database.
                </p>
            </form>
        </div>
    </div>

</div>

<style>
    .profil-page {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    .profil-header {
        margin: 0 0 22px 5px;
    }

    .profil-header h2 {
        margin: 0 0 7px;
        font-size: 23px;
        font-weight: 650;
        color: #111;
    }

    .profil-header p {
        margin: 0;
        font-size: 10px;
        color: #555;
    }

    .profil-identity {
        display: flex;
        align-items: center;
        gap: 16px;
        min-height: 99px;
        padding: 16px 27px;
        margin-bottom: 24px;
        border-radius: 26px;
        background: #e6eee9;
        box-shadow: 0 4px 9px rgba(0, 0, 0, .18);
    }

    .profil-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 59px;
        height: 59px;
        min-width: 59px;
        border: 4px solid #fff;
        border-radius: 50%;
        background: #9bc7b4;
        color: #245541;
        font-size: 19px;
        font-weight: 700;
    }

    .identity-info h3 {
        margin: 0 0 5px;
        color: #245541;
        font-size: 16px;
        font-weight: 500;
    }

    .identity-info p {
        margin: 0 0 6px;
        color: #89938d;
        font-size: 9px;
    }

    .guru-active {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 7px;
        border-radius: 12px;
        background: #fff;
        color: #39765f;
        font-size: 8px;
        font-weight: 600;
    }

    .profil-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(220px, 1fr);
        gap: 14px;
        align-items: stretch;
        padding: 0 3px;
    }

    .profil-card {
        min-width: 0;
        padding: 17px 19px;
        border-radius: 27px;
        background: #fff;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .18);
    }

    .profil-card-header {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 15px;
    }

    .profil-card-header > i {
        color: #245541;
        font-size: 19px;
    }

    .card-heading-text {
        min-width: 0;
        flex: 1;
    }

    .card-heading-text h3 {
        margin: 1px 0 3px;
        font-size: 12px;
        font-weight: 700;
        color: #244c39;
        white-space: nowrap;
    }

    .card-heading-text p {
        margin: 0;
        font-size: 8px;
        color: #929b95;
    }

    .btn-edit-contact {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 2px 0;
        border: none;
        background: transparent;
        color: #244c39;
        font-size: 8px;
        font-weight: 650;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-edit-contact:hover {
        color: #39765f;
    }

    .personal-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 17px;
        row-gap: 12px;
        padding-left: 13px;
    }

    .personal-info-item {
        min-width: 0;
    }

    .personal-info-item span {
        display: block;
        margin-bottom: 5px;
        color: #89938d;
        font-size: 8px;
    }

    .personal-info-item strong {
        display: block;
        overflow-wrap: anywhere;
        color: #244c39;
        font-size: 8px;
        font-weight: 650;
    }

    .subject-card {
        padding-left: 18px;
        padding-right: 15px;
    }

    .subject-card .profil-card-header {
        margin-bottom: 15px;
    }

    .subject-description {
        margin: 0 0 14px;
        color: #89938d;
        font-size: 8px;
    }

    .subject-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .subject-info > i:first-child {
        color: #62a784;
        font-size: 18px;
    }

    .subject-info > div {
        flex: 1;
        min-width: 0;
    }

    .subject-info strong {
        display: block;
        margin-bottom: 4px;
        color: #245541;
        font-size: 8px;
        font-weight: 650;
    }

    .subject-info p {
        margin: 0;
        color: #89938d;
        font-size: 7px;
        line-height: 1.5;
    }

    .subject-info .subject-check {
        color: #245541;
        font-size: 12px;
    }

    /* Modal edit kontak */
    .profil-modal-overlay[hidden] {
        display: none;
    }

    .profil-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, .35);
    }

    .profil-modal {
        width: 100%;
        max-width: 390px;
        padding: 22px;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 30px rgba(0, 0, 0, .18);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        color: #245541;
    }

    .btn-close-modal {
        border: none;
        background: transparent;
        color: #777;
        cursor: pointer;
    }

    #form-edit-profil label {
        display: block;
        margin-bottom: 7px;
        font-size: 12px;
        font-weight: 600;
    }

    #form-edit-profil input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ced8d2;
        border-radius: 7px;
        font: inherit;
        font-size: 13px;
        box-sizing: border-box;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 18px;
    }

    .modal-actions button {
        padding: 9px 14px;
        border-radius: 6px;
        font: inherit;
        font-size: 12px;
        cursor: pointer;
    }

    .btn-cancel {
        border: 1px solid #ccc;
        background: #fff;
        color: #555;
    }

    .btn-save-contact {
        border: 1px solid #39765f;
        background: #39765f;
        color: #fff;
    }

    .modal-note {
        margin: 12px 0 0;
        color: #999;
        font-size: 10px;
        line-height: 1.5;
    }

    @media (max-width: 760px) {
        .profil-grid {
            grid-template-columns: 1fr;
        }

        .profil-identity {
            padding: 15px 18px;
            border-radius: 20px;
        }

        .profil-card {
            border-radius: 20px;
        }
    }

    @media (max-width: 420px) {
        .profil-header h2 {
            font-size: 20px;
        }

        .personal-info-grid {
            padding-left: 0;
            column-gap: 10px;
        }

        .card-heading-text h3 {
            white-space: normal;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('profil-modal');
        const editButton = document.getElementById('btn-edit-profil');
        const closeButton = document.getElementById('btn-close-modal');
        const cancelButton = document.getElementById('btn-cancel-modal');
        const form = document.getElementById('form-edit-profil');
        const phoneInput = document.getElementById('input-phone');
        const phoneDisplay = document.getElementById('display-phone');

        function closeModal() {
            modal.hidden = true;
        }

        editButton.addEventListener('click', function () {
            phoneInput.value = phoneDisplay.textContent.trim();
            modal.hidden = false;
            phoneInput.focus();
        });

        closeButton.addEventListener('click', closeModal);
        cancelButton.addEventListener('click', closeModal);

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            phoneDisplay.textContent = phoneInput.value.trim();
            closeModal();

            alert('Nomor telepon diperbarui untuk pratinjau. Perubahan belum disimpan ke database.');
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !modal.hidden) {
                closeModal();
            }
        });
    });
</script>
@endsection
