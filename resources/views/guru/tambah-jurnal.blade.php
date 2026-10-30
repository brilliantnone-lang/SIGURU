@extends('layouts.app')

@section('title', 'Tambah Jurnal Harian')

@section('content')
<style>
    .jurnal-page {
        width: 100%;
        color: #17221c;
        font-family: inherit;
    }

    .jurnal-page *,
    .jurnal-page *::before,
    .jurnal-page *::after {
        box-sizing: border-box;
    }

    .jurnal-header {
        margin: 0 0 23px 5px;
    }

    .jurnal-header h2 {
        margin: 0 0 6px;
        color: #173d2b;
        font-size: 26px;
        font-weight: 700;
    }

    .jurnal-header p {
        margin: 0;
        color: #7d8580;
        font-size: 12px;
    }

    .jurnal-card {
        width: 100%;
        padding: 22px 24px;
        background: #fff;
        border: 1px solid #c7d9cf;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(25, 55, 39, .12);
    }

    .jurnal-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 23px;
    }

    .jurnal-heading i {
        color: #39745b;
        font-size: 34px;
    }

    .jurnal-heading h3 {
        margin: 0 0 5px;
        font-size: 21px;
        font-weight: 700;
    }

    .jurnal-heading p {
        margin: 0;
        color: #858b87;
        font-size: 12px;
    }

    /* PANEL HIJAU */
    .jurnal-panel {
        margin-bottom: 20px;
        padding: 12px;
        background: #eff9f4;
        border: 2px solid #d0e5d9;
        border-radius: 13px;
        box-shadow: 0 1px 3px rgba(39, 88, 62, .10);
    }

    .jurnal-panel-title {
        margin: 0 0 5px;
        font-size: 17px;
        line-height: 1.4;
        font-weight: 700;
    }

    .jurnal-panel-description {
        margin: 0 0 12px;
        color: #89928c;
        font-size: 10px;
    }

    /* STATUS MENGAJAR */
    .role-options {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .role-option {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 38px;
        padding: 7px 12px;
        color: #858d87;
        background: #fff;
        border: 1px solid #d6dfd9;
        border-radius: 10px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
    }

    .role-option input,
    .replacement-radio input,
    .attendance-method input {
        width: 15px;
        height: 15px;
        margin: 0;
        accent-color: #39745b;
        flex-shrink: 0;
    }

    .role-option:has(input:checked) {
        color: #39745b;
        background: #d8f6e8;
        border-color: #75c4a0;
    }

    .replacement-fields {
        display: none;
        margin-top: 14px;
    }

    .replacement-fields.active {
        display: block;
    }

    .replacement-options {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 14px;
        margin-bottom: 12px;
    }

    .replacement-radio {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin: 0;
        color: #737d76;
        cursor: pointer;
        font-size: 14px;
    }

    .replacement-radio:has(input:checked) {
        color: #171d19;
    }

    .replacement-label {
        display: block;
        margin: 0 0 6px;
        font-size: 17px;
        font-weight: 700;
    }

    .required {
        color: #ed3434;
    }

    /* FORM */
    .jurnal-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px 28px;
    }

    .jurnal-field {
        min-width: 0;
    }

    .jurnal-field.full {
        grid-column: 1 / -1;
    }

    .jurnal-field > label,
    .jurnal-field > .field-label {
        display: block;
        margin-bottom: 6px;
        font-size: 15px;
        font-weight: 700;
    }

    .jurnal-control {
        display: block;
        width: 100%;
        min-width: 0;
        height: 39px;
        padding: 8px 11px;
        color: #303832;
        background: #fff;
        border: 1px solid #b8c0ba;
        border-radius: 10px;
        outline: none;
        font-family: inherit;
        font-size: 13px;
    }

    .jurnal-control:focus {
        border-color: #5a9d79;
        box-shadow: 0 0 0 2px rgba(57, 116, 91, .10);
    }

    textarea.jurnal-control {
        min-height: 58px;
        height: auto;
        resize: vertical;
    }

    .field-help {
        display: block;
        margin-top: 5px;
        color: #78847b;
        font-size: 11px;
        line-height: 1.5;
    }

    /* ABSENSI */
    .attendance-panel {
        margin-bottom: 20px;
    }

    .attendance-methods {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin: 8px 0 14px;
    }

    .attendance-method {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
        color: #222a24;
        cursor: pointer;
        font-size: 14px;
        font-weight: 400;
    }

    .attendance-method:has(input:not(:checked)) {
        color: #c1c7c3;
    }

    .attendance-details {
        display: none;
    }

    .attendance-details.active {
        display: block;
    }

    /* Tata letak jumlah dan nama siswa */
    .manual-attendance-row {
        display: grid;
        grid-template-columns: 70px 46px minmax(0, 1fr);
        align-items: center;
        gap: 12px;
        margin-bottom: 9px;
    }

    .manual-attendance-label {
        font-size: 14px;
        font-weight: 700;
        text-align: right;
    }

    .manual-count {
        width: 46px;
        height: 35px;
        padding: 5px;
        text-align: center;
        background: #fff;
        border: 1px solid #b8c0ba;
        border-radius: 10px;
        font-size: 13px;
    }

    .manual-name-select {
        width: 100%;
        min-width: 0;
        height: 35px;
        padding: 5px 10px;
        background: #fff;
        border: 1px solid #b8c0ba;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
    }

    .manual-name-list {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-top: 7px;
    }

    .attendance-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .attendance-table th,
    .attendance-table td {
        padding: 9px;
        border-bottom: 1px solid #d9e7de;
        text-align: left;
    }

    .attendance-table th {
        color: #285b43;
        background: #e1f1e8;
    }

    .attendance-table select {
        width: 100%;
        min-width: 100px;
        padding: 7px;
        border: 1px solid #c7d6cc;
        border-radius: 7px;
        background: white;
    }

    .attendance-message {
        padding: 10px 4px;
        color: #78847b;
        font-size: 12px;
    }

    /* FOTO */
    .photo-upload {
        display: flex;
        min-height: 125px;
        padding: 18px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 7px;
        color: #39745b;
        background: #eff9f4;
        border: 2px solid #d0e5d9;
        border-radius: 13px;
        cursor: pointer;
        text-align: center;
    }

    .photo-upload i {
        font-size: 34px;
    }

    .photo-upload strong {
        font-size: 14px;
    }

    .photo-upload small {
        font-size: 11px;
    }

    .photo-preview {
        display: none;
        max-width: 100%;
        max-height: 250px;
        margin: 10px auto 0;
        border-radius: 8px;
    }

    /* TOMBOL */
    .jurnal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 15px;
    }

    .jurnal-btn {
        display: inline-flex;
        min-height: 39px;
        padding: 8px 15px;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        font-family: inherit;
        font-size: 13px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-cancel {
        color: #555;
        background: white;
        border: 1px solid #aaa;
    }

    .btn-save {
        color: white;
        background: #39745b;
        border: 1px solid #39745b;
        font-weight: 600;
    }

    .btn-save:hover {
        color: white;
        background: #2d6049;
    }

    .jurnal-alert {
        margin-bottom: 14px;
        padding: 12px;
        border-radius: 7px;
        font-size: 13px;
    }

    .jurnal-alert.error {
        color: #842029;
        background: #f8d7da;
    }

    .jurnal-alert.success {
        color: #0f5132;
        background: #d1e7dd;
    }

    @media (max-width: 760px) {
        .jurnal-card {
            padding: 16px;
        }

        .jurnal-grid {
            gap: 13px;
        }

        .manual-attendance-row {
            grid-template-columns: 60px 42px minmax(0, 1fr);
            gap: 8px;
        }

        .manual-count {
            width: 42px;
        }
    }

    @media (max-width: 540px) {
        .jurnal-header h2 {
            font-size: 22px;
        }

        .jurnal-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .jurnal-field.full {
            grid-column: auto;
        }

        .replacement-options {
            gap: 10px;
        }

        .replacement-radio {
            font-size: 12px;
        }

        .manual-attendance-row {
            grid-template-columns: 58px 40px minmax(0, 1fr);
            gap: 7px;
        }

        .manual-attendance-label {
            font-size: 12px;
        }

        .manual-count,
        .manual-name-select {
            font-size: 12px;
        }
    }
</style>

<div class="jurnal-page">

    <header class="jurnal-header">
        <h2>Jurnal Harian Guru</h2>
        <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
    </header>

    @if (session('success'))
        <div class="jurnal-alert success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="jurnal-alert error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="jurnal-alert error">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('guru.jurnal.store') }}"
        method="POST"
        enctype="multipart/form-data"
        id="formTambahJurnal"
    >
        @csrf

        <div class="jurnal-card">

            <div class="jurnal-heading">
                <i class="bi bi-journal-bookmark-fill"></i>
                <div>
                    <h3>Isi Jurnal Mengajar</h3>
                    <p>Lengkapi informasi pembelajaran di bawah ini.</p>
                </div>
            </div>

            {{-- STATUS MENGAJAR --}}
            <section class="jurnal-panel">
                <h4 class="jurnal-panel-title">Status Mengajar</h4>
                <p class="jurnal-panel-description">
                    Pilih peran Anda pada sesi pembelajaran ini.
                </p>

                <div class="role-options">
                    <label class="role-option">
                        <input
                            type="radio"
                            name="status_mengajar"
                            value="pengampu"
                            {{ old('status_mengajar', 'pengampu') === 'pengampu' ? 'checked' : '' }}
                        >
                        <span>Guru Pengampu</span>
                    </label>

                    <label class="role-option">
                        <input
                            type="radio"
                            name="status_mengajar"
                            value="pengganti"
                            {{ old('status_mengajar') === 'pengganti' ? 'checked' : '' }}
                        >
                        <span>Guru Pengganti</span>
                    </label>
                </div>

                <div class="replacement-fields" id="replacementFields">

                    <div class="replacement-options">
                        <label class="replacement-radio">
                            <input
                                type="radio"
                                name="jenis_penggantian"
                                value="saya_digantikan"
                                {{ old('jenis_penggantian') === 'saya_digantikan' ? 'checked' : '' }}
                            >
                            <span>Saya yang Digantikan</span>
                        </label>

                        <label class="replacement-radio">
                            <input
                                type="radio"
                                name="jenis_penggantian"
                                value="saya_menggantikan"
                                {{ old('jenis_penggantian', 'saya_menggantikan') === 'saya_menggantikan' ? 'checked' : '' }}
                            >
                            <span>Saya yang menggantikan</span>
                        </label>
                    </div>

                    <label
                        for="guru_pendamping_id"
                        class="replacement-label"
                        id="labelGuruPengganti"
                    >
                        Nama Guru Pengampu <span class="required">*</span>
                    </label>

                    <select
                        name="guru_pendamping_id"
                        id="guru_pendamping_id"
                        class="jurnal-control"
                        disabled
                    >
                        <option value="">Masukkan nama guru</option>

                        @foreach ($gurus as $guruPilihan)
                            <option
                                value="{{ $guruPilihan->id }}"
                                {{ old('guru_pendamping_id') == $guruPilihan->id ? 'selected' : '' }}
                            >
                                {{ $guruPilihan->user->name ?? $guruPilihan->nama_guru ?? 'Guru #' . $guruPilihan->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </section>

            {{-- DATA JURNAL --}}
            <div class="jurnal-grid">

                <div class="jurnal-field">
                    <label for="tanggal">
                        Tanggal Mengajar <span class="required">*</span>
                    </label>
                    <input
                        type="date"
                        name="tanggal"
                        id="tanggal"
                        class="jurnal-control"
                        value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                        required
                    >
                </div>

                <div class="jurnal-field">
                    <label for="kelas_display">
                        Kelas <span class="required">*</span>
                    </label>
                    <select id="kelas_display" class="jurnal-control" required>
                        <option value="">-- Pilih kelas --</option>
                        @foreach ($jadwalTersedia->unique('kelas_id') as $j)
                            <option
                                value="{{ $j->kelas_id }}"
                                {{ old('jadwal_id') == $j->id ? 'selected' : '' }}
                            >
                                {{ $j->kelas->nama_kelas ?? 'Kelas #' . $j->kelas_id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="jurnal-field">
                    <label for="mapel_display">
                        Mata Pelajaran <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="mapel_display"
                        class="jurnal-control"
                        placeholder="Terisi otomatis dari jadwal"
                        readonly
                    >
                </div>

                <div class="jurnal-field">
                    <label for="jadwal_id">
                        Jam Pelajaran <span class="required">*</span>
                    </label>
                    <select
                        name="jadwal_id"
                        id="jadwal_id"
                        class="jurnal-control"
                        required
                    >
                        <option value="">-- Pilih jam pelajaran --</option>
                        @foreach ($jadwalTersedia as $j)
                            <option
                                value="{{ $j->id }}"
                                data-kelas-id="{{ $j->kelas_id }}"
                                data-mapel="{{ $j->mataPelajaran->nama_mata_pelajaran ?? '-' }}"
                                {{ old('jadwal_id') == $j->id ? 'selected' : '' }}
                            >
                                Jam ke-{{ $j->jam_mulai_ke }}-{{ $j->jam_selesai_ke }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="jurnal-field full">
                    <label for="pokok_bahasan">
                        Pokok Bahasan/Materi <span class="required">*</span>
                    </label>
                    <textarea
                        name="pokok_bahasan"
                        id="pokok_bahasan"
                        class="jurnal-control"
                        placeholder="Tuliskan pokok bahasan yang diajarkan hari ini"
                        required
                    >{{ old('pokok_bahasan') }}</textarea>
                </div>

                <div class="jurnal-field">
                    <label for="status_penyelesaian">
                        Status Penyelesaian <span class="required">*</span>
                    </label>
                    <select
                        name="status_penyelesaian"
                        id="status_penyelesaian"
                        class="jurnal-control"
                        required
                    >
                        <option value="selesai"
                            {{ old('status_penyelesaian', 'selesai') === 'selesai' ? 'selected' : '' }}>
                            Tuntas
                        </option>
                        <option value="belum_selesai"
                            {{ old('status_penyelesaian') === 'belum_selesai' ? 'selected' : '' }}>
                            Belum Tuntas
                        </option>
                    </select>
                </div>

                <div class="jurnal-field">
                    <label for="semester_display">
                        Semester Akademik <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="semester_display"
                        class="jurnal-control"
                        value="{{ $coverAktif ? $coverAktif->tahun_ajaran . ' Semester ' . $coverAktif->semester : 'Cover jurnal belum tersedia' }}"
                        readonly
                    >
                </div>

                <div
                    class="jurnal-field full"
                    id="alasanContainer"
                    style="{{ old('status_penyelesaian') === 'belum_selesai' ? '' : 'display:none;' }}"
                >
                    <label for="alasan_belum_selesai">Alasan Belum Tuntas</label>
                    <textarea
                        name="alasan_belum_selesai"
                        id="alasan_belum_selesai"
                        class="jurnal-control"
                        placeholder="Tuliskan alasan materi belum selesai"
                    >{{ old('alasan_belum_selesai') }}</textarea>
                </div>

                {{-- ABSENSI SISWA --}}
                <div class="jurnal-field full">
                    <label class="field-label">
                        Absensi Siswa <span class="required">*</span>
                    </label>

                    <div class="attendance-methods">
                        <label class="attendance-method">
                            <input
                                type="radio"
                                name="metode_absensi"
                                value="otomatis"
                                {{ old('metode_absensi', 'otomatis') === 'otomatis' ? 'checked' : '' }}
                            >
                            <span>Ambil Data dari Absensi Siswa</span>
                        </label>

                        <label class="attendance-method">
                            <input
                                type="radio"
                                name="metode_absensi"
                                value="manual"
                                {{ old('metode_absensi') === 'manual' ? 'checked' : '' }}
                            >
                            <span>Masukkan Data Absen Sendiri</span>
                        </label>
                    </div>

                    {{-- MODE OTOMATIS --}}
                    <div id="automaticAttendance" class="attendance-details">
                        <div id="attendanceMessage" class="attendance-message">
                            Pilih kelas dan jam pelajaran untuk memuat siswa.
                        </div>

                        <div class="attendance-table-wrap">
                            <table
                                id="attendanceTable"
                                class="attendance-table"
                                style="display:none;"
                            >
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Siswa</th>
                                        <th>Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody id="murid-list"></tbody>
                            </table>
                        </div>
                    </div>

                    {{-- MODE MANUAL --}}
                    <div id="manualAttendance" class="attendance-details">
                        <div class="manual-attendance-row">
                            <label class="manual-attendance-label" for="jumlah_sakit">
                                Sakit :
                            </label>
                            <input
                                type="number"
                                id="jumlah_sakit"
                                class="manual-count"
                                min="0"
                                max="100"
                                value="{{ old('jumlah_sakit', 0) }}"
                            >
                            <div id="nama_sakit" class="manual-name-list">
                                <select class="manual-name-select">
                                    <option value="">-</option>
                                </select>
                            </div>
                        </div>

                        <div class="manual-attendance-row">
                            <label class="manual-attendance-label" for="jumlah_izin">
                                Izin :
                            </label>
                            <input
                                type="number"
                                id="jumlah_izin"
                                class="manual-count"
                                min="0"
                                max="100"
                                value="{{ old('jumlah_izin', 0) }}"
                            >
                            <div id="nama_izin" class="manual-name-list">
                                <select class="manual-name-select">
                                    <option value="">-</option>
                                </select>
                            </div>
                        </div>

                        <div class="manual-attendance-row">
                            <label class="manual-attendance-label" for="jumlah_alpa">
                                Alpha :
                            </label>
                            <input
                                type="number"
                                id="jumlah_alpa"
                                class="manual-count"
                                min="0"
                                max="100"
                                value="{{ old('jumlah_alpa', 0) }}"
                            >
                            <div id="nama_alpa" class="manual-name-list">
                                <select class="manual-name-select">
                                    <option value="">-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="jurnal-field full">
                    <label for="keterangan">Catatan Tambahan</label>
                    <input
                        type="text"
                        name="keterangan"
                        id="keterangan"
                        class="jurnal-control"
                        value="{{ old('keterangan') }}"
                        placeholder="Catatan atau evaluasi pembelajaran (opsional)"
                    >
                </div>

                <div class="jurnal-field full">
                    <label for="foto_kegiatan">Foto Kegiatan</label>
                    <label for="foto_kegiatan" class="photo-upload">
                        <i class="bi bi-images"></i>
                        <strong id="photoLabel">
                            Klik untuk pilih foto kegiatan pembelajaran
                        </strong>
                        <small>JPG atau PNG - Batas Ukuran 3 MB</small>
                    </label>

                    <input
                        type="file"
                        name="foto_kegiatan"
                        id="foto_kegiatan"
                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                        hidden
                    >

                    <img
                        id="photoPreview"
                        class="photo-preview"
                        alt="Pratinjau foto kegiatan"
                    >
                </div>
            </div>
        </div>

        <div class="jurnal-actions">
            <a href="{{ route('guru.jurnal-harian') }}"
               class="jurnal-btn btn-cancel">
                Batal
            </a>

            <button
                type="submit"
                class="jurnal-btn btn-save"
                id="saveJournalButton"
                {{ $jadwalTersedia->isEmpty() || !$coverAktif ? 'disabled' : '' }}
            >
                Simpan Jurnal
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formTambahJurnal');

    const kelasSelect = document.getElementById('kelas_display');
    const jadwalSelect = document.getElementById('jadwal_id');
    const mapelInput = document.getElementById('mapel_display');

    const replacementFields = document.getElementById('replacementFields');
    const guruSelect = document.getElementById('guru_pendamping_id');
    const labelGuru = document.getElementById('labelGuruPengganti');

    const automaticAttendance = document.getElementById('automaticAttendance');
    const manualAttendance = document.getElementById('manualAttendance');

    const attendanceMessage = document.getElementById('attendanceMessage');
    const attendanceTable = document.getElementById('attendanceTable');
    const muridList = document.getElementById('murid-list');

    const fotoInput = document.getElementById('foto_kegiatan');
    const photoLabel = document.getElementById('photoLabel');
    const photoPreview = document.getElementById('photoPreview');

    let daftarMurid = [];
    let requestController = null;
    let photoUrl = null;

    function selectedValue(name) {
        const selected = document.querySelector(`input[name="${name}"]:checked`);
        return selected ? selected.value : '';
    }

    /* STATUS MENGAJAR */
    function updateStatusMengajar() {
        const isPengganti = selectedValue('status_mengajar') === 'pengganti';

        replacementFields.classList.toggle('active', isPengganti);
        guruSelect.disabled = !isPengganti;
        guruSelect.required = isPengganti;

        if (!isPengganti) {
            guruSelect.value = '';
        }

        updateLabelGuru();
    }

    function updateLabelGuru() {
        const jenis = selectedValue('jenis_penggantian');

        labelGuru.textContent = jenis === 'saya_digantikan'
            ? 'Nama Guru Pengganti *'
            : 'Nama Guru Pengampu *';
    }

    document.querySelectorAll('input[name="status_mengajar"]').forEach(input => {
        input.addEventListener('change', updateStatusMengajar);
    });

    document.querySelectorAll('input[name="jenis_penggantian"]').forEach(input => {
        input.addEventListener('change', updateLabelGuru);
    });

    /* FILTER JADWAL BERDASARKAN KELAS */
    function filterJadwal() {
        const kelasId = kelasSelect.value;
        let firstMatch = '';

        Array.from(jadwalSelect.options).forEach((option, index) => {
            if (index === 0) return;

            const match = !kelasId || option.dataset.kelasId === kelasId;
            option.hidden = !match;

            if (match && !firstMatch) {
                firstMatch = option.value;
            }
        });

        const selected = jadwalSelect.options[jadwalSelect.selectedIndex];

        if (selected && selected.hidden) {
            jadwalSelect.value = '';
        }

        if (kelasId && !jadwalSelect.value) {
            jadwalSelect.value = firstMatch;
        }

        updateMapel();
        loadMurid();
    }

    function updateKelasFromJadwal() {
        const option = jadwalSelect.options[jadwalSelect.selectedIndex];

        if (!option || !option.value) {
            mapelInput.value = '';
            return;
        }

        kelasSelect.value = option.dataset.kelasId || '';
        updateMapel();
    }

    function updateMapel() {
        const option = jadwalSelect.options[jadwalSelect.selectedIndex];
        mapelInput.value = option && option.value ? option.dataset.mapel || '' : '';
    }

    kelasSelect.addEventListener('change', filterJadwal);

    jadwalSelect.addEventListener('change', function () {
        updateKelasFromJadwal();
        loadMurid();
    });

    /* STATUS PENYELESAIAN */
    const statusPenyelesaian = document.getElementById('status_penyelesaian');
    const alasanContainer = document.getElementById('alasanContainer');

    function updateAlasan() {
        alasanContainer.style.display =
            statusPenyelesaian.value === 'belum_selesai' ? '' : 'none';
    }

    statusPenyelesaian.addEventListener('change', updateAlasan);

    /* METODE ABSENSI */
    function updateMetodeAbsensi() {
        const manual = selectedValue('metode_absensi') === 'manual';

        automaticAttendance.classList.toggle('active', !manual);
        manualAttendance.classList.toggle('active', manual);

        if (manual) {
            renderManualAttendance();
        } else {
            renderAutomaticAttendance();
        }
    }

    document.querySelectorAll('input[name="metode_absensi"]').forEach(input => {
        input.addEventListener('change', updateMetodeAbsensi);
    });

    /* MUAT DATA SISWA DARI SERVER */
    async function loadMurid() {
        const jadwalId = jadwalSelect.value;

        daftarMurid = [];
        muridList.innerHTML = '';
        attendanceTable.style.display = 'none';

        if (requestController) {
            requestController.abort();
        }

        if (!jadwalId) {
            attendanceMessage.textContent =
                'Pilih kelas dan jam pelajaran untuk memuat siswa.';
            attendanceMessage.style.display = 'block';
            renderManualAttendance();
            return;
        }

        requestController = new AbortController();

        attendanceMessage.textContent = 'Memuat daftar siswa...';
        attendanceMessage.style.display = 'block';

        try {
            const templateUrl = @json(
                route('guru.jurnal.get-murid', ['jadwal_id' => '__ID__'])
            );

            const url = templateUrl.replace(
                '__ID__',
                encodeURIComponent(jadwalId)
            );

            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: requestController.signal
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data siswa.');
            }

            const data = await response.json();

            if (!Array.isArray(data)) {
                throw new Error('Format data siswa tidak sesuai.');
            }

            daftarMurid = data;

            renderAutomaticAttendance();
            renderManualAttendance();
        } catch (error) {
            if (error.name === 'AbortError') return;

            console.error(error);

            attendanceMessage.textContent =
                'Daftar siswa gagal dimuat. Periksa route dan data kelas.';
            attendanceMessage.style.display = 'block';

            renderManualAttendance();
        }
    }

    /* PILIHAN STATUS KEHADIRAN */
    function createStatusSelect(muridId) {
        const select = document.createElement('select');
        select.name = `absensi[${muridId}]`;

        [
            ['hadir', 'Hadir'],
            ['sakit', 'Sakit'],
            ['izin', 'Izin'],
            ['alpa', 'Alpha']
        ].forEach(([value, text]) => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = text;
            select.appendChild(option);
        });

        return select;
    }

    /* ABSENSI OTOMATIS */
    function renderAutomaticAttendance() {
        if (selectedValue('metode_absensi') !== 'otomatis') return;

        muridList.innerHTML = '';

        if (!jadwalSelect.value || !daftarMurid.length) {
            attendanceTable.style.display = 'none';
            attendanceMessage.style.display = 'block';

            attendanceMessage.textContent = !jadwalSelect.value
                ? 'Pilih kelas dan jam pelajaran untuk memuat siswa.'
                : 'Belum ada data siswa untuk jadwal ini.';

            return;
        }

        attendanceMessage.style.display = 'none';
        attendanceTable.style.display = 'table';

        daftarMurid.forEach((murid, index) => {
            const row = document.createElement('tr');
            const numberCell = document.createElement('td');
            const nameCell = document.createElement('td');
            const statusCell = document.createElement('td');

            numberCell.textContent = index + 1;
            nameCell.textContent = murid.nama_siswa;
            statusCell.appendChild(createStatusSelect(murid.id));

            row.append(numberCell, nameCell, statusCell);
            muridList.appendChild(row);
        });
    }

    /* ABSENSI MANUAL: JUMLAH DAN DROPDOWN NAMA */
    const attendanceCategories = [
        { status: 'sakit', countId: 'jumlah_sakit', containerId: 'nama_sakit' },
        { status: 'izin', countId: 'jumlah_izin', containerId: 'nama_izin' },
        { status: 'alpa', countId: 'jumlah_alpa', containerId: 'nama_alpa' }
    ];

    function renderManualAttendance() {
        if (selectedValue('metode_absensi') !== 'manual') return;

        attendanceCategories.forEach(category => {
            const countInput = document.getElementById(category.countId);
            const container = document.getElementById(category.containerId);

            const count = Math.max(
                0,
                Math.min(100, parseInt(countInput.value, 10) || 0)
            );

            container.innerHTML = '';

            if (count === 0) {
                const emptySelect = document.createElement('select');
                emptySelect.className = 'manual-name-select';
                emptySelect.disabled = true;

                const option = document.createElement('option');
                option.value = '';
                option.textContent = '-';

                emptySelect.appendChild(option);
                container.appendChild(emptySelect);
                return;
            }

            if (!jadwalSelect.value || !daftarMurid.length) {
                const emptySelect = document.createElement('select');
                emptySelect.className = 'manual-name-select';
                emptySelect.disabled = true;

                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Pilih jadwal terlebih dahulu';

                emptySelect.appendChild(option);
                container.appendChild(emptySelect);
                return;
            }

            for (let i = 0; i < count; i++) {
                const select = document.createElement('select');

                select.className = 'manual-name-select';
                select.dataset.status = category.status;
                select.required = true;

                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = '-- Pilih nama siswa --';

                select.appendChild(placeholder);

                daftarMurid.forEach(murid => {
                    const option = document.createElement('option');
                    option.value = murid.id;
                    option.textContent = murid.nama_siswa;
                    select.appendChild(option);
                });

                container.appendChild(select);
            }
        });

        updateManualOptions();
    }

    function updateManualOptions() {
        const selects = Array.from(
            document.querySelectorAll('.manual-name-select[data-status]')
        );

        const selectedIds = selects
            .map(select => select.value)
            .filter(Boolean);

        selects.forEach(select => {
            Array.from(select.options).forEach(option => {
                if (!option.value) return;

                option.disabled =
                    selectedIds.includes(option.value) &&
                    select.value !== option.value;
            });
        });
    }

    attendanceCategories.forEach(category => {
        document.getElementById(category.countId).addEventListener(
            'input',
            renderManualAttendance
        );
    });

    manualAttendance.addEventListener('change', function (event) {
        if (event.target.classList.contains('manual-name-select')) {
            updateManualOptions();
        }
    });

    /* UNGGAH FOTO */
    fotoInput.addEventListener('change', function () {
        const file = this.files[0];

        if (photoUrl) {
            URL.revokeObjectURL(photoUrl);
            photoUrl = null;
        }

        photoPreview.style.display = 'none';
        photoPreview.removeAttribute('src');

        if (!file) {
            photoLabel.textContent =
                'Klik untuk pilih foto kegiatan pembelajaran';
            return;
        }

        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            alert('Foto harus berformat JPG atau PNG.');
            this.value = '';
            return;
        }

        if (file.size > 3 * 1024 * 1024) {
            alert('Ukuran foto maksimal 3 MB.');
            this.value = '';
            return;
        }

        photoLabel.textContent = file.name;

        photoUrl = URL.createObjectURL(file);
        photoPreview.src = photoUrl;
        photoPreview.style.display = 'block';
    });

    /* VALIDASI DAN PEMBENTUKAN DATA ABSENSI */
    form.addEventListener('submit', function (event) {
        form.querySelectorAll('.manual-generated-input').forEach(input => input.remove());

        if (!jadwalSelect.value) {
            event.preventDefault();
            alert('Pilih kelas dan jam pelajaran terlebih dahulu.');
            jadwalSelect.focus();
            return;
        }

        if (selectedValue('status_mengajar') === 'pengganti') {
            if (!selectedValue('jenis_penggantian')) {
                event.preventDefault();
                alert('Pilih apakah Anda yang digantikan atau yang menggantikan.');
                return;
            }

            if (!guruSelect.value) {
                event.preventDefault();
                alert('Pilih nama guru yang berkaitan dengan sesi penggantian.');
                guruSelect.focus();
                return;
            }
        }

        if (selectedValue('metode_absensi') === 'manual') {
            const selects = Array.from(
                document.querySelectorAll('.manual-name-select[data-status]')
            );

            if (selects.some(select => !select.value)) {
                event.preventDefault();
                alert('Pilih nama siswa untuk setiap jumlah sakit, izin, dan alpha.');
                return;
            }

            const ids = selects.map(select => select.value);

            if (new Set(ids).size !== ids.length) {
                event.preventDefault();
                alert('Satu siswa tidak boleh dipilih lebih dari satu kali.');
                return;
            }

            selects.forEach(select => {
                const input = document.createElement('input');

                input.type = 'hidden';
                input.className = 'manual-generated-input';
                input.name = `absensi[${select.value}]`;
                input.value = select.dataset.status;

                form.appendChild(input);
            });
        }
    });

    /* INISIALISASI */
    updateStatusMengajar();
    updateLabelGuru();
    updateAlasan();
    updateMetodeAbsensi();

    if (jadwalSelect.value) {
        updateKelasFromJadwal();
        loadMurid();
    }
});
</script>
@endsection