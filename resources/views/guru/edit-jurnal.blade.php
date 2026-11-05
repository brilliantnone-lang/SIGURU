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

    .jurnal-control[readonly] {
        background: #f4f7f5;
        color: #6b7d71;
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
        display: block;
        max-width: 100%;
        max-height: 250px;
        margin: 10px auto 0;
        border-radius: 8px;
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
        <h2>Edit Jurnal Harian</h2>
        <p>Perbarui informasi pembelajaran di bawah ini.</p>
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

    @if($jurnal->status_validasi === 'menunggu_revisi')
    <div class="jurnal-alert warning">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong>Jurnal ini sedang menunggu revisi.</strong>
        Setelah disimpan, status akan berubah menjadi <strong>Sudah Direvisi</strong> dan menunggu validasi Kepala Sekolah.
    </div>
    @endif

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

            {{-- STATUS MENGAJAR --}}
            <section class="jurnal-panel">
                <h4 class="jurnal-panel-title">Status Mengajar</h4>
                <p class="jurnal-panel-description">
                    Pilih peran Anda pada sesi pembelajaran ini.
                </p>

                @php
                    $statusMengajarAwal = $jurnal->guru_pendamping_id ? 'pengganti' : 'pengampu';
                @endphp

                <div class="role-options">
                    <label class="role-option">
                        <input
                            type="radio"
                            name="status_mengajar"
                            value="pengampu"
                            {{ old('status_mengajar', $statusMengajarAwal) === 'pengampu' ? 'checked' : '' }}>
                        <span>Guru Pengampu</span>
                    </label>

                    <label class="role-option">
                        <input
                            type="radio"
                            name="status_mengajar"
                            value="pengganti"
                            {{ old('status_mengajar', $statusMengajarAwal) === 'pengganti' ? 'checked' : '' }}>
                        <span>Guru Pengganti</span>
                    </label>
                </div>

                <div class="replacement-fields {{ old('status_mengajar', $statusMengajarAwal) === 'pengganti' ? 'active' : '' }}" id="replacementFields">

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
                        {{ old('status_mengajar', $statusMengajarAwal) === 'pengganti' ? '' : 'disabled' }}>
                        <option value="">Masukkan nama guru</option>

                        @foreach ($gurus as $guruPilihan)
                        <option
                            value="{{ $guruPilihan->id }}"
                            {{ old('guru_pendamping_id', $jurnal->guru_pendamping_id) == $guruPilihan->id ? 'selected' : '' }}>
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
                        value="{{ old('tanggal', \Carbon\Carbon::parse($jurnal->tanggal)->format('Y-m-d')) }}"
                        required>
                </div>

                <div class="jurnal-field">
                    <label for="kelas_display">
                        Kelas <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="kelas_display"
                        class="jurnal-control"
                        value="{{ $jurnal->kelas->nama_kelas ?? 'Kelas #' . $jurnal->kelas_id }}"
                        readonly>
                    <small class="field-help">Kelas tidak bisa diubah saat edit jurnal.</small>
                </div>

                <div class="jurnal-field">
                    <label for="mapel_display">
                        Mata Pelajaran <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="mapel_display"
                        class="jurnal-control"
                        value="{{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}"
                        readonly>
                </div>

                <div class="jurnal-field">
                    <label for="jadwal_display">
                        Jam Pelajaran <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="jadwal_display"
                        class="jurnal-control"
                        value="Jam ke-{{ $jurnal->jam_mulai_ke }}-{{ $jurnal->jam_selesai_ke }}"
                        readonly>
                    <small class="field-help">Jam pelajaran tidak bisa diubah saat edit jurnal.</small>
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
                        required>{{ old('pokok_bahasan', $jurnal->pokok_bahasan) }}</textarea>
                </div>

                <div class="jurnal-field">
                    <label for="status_penyelesaian">
                        Status Penyelesaian <span class="required">*</span>
                    </label>
                    <select
                        name="status_penyelesaian"
                        id="status_penyelesaian"
                        class="jurnal-control"
                        required>
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
                    style="{{ old('status_penyelesaian', $jurnal->status_penyelesaian) === 'belum_selesai' ? '' : 'display:none;' }}">
                    <label for="alasan_belum_selesai">Alasan Belum Tuntas</label>
                    <textarea
                        name="alasan_belum_selesai"
                        id="alasan_belum_selesai"
                        class="jurnal-control"
                        placeholder="Tuliskan alasan materi belum selesai">{{ old('alasan_belum_selesai', $jurnal->alasan_belum_selesai) }}</textarea>
                </div>

                {{-- ABSENSI SISWA --}}
                <div class="jurnal-field full">
                    <label class="field-label">
                        Absensi Siswa <span class="required">*</span>
                    </label>

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
                                value="{{ old('jumlah_sakit', $jurnal->attendances->where('status_kehadiran', 'sakit')->count()) }}">
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
                                value="{{ old('jumlah_izin', $jurnal->attendances->where('status_kehadiran', 'izin')->count()) }}">
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
                                value="{{ old('jumlah_alpa', $jurnal->attendances->where('status_kehadiran', 'alpa')->count()) }}">
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
                        value="{{ old('keterangan', $jurnal->keterangan) }}"
                        placeholder="Catatan atau evaluasi pembelajaran (opsional)">
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
                        hidden>

                    @if($jurnal->foto_kegiatan)
                    <img
                        id="photoPreview"
                        class="photo-preview"
                        src="{{ Storage::url($jurnal->foto_kegiatan) }}"
                        alt="Foto kegiatan">
                    <div class="photo-current-info">
                        <i class="bi bi-image-fill"></i>
                        Foto saat ini. Pilih foto baru untuk mengganti.
                    </div>
                    @else
                    <img
                        id="photoPreview"
                        class="photo-preview"
                        style="display:none;"
                        alt="Pratinjau foto kegiatan">
                    @endif
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
                id="saveJournalButton">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@php
    // Siapkan data absensi tersimpan dalam format: { murid_id: status }
    $absensiTersimpan = $jurnal->attendances->mapWithKeys(function ($a) {
        return [$a->murid_id => $a->status_kehadiran];
    });

    // Siapkan data murid: [{ id, nama_siswa }]
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
        const photoLabel = document.getElementById('photoLabel');
        const photoPreview = document.getElementById('photoPreview');

        // Data absensi tersimpan & murid dari PHP (sudah disiapkan di @php)
        const absensiTersimpan = @json($absensiTersimpan);
        const muridsData = @json($muridsData);

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

            labelGuru.textContent = jenis === 'saya_digantikan' ?
                'Nama Guru Pengganti *' :
                'Nama Guru Pengampu *';
        }

        document.querySelectorAll('input[name="status_mengajar"]').forEach(input => {
            input.addEventListener('change', updateStatusMengajar);
        });

        document.querySelectorAll('input[name="jenis_penggantian"]').forEach(input => {
            input.addEventListener('change', updateLabelGuru);
        });

        /* STATUS PENYELESAIAN */
        function updateAlasan() {
            alasanContainer.style.display =
                statusPenyelesaian.value === 'belum_selesai' ? '' : 'none';
        }

        statusPenyelesaian.addEventListener('change', updateAlasan);

        /* ABSENSI MANUAL */
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
                if (perStatus[status]) {
                    perStatus[status].push(murid);
                }
            });

            return perStatus;
        }

        function renderManualAttendance() {
            const muridPerStatus = getMuridPerStatus();

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

                if (!muridsData.length) {
                    const emptySelect = document.createElement('select');
                    emptySelect.className = 'manual-name-select';
                    emptySelect.disabled = true;

                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Belum ada murid di kelas ini';

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

                    muridsData.forEach(murid => {
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
                renderManualAttendance();
            });
        });

        document.getElementById('manualAttendance').addEventListener('change', function(event) {
            if (event.target.classList.contains('manual-name-select')) {
                updateManualOptions();
            }
        });

        /* UNGGAH FOTO */
        fotoInput.addEventListener('change', function() {
            const file = this.files[0];

            if (photoUrl) {
                URL.revokeObjectURL(photoUrl);
                photoUrl = null;
            }

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
        form.addEventListener('submit', function(event) {
            form.querySelectorAll('.manual-generated-input').forEach(input => input.remove());

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
        renderManualAttendance();
    });
</script>
@endsection