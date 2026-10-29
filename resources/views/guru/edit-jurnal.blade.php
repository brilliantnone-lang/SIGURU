@extends('layouts.app')

@section('title', 'Edit Jurnal Harian')

@section('content')
<div class="edit-jurnal-page">

    {{-- HEADER --}}
    <div class="page-heading">
        <h2>Jurnal Harian Guru</h2>
        <p>Perbarui catatan kegiatan pembelajaran Anda.</p>
    </div>

    {{-- KARTU FORM --}}
    <div class="edit-card">

        <div class="card-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Edit Jurnal Mengajar</h3>
                <p>Ubah informasi pembelajaran sesuai kegiatan yang dilaksanakan.</p>
            </div>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- STATUS MENGAJAR --}}
            <div class="teaching-status-box">
                <h4>Status Mengajar</h4>
                <p>Pilih peran Anda pada sesi pembelajaran ini.</p>

                <div class="teaching-options">
                    <label class="teaching-option">
                        <input type="radio" name="status_mengajar"
                               value="pengampu"
                               {{ old('status_mengajar', $jurnal->status_mengajar ?? 'pengampu') == 'pengampu' ? 'checked' : '' }}>
                        <span>Guru Pengampu</span>
                    </label>

                    <label class="teaching-option">
                        <input type="radio" name="status_mengajar"
                               value="pengganti"
                               {{ old('status_mengajar', $jurnal->status_mengajar ?? '') == 'pengganti' ? 'checked' : '' }}>
                        <span>Guru Pengganti</span>
                    </label>
                </div>
            </div>

            <div class="form-grid">

                {{-- TANGGAL --}}
                <div class="form-group">
                    <label for="tanggal">Tanggal Mengajar <span>*</span></label>
                    <input type="date" id="tanggal" name="tanggal"
                           value="{{ old('tanggal', $jurnal->tanggal ? \Carbon\Carbon::parse($jurnal->tanggal)->format('Y-m-d') : '') }}"
                           required>
                </div>

                {{-- KELAS --}}
                <div class="form-group">
                    <label for="kelas_id">Kelas <span>*</span></label>
                    <select id="kelas_id" name="kelas_id" required>
                        <option value="">Pilih Kelas</option>
                        @foreach(($kelas ?? collect()) as $itemKelas)
                            <option value="{{ $itemKelas->id }}"
                                {{ (string) old('kelas_id', $jurnal->kelas_id) === (string) $itemKelas->id ? 'selected' : '' }}>
                                {{ $itemKelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- MATA PELAJARAN --}}
                <div class="form-group">
                    <label for="mata_pelajaran">Mata Pelajaran <span>*</span></label>
                    <input type="text" id="mata_pelajaran" name="mata_pelajaran"
                           value="{{ old('mata_pelajaran', $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? $jurnal->mata_pelajaran ?? '') }}"
                           placeholder="Masukkan mata pelajaran" required>
                </div>

                {{-- JAM PELAJARAN --}}
                <div class="form-group">
                    <label for="jam_pelajaran">Jam Pelajaran <span>*</span></label>
                    <select id="jam_pelajaran" name="jam_pelajaran" required>
                        <option value="">Pilih Jam Pelajaran</option>
                        <option value="1-2" {{ old('jam_pelajaran', ($jurnal->jam_mulai_ke ?? '') . '-' . ($jurnal->jam_selesai_ke ?? '')) == '1-2' ? 'selected' : '' }}>Jam ke 1-2</option>
                        <option value="3-4" {{ old('jam_pelajaran', ($jurnal->jam_mulai_ke ?? '') . '-' . ($jurnal->jam_selesai_ke ?? '')) == '3-4' ? 'selected' : '' }}>Jam ke 3-4</option>
                        <option value="5-6" {{ old('jam_pelajaran', ($jurnal->jam_mulai_ke ?? '') . '-' . ($jurnal->jam_selesai_ke ?? '')) == '5-6' ? 'selected' : '' }}>Jam ke 5-6</option>
                        <option value="7-8" {{ old('jam_pelajaran', ($jurnal->jam_mulai_ke ?? '') . '-' . ($jurnal->jam_selesai_ke ?? '')) == '7-8' ? 'selected' : '' }}>Jam ke 7-8</option>
                    </select>
                </div>

                {{-- POKOK BAHASAN --}}
                <div class="form-group full-width">
                    <label for="pokok_bahasan">Pokok Bahasan/Materi <span>*</span></label>
                    <input type="text" id="pokok_bahasan" name="pokok_bahasan"
                           value="{{ old('pokok_bahasan', $jurnal->pokok_bahasan) }}"
                           placeholder="Tuliskan pokok bahasan yang diajarkan hari ini" required>
                </div>

                {{-- STATUS PENYELESAIAN --}}
                <div class="form-group">
                    <label for="status_penyelesaian">Status Penyelesaian <span>*</span></label>
                    <select id="status_penyelesaian" name="status_penyelesaian" required>
                        <option value="selesai" {{ old('status_penyelesaian', $jurnal->status_penyelesaian) == 'selesai' ? 'selected' : '' }}>Tuntas</option>
                        <option value="belum_selesai" {{ old('status_penyelesaian', $jurnal->status_penyelesaian) == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    </select>
                </div>

                {{-- SEMESTER --}}
                <div class="form-group">
                    <label for="semester">Tahun Ajaran / Semester <span>*</span></label>
                    <select id="semester" name="semester" required>
                        <option value="">Pilih Semester</option>
                        <option value="2026/2027-Ganjil" {{ old('semester', $jurnal->semester ?? '') == '2026/2027-Ganjil' ? 'selected' : '' }}>2026/2027 Semester Ganjil</option>
                        <option value="2026/2027-Genap" {{ old('semester', $jurnal->semester ?? '') == '2026/2027-Genap' ? 'selected' : '' }}>2026/2027 Semester Genap</option>
                    </select>
                </div>

                {{-- ALASAN BELUM SELESAI --}}
                <div class="form-group full-width" id="alasanGroup"
                     @if($jurnal->status_penyelesaian == 'selesai') hidden @endif>
                    <label for="alasan_belum_selesai">Alasan Belum Selesai <span>*</span></label>
                    <textarea id="alasan_belum_selesai" name="alasan_belum_selesai"
                              rows="2"
                              placeholder="Jelaskan alasan materi belum selesai">{{ old('alasan_belum_selesai', $jurnal->alasan_belum_selesai) }}</textarea>
                </div>

                {{-- ABSENSI SISWA --}}
                <div class="form-group full-width attendance-group">
                    <label>Absensi Siswa <span>*</span></label>

                    <label class="radio-line">
                        <input type="radio" name="sumber_absensi" value="otomatis"
                               {{ old('sumber_absensi', 'manual') == 'otomatis' ? 'checked' : '' }}>
                        <span>Ambil Data dari Absensi Siswa</span>
                    </label>

                    <label class="radio-line">
                        <input type="radio" name="sumber_absensi" value="manual"
                               {{ old('sumber_absensi', 'manual') == 'manual' ? 'checked' : '' }}>
                        <span>Masukkan Data Absen Sendiri</span>
                    </label>

                    <div id="manualAttendance" class="manual-attendance">
                        @foreach([
                            'sakit' => 'Sakit',
                            'izin' => 'Izin',
                            'alpha' => 'Alpha'
                        ] as $key => $label)
                            <div class="attendance-row">
                                <label for="{{ $key }}">{{ $label }} :</label>
                                <input type="number" min="0" id="{{ $key }}"
                                       name="absensi[{{ $key }}]"
                                       value="{{ old('absensi.' . $key, 0) }}">
                                <input type="text"
                                       name="nama_siswa[{{ $key }}]"
                                       placeholder="Nama siswa (opsional)">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- CATATAN --}}
                <div class="form-group full-width">
                    <label for="keterangan">Catatan Tambahan</label>
                    <input type="text" id="keterangan" name="keterangan"
                           value="{{ old('keterangan', $jurnal->keterangan) }}"
                           placeholder="Catatan atau evaluasi pembelajaran (opsional)">
                </div>

                {{-- FOTO KEGIATAN --}}
                <div class="form-group full-width">
                    <label for="foto_kegiatan">Foto Kegiatan</label>

                    <label class="upload-box" for="foto_kegiatan">
                        <input type="file" id="foto_kegiatan"
                               name="foto_kegiatan"
                               accept="image/jpeg,image/png" hidden>

                        <div id="uploadPlaceholder" class="upload-placeholder">
                            <i class="bi bi-image-fill"></i>
                            <strong>
                                Klik untuk {{ $jurnal->foto_kegiatan ? 'mengganti foto kegiatan' : 'memilih foto kegiatan pembelajaran' }}
                            </strong>
                            <span>JPG atau PNG - Batas Ukuran 3 MB</span>
                        </div>

                        <img id="previewFoto"
                             src="{{ $jurnal->foto_kegiatan ? asset('storage/' . $jurnal->foto_kegiatan) : '' }}"
                             alt="Foto kegiatan"
                             @if(!$jurnal->foto_kegiatan) hidden @endif>
                    </label>

                    <small id="uploadError" class="upload-error"></small>
                </div>

            </div>

            {{-- TOMBOL BAWAH --}}
            <div class="form-actions">
                <a href="{{ route('guru.jurnal-harian') }}" class="btn-cancel">
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
    .edit-jurnal-page {
        width: 100%;
        color: #202720;
        font-family: inherit;
        padding-bottom: 15px;
    }

    .page-heading {
        margin-bottom: 14px;
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

    .edit-card {
        padding: 13px 15px 15px;
        background: #fff;
        border: 1px solid #b9d0c5;
        border-radius: 7px;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .12);
    }

    .card-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 12px;
    }

    .card-heading > i {
        font-size: 27px;
        color: #39765f;
    }

    .card-heading h3 {
        margin: 0 0 3px;
        color: #171717;
        font-size: 16px;
        font-weight: 700;
    }

    .card-heading p {
        margin: 0;
        color: #999;
        font-size: 10px;
    }

    .teaching-status-box {
        margin-bottom: 14px;
        padding: 12px;
        border: 2px solid #d2e4db;
        border-radius: 12px;
        background: #effaf5;
    }

    .teaching-status-box h4 {
        margin: 0 0 4px;
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
        padding: 6px 10px;
        border: 1px solid #d5ded9;
        border-radius: 8px;
        background: #fff;
        color: #777;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .teaching-option:has(input:checked) {
        border-color: #8cc8ad;
        background: #d9f8e9;
        color: #39765f;
    }

    .teaching-option input,
    .radio-line input {
        accent-color: #39765f;
    }

    .form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 12px 28px;
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
        line-height: 1.4;
    }

    .form-group > label > span {
        color: #dc2626;
    }

    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group input[type="number"],
    .form-group select,
    .form-group textarea {
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        min-height: 32px;
        padding: 6px 9px;
        border: 1px solid #bdbdbd;
        border-radius: 8px;
        background: #fff;
        color: #303030;
        font-family: inherit;
        font-size: 12px;
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #39765f;
        box-shadow: 0 0 0 2px rgba(57, 118, 95, .12);
    }

    .attendance-group {
        gap: 9px;
    }

    .radio-line {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #444;
        font-size: 12px;
        cursor: pointer;
    }

    .manual-attendance {
        display: grid;
        gap: 7px;
        margin-top: 4px;
        padding: 10px;
        border: 1px solid #d2e4db;
        border-radius: 8px;
        background: #f7fcf9;
    }

    .attendance-row {
        display: grid;
        grid-template-columns: 55px 55px minmax(0, 1fr);
        align-items: center;
        gap: 8px;
    }

    .attendance-row label {
        font-size: 11px;
        font-weight: 600;
    }

    .attendance-row input {
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        min-height: 30px;
        padding: 5px 7px;
        border: 1px solid #cbd8d0;
        border-radius: 6px;
        background: #fff;
        font-size: 11px;
    }

    .upload-box {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 115px;
        padding: 10px;
        border: 2px solid #d2e4db;
        border-radius: 11px;
        background: #effaf5;
        cursor: pointer;
    }

    .upload-placeholder {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 5px;
        text-align: center;
        color: #39765f;
    }

    .upload-placeholder i {
        font-size: 27px;
    }

    .upload-placeholder strong {
        font-size: 13px;
    }

    .upload-placeholder span {
        font-size: 11px;
    }

    #previewFoto {
        display: block;
        max-width: 100%;
        max-height: 250px;
        border-radius: 6px;
        object-fit: contain;
    }

    #previewFoto[hidden],
    .upload-placeholder[hidden],
    [hidden] {
        display: none !important;
    }

    .upload-error {
        color: #b91c1c;
        font-size: 11px;
    }

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 16px;
        margin-top: 24px;
    }

    .btn-cancel,
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 45px;
        padding: 10px 22px;
        border-radius: 11px;
        font-family: inherit;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s, color .15s;
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
    }

    @media (max-width: 650px) {
        .page-heading h2 {
            font-size: 22px;
        }

        .edit-card {
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

        .attendance-row {
            grid-template-columns: 45px 45px minmax(0, 1fr);
            gap: 5px;
        }

        .form-actions {
            gap: 8px;
            margin-top: 18px;
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
    // Menampilkan alasan ketika status belum selesai
    const statusSelect = document.getElementById('status_penyelesaian');
    const alasanGroup = document.getElementById('alasanGroup');
    const alasanInput = document.getElementById('alasan_belum_selesai');

    function updateAlasan() {
        const belumSelesai = statusSelect.value === 'belum_selesai';

        alasanGroup.hidden = !belumSelesai;
        alasanInput.required = belumSelesai;
    }

    statusSelect.addEventListener('change', updateAlasan);
    updateAlasan();

    // Menampilkan absensi manual hanya jika dipilih
    const sumberAbsensi = document.querySelectorAll('input[name="sumber_absensi"]');
    const manualAttendance = document.getElementById('manualAttendance');

    function updateAbsensi() {
        const manual = document.querySelector(
            'input[name="sumber_absensi"]:checked'
        )?.value === 'manual';

        manualAttendance.hidden = !manual;
    }

    sumberAbsensi.forEach(function (radio) {
        radio.addEventListener('change', updateAbsensi);
    });

    updateAbsensi();

    // Pratinjau foto yang dipilih
    const fotoInput = document.getElementById('foto_kegiatan');
    const previewFoto = document.getElementById('previewFoto');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const uploadError = document.getElementById('uploadError');

    fotoInput.addEventListener('change', function () {
        const file = fotoInput.files[0];

        uploadError.textContent = '';

        if (!file) {
            return;
        }

        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            uploadError.textContent = 'Foto harus berformat JPG atau PNG.';
            fotoInput.value = '';
            return;
        }

        if (file.size > 3 * 1024 * 1024) {
            uploadError.textContent = 'Ukuran foto maksimal 3 MB.';
            fotoInput.value = '';
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