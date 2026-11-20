@extends('layouts.app')

@section('title', 'Edit Jurnal Harian')

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

    .role-option input:disabled,
    .replacement-radio input:disabled {
        cursor: not-allowed;
    }

    .role-option:has(input:disabled) {
        cursor: not-allowed;
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

    .jurnal-control[readonly],
    .jurnal-control:disabled {
        background: #f4f7f5;
        color: #6b7d71;
        cursor: not-allowed;
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
        display: block;
        max-width: 100%;
        max-height: 250px;
        margin: 10px auto 0;
        border-radius: 8px;
        object-fit: contain;
    }

    .photo-current-info {
        margin-top: 8px;
        padding: 8px 12px;
        background: #f0f7f3;
        border: 1px solid #c7d9cf;
        border-radius: 7px;
        font-size: 11px;
        color: #4a6353;
    }

    .photo-current-info i {
        margin-right: 5px;
        color: #39745b;
    }

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

    .jurnal-alert.warning {
        color: #856404;
        background: #fff3cd;
        border: 1px solid #ffeeba;
    }

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

    .badge-penggantian {
        margin-top: 12px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 12px;
        line-height: 1.5;
    }

    .badge-penggantian.menunggu {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .badge-penggantian.selesai {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .badge-penggantian i {
        margin-right: 6px;
    }

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
        padding: 10px 20px 16px;
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

    .badge-penggantian.revisi {
        background: #dbeafe;
        color: #1d4ed8;
        border: 1px solid #93c5fd;
    }

    .success-icon i {
        line-height: 1;
    }

    .success-modal-content h3 {
        margin: 5px 0 16px;
        color: #39765f;
        font-size: 27px;
        font-weight: 700;
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
        transition: background .2s ease;
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

    <header class="jurnal-header">
        <h2>Edit Jurnal Harian</h2>
        <p>Perbarui informasi pembelajaran di bawah ini.</p>
    </header>

    @if(session('jurnal_updated'))
    <div class="success-modal-overlay" id="successModal">
        <div class="success-modal">
            <div class="success-modal-header"></div>
            <div class="success-modal-content">
                <div class="success-icon"><i class="bi bi-check-lg"></i></div>
                <h3>Jurnal Berhasil Diperbaharui</h3>
                <button type="button" class="success-modal-button" onclick="closeSuccessModal()">Oke</button>
            </div>
        </div>
    </div>
    @endif

    @if (session('success')) <div class="jurnal-alert success">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="jurnal-alert error">{{ session('error') }}</div> @endif

    @if ($errors->any())
    <div class="jurnal-alert error">
        <strong>Periksa kembali data berikut:</strong>
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    @if($jurnal->status_validasi === 'menunggu_revisi')
    <div class="jurnal-alert warning">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong>Jurnal ini sedang menunggu revisi.</strong>
        Setelah disimpan, status akan berubah menjadi <strong>Sudah Direvisi</strong>.
    </div>
    @endif

    @php
    $statusMengajarAwal = $jurnal->jenis_pengajar
    ?? ($jurnal->guru_pengganti_id ? 'pengganti' : 'pengampu');

    $jenisPenggantianAwal = $jurnal->jenis_penggantian
    ?? ($statusMengajarAwal === 'pengganti' ? 'saya_menggantikan' : null);

    $guruLoginId = auth()->user()->guru->id ?? null;
    $isGuruPemilik = $jurnal->guru_id === $guruLoginId;
    $isGuruPengganti = $jurnal->guru_pengganti_id === $guruLoginId;

    $isJurnalPenggantian = $jurnal->status_penggantian
    && $jurnal->status_penggantian !== 'tidak_ada';

    $tampilkanInfoDigantikan = $isGuruPemilik
    && $isJurnalPenggantian
    && $jurnal->jenis_penggantian === 'saya_digantikan';

    // 🔧 Tentukan apakah field materi/absensi/foto/catatan ditampilkan
    // - Siti (pemilik jurnal penggantian) → TIDAK tampil (tugas Budi)
    // - Budi (pengganti) → tampil
    // - Jurnal biasa → tampil
    $tampilkanMateriDll = !($isGuruPemilik && $isJurnalPenggantian);

    $namaGuruTerkait = null;
    if ($isJurnalPenggantian) {
    if ($jurnal->jenis_penggantian === 'saya_digantikan') {
    $namaGuruTerkait = $jurnal->guruPengganti->user->name
    ?? $jurnal->guruPengganti->nama_guru
    ?? 'Guru Pengganti';
    } elseif ($jurnal->jenis_penggantian === 'saya_menggantikan') {
    $namaGuruTerkait = $jurnal->guruDigantikan->user->name
    ?? $jurnal->guruDigantikan->nama_guru
    ?? 'Guru Pengampu';
    }
    }
    @endphp

    <form
        action="{{ route('guru.jurnal.update', $jurnal->id) }}"
        method="POST"
        enctype="multipart/form-data"
        id="formEditJurnal">
        @csrf
        @method('PUT')

        <div class="jurnal-card">

            <div class="jurnal-heading">
                <i class="bi bi-journal-bookmark-fill"></i>
                <div>
                    <h3>Isi Jurnal Mengajar</h3>
                    <p>Lengkapi informasi pembelajaran di bawah ini.</p>
                </div>
            </div>

            {{-- ============================================================
                 STATUS MENGAJAR
            ============================================================ --}}
            @if(! $isJurnalPenggantian)
            <section class="jurnal-panel">
                <h4 class="jurnal-panel-title">Status Mengajar</h4>
                <p class="jurnal-panel-description">Pilih peran Anda pada sesi pembelajaran ini.</p>

                <div class="role-options">
                    <label class="role-option">
                        <input type="radio" name="status_mengajar" value="pengampu"
                            {{ old('status_mengajar', $statusMengajarAwal) === 'pengampu' ? 'checked' : '' }}>
                        <span>Guru Pengampu</span>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="status_mengajar" value="pengganti"
                            {{ old('status_mengajar', $statusMengajarAwal) === 'pengganti' ? 'checked' : '' }}>
                        <span>Guru Pengganti</span>
                    </label>
                </div>

                <div class="replacement-fields {{ old('status_mengajar', $statusMengajarAwal) === 'pengganti' ? 'active' : '' }}" id="replacementFields">
                    <div class="replacement-options">
                        <label class="replacement-radio">
                            <input type="radio" name="jenis_penggantian" value="saya_digantikan"
                                {{ old('jenis_penggantian', $jenisPenggantianAwal) === 'saya_digantikan' ? 'checked' : '' }}>
                            <span>Saya yang Digantikan</span>
                        </label>
                        <label class="replacement-radio">
                            <input type="radio" name="jenis_penggantian" value="saya_menggantikan"
                                {{ old('jenis_penggantian', $jenisPenggantianAwal) === 'saya_menggantikan' ? 'checked' : '' }}>
                            <span>Saya yang menggantikan</span>
                        </label>
                    </div>

                    <label for="guru_pendamping_id" class="replacement-label" id="labelGuruPengganti">
                        Nama Guru Pengampu <span class="required">*</span>
                    </label>

                    <select name="guru_pendamping_id" id="guru_pendamping_id" class="jurnal-control"
                        {{ old('status_mengajar', $statusMengajarAwal) === 'pengganti' ? '' : 'disabled' }}>
                        <option value="">Masukkan nama guru</option>
                        @foreach ($gurus as $guruPilihan)
                        <option value="{{ $guruPilihan->id }}"
                            {{ old('guru_pendamping_id', $jurnal->guru_pengganti_id ?? $jurnal->guru_pendamping_id) == $guruPilihan->id ? 'selected' : '' }}>
                            {{ $guruPilihan->user->name ?? $guruPilihan->nama_guru ?? 'Guru #' . $guruPilihan->id }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </section>

            @else
            {{-- Jurnal penggantian: ringkasan --}}
            <section class="jurnal-panel">
                <h4 class="jurnal-panel-title">Status Mengajar</h4>
                <p class="jurnal-panel-description">Jurnal ini adalah jurnal penggantian.</p>

                <div class="role-options">
                    <label class="role-option">
                        <input type="radio" checked disabled>
                        <span>Guru Pengganti</span>
                    </label>
                </div>

                <div class="replacement-fields active">
                    <label class="replacement-label">
                        @if($jurnal->jenis_penggantian === 'saya_digantikan')
                        Nama Guru Pengganti
                        @elseif($jurnal->jenis_penggantian === 'saya_menggantikan')
                        Nama Guru Pengampu (yang digantikan)
                        @else
                        Nama Guru Terkait
                        @endif
                        @if($isGuruPemilik) <span class="required">*</span> @endif
                    </label>

                    @if($isGuruPemilik)
                    {{-- SITI: select BISA DIUBAH --}}
                    <select name="guru_pendamping_id" id="guru_pendamping_id" class="jurnal-control">
                        <option value="">-- Pilih guru --</option>
                        @foreach ($gurus as $guruPilihan)
                        <option value="{{ $guruPilihan->id }}"
                            {{ ($jurnal->guru_pengganti_id ?? $jurnal->guru_digantikan_id) == $guruPilihan->id ? 'selected' : '' }}>
                            {{ $guruPilihan->user->name ?? $guruPilihan->nama_guru ?? 'Guru #' . $guruPilihan->id }}
                        </option>
                        @endforeach
                    </select>
                    <small class="field-help">
                        Anda bisa mengoreksi nama guru pengganti jika salah input.
                    </small>
                    @else
                    {{-- BUDI: readonly --}}
                    <select class="jurnal-control" disabled>
                        <option value="">{{ $namaGuruTerkait ?? '-' }}</option>
                    </select>
                    <small class="field-help">
                        Status mengajar dan guru pengganti tidak bisa diubah.
                    </small>
                    @endif
                </div>

                @if($jurnal->status_penggantian)
                <div class="badge-penggantian
        {{ $jurnal->status_penggantian === 'menunggu_diisi' ? 'menunggu' : '' }}
        {{ $jurnal->status_penggantian === 'belum_direvisi' ? 'revisi' : '' }}
        {{ $jurnal->status_penggantian === 'selesai_diisi' ? 'selesai' : '' }}">
                    @if($jurnal->status_penggantian === 'menunggu_diisi')
                    <i class="bi bi-hourglass-split"></i>
                    <strong>Menunggu diisi</strong> oleh {{ $namaGuruTerkait ?? 'guru pengganti' }}.
                    @elseif($jurnal->status_penggantian === 'belum_direvisi')
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Perlu direvisi</strong> — data sudah diisi sebelumnya.
                    @else
                    <i class="bi bi-check-circle-fill"></i>
                    <strong>Sudah diisi</strong> oleh {{ $namaGuruTerkait ?? 'guru pengganti' }}.
                    @endif
                </div>
                @endif
            </section>
            @endif

            {{-- Info panel khusus Siti --}}
            @if($tampilkanInfoDigantikan)
            <div class="info-digantikan" style="display:block;">
                <i class="bi bi-info-circle-fill"></i>
                <strong>Mode "Saya yang Digantikan".</strong><br>
                Tanggal, kelas, mapel, jam, dan nama guru pengganti tidak bisa diubah.
                Materi, absensi, catatan, dan foto akan diisi oleh guru pengganti.
            </div>
            @endif

            {{-- DATA JURNAL --}}
            <div class="jurnal-grid">

                {{-- TANGGAL --}}
                <div class="jurnal-field">
                    <label for="tanggal">
                        Tanggal Mengajar <span class="required">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" class="jurnal-control"
                        value="{{ old('tanggal', \Carbon\Carbon::parse($jurnal->tanggal)->format('Y-m-d')) }}"
                        {{ $isJurnalPenggantian ? 'readonly' : 'required' }}>
                    @if($isJurnalPenggantian)
                    <small class="field-help">Tanggal tidak bisa diubah pada jurnal penggantian.</small>
                    @endif
                </div>

                <div class="jurnal-field">
                    <label for="kelas_display">Kelas <span class="required">*</span></label>
                    <input type="text" id="kelas_display" class="jurnal-control"
                        value="{{ $jurnal->kelas->nama_kelas ?? 'Kelas #' . $jurnal->kelas_id }}" readonly>
                    <small class="field-help">Kelas tidak bisa diubah.</small>
                </div>

                <div class="jurnal-field">
                    <label for="mapel_display">Mata Pelajaran <span class="required">*</span></label>
                    <input type="text" id="mapel_display" class="jurnal-control"
                        value="{{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}" readonly>
                </div>

                <div class="jurnal-field">
                    <label for="jadwal_display">Jam Pelajaran <span class="required">*</span></label>
                    <input type="text" id="jadwal_display" class="jurnal-control"
                        value="Jam ke-{{ $jurnal->jam_mulai_ke }}-{{ $jurnal->jam_selesai_ke }}" readonly>
                    <small class="field-help">Jam tidak bisa diubah.</small>
                </div>

                {{-- 🔧 STATUS PENYELESAIAN --}}
                @if($tampilkanMateriDll)
                <div class="jurnal-field" id="fieldStatusPenyelesaian">
                    <label for="status_penyelesaian">Status Penyelesaian <span class="required">*</span></label>
                    <select name="status_penyelesaian" id="status_penyelesaian" class="jurnal-control" required>
                        <option value="selesai"
                            {{ old('status_penyelesaian', $jurnal->status_penyelesaian) === 'selesai' ? 'selected' : '' }}>
                            Tuntas
                        </option>
                        <option value="belum_selesai"
                            {{ old('status_penyelesaian', $jurnal->status_penyelesaian) === 'belum_selesai' ? 'selected' : '' }}>
                            Belum Tuntas
                        </option>
                    </select>
                </div>
                @endif

                <div class="jurnal-field">
                    <label for="semester_display">Semester Akademik <span class="required">*</span></label>
                    <input type="text" id="semester_display" class="jurnal-control"
                        value="{{ $coverAktif ? $coverAktif->tahun_ajaran . ' Semester ' . $coverAktif->semester : 'Cover jurnal belum tersedia' }}"
                        readonly>
                </div>

                {{-- 🔧 ALASAN BELUM TUNTAS --}}
                @if($tampilkanMateriDll)
                <div class="jurnal-field full" id="alasanContainer"
                    style="{{ old('status_penyelesaian', $jurnal->status_penyelesaian) === 'belum_selesai' ? '' : 'display:none;' }}">
                    <label for="alasan_belum_selesai">Alasan Belum Tuntas</label>
                    <textarea name="alasan_belum_selesai" id="alasan_belum_selesai" class="jurnal-control"
                        placeholder="Tuliskan alasan materi belum selesai">{{ old('alasan_belum_selesai', $jurnal->alasan_belum_selesai) }}</textarea>
                </div>
                @endif

                {{-- 🔧 ABSENSI --}}
                @if($tampilkanMateriDll)
                <div class="jurnal-field full" id="fieldAbsensi">
                    <label class="field-label">Absensi Siswa <span class="required">*</span></label>

                    <div id="sesiInfo" class="sesi-info" style="display:block;">
                        <i class="bi bi-clock-history"></i>
                        <span class="sesi-label" id="sesiLabel">
                            Sesi {{ $jurnal->jam_mulai_ke }}–{{ $jurnal->jam_selesai_ke }}
                        </span>
                        <span class="sesi-detail" id="sesiDetail">
                            {{ $jurnal->kelas->nama_kelas ?? '-' }} · {{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}
                        </span>
                    </div>

                    <div id="manualAttendance">
                        @foreach(['sakit' => 'Sakit', 'izin' => 'Izin', 'alpa' => 'Alpha'] as $statusKey => $label)
                        <div class="manual-attendance-row">
                            <label class="manual-attendance-label" for="jumlah_{{ $statusKey }}">{{ $label }} :</label>
                            <input type="number" id="jumlah_{{ $statusKey }}" class="manual-count"
                                min="0" max="100"
                                value="{{ old('jumlah_' . $statusKey, $jurnal->attendances->where('status_kehadiran', $statusKey)->count()) }}">
                            <div id="nama_{{ $statusKey }}" class="manual-name-list">
                                <select class="manual-name-select">
                                    <option value="">-</option>
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- 🔧 CATATAN --}}
                @if($tampilkanMateriDll)
                <div class="jurnal-field full" id="fieldCatatan">
                    <label for="keterangan">Catatan Tambahan</label>
                    <input type="text" name="keterangan" id="keterangan" class="jurnal-control"
                        value="{{ old('keterangan', $jurnal->keterangan) }}"
                        placeholder="Catatan atau evaluasi pembelajaran (opsional)">
                </div>
                @endif

                {{-- 🔧 FOTO --}}
                @if($tampilkanMateriDll)
                <div class="jurnal-field full" id="fieldFoto">
                    <label for="foto_kegiatan">Foto Kegiatan</label>
                    <label for="foto_kegiatan" class="upload-box">
                        <input type="file" name="foto_kegiatan" id="foto_kegiatan"
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

                    @if($jurnal->foto_kegiatan)
                    <img id="photoPreview" class="photo-preview"
                        src="{{ Storage::url($jurnal->foto_kegiatan) }}" alt="Foto kegiatan">
                    <div class="photo-current-info">
                        <i class="bi bi-image-fill"></i>
                        Foto saat ini. Pilih foto baru untuk mengganti.
                    </div>
                    @else
                    <img id="photoPreview" class="photo-preview" style="display:none;" alt="Pratinjau">
                    @endif
                </div>
                @endif
            </div>
        </div>

        <div class="jurnal-actions">
            <a href="{{ route('guru.jurnal-harian') }}" class="jurnal-btn btn-cancel">Batal</a>
            <button type="submit" class="jurnal-btn btn-save" id="saveJournalButton">Simpan Perubahan</button>
        </div>
    </form>
</div>

@php
$absensiTersimpan = $jurnal->attendances->mapWithKeys(function ($a) {
return [$a->murid_id => $a->status_kehadiran];
});

$muridsData = $murids->map(function ($m) {
return ['id' => $m->id, 'nama_siswa' => $m->nama_siswa];
});
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formEditJurnal');
        const replacementFields = document.getElementById('replacementFields');
        const guruSelect = document.getElementById('guru_pendamping_id');
        const labelGuru = document.getElementById('labelGuruPengganti');

        const statusPenyelesaian = document.getElementById('status_penyelesaian');
        const alasanContainer = document.getElementById('alasanContainer');

        const fotoInput = document.getElementById('foto_kegiatan');
        const uploadContent = document.getElementById('uploadContent');
        const selectedFile = document.getElementById('selectedFile');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileError = document.getElementById('fileError');
        const photoPreview = document.getElementById('photoPreview');

        const absensiTersimpan = @json($absensiTersimpan);
        const muridsData = @json($muridsData);

        let photoUrl = null;

        function selectedValue(name) {
            const selected = document.querySelector(`input[name="${name}"]:checked`);
            return selected ? selected.value : '';
        }

        const statusMengajarInputs = document.querySelectorAll('input[name="status_mengajar"]');

        function updateStatusMengajar() {
            const isPengganti = selectedValue('status_mengajar') === 'pengganti';
            if (replacementFields) {
                replacementFields.classList.toggle('active', isPengganti);
            }
            if (guruSelect && !guruSelect.readOnly) {
                guruSelect.disabled = !isPengganti;
                guruSelect.required = isPengganti;
            }
            updateLabelGuru();
        }

        function updateLabelGuru() {
            if (!labelGuru) return;
            const jenis = selectedValue('jenis_penggantian');
            labelGuru.textContent = jenis === 'saya_digantikan' ?
                'Nama Guru Pengganti *' :
                'Nama Guru Pengampu *';
        }

        if (statusMengajarInputs.length > 0) {
            statusMengajarInputs.forEach(input => input.addEventListener('change', updateStatusMengajar));
            document.querySelectorAll('input[name="jenis_penggantian"]').forEach(input => {
                input.addEventListener('change', updateLabelGuru);
            });
            updateStatusMengajar();
            updateLabelGuru();
        }

        if (statusPenyelesaian && alasanContainer) {
            statusPenyelesaian.addEventListener('change', function() {
                alasanContainer.style.display = statusPenyelesaian.value === 'belum_selesai' ? '' : 'none';
            });
        }

        // Absensi
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

        function getMuridPerStatus() {
            const perStatus = {
                sakit: [],
                izin: [],
                alpa: [],
                hadir: []
            };
            muridsData.forEach(murid => {
                const status = absensiTersimpan[murid.id] || 'hadir';
                if (perStatus[status]) perStatus[status].push(murid);
            });
            return perStatus;
        }

        function renderManualAttendance() {
            const muridPerStatus = getMuridPerStatus();

            attendanceCategories.forEach(category => {
                const countInput = document.getElementById(category.countId);
                const container = document.getElementById(category.containerId);
                if (!countInput || !container) return;

                const count = Math.max(0, Math.min(100, parseInt(countInput.value, 10) || 0));
                container.innerHTML = '';

                if (count === 0) {
                    const emptySelect = document.createElement('select');
                    emptySelect.className = 'manual-name-select';
                    emptySelect.disabled = true;
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = '-';
                    emptySelect.appendChild(opt);
                    container.appendChild(emptySelect);
                    return;
                }

                if (!muridsData.length) {
                    const emptySelect = document.createElement('select');
                    emptySelect.className = 'manual-name-select';
                    emptySelect.disabled = true;
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Belum ada murid di kelas ini';
                    emptySelect.appendChild(opt);
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

                    muridsData.forEach(murid => {
                        const opt = document.createElement('option');
                        opt.value = murid.id;
                        opt.textContent = murid.nama_siswa;
                        select.appendChild(opt);
                    });

                    if (muridCocok[i]) select.value = muridCocok[i].id;
                    container.appendChild(select);
                }
            });

            updateManualOptions();
        }

        function updateManualOptions() {
            const selects = Array.from(document.querySelectorAll('.manual-name-select[data-status]'));
            const selectedIds = selects.map(s => s.value).filter(Boolean);

            selects.forEach(select => {
                Array.from(select.options).forEach(option => {
                    if (!option.value) return;
                    option.disabled = selectedIds.includes(option.value) && select.value !== option.value;
                });
            });
        }

        attendanceCategories.forEach(category => {
            const input = document.getElementById(category.countId);
            if (input) {
                input.addEventListener('input', () => renderManualAttendance());
            }
        });

        const manualAtt = document.getElementById('manualAttendance');
        if (manualAtt) {
            manualAtt.addEventListener('change', function(event) {
                if (event.target.classList.contains('manual-name-select')) {
                    updateManualOptions();
                }
            });
        }

        // Upload foto
        if (fotoInput) {
            fotoInput.addEventListener('change', function() {
                const file = this.files[0];
                fileError.textContent = '';

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

                if (photoUrl) URL.revokeObjectURL(photoUrl);
                photoUrl = URL.createObjectURL(file);
                photoPreview.src = photoUrl;
                photoPreview.style.display = 'block';
            });
        }

        // Submit
        form.addEventListener('submit', function(event) {
            form.querySelectorAll('.manual-generated-input').forEach(input => input.remove());

            const statusInput = document.querySelector('input[name="status_mengajar"]:checked');
            if (statusInput && statusInput.value === 'pengganti' && guruSelect && !guruSelect.value) {
                event.preventDefault();
                alert('Pilih nama guru yang berkaitan dengan sesi penggantian.');
                guruSelect.focus();
                return;
            }

            // Validasi absensi hanya kalau field absensi ada
            const fieldAbsensi = document.getElementById('fieldAbsensi');
            if (fieldAbsensi) {
                const selects = Array.from(document.querySelectorAll('.manual-name-select[data-status]'));

                if (selects.some(s => !s.value)) {
                    event.preventDefault();
                    alert('Pilih nama siswa untuk setiap jumlah sakit, izin, dan alpha.');
                    return;
                }

                const ids = selects.map(s => s.value);
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

        renderManualAttendance();
    });
</script>
<script>
    window.closeSuccessModal = function() {
        window.location.href = "{{ route('guru.jurnal-harian') }}";
    };
</script>

@endsection