@extends('layouts.app')

@section('title', 'Tambah Jurnal Harian Guru')

@section('content')
<div class="create-jurnal-page">

    {{-- HEADER HALAMAN --}}
    <div class="page-heading">
        <h2>Jurnal Harian Guru</h2>
        <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
    </div>

    {{-- KARTU FORMULIR --}}
    <div class="form-card">

        <div class="form-card-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Isi Jurnal Mengajar</h3>
                <p>Lengkapi informasi pembelajaran di bawah ini</p>
            </div>
        </div>

        {{-- STATUS MENGAJAR --}}
        <div class="teaching-status-box">
            <h4>Status Mengajar</h4>
            <p>Pilih peran Anda pada sesi pembelajaran ini.</p>

            <div class="teaching-options">
                <label class="teaching-option active">
                    <input type="radio" name="status_mengajar"
                           value="pengampu" checked>
                    <span>Guru Pengampu</span>
                </label>

                <label class="teaching-option">
                    <input type="radio" name="status_mengajar"
                           value="pengganti">
                    <span>Guru Pengganti</span>
                </label>
            </div>
        </div>

        {{-- FORM INPUT --}}
        <form action="#" method="POST" enctype="multipart/form-data"
              id="formTambahJurnal">
            @csrf

            <div class="form-grid">

                {{-- TANGGAL --}}
                <div class="form-group">
                    <label for="tanggal">
                        Tanggal Mengajar <span class="required">*</span>
                    </label>
                    <input type="date" id="tanggal" name="tanggal"
                           value="{{ date('Y-m-d') }}" required>
                </div>

                {{-- KELAS --}}
                <div class="form-group">
                    <label for="kelas_id">
                        Kelas <span class="required">*</span>
                    </label>
                    <select id="kelas_id" name="kelas_id" required>
                        <option value="">Pilih Kelas</option>
                        <option value="1">VII A</option>
                        <option value="2">VII B</option>
                        <option value="3">VIII A</option>
                        <option value="4">VIII B</option>
                        <option value="5">IX A</option>
                    </select>
                </div>

                {{-- MATA PELAJARAN --}}
                <div class="form-group">
                    <label for="mata_pelajaran">
                        Mata Pelajaran <span class="required">*</span>
                    </label>
                    <input type="text" id="mata_pelajaran"
                           name="mata_pelajaran"
                           placeholder="Masukkan mata pelajaran" required>
                </div>

                {{-- JAM PELAJARAN --}}
                <div class="form-group">
                    <label for="jam_pelajaran">
                        Jam Pelajaran <span class="required">*</span>
                    </label>
                    <select id="jam_pelajaran" name="jam_pelajaran" required>
                        <option value="">Pilih Jam Pelajaran</option>
                        <option value="1-2">Jam ke 1-2</option>
                        <option value="3-4">Jam ke 3-4</option>
                        <option value="5-6">Jam ke 5-6</option>
                        <option value="7-8">Jam ke 7-8</option>
                    </select>
                </div>

                {{-- POKOK BAHASAN --}}
                <div class="form-group full-width">
                    <label for="pokok_bahasan">
                        Pokok Bahasan/Materi <span class="required">*</span>
                    </label>
                    <input type="text" id="pokok_bahasan"
                           name="pokok_bahasan"
                           placeholder="Tuliskan pokok bahasan yang diajarkan hari ini"
                           required>
                </div>

                {{-- STATUS PENYELESAIAN --}}
                <div class="form-group">
                    <label for="status_penyelesaian">
                        Status Penyelesaian <span class="required">*</span>
                    </label>
                    <select id="status_penyelesaian"
                            name="status_penyelesaian" required>
                        <option value="selesai">Tuntas</option>
                        <option value="belum_selesai">Belum Selesai</option>
                    </select>
                </div>

                {{-- SEMESTER --}}
                <div class="form-group">
                    <label for="semester">
                        Status Jurnal / Semester <span class="required">*</span>
                    </label>
                    <select id="semester" name="semester" required>
                        <option value="2026/2027-Ganjil">
                            2026/2027 Semester Ganjil
                        </option>
                        <option value="2026/2027-Genap">
                            2026/2027 Semester Genap
                        </option>
                    </select>
                </div>

                {{-- ALASAN BELUM SELESAI --}}
                <div class="form-group full-width"
                     id="alasanGroup" hidden>
                    <label for="alasan_belum_selesai">
                        Alasan Belum Selesai <span class="required">*</span>
                    </label>
                    <textarea id="alasan_belum_selesai"
                              name="alasan_belum_selesai" rows="2"
                              placeholder="Jelaskan alasan materi belum selesai"></textarea>
                </div>

                {{-- ABSENSI --}}
                <div class="form-group full-width attendance-group">
                    <label>
                        Absensi Siswa <span class="required">*</span>
                    </label>

                    <label class="radio-line">
                        <input type="radio" name="sumber_absensi"
                               value="otomatis" checked>
                        <span>Ambil Data dari Absensi Siswa</span>
                    </label>

                    <label class="radio-line disabled-option">
                        <input type="radio" name="sumber_absensi"
                               value="manual" disabled>
                        <span>Masukkan Data Absen Sendiri</span>
                    </label>
                </div>

                {{-- CATATAN TAMBAHAN --}}
                <div class="form-group full-width">
                    <label for="keterangan">Catatan Tambahan</label>
                    <input type="text" id="keterangan" name="keterangan"
                           placeholder="Catatan atau evaluasi pembelajaran (opsional)">
                </div>

                {{-- FOTO KEGIATAN --}}
                <div class="form-group full-width">
                    <label for="foto_kegiatan">Foto Kegiatan</label>

                    <label class="upload-box" for="foto_kegiatan">
                        <input type="file" id="foto_kegiatan"
                               name="foto_kegiatan"
                               accept="image/jpeg,image/png"
                               hidden>

                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <i class="bi bi-image-fill"></i>
                            <i class="bi bi-grid-fill"></i>
                            <strong>Klik untuk pilih foto kegiatan pembelajaran</strong>
                            <span>JPG atau PNG - Batas Ukuran 3 MB</span>
                        </div>

                        <img id="previewFoto" alt="Pratinjau foto kegiatan"
                             hidden>
                    </label>

                    <small class="upload-error" id="uploadError"></small>
                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="form-actions">
                <a href="{{ url()->previous() }}" class="btn-cancel">
                    Batal
                </a>

                <button type="submit" class="btn-save">
                    Simpan Jurnal
                </button>
            </div>

        </form>
    </div>
