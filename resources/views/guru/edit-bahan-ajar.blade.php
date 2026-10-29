@extends('layouts.app')

@section('title', 'Edit Bahan Ajar')

@section('content')
<div class="edit-bahan-page">

    {{-- HEADER --}}
    <div class="page-heading">
        <h2>Edit Bahan Ajar</h2>
        <p>Perbarui materi untuk mendukung pembelajaran.</p>
    </div>

    {{-- FORM EDIT --}}
    <div class="edit-card">

        <div class="card-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Edit Bahan Ajar</h3>
                <p>Ubah informasi materi atau ganti file bahan ajar.</p>
            </div>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- JUDUL MATERI --}}
            <div class="form-group">
                <label for="judul_materi">
                    Judul Materi <span>*</span>
                </label>

                <input
                    type="text"
                    id="judul_materi"
                    name="judul_materi"
                    value="{{ old('judul_materi', $bahanAjar->judul_materi ?? '') }}"
                    placeholder="Contoh: Modul Ajar Teks Deskripsi"
                    required
                >
            </div>

            {{-- KELAS --}}
            <div class="form-group">
                <label for="kelas">
                    Kelas <span>*</span>
                </label>

                <input
                    type="text"
                    id="kelas"
                    name="kelas"
                    value="{{ old('kelas', $bahanAjar->kelas ?? '') }}"
                    placeholder="Contoh: VII"
                    required
                >
            </div>

            {{-- FILE BAHAN AJAR --}}
            <div class="form-group file-group">
                <label for="file_bahan_ajar">
                    File Bahan Ajar
                </label>

                <label for="file_bahan_ajar" class="upload-box">
                    <input
                        type="file"
                        id="file_bahan_ajar"
                        name="file_bahan_ajar"
                        accept=".pdf,.doc,.docx"
                    >

                    <div class="upload-content" id="uploadContent">
                        <i class="bi bi-cloud-arrow-up"></i>

                        <strong>Klik untuk mengganti file</strong>

                        <span>PDF, DOC, atau DOCX - Batas Ukuran 3 MB</span>

                        @if(!empty($bahanAjar->file_bahan_ajar))
                            <small class="current-file">
                                File saat ini:
                                {{ basename($bahanAjar->file_bahan_ajar) }}
                            </small>
                        @else
                            <small class="current-file">
                                Belum ada file yang tersimpan.
                            </small>
                        @endif
                    </div>

                    <div class="selected-file" id="selectedFile" hidden>
                        <i class="bi bi-file-earmark-check"></i>
                        <strong id="fileName"></strong>
                        <span id="fileSize"></span>
                        <small>Klik area ini untuk mengganti file</small>
                    </div>
                </label>

                <small class="field-note">
                    Kosongkan bagian ini jika tidak ingin mengganti file.
                </small>

                <small id="fileError" class="file-error"></small>
            </div>

            {{-- TOMBOL --}}
            <div class="form-actions">
                <a href="{{ route('guru.bahan-ajar') }}" class="btn-cancel">
                    Batal
                </a>

                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<style>
    .edit-bahan-page {
        width: 100%;
        padding-bottom: 20px;
        color: #26332F;
        font-family: inherit;
    }

    /* HEADER */
    .page-heading {
        margin-bottom: 22px;
    }

    .page-heading h2 {
        margin: 0 0 5px;
        color: #111;
        font-size: 30px;
        line-height: 1.3;
        font-weight: 500;
    }

    .page-heading p {
        margin: 0;
        color: #999;
        font-size: 14px;
        font-weight: 300;
    }

    /* KARTU */
    .edit-card {
        box-sizing: border-box;
        width: 100%;
        padding: 20px;
        background: #fff;
        border: 1px solid #B9D0C5;
        border-radius: 10px;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .08);
    }

    .card-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
    }

    .card-heading > i {
        color: #39765f;
        font-size: 28px;
    }

    .card-heading h3 {
        margin: 0 0 4px;
        color: #171717;
        font-size: 17px;
        font-weight: 700;
    }

    .card-heading p {
        margin: 0;
        color: #999;
        font-size: 11px;
    }

    /* FORM */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 20px;
    }

    .form-group > label:not(.upload-box) {
        color: #111;
        font-size: 17px;
        font-weight: 700;
    }

    .form-group label span {
        color: #ef4444;
    }

    .form-group input[type="text"] {
        box-sizing: border-box;
        width: 100%;
        min-height: 48px;
        padding: 11px 13px;
        border: 1px solid #c8c8c8;
        border-radius: 8px;
        background: #fff;
        color: #333;
        font-family: inherit;
        font-size: 15px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .form-group input[type="text"]::placeholder {
        color: #aaa;
    }

    .form-group input[type="text"]:focus {
        border-color: #39765f;
        box-shadow: 0 0 0 3px rgba(57, 118, 95, .12);
    }

    /* AREA UNGGAH FILE */
    .file-group {
        margin-bottom: 12px;
    }

    .upload-box {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        width: 100%;
        min-height: 145px;
        padding: 16px;
        border: 2px solid #d8efdf;
        border-radius: 11px;
        background: #e0f0e7;
        cursor: pointer;
        transition: background .2s, border-color .2s;
    }

    .upload-box:hover {
        background: #d7ebdf;
        border-color: #9acbb1;
    }

    .upload-box input[type="file"] {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        clip-path: inset(50%);
        white-space: nowrap;
    }

    .upload-content,
    .selected-file {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 6px;
        max-width: 100%;
        text-align: center;
        color: #39765f;
    }

    .upload-content i,
    .selected-file > i {
        font-size: 43px;
        line-height: 1;
    }

    .upload-content strong,
    .selected-file strong {
        max-width: 100%;
        color: #39765f;
        font-size: 18px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .upload-content span,
    .selected-file span {
        color: #39765f;
        font-size: 14px;
    }

    .current-file,
    .selected-file small {
        max-width: 100%;
        margin-top: 3px;
        color: #638574;
        font-size: 11px;
        overflow-wrap: anywhere;
    }

    .field-note {
        color: #777;
        font-size: 11px;
    }

    .file-error {
        color: #dc2626;
        font-size: 12px;
    }

    [hidden] {
        display: none !important;
    }

    /* TOMBOL BATAL DAN SIMPAN */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 24px;
    }

    .btn-cancel,
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        min-height: 45px;
        padding: 10px 22px;
        border-radius: 11px;
        font-family: inherit;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .btn-cancel {
        border: 1px solid #555;
        background: #fff;
        color: #555;
    }

    .btn-cancel:hover {
        background: #f5f5f5;
        color: #333;
    }

    .btn-save {
        border: 1px solid #39765f;
        background: #39765f;
        color: #fff;
    }

    .btn-save:hover {
        border-color: #2e624e;
        background: #2e624e;
        color: #fff;
    }

    @media (max-width: 576px) {
        .page-heading h2 {
            font-size: 25px;
        }

        .page-heading p {
            font-size: 12px;
        }

        .edit-card {
            padding: 14px;
        }

        .form-group > label:not(.upload-box) {
            font-size: 15px;
        }

        .form-group input[type="text"] {
            min-height: 43px;
            font-size: 13px;
        }

        .upload-box {
            min-height: 125px;
        }

        .upload-content strong,
        .selected-file strong {
            font-size: 15px;
        }

        .upload-content span,
        .selected-file span {
            font-size: 11px;
        }

        .form-actions {
            gap: 8px;
        }

        .btn-cancel,
        .btn-save {
            min-height: 40px;
            padding: 9px 12px;
            font-size: 13px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('file_bahan_ajar');
    const uploadContent = document.getElementById('uploadContent');
    const selectedFile = document.getElementById('selectedFile');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileError = document.getElementById('fileError');

    const maxSize = 3 * 1024 * 1024;
    const allowedExtensions = ['pdf', 'doc', 'docx'];

    fileInput.addEventListener('change', function () {
        fileError.textContent = '';

        const file = fileInput.files[0];

        if (!file) {
            uploadContent.hidden = false;
            selectedFile.hidden = true;
            return;
        }

        const extension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(extension)) {
            fileError.textContent = 'Format file harus PDF, DOC, atau DOCX.';
            fileInput.value = '';
            uploadContent.hidden = false;
            selectedFile.hidden = true;
            return;
        }

        if (file.size > maxSize) {
            fileError.textContent = 'Ukuran file maksimal 3 MB.';
            fileInput.value = '';
            uploadContent.hidden = false;
            selectedFile.hidden = true;
            return;
        }

        fileName.textContent = file.name;
        fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';

        uploadContent.hidden = true;
        selectedFile.hidden = false;
    });
});
</script>
@endsection