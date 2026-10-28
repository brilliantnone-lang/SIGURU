@extends('layouts.app')

@section('title', 'Panduan Penggunaan')

@section('content')
<style>
    .kepsek-panduan {
        width: 100%;
        min-width: 0;
        color: #26332f;
        font-family: inherit;
    }

    .kepsek-panduan *,
    .kepsek-panduan *::before,
    .kepsek-panduan *::after {
        box-sizing: border-box;
    }

    /* Heading */
    .panduan-heading {
        margin-bottom: 24px;
    }

    .panduan-heading h3 {
        margin: 0;
        color: #204b36;
        font-size: 25px;
        font-weight: 700;
    }

    .panduan-heading p {
        margin: 4px 0 0;
        color: #35483e;
        font-size: 11px;
    }

    /* Banner sambutan */
    .panduan-welcome {
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 76px;
        margin-bottom: 24px;
        padding: 14px 18px;
        background: #c9e3d7;
        border: 1px solid #b6d7c7;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .16);
    }

    .panduan-welcome-icon {
        display: flex;
        flex: 0 0 35px;
        align-items: center;
        justify-content: center;
        color: #4b9b75;
        font-size: 31px;
    }

    .panduan-welcome-content {
        min-width: 0;
    }

    .panduan-welcome-content h4 {
        margin: 0 0 6px;
        color: #14231b;
        font-size: 17px;
        font-weight: 700;
    }

    .panduan-welcome-content p {
        margin: 0;
        color: #35483e;
        font-size: 10px;
        line-height: 1.6;
    }

    /* Kartu panduan */
    .panduan-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .panduan-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        min-height: 176px;
        padding: 25px 24px 18px;
        background: #fff;
        border: 1px solid #e1e5e2;
        border-radius: 9px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .17);
    }

    .panduan-card-number {
        position: absolute;
        top: 13px;
        right: 19px;
        color: #204b36;
        font-size: 25px;
        font-weight: 700;
        line-height: 1;
    }

    .panduan-card h4 {
        max-width: calc(100% - 35px);
        margin: 8px 0 13px;
        color: #244b37;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.5;
    }

    .panduan-card p {
        margin: 0;
        color: #46534c;
        font-size: 10px;
        line-height: 1.65;
    }

    .panduan-card-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        align-self: flex-start;
        margin-top: auto;
        padding-top: 20px;
        color: #245b3e;
        font-size: 9px;
        font-weight: 700;
        text-decoration: none;
    }

    .panduan-card-link:hover {
        color: #13814b;
        text-decoration: underline;
    }

    .panduan-card-link i {
        font-size: 10px;
    }

    /* Responsif */
    @media (max-width: 1000px) {
        .panduan-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .panduan-card {
            min-height: 180px;
        }
    }

    @media (max-width: 600px) {
        .panduan-heading h3 {
            font-size: 22px;
        }

        .panduan-heading {
            margin-bottom: 18px;
        }

        .panduan-welcome {
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
            padding: 13px;
        }

        .panduan-welcome-icon {
            flex-basis: 28px;
            font-size: 26px;
        }

        .panduan-welcome-content h4 {
            font-size: 14px;
        }

        .panduan-welcome-content p {
            font-size: 10px;
        }

        .panduan-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .panduan-card {
            min-height: 160px;
            padding: 23px 20px 17px;
        }
    }
</style>

<div class="kepsek-panduan">

    {{-- Judul --}}
    <div class="panduan-heading">
        <h3>Panduan Penggunaan</h3>
        <p>Semua yang perlu Anda ketahui untuk menggunakan sistem jurnal mengajar sebagai Kepala Sekolah</p>
    </div>

    {{-- Banner sambutan --}}
    <section class="panduan-welcome">
        <div class="panduan-welcome-icon">
            <i class="bi bi-book-half"></i>
        </div>

        <div class="panduan-welcome-content">
            <h4>Selamat datang di Ruang Kepala Sekolah</h4>
            <p>
                Ikuti panduan singkat ini untuk memeriksa dan memvalidasi jurnal mengajar guru,
                memantau rekapitulasi, dan mengelola informasi sekolah.
            </p>
        </div>
    </section>

    {{-- Daftar panduan --}}
    <div class="panduan-grid">

        {{-- Panduan 01 --}}
        <article class="panduan-card">
            <span class="panduan-card-number">01</span>

            <h4>Melihat Jurnal Guru</h4>

            <p>
                Buka menu Jurnal Harian Guru untuk melihat daftar jurnal yang telah dikumpulkan
                oleh guru. Pilih jurnal yang ingin diperiksa dengan menekan aksi Lihat.
            </p>

            {{-- Link Diperbaiki ke .index --}}
            <a href="{{ route('kepsek.validasi-jurnal.index') }}" class="panduan-card-link">
                Lihat daftar jurnal
                <i class="bi bi-arrow-right"></i>
            </a>
        </article>

        {{-- Panduan 02 --}}
        <article class="panduan-card">
            <span class="panduan-card-number">02</span>

            <h4>Memeriksa Isi Jurnal</h4>

            <p>
                Setelah memilih jurnal, sistem akan menampilkan detail jurnal dalam bentuk
                pratinjau. Periksa kesesuaian informasi seperti tanggal, kelas, mata pelajaran,
                materi, dan lampiran.
            </p>
        </article>

        {{-- Panduan 03 --}}
        <article class="panduan-card">
            <span class="panduan-card-number">03</span>

            <h4>Memvalidasi Jurnal</h4>

            <p>
                Jika jurnal sudah sesuai, tekan tombol Validasi. Anda juga dapat menambahkan
                catatan (opsional) sebelum memvalidasi jurnal.
            </p>
        </article>

        {{-- Panduan 04 --}}
        <article class="panduan-card">
            <span class="panduan-card-number">04</span>

            <h4>Meminta Perbaikan</h4>

            <p>
                Jika terdapat informasi yang perlu diperbaiki, tekan tombol Perlu Revisi.
                Tambahkan catatan agar guru mengetahui bagian yang harus diperbaiki,
                kemudian jurnal akan dikembalikan ke guru.
            </p>
        </article>

        {{-- Panduan 05 --}}
        <article class="panduan-card">
            <span class="panduan-card-number">05</span>

            <h4>Melihat Rekapitulasi Absensi</h4>

            <p>
                Gunakan menu Rekapitulasi Absensi Siswa untuk melihat data kehadiran siswa
                secara keseluruhan. Anda dapat memfilter berdasarkan kelas dan periode
                waktu yang diinginkan.
            </p>

            {{-- Link Diperbaiki ke .index --}}
            <a href="{{ route('kepsek.rekapitulasi-absensi.index') }}" class="panduan-card-link">
                Lihat rekapitulasi absensi
                <i class="bi bi-arrow-right"></i>
            </a>
        </article>

    </div>
</div>
@endsection