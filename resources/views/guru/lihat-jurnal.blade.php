@extends('layouts.app')

@section('title', 'Lihat Jurnal Harian')

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
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
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
        cursor: not-allowed;
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
        cursor: not-allowed;
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
        cursor: not-allowed;
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

    /* 🔑 READ-ONLY STYLING */
    .jurnal-control[disabled],
    .jurnal-control[readonly] {
        background: #f4f7f5;
        color: #4a5a50;
        cursor: not-allowed;
        opacity: 1;
    }

    .jurnal-control[disabled]:focus,
    .jurnal-control[readonly]:focus {
        border-color: #b8c0ba;
        box-shadow: none;
    }

    textarea.jurnal-control {
        min-height: 58px;
        height: auto;
        resize: vertical;
    }

    textarea.jurnal-control[disabled],
    textarea.jurnal-control[readonly] {
        resize: none;
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
        display: block;
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
        background: #f4f7f5;
        border: 1px solid #b8c0ba;
        border-radius: 10px;
        font-size: 13px;
        color: #4a5a50;
        cursor: not-allowed;
    }

    .manual-name-select {
        width: 100%;
        min-width: 0;
        height: 35px;
        padding: 5px 10px;
        background: #f4f7f5;
        border: 1px solid #b8c0ba;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        color: #4a5a50;
        cursor: not-allowed;
    }

    .manual-name-select[disabled] {
        opacity: 1;
    }

    .manual-name-list {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-top: 7px;
    }

    /* FOTO */
    .photo-display {
        display: block;
        max-width: 100%;
        max-height: 400px;
        margin: 0 auto;
        border-radius: 10px;
        border: 1px solid #c7d9cf;
        cursor: zoom-in;
        transition: transform .2s ease;
    }

    .photo-display:hover {
        transform: scale(1.02);
    }

    .photo-empty {
        display: flex;
        min-height: 125px;
        padding: 18px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 7px;
        color: #9aa39d;
        background: #f4f7f5;
        border: 2px dashed #c7d9cf;
        border-radius: 13px;
        text-align: center;
    }

    .photo-empty i {
        font-size: 34px;
        color: #b8c0ba;
    }

    .photo-empty strong {
        font-size: 13px;
        font-weight: 600;
    }

    .photo-empty small {
        font-size: 11px;
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
        gap: 6px;
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

    .btn-cancel:hover {
        background: #f4f4f4;
    }

    .btn-edit {
        color: white;
        background: #39745b;
        border: 1px solid #39745b;
        font-weight: 600;
    }

    .btn-edit:hover {
        background: #2d6049;
        color: white;
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

        .jurnal-header {
            flex-direction: column;
            align-items: flex-start;
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

        .jurnal-actions {
            flex-direction: column;
        }

        .jurnal-btn {
            width: 100%;
        }
    }
</style>

<div class="jurnal-page">

    <header class="jurnal-header">
        <div>
            <h2>Lihat Jurnal Harian</h2>
            <p>Detail kegiatan pembelajaran yang telah dicatat.</p>
        </div>
    </header>

    @if (session('success'))
    <div class="jurnal-alert success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="jurnal-alert error">{{ session('error') }}</div>
    @endif

    @if($jurnal->status_validasi === 'menunggu_revisi')
    <div class="jurnal-alert warning">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong>Jurnal ini perlu revisi.</strong>
        Klik tombol <strong>Edit Jurnal</strong> di bawah untuk memperbaiki.
    </div>
    @endif

    {{-- TIDAK ADA FORM — karena read-only --}}
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
                        name="status_mengajar_display"
                        value="pengampu"
                        {{ $statusMengajarAwal === 'pengampu' ? 'checked' : '' }}
                        disabled>
                    <span>Guru Pengampu</span>
                </label>

                <label class="role-option">
                    <input
                        type="radio"
                        name="status_mengajar_display"
                        value="pengganti"
                        {{ $statusMengajarAwal === 'pengganti' ? 'checked' : '' }}
                        disabled>
                    <span>Guru Pengganti</span>
                </label>
            </div>

            <div class="replacement-fields {{ $statusMengajarAwal === 'pengganti' ? 'active' : '' }}">
                <label class="replacement-label">
                    Nama Guru Pengampu
                </label>

                <select class="jurnal-control" disabled>
                    <option value="">
                        {{ $jurnal->guruPendamping->user->name ?? $jurnal->guruPendamping->nama_guru ?? 'Tidak ada guru pendamping' }}
                    </option>
                </select>
            </div>
        </section>

        {{-- DATA JURNAL --}}
        <div class="jurnal-grid">

            <div class="jurnal-field">
                <label for="tanggal_display">
                    Tanggal Mengajar
                </label>
                <input
                    type="text"
                    id="tanggal_display"
                    class="jurnal-control"
                    value="{{ $jurnal->tanggal ? \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('l, d F Y') : '-' }}"
                    readonly>
            </div>

            <div class="jurnal-field">
                <label for="kelas_display">
                    Kelas
                </label>
                <input
                    type="text"
                    id="kelas_display"
                    class="jurnal-control"
                    value="{{ $jurnal->kelas->nama_kelas ?? 'Kelas #' . $jurnal->kelas_id }}"
                    readonly>
            </div>

            <div class="jurnal-field">
                <label for="mapel_display">
                    Mata Pelajaran
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
                    Jam Pelajaran
                </label>
                <input
                    type="text"
                    id="jadwal_display"
                    class="jurnal-control"
                    value="Jam ke-{{ $jurnal->jam_mulai_ke }}-{{ $jurnal->jam_selesai_ke }}"
                    readonly>
            </div>

            <div class="jurnal-field full">
                <label for="pokok_bahasan_display">
                    Pokok Bahasan/Materi
                </label>
                <textarea
                    id="pokok_bahasan_display"
                    class="jurnal-control"
                    readonly>{{ $jurnal->pokok_bahasan ?: '-' }}</textarea>
            </div>

            <div class="jurnal-field">
                <label for="status_penyelesaian_display">
                    Status Penyelesaian
                </label>
                <input
                    type="text"
                    id="status_penyelesaian_display"
                    class="jurnal-control"
                    value="{{ $jurnal->status_penyelesaian === 'selesai' ? 'Tuntas' : 'Belum Tuntas' }}"
                    readonly>
            </div>

            <div class="jurnal-field">
                <label for="semester_display">
                    Semester Akademik
                </label>
                <input
                    type="text"
                    id="semester_display"
                    class="jurnal-control"
                    value="{{ $jurnal->coverJurnal ? $jurnal->coverJurnal->tahun_ajaran . ' Semester ' . $jurnal->coverJurnal->semester : '-' }}"
                    readonly>
            </div>

            @if($jurnal->status_penyelesaian === 'belum_selesai')
            <div class="jurnal-field full">
                <label for="alasan_display">
                    Alasan Belum Tuntas
                </label>
                <textarea
                    id="alasan_display"
                    class="jurnal-control"
                    readonly>{{ $jurnal->alasan_belum_selesai ?: '-' }}</textarea>
            </div>
            @endif

            {{-- ABSENSI SISWA --}}
            <div class="jurnal-field full">
                <label class="field-label">
                    Absensi Siswa
                </label>

                <div class="sesi-info">
                    <i class="bi bi-clock-history"></i>
                    <span class="sesi-label">
                        Sesi {{ $jurnal->jam_mulai_ke }}–{{ $jurnal->jam_selesai_ke }}
                    </span>
                    <span class="sesi-detail">
                        {{ $jurnal->kelas->nama_kelas ?? '-' }} · {{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}
                    </span>
                </div>

                @php
                // Kelompokkan absensi per status
                $absensiPerStatus = [
                'sakit' => $jurnal->attendances->where('status_kehadiran', 'sakit')->values(),
                'izin' => $jurnal->attendances->where('status_kehadiran', 'izin')->values(),
                'alpa' => $jurnal->attendances->where('status_kehadiran', 'alpa')->values(),
                ];
                @endphp

                <div id="manualAttendance">
                    @foreach(['sakit' => 'Sakit', 'izin' => 'Izin', 'alpa' => 'Alpha'] as $statusKey => $statusLabel)
                    <div class="manual-attendance-row">
                        <label class="manual-attendance-label">
                            {{ $statusLabel }} :
                        </label>
                        <input
                            type="number"
                            class="manual-count"
                            value="{{ $absensiPerStatus[$statusKey]->count() }}"
                            readonly>
                        <div class="manual-name-list">
                            @if($absensiPerStatus[$statusKey]->count() > 0)
                            @foreach($absensiPerStatus[$statusKey] as $attendance)
                            <select class="manual-name-select" disabled>
                                <option value="">
                                    {{ $attendance->murid->nama_siswa ?? 'Murid #' . $attendance->murid_id }}
                                </option>
                            </select>
                            @endforeach
                            @else
                            <select class="manual-name-select" disabled>
                                <option value="">-</option>
                            </select>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="jurnal-field full">
                <label for="keterangan_display">Catatan Tambahan</label>
                <input
                    type="text"
                    id="keterangan_display"
                    class="jurnal-control"
                    value="{{ $jurnal->keterangan ?: 'Tidak ada catatan tambahan.' }}"
                    readonly>
            </div>

            <div class="jurnal-field full">
                <label>Foto Kegiatan</label>

                @if($jurnal->foto_kegiatan)
                <img
                    id="photoDisplay"
                    class="photo-display"
                    src="{{ Storage::url($jurnal->foto_kegiatan) }}"
                    alt="Foto kegiatan pembelajaran"
                    onclick="openPhotoModal(this.src)">
                <div class="photo-current-info">
                    <i class="bi bi-image-fill"></i>
                    Klik foto untuk memperbesar.
                </div>
                @else
                <div class="photo-empty">
                    <i class="bi bi-image"></i>
                    <strong>Belum ada foto kegiatan</strong>
                    <small>Guru belum mengunggah foto untuk jurnal ini.</small>
                </div>
                @endif
            </div>
        </div>

        <div class="jurnal-actions">
            <a href="{{ route('guru.jurnal-harian') }}"
                class="jurnal-btn btn-cancel">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

            @if($jurnal->status_validasi !== 'valid')
            <a href="{{ route('guru.edit-jurnal', $jurnal->id) }}"
                class="jurnal-btn btn-edit">
                <i class="bi bi-pencil-square"></i>
                Edit Jurnal
            </a>
            @endif
        </div>
    </div>
</div>

{{-- Modal Zoom Foto --}}
<div id="photoModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.85); z-index:9999; align-items:center; justify-content:center; cursor:zoom-out;" onclick="closePhotoModal()">
    <img id="photoModalImg" style="max-width:95%; max-height:95%; border-radius:8px;" alt="Foto kegiatan">
</div>

<script>
    function openPhotoModal(src) {
        const modal = document.getElementById('photoModal');
        const img = document.getElementById('photoModalImg');
        img.src = src;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePhotoModal() {
        const modal = document.getElementById('photoModal');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePhotoModal();
        }
    });
</script>
@endsection