@extends('layouts.app')

@section('title', 'Detail Jurnal Harian')

@section('content')
<div class="detail-jurnal-page">

    {{-- HEADER HALAMAN --}}
    <div class="page-heading">
        <h2>Jurnal Harian Guru</h2>
        <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
    </div>

    {{-- KARTU DETAIL JURNAL --}}
    <div class="detail-card">

        {{-- JUDUL KARTU --}}
        <div class="detail-card-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Detail Jurnal Mengajar</h3>
                <p>Informasi kegiatan pembelajaran yang telah dicatat</p>
            </div>
        </div>

        {{-- STATUS MENGAJAR --}}
        <div class="teaching-status-box">
            <h4>Status Mengajar</h4>
            <p>Peran guru pada sesi pembelajaran ini.</p>

            <div class="teaching-options">
                <span class="teaching-option active">
                    <i class="bi bi-record-circle-fill"></i>
                    {{ $jurnal->status_mengajar == 'pengganti'
                        ? 'Guru Pengganti'
                        : 'Guru Pengampu' }}
                </span>
            </div>
        </div>

        {{-- INFORMASI JURNAL --}}
        <div class="detail-grid">

            {{-- TANGGAL --}}
            <div class="detail-item">
                <span class="detail-label">Tanggal Mengajar</span>
                <div class="detail-value">
                    @if($jurnal->tanggal)
                        {{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d/m/Y') }}
                    @else
                        -
                    @endif
                </div>
            </div>

            {{-- KELAS --}}
            <div class="detail-item">
                <span class="detail-label">Kelas</span>
                <div class="detail-value">
                    {{ $jurnal->kelas->nama_kelas ?? '-' }}
                </div>
            </div>

            {{-- MATA PELAJARAN --}}
            <div class="detail-item">
                <span class="detail-label">Mata Pelajaran</span>
                <div class="detail-value">
                    {{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran
                        ?? $jurnal->mata_pelajaran
                        ?? '-' }}
                </div>
            </div>

            {{-- JAM PELAJARAN --}}
            <div class="detail-item">
                <span class="detail-label">Jam Pelajaran</span>
                <div class="detail-value">
                    Jam ke {{ $jurnal->jam_mulai_ke ?? '-' }}-{{ $jurnal->jam_selesai_ke ?? '-' }}
                </div>
            </div>

            {{-- POKOK BAHASAN --}}
            <div class="detail-item full-width">
                <span class="detail-label">Pokok Bahasan/Materi</span>
                <div class="detail-value">
                    {{ $jurnal->pokok_bahasan ?? '-' }}
                </div>
            </div>

            {{-- STATUS PENYELESAIAN --}}
            <div class="detail-item">
                <span class="detail-label">Status Penyelesaian</span>
                <div class="detail-value">
                    @if($jurnal->status_penyelesaian == 'selesai')
                        <span class="status-badge status-complete">Tuntas</span>
                    @else
                        <span class="status-badge status-incomplete">Belum Selesai</span>
                    @endif
                </div>
            </div>

            {{-- SEMESTER --}}
            <div class="detail-item">
                <span class="detail-label">Tahun Ajaran / Semester</span>
                <div class="detail-value">
                    {{ $jurnal->semester ?? '-' }}
                </div>
            </div>

            {{-- ALASAN BELUM SELESAI --}}
            @if($jurnal->status_penyelesaian != 'selesai')
                <div class="detail-item full-width">
                    <span class="detail-label">Alasan Belum Selesai</span>
                    <div class="detail-value">
                        {{ $jurnal->alasan_belum_selesai ?? '-' }}
                    </div>
                </div>
            @endif

        </div>

        {{-- ABSENSI SISWA --}}
        <div class="attendance-section">
            <div class="section-heading">
                <i class="bi bi-people-fill"></i>
                <h4>Absensi Siswa</h4>
            </div>

            <div class="attendance-content">

                @php
                    $absensi = $jurnal->absensi_siswa ?? null;
                @endphp

                @if(is_array($absensi) || is_object($absensi))
                    @foreach($absensi as $jenis => $jumlah)
                        <div class="attendance-item">
                            <span>{{ ucfirst($jenis) }}</span>
                            <strong>{{ $jumlah }}</strong>
                        </div>
                    @endforeach
                @else
                    <div class="attendance-item">
                        <span>Data Absensi</span>
                        <strong>Belum tersedia</strong>
                    </div>
                @endif

            </div>

            <p class="attendance-note">
                Data absensi ditampilkan sesuai informasi yang tersimpan pada jurnal.
            </p>
        </div>

        {{-- CATATAN TAMBAHAN --}}
        <div class="detail-item notes-item">
            <span class="detail-label">Catatan Tambahan</span>
            <div class="detail-value">
                {{ $jurnal->keterangan ?? '-' }}
            </div>
        </div>

        {{-- FOTO KEGIATAN --}}
        <div class="photo-section">
            <span class="detail-label">Foto Kegiatan</span>

            <div class="photo-box">
                @if($jurnal->foto_kegiatan)
                    <img
                        src="{{ asset('storage/' . $jurnal->foto_kegiatan) }}"
                        alt="Foto kegiatan pembelajaran"
                        class="activity-photo"
                    >
                @else
                    <div class="empty-photo">
                        <i class="bi bi-image"></i>
                        <strong>Belum ada foto kegiatan</strong>
                        <span>Foto kegiatan pembelajaran belum diunggah.</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- TOMBOL KEMBALI --}}
        <div class="detail-actions">
            <a href="{{ route('guru.jurnal-harian') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>

    </div>
