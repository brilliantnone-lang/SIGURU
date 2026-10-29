@extends('layouts.app')

@section('title', 'Unggah Bahan Ajar')

@section('content')
<div class="unggah-page">
    <div class="page-heading">
        <h2>Unggah Bahan Ajar</h2>
        <p>Tambahkan materi untuk mendukung pembelajaran.</p>
    </div>

    <div class="unggah-card">
        <form action="{{ route('guru.bahan-ajar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="form-group">
                <label for="judul_materi">Judul Materi <span>*</span></label>
                <input type="text" id="judul_materi" name="judul_materi" value="{{ old('judul_materi') }}" placeholder="Contoh: Modul Ajar Teks Deskripsi" required>
            </div>

            <div class="form-group">
                <label for="kelas_id">Kelas <span>*</span></label>
                <select id="kelas_id" name="kelas_id" required style="width:100%; min-height:48px; padding:11px 13px; border:1px solid #c8c8c8; border-radius:8px; background:#fff; color:#333; font-family:inherit; font-size:15px; outline:none; transition:border-color .2s, box-shadow .2s;">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan (Opsional)</label>
                <textarea id="catatan" name="catatan" rows="3" placeholder="Contoh: Untuk pertemuan ke-3 / Panduan Semester Ganjil" style="width:100%; padding:11px 13px; border:1px solid #c8c8c8; border-radius:8px; background:#fff; color:#333; font-family:inherit; font-size:15px; outline:none;">{{ old('catatan') }}</textarea>
            </div>

            <div class="form-group file-group">
                <label for="file_bahan_ajar">File Bahan Ajar <span>*</span></label>
                <label for="file_bahan_ajar" class="upload-box">
                    <input type="file" id="file_bahan_ajar" name="file_bahan_ajar" accept=".pdf,.doc,.docx" required>
                    <div class="upload-content" id="uploadContent">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <strong>Klik untuk memilih file</strong>
                        <span>PDF, DOC, atau DOCX - Batas Ukuran 3 MB</span>
                    </div>
                    <div class="selected-file" id="selectedFile" hidden>
                        <i class="bi bi-file-earmark-check"></i>
                        <strong id="fileName"></strong>
                        <span id="fileSize"></span>
                        <small>Klik area ini untuk mengganti file</small>
                    </div>
                </label>
                <small id="fileError" class="file-error"></small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-simpan">SIMPAN</button>
                <a href="{{ route('guru.bahan-ajar') }}" class="btn-batalkan">BATALKAN</a>
            </div>
        </form>
    </div>
</div>

<style>
    .unggah-page {
        width: 100%;
        color: #26332F;
        font-family: inherit;
        padding-bottom: 20px;
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

    /* KARTU FORM */
    .unggah-card {
        width: 100%;
        box-sizing: border-box;
        padding: 20px;
        background: #fff;
        border: 1px solid #B9D0C5;
        border-radius: 10px;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .08);
    }

    /* INPUT */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 18px;
    }

    .form-group>label:not(.upload-box) {
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

    /* AREA UPLOAD */
    .file-group {
        margin-top: 3px;
        margin-bottom: 20px;
    }

    .upload-box {
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        width: 100%;
        min-height: 130px;
        padding: 15px;
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
        white-space: nowrap;
        clip-path: inset(50%);
    }

    .upload-content,
    .selected-file {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 5px;
        max-width: 100%;
        text-align: center;
        color: #39765f;
    }

    .upload-content i,
    .selected-file>i {
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

    .selected-file small {
        margin-top: 4px;
        color: #638574;
        font-size: 11px;
    }

    [hidden] {
        display: none !important;
    }

    .file-error {
        color: #dc2626;
        font-size: 12px;
    }

    /* TOMBOL */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 24px;
    }

    .btn-simpan,
    .btn-batalkan {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 145px;
        min-height: 48px;
        box-sizing: border-box;
        padding: 11px 24px;
        border: none;
        border-radius: 17px;
        font-family: inherit;
        font-size: 17px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, transform .2s;
    }

    .btn-simpan {
        background: #96e9c6;
        color: #39765f;
    }

    .btn-simpan:hover {
        background: #7cdbb4;
    }

    .btn-batalkan {
        background: #ff9b4a;
        color: #a95717;
    }

    .btn-batalkan:hover {
        background: #f58a35;
        color: #87400e;
    }

    .btn-simpan:active,
    .btn-batalkan:active {
        transform: scale(.98);
    }

    /* RESPONSIVE */
    @media (max-width: 576px) {
        .page-heading h2 {
            font-size: 25px;
        }

        .page-heading p {
            font-size: 12px;
        }

        .unggah-card {
            padding: 14px;
        }

        .form-group>label:not(.upload-box) {
            font-size: 15px;
        }

        .form-group input[type="text"] {
            min-height: 43px;
            font-size: 13px;
        }

        .upload-box {
            min-height: 115px;
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
            gap: 12px;
        }

        .btn-simpan,
        .btn-batalkan {
            min-width: 120px;
            min-height: 43px;
            padding: 10px 17px;
            font-size: 14px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file_bahan_ajar');
        const uploadContent = document.getElementById('uploadContent');
        const selectedFile = document.getElementById('selectedFile');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileError = document.getElementById('fileError');

        const maxSize = 3 * 1024 * 1024;
        const allowedExtensions = ['pdf', 'doc', 'docx'];

        fileInput.addEventListener('change', function() {
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