</div>

<style>
    .create-jurnal-page {
        width: 100%;
        max-width: 100%;
        color: #202720;
        font-family: inherit;
        padding-bottom: 15px;
    }

    .page-heading {
        margin: 0 0 14px;
    }

    .page-heading h2 {
        margin: 0 0 6px;
        color: #111;
        font-size: 26px;
        line-height: 1.3;
        font-weight: 700;
    }

    .page-heading p {
        margin: 0;
        color: #858585;
        font-size: 12px;
        line-height: 1.5;
    }

    .form-card {
        padding: 13px 15px 15px;
        background: #fff;
        border: 1px solid #b9d0c5;
        border-radius: 7px;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .12);
    }

    .form-card-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 12px;
    }

    .form-card-heading > i {
        flex-shrink: 0;
        font-size: 27px;
        color: #39765f;
    }

    .form-card-heading h3 {
        margin: 0 0 3px;
        color: #171717;
        font-size: 16px;
        font-weight: 700;
    }

    .form-card-heading p {
        margin: 0;
        color: #999;
        font-size: 10px;
    }

    .teaching-status-box {
        margin-bottom: 13px;
        padding: 12px;
        border: 2px solid #d2e4db;
        border-radius: 12px;
        background: #effaf5;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
    }

    .teaching-status-box h4 {
        margin: 0 0 4px;
        color: #161f1a;
        font-size: 14px;
        font-weight: 700;
    }

    .teaching-status-box > p {
        margin: 0 0 9px;
        color: #999;
        font-size: 10px;
    }

    .teaching-options {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .teaching-option {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 10px;
        border: 1px solid #d5ded9;
        border-radius: 9px;
        background: #fff;
        color: #929a95;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: .15s ease;
    }

    .teaching-option input,
    .radio-line input {
        margin: 0;
        accent-color: #39765f;
        cursor: pointer;
    }

    .teaching-option.active {
        border-color: #8cc8ad;
        background: #d9f8e9;
        color: #39765f;
    }

    .form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        column-gap: 38px;
        row-gap: 10px;
        padding: 0 12px;
    }

    .form-group {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 5px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group > label:not(.radio-line):not(.upload-box) {
        margin: 0;
        color: #111;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.3;
    }

    .required {
        color: #dc2626;
    }

    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group select,
    .form-group textarea {
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        min-height: 30px;
        padding: 5px 8px;
        border: 1px solid #bdbdbd;
        border-radius: 8px;
        outline: none;
        background: #fff;
        color: #303030;
        font-family: inherit;
        font-size: 12px;
        transition: border-color .15s, box-shadow .15s;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 60px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #39765f;
        box-shadow: 0 0 0 2px rgba(57, 118, 95, .12);
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #999;
        opacity: 1;
    }

    .attendance-group {
        gap: 8px;
    }

    .attendance-group > label:first-child {
        margin-bottom: 1px;
    }

    .radio-line {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 18px;
        margin: 0;
        color: #444;
        font-size: 12px;
        font-weight: 400;
        cursor: pointer;
    }

    .radio-line input {
        width: 12px;
        height: 12px;
        flex-shrink: 0;
    }

    .disabled-option {
        color: #c5c5c5;
        cursor: not-allowed;
    }

    .disabled-option input {
        cursor: not-allowed;
    }

    .upload-box {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        min-height: 102px;
        padding: 10px;
        border: 2px solid #d2e4db;
        border-radius: 11px;
        background: #effaf5;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
        cursor: pointer;
        transition: background .15s, border-color .15s;
    }

    .upload-box:hover {
        border-color: #8ebda6;
        background: #e7f6ee;
    }

    .upload-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 4px;
        text-align: center;
        color: #39765f;
    }

    .upload-placeholder > i:first-child {
        font-size: 26px;
        line-height: 1;
    }

    .upload-placeholder > i:nth-child(2) {
        display: none;
    }

    .upload-placeholder strong {
        margin-top: 5px;
        font-size: 13px;
        font-weight: 700;
    }

    .upload-placeholder span {
        font-size: 11px;
    }

    #previewFoto {
        display: block;
        max-width: 100%;
        max-height: 240px;
        border-radius: 6px;
        object-fit: contain;
    }

    #previewFoto[hidden],
    .upload-placeholder[hidden] {
        display: none;
    }

    .upload-error {
        color: #b91c1c;
        font-size: 11px;
    }

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
        margin-top: 13px;
    }

    .btn-cancel,
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 34px;
        padding: 7px 12px;
        border-radius: 5px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s;
    }

    .btn-cancel {
        border: 1px solid #aaa;
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
    }

    @media (max-width: 650px) {
        .page-heading h2 {
            font-size: 22px;
        }

        .form-card {
            padding: 12px 10px;
        }

        .form-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 12px;
            padding: 0 2px;
        }

        .form-group.full-width {
            grid-column: auto;
        }

        .teaching-option {
            font-size: 12px;
        }

        .form-actions {
            margin-top: 15px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Pilihan status mengajar
    const teachingOptions = document.querySelectorAll('.teaching-option');

    teachingOptions.forEach(function (option) {
        option.querySelector('input').addEventListener('change', function () {
            teachingOptions.forEach(function (item) {
                item.classList.toggle(
                    'active',
                    item.querySelector('input').checked
                );
            });
        });
    });

    // Tampilkan alasan jika materi belum selesai
    const statusSelect = document.getElementById('status_penyelesaian');
    const alasanGroup = document.getElementById('alasanGroup');
    const alasanInput = document.getElementById('alasan_belum_selesai');

    function updateAlasan() {
        const belumSelesai = statusSelect.value === 'belum_selesai';

        alasanGroup.hidden = !belumSelesai;
        alasanInput.required = belumSelesai;

        if (!belumSelesai) {
            alasanInput.value = '';
        }
    }

    statusSelect.addEventListener('change', updateAlasan);
    updateAlasan();

    // Pratinjau foto kegiatan
    const fotoInput = document.getElementById('foto_kegiatan');
    const previewFoto = document.getElementById('previewFoto');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const uploadError = document.getElementById('uploadError');
    const maxSize = 3 * 1024 * 1024;

    fotoInput.addEventListener('change', function () {
        const file = fotoInput.files[0];

        uploadError.textContent = '';

        if (!file) {
            previewFoto.hidden = true;
            previewFoto.removeAttribute('src');
            uploadPlaceholder.hidden = false;
            return;
        }

        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            uploadError.textContent = 'Foto harus berformat JPG atau PNG.';
            fotoInput.value = '';
            previewFoto.hidden = true;
            uploadPlaceholder.hidden = false;
            return;
        }

        if (file.size > maxSize) {
            uploadError.textContent = 'Ukuran foto maksimal 3 MB.';
            fotoInput.value = '';
            previewFoto.hidden = true;
            uploadPlaceholder.hidden = false;
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            previewFoto.src = event.target.result;
            previewFoto.hidden = false;
            uploadPlaceholder.hidden = true;
        };

        reader.readAsDataURL(file);
    });
});
</script>
@endsection