</div>

<style>
    .detail-jurnal-page {
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

    .detail-card {
        padding: 13px 15px 15px;
        background: #fff;
        border: 1px solid #b9d0c5;
        border-radius: 7px;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .12);
    }

    .detail-card-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 12px;
    }

    .detail-card-heading > i {
        font-size: 27px;
        color: #39765f;
    }

    .detail-card-heading h3 {
        margin: 0 0 3px;
        color: #171717;
        font-size: 16px;
        font-weight: 700;
    }

    .detail-card-heading p {
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
        padding: 6px 10px;
        border: 1px solid #8cc8ad;
        border-radius: 8px;
        background: #d9f8e9;
        color: #39765f;
        font-size: 13px;
        font-weight: 600;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 12px 28px;
        padding: 0 12px;
    }

    .detail-item {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 5px;
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .detail-label {
        color: #111;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.4;
    }

    .detail-value {
        box-sizing: border-box;
        width: 100%;
        min-height: 30px;
        padding: 7px 9px;
        border: 1px solid #d7e2dc;
        border-radius: 7px;
        background: #f8fbf9;
        color: #333;
        font-size: 12px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-complete {
        background: #d9f5e5;
        color: #24764b;
    }

    .status-incomplete {
        background: #fff0d9;
        color: #a96400;
    }

    .attendance-section {
        margin: 14px 0;
        padding: 12px;
        border: 2px solid #d2e4db;
        border-radius: 11px;
        background: #effaf5;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .section-heading i {
        color: #39765f;
        font-size: 19px;
    }

    .section-heading h4 {
        margin: 0;
        color: #111;
        font-size: 14px;
        font-weight: 700;
    }

    .attendance-content {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
    }

    .attendance-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        padding: 10px 5px;
        border: 1px solid #d6e6dd;
        border-radius: 7px;
        background: #fff;
        color: #555;
        font-size: 11px;
        text-align: center;
    }

    .attendance-item strong {
        color: #39765f;
        font-size: 17px;
    }

    .attendance-note {
        margin: 10px 0 0;
        color: #89958e;
        font-size: 10px;
        line-height: 1.5;
    }

    .notes-item {
        margin: 14px 12px;
    }

    .photo-section {
        margin: 14px 12px 0;
    }

    .photo-section > .detail-label {
        display: block;
        margin-bottom: 7px;
    }

    .photo-box {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 120px;
        padding: 10px;
        border: 2px solid #d2e4db;
        border-radius: 11px;
        background: #effaf5;
    }

    .activity-photo {
        display: block;
        max-width: 100%;
        max-height: 320px;
        border-radius: 7px;
        object-fit: contain;
    }

    .empty-photo {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 6px;
        padding: 15px;
        color: #39765f;
        text-align: center;
    }

    .empty-photo i {
        font-size: 28px;
    }

    .empty-photo strong {
        font-size: 13px;
    }

    .empty-photo span {
        color: #89958e;
        font-size: 11px;
    }

    .detail-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 15px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 34px;
        padding: 7px 13px;
        border: 1px solid #39765f;
        border-radius: 5px;
        background: #39765f;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: background .15s;
    }

    .btn-back:hover {
        background: #2e624e;
        color: #fff;
    }

    @media (max-width: 650px) {
        .page-heading h2 {
            font-size: 22px;
        }

        .detail-card {
            padding: 12px 10px;
        }

        .detail-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 12px;
            padding: 0 2px;
        }

        .detail-item.full-width {
            grid-column: auto;
        }

        .attendance-content {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .notes-item,
        .photo-section {
            margin-right: 2px;
            margin-left: 2px;
        }
    }
</style>
@endsection