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
    .replacement-radio input {
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

    .jurnal-field>label,
    .jurnal-field>.field-label {
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

    /* Info Sesi */
    .sesi-info {
        display: none;
        margin-bottom: 12px;
        padding: 10px 14px;
        background: #e8f5ed;
        border: 1px solid #b9d9c8;
        border-radius: 8px;
        color: #285840;
        font-size: 12px;
    }

    .sesi-info i {
        margin-right: 6px;
    }

    .sesi-info .sesi-label {
        font-weight: 700;
        font-size: 13px;
    }

    .sesi-info .sesi-detail {
        color: #6b7d71;
        font-size: 11px;
        margin-left: 8px;
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
    /* UPLOAD FOTO KEGIATAN */
    .upload-box {
        display: flex;
        width: 100%;
        min-height: 125px;
        padding: 18px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 7px;
        color: #39765f;
        background: #eff9f4;
        border: 2px dashed #b9d9c8;
        border-radius: 10px;
        cursor: pointer;
        text-align: center;
        transition: background .2s ease, border-color .2s ease;
    }

    .upload-box:hover {
        background: #e5f4eb;
        border-color: #75b99a;
    }

    .upload-box input[type="file"] {
        display: none;
    }

    .upload-content,
    .selected-file {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 7px;
    }

    .upload-content i,
    .selected-file i {
        font-size: 34px;
    }

    .upload-content strong,
    .selected-file strong {
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .upload-content span,
    .selected-file span {
        color: #78847b;
        font-size: 11px;
    }

    .selected-file small {
        color: #39765f;
        font-size: 11px;
    }

    .file-error {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 11px;
    }

    .photo-preview {
        display: none;
        max-width: 100%;
        max-height: 250px;
        margin: 10px auto 0;
        border-radius: 8px;
        object-fit: contain;
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

    /* INFO PANEL PENGGANTI */
    .info-digantikan {
        display: none;
        margin-bottom: 20px;
        padding: 12px 16px;
        background: #fef3c7;
        border: 1px solid #fde68a;
        border-radius: 10px;
        color: #92400e;
        font-size: 13px;
        line-height: 1.6;
    }

    .info-digantikan i {
        margin-right: 6px;
    }

    /* POPUP SUKSES TAMBAH JURNAL */
    .success-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, .25);
    }

    .success-modal {
        box-sizing: border-box;
        width: 100%;
        max-width: 470px;
        overflow: hidden;
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, .15);
        text-align: center;
        animation: modalAppear .25s ease;
    }

    .success-modal-header {
        width: 100%;
        height: 30px;
        background: #39765f;
    }

    .success-modal-content {
        padding: 10px 20px 20px;
    }

    .success-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 65px;
        height: 65px;
        margin: 0 auto 10px;
        color: #39765f;
        font-size: 75px;
    }

    .success-icon i {
        line-height: 1;
    }

    .success-modal-content h3 {
        margin: 5px 0 10px;
        color: #39765f;
        font-size: 25px;
        font-weight: 700;
    }

    .success-modal-content p {
        margin: 0 0 18px;
        color: #555;
        font-size: 14px;
        line-height: 1.5;
    }

    .success-modal-button {
        width: 130px;
        min-height: 48px;
        border: none;
        border-radius: 16px;
        background: #96E8C5;
        color: #39765f;
        font-family: inherit;
        font-size: 19px;
        font-weight: 700;
        cursor: pointer;
    }

    .success-modal-button:hover {
        background: #7DDDB5;
    }

    @keyframes modalAppear {
        from {
            opacity: 0;
            transform: scale(.92);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
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

        .success-modal {
            max-width: 360px;
        }

        .success-modal-content h3 {
            font-size: 21px;
        }
    }
</style>

<div class="jurnal-page">
        @if(session('jurnal_created'))
        <div class="success-modal-overlay" id="successModal">
            <div class="success-modal">
                <div class="success-modal-header"></div>

                <div class="success-modal-content">
                    <div class="success-icon">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <h3>Jurnal Berhasil Ditambahkan</h3>

                    <p>
                        Jurnal harian berhasil disimpan dan tercatat dalam sistem.
                    </p>

                    <button type="button"
                            class="success-modal-button"
                            onclick="closeSuccessModal()">
                        Oke
                    </button>
                </div>
            </div>
        </div>
    @endif

    <header class="jurnal-header">
        <h2>Jurnal Harian Guru</h2>
        <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
    </header>

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
        id="formTambahJurnal">
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
                            {{ old('status_mengajar', 'pengampu') === 'pengampu' ? 'checked' : '' }}>
                        <span>Guru Pengampu</span>
                    </label>

                    <label class="role-option">
                        <input
                            type="radio"
                            name="status_mengajar"
                            value="pengganti"
                            {{ old('status_mengajar') === 'pengganti' ? 'checked' : '' }}>
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
                                {{ old('jenis_penggantian') === 'saya_digantikan' ? 'checked' : '' }}>
                            <span>Saya yang Digantikan</span>
                        </label>

                        <label class="replacement-radio">
                            <input
                                type="radio"
                                name="jenis_penggantian"
                                value="saya_menggantikan"
                                {{ old('jenis_penggantian', 'saya_menggantikan') === 'saya_menggantikan' ? 'checked' : '' }}>
                            <span>Saya yang menggantikan</span>
                        </label>
                    </div>

                    <label
                        for="guru_pendamping_id"
                        class="replacement-label"
                        id="labelGuruPengganti">
                        Nama Guru Pengampu <span class="required">*</span>
                    </label>

                    <select
                        name="guru_pendamping_id"
                        id="guru_pendamping_id"
                        class="jurnal-control"
                        disabled>
                        <option value="">Masukkan nama guru</option>

                        @foreach ($gurus as $guruPilihan)
                        <option
                            value="{{ $guruPilihan->id }}"
                            {{ old('guru_pendamping_id') == $guruPilihan->id ? 'selected' : '' }}>
                            {{ $guruPilihan->user->name ?? $guruPilihan->nama_guru ?? 'Guru #' . $guruPilihan->id }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </section>

            {{-- INFO PANEL SAAT "SAYA YANG DIGANTIKAN" --}}
            <div class="info-digantikan" id="infoDigantikan">
                <i class="bi bi-info-circle-fill"></i>
                <strong>Anda memilih "Saya yang Digantikan".</strong><br>
                Cukup isi tanggal, kelas, mata pelajaran, jam, dan pilih nama guru pengganti.
                Materi, absensi, catatan, dan foto akan diisi oleh guru pengganti.
            </div>

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
                        value="{{ old('tanggal', $tanggalDipilih ?? now()->format('Y-m-d')) }}"
                        required>
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
                            {{ old('jadwal_id', $jadwalDipilih->id ?? null) == $j->id ? 'selected' : '' }}>
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
                        readonly>
                </div>

                <div class="jurnal-field">
                    <label for="jadwal_id">
                        Jam Pelajaran <span class="required">*</span>
                    </label>
                    <select
                        name="jadwal_id"
                        id="jadwal_id"
                        class="jurnal-control"
                        required>
                        <option value="">-- Pilih jam pelajaran --</option>
                        @foreach ($jadwalTersedia as $j)
                        <option
                            value="{{ $j->id }}"
                            data-kelas-id="{{ $j->kelas_id }}"
                            data-mapel="{{ $j->mataPelajaran->nama_mata_pelajaran ?? '-' }}"
                            {{ old('jadwal_id', $jadwalDipilih->id ?? null) == $j->id ? 'selected' : '' }}>
                            Jam ke-{{ $j->jam_mulai_ke }}-{{ $j->jam_selesai_ke }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🔧 FIELD POKOK BAHASAN (disembunyikan saat "Saya yang Digantikan") --}}
                <div class="jurnal-field full" id="fieldPokokBahasan">
                    <label for="pokok_bahasan">
                        Pokok Bahasan/Materi <span class="required">*</span>
                    </label>
                    <textarea
                        name="pokok_bahasan"
                        id="pokok_bahasan"
                        class="jurnal-control"
                        placeholder="Tuliskan pokok bahasan yang diajarkan hari ini"
                        required>{{ old('pokok_bahasan') }}</textarea>
                </div>

                {{-- 🔧 FIELD STATUS PENYELESAIAN (disembunyikan saat "Saya yang Digantikan") --}}
                <div class="jurnal-field" id="fieldStatusPenyelesaian">
                    <label for="status_penyelesaian">
                        Status Penyelesaian <span class="required">*</span>
                    </label>
                    <select
                        name="status_penyelesaian"
                        id="status_penyelesaian"
                        class="jurnal-control"
                        required>
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
                        readonly>
                </div>

                <div
                    class="jurnal-field full"
                    id="alasanContainer"
                    style="{{ old('status_penyelesaian') === 'belum_selesai' ? '' : 'display:none;' }}">
                    <label for="alasan_belum_selesai">Alasan Belum Tuntas</label>
                    <textarea
                        name="alasan_belum_selesai"
                        id="alasan_belum_selesai"
                        class="jurnal-control"
                        placeholder="Tuliskan alasan materi belum selesai">{{ old('alasan_belum_selesai') }}</textarea>
                </div>

                {{-- 🔧 FIELD ABSENSI (disembunyikan saat "Saya yang Digantikan") --}}
                <div class="jurnal-field full" id="fieldAbsensi">
                    <label class="field-label">
                        Absensi Siswa <span class="required">*</span>
                    </label>

                    {{-- Info Sesi --}}
                    <div id="sesiInfo" class="sesi-info">
                        <i class="bi bi-clock-history"></i>
                        <span class="sesi-label" id="sesiLabel">-</span>
                        <span class="sesi-detail" id="sesiDetail"></span>
                    </div>

                    <div id="manualAttendance">
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
                                value="{{ old('jumlah_sakit', 0) }}">
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
                                value="{{ old('jumlah_izin', 0) }}">
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
                                value="{{ old('jumlah_alpa', 0) }}">
                            <div id="nama_alpa" class="manual-name-list">
                                <select class="manual-name-select">
                                    <option value="">-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔧 FIELD CATATAN (disembunyikan saat "Saya yang Digantikan") --}}
                <div class="jurnal-field full" id="fieldCatatan">
                    <label for="keterangan">Catatan Tambahan</label>
                    <input
                        type="text"
                        name="keterangan"
                        id="keterangan"
                        class="jurnal-control"
                        value="{{ old('keterangan') }}"
                        placeholder="Catatan atau evaluasi pembelajaran (opsional)">
                </div>

                {{-- 🔧 FIELD FOTO (disembunyikan saat "Saya yang Digantikan") --}}
                <div class="jurnal-field full" id="fieldFoto">
                    <label for="foto_kegiatan">Foto Kegiatan</label>

                    <label for="foto_kegiatan" class="upload-box">
                        <input
                            type="file"
                            id="foto_kegiatan"
                            name="foto_kegiatan"
                            accept=".jpg,.jpeg,.png,image/jpeg,image/png">

                        <div class="upload-content" id="uploadContent">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <strong>Klik untuk memilih foto</strong>
                            <span>JPG atau PNG - Batas Ukuran 3 MB</span>
                        </div>

                        <div class="selected-file" id="selectedFile" hidden>
                            <i class="bi bi-file-earmark-image"></i>
                            <strong id="fileName"></strong>
                            <span id="fileSize"></span>
                            <small>Klik area ini untuk mengganti foto</small>
                        </div>
                    </label>

                    <small id="fileError" class="file-error"></small>

                    <img
                        id="photoPreview"
                        class="photo-preview"
                        alt="Pratinjau foto kegiatan">
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
                {{ $jadwalTersedia->isEmpty() || !$coverAktif ? 'disabled' : '' }}>
                Simpan Jurnal
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formTambahJurnal');

        const kelasSelect = document.getElementById('kelas_display');
        const jadwalSelect = document.getElementById('jadwal_id');
        const mapelInput = document.getElementById('mapel_display');

        const replacementFields = document.getElementById('replacementFields');
        const guruSelect = document.getElementById('guru_pendamping_id');
        const labelGuru = document.getElementById('labelGuruPengganti');
        const infoDigantikan = document.getElementById('infoDigantikan');

        const sesiInfo = document.getElementById('sesiInfo');
        const sesiLabel = document.getElementById('sesiLabel');
        const sesiDetail = document.getElementById('sesiDetail');

        const fotoInput = document.getElementById('foto_kegiatan');
        const uploadContent = document.getElementById('uploadContent');
        const selectedFile = document.getElementById('selectedFile');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileError = document.getElementById('fileError');
        const photoPreview = document.getElementById('photoPreview');

        let daftarMurid = [];
        let muridPerStatus = {
            sakit: [],
            izin: [],
            alpa: [],
            hadir: []
        };
        let requestController = null;

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
            toggleFieldPengganti();
        }

        function updateLabelGuru() {
            const jenis = selectedValue('jenis_penggantian');

            labelGuru.textContent = jenis === 'saya_digantikan' ?
                'Nama Guru Pengganti *' :
                'Nama Guru Pengampu *';

            toggleFieldPengganti();
        }

        // 🔧 Fungsi baru: sembunyikan field saat "Saya yang Digantikan"
        function toggleFieldPengganti() {
            const isPengganti = selectedValue('status_mengajar') === 'pengganti';
            const isDigantikan = isPengganti && selectedValue('jenis_penggantian') === 'saya_digantikan';

            // Tampilkan info panel
            if (infoDigantikan) {
                infoDigantikan.style.display = isDigantikan ? 'block' : 'none';
            }

            // Daftar field yang disembunyikan
            const fieldIds = [
                'fieldPokokBahasan',
                'fieldStatusPenyelesaian',
                'alasanContainer',
                'fieldAbsensi',
                'fieldCatatan',
                'fieldFoto',
            ];

            fieldIds.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;

                if (isDigantikan) {
                    el.style.display = 'none';
                    el.querySelectorAll('[required]').forEach(inp => {
                        inp.dataset.wasRequired = '1';
                        inp.removeAttribute('required');
                    });
                } else {
                    el.style.display = '';
                    el.querySelectorAll('[data-was-required="1"]').forEach(inp => {
                        inp.setAttribute('required', 'required');
                        delete inp.dataset.wasRequired;
                    });
                }
            });
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

        jadwalSelect.addEventListener('change', function() {
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

        /* MUAT DATA SISWA DARI SERVER */
        async function loadMurid() {
            const jadwalId = jadwalSelect.value;

            daftarMurid = [];
            muridPerStatus = {
                sakit: [],
                izin: [],
                alpa: [],
                hadir: []
            };

            ['jumlah_sakit', 'jumlah_izin', 'jumlah_alpa'].forEach(id => {
                delete document.getElementById(id).dataset.userEdited;
            });

            if (requestController) {
                requestController.abort();
            }

            if (!jadwalId) {
                sesiInfo.style.display = 'none';
                resetJumlahInput();
                renderManualAttendance();
                return;
            }

            requestController = new AbortController();

            try {
                const templateUrl = @json(
                    route('guru.get-murid', ['jadwal_id' => '__ID__'])
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

                if (Array.isArray(data)) {
                    daftarMurid = data;
                    sesiInfo.style.display = 'none';
                } else if (data && Array.isArray(data.murids)) {
                    daftarMurid = data.murids;

                    if (data.sesi && data.sesi.label) {
                        sesiLabel.textContent = data.sesi.label;
                        let detail = `${data.kelas || '-'} · ${data.mapel || '-'}`;
                        if (data.ada_absensi_terakhir && data.tanggal_absensi_terakhir) {
                            const tgl = new Date(data.tanggal_absensi_terakhir);
                            const tglFormat = tgl.toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });
                            detail += ` · Absensi terakhir: ${tglFormat}`;
                        } else {
                            detail += ' · Belum ada absensi sebelumnya';
                        }
                        sesiDetail.textContent = detail;
                        sesiInfo.style.display = 'block';
                    } else {
                        sesiInfo.style.display = 'none';
                    }
                } else {
                    throw new Error('Format data siswa tidak sesuai.');
                }

                muridPerStatus = {
                    sakit: [],
                    izin: [],
                    alpa: [],
                    hadir: []
                };
                daftarMurid.forEach(murid => {
                    const status = murid.status_terakhir || 'hadir';
                    if (muridPerStatus[status]) {
                        muridPerStatus[status].push(murid);
                    }
                });

                setJumlahDariPatokan();
                renderManualAttendance();
            } catch (error) {
                if (error.name === 'AbortError') return;

                console.error(error);
                sesiInfo.style.display = 'none';
                resetJumlahInput();
                renderManualAttendance();
            }
        }

        function setJumlahDariPatokan() {
            attendanceCategories.forEach(category => {
                const input = document.getElementById(category.countId);
                const jumlah = muridPerStatus[category.status].length;

                if (!input.dataset.userEdited) {
                    input.value = jumlah;
                }
            });
        }

        function resetJumlahInput() {
            ['jumlah_sakit', 'jumlah_izin', 'jumlah_alpa'].forEach(id => {
                const input = document.getElementById(id);
                input.value = 0;
                delete input.dataset.userEdited;
            });
        }

        /* ABSENSI MANUAL: JUMLAH DAN DROPDOWN NAMA */
        const attendanceCategories = [{
                status: 'sakit',
                countId: 'jumlah_sakit',
                containerId: 'nama_sakit'
            },
            {
                status: 'izin',
                countId: 'jumlah_izin',
                containerId: 'nama_izin'
            },
            {
                status: 'alpa',
                countId: 'jumlah_alpa',
                containerId: 'nama_alpa'
            }
        ];

        function renderManualAttendance() {
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

                const muridCocok = muridPerStatus[category.status] || [];

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

                    if (muridCocok[i]) {
                        select.value = muridCocok[i].id;
                    }

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
            const input = document.getElementById(category.countId);

            input.addEventListener('input', function() {
                input.dataset.userEdited = 'true';
                renderManualAttendance();
            });
        });

        document.getElementById('manualAttendance').addEventListener('change', function(event) {
            if (event.target.classList.contains('manual-name-select')) {
                updateManualOptions();
            }
        });

        /* UNGGAH FOTO KEGIATAN */
        fotoInput.addEventListener('change', function() {
            const file = this.files[0];

            fileError.textContent = '';
            photoPreview.style.display = 'none';
            photoPreview.removeAttribute('src');

            if (!file) {
                uploadContent.hidden = false;
                selectedFile.hidden = true;
                return;
            }

            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                fileError.textContent = 'Foto harus berformat JPG atau PNG.';
                this.value = '';
                uploadContent.hidden = false;
                selectedFile.hidden = true;
                return;
            }

            if (file.size > 3 * 1024 * 1024) {
                fileError.textContent = 'Ukuran foto maksimal 3 MB.';
                this.value = '';
                uploadContent.hidden = false;
                selectedFile.hidden = true;
                return;
            }

            uploadContent.hidden = true;
            selectedFile.hidden = false;

            fileName.textContent = file.name;
            fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';

            photoPreview.src = URL.createObjectURL(file);
            photoPreview.style.display = 'block';
        });

        /* VALIDASI DAN PEMBENTUKAN DATA ABSENSI */
        form.addEventListener('submit', function(event) {
            form.querySelectorAll('.manual-generated-input').forEach(input => input.remove());

            if (!jadwalSelect.value) {
                event.preventDefault();
                alert('Pilih kelas dan jam pelajaran terlebih dahulu.');
                jadwalSelect.focus();
                return;
            }

            const isPengganti = selectedValue('status_mengajar') === 'pengganti';
            const isDigantikan = isPengganti && selectedValue('jenis_penggantian') === 'saya_digantikan';

            if (isPengganti) {
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

            // 🔧 SKIP validasi absensi kalau mode "Saya yang Digantikan"
            if (isDigantikan) {
                return;
            }

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
        });

        /* INISIALISASI */
        updateStatusMengajar();
        updateLabelGuru();
        updateAlasan();
        toggleFieldPengganti();

        @if($jadwalDipilih ?? null)
        kelasSelect.value = '{{ $jadwalDipilih->kelas_id }}';
        jadwalSelect.value = '{{ $jadwalDipilih->id }}';
        updateMapel();
        loadMurid();
        @else
        if (jadwalSelect.value) {
            updateKelasFromJadwal();
            loadMurid();
        }
        @endif
    });
</script>
<script>
    window.closeSuccessModal = function () {
        window.location.href = "{{ route('guru.jurnal-harian') }}";
    };
</script>
@endsection