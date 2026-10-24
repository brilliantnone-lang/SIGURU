@extends('layouts.app')

@section('title', 'Panduan Penggunaan')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<div class="panduan-page">

    {{-- Header --}}
    <div class="panduan-header">
        <h2>Panduan Penggunaan</h2>
        <p>Semua yang perlu Anda ketahui untuk menggunakan ruang kerja guru.</p>
    </div>

    {{-- Banner Sambutan --}}
    <section class="panduan-welcome">
        <i class="bi bi-book"></i>
        <div>
            <h3>Selamat datang di Ruang Guru</h3>
            <p>
                Ikuti panduan singkat ini untuk memeriksa dan mencatat pembelajaran,
                mengelola guru pengganti, dan memantau kehadiran siswa.
            </p>
        </div>
    </section>

    {{-- Daftar Panduan --}}
    <div class="panduan-grid">

        {{-- Panduan 1 --}}
        <article class="panduan-card">
            <span class="panduan-number">01</span>

            <h3>Mengisi Jurnal Harian</h3>
            <p>
                Buka menu Jurnal Harian Guru.
                Klik Tambah Jurnal dan pilih status mengajar di tanggal, kelas,
                jam, serta pokok bahasan. Mata pelajaran terisi otomatis.
                Pilih status penyelesaian, tambahkan catatan atau foto,
                lalu klik Simpan Jurnal.
            </p>

            <a href="{{ route('guru.dashboard') }}" class="panduan-link">
                Mulai isi jurnal
            </a>
        </article>

        {{-- Panduan 2 --}}
        <article class="panduan-card">
            <span class="panduan-number">02</span>

            <h3>Fitur Guru Pengganti</h3>
            <p>
                Pada formulir jurnal, pilih Guru Pengganti.
                Pilih Saya yang digantikan jika guru lain mengambil sesi Anda.
                Pilih Saya yang menggantikan jika Anda mengajar kelas guru lain.
                Masukkan nama guru terkait. Isi semua data yang diperlukan
                agar jurnal tercatat pada jurnal.
            </p>
        </article>

        {{-- Panduan 3 --}}
        <article class="panduan-card">
            <span class="panduan-number">03</span>

            <h3>Mencatat Absensi Siswa</h3>
            <p>
                Buka menu Absensi Siswa.
                Pilih kelas dan jam pelajaran yang sesuai.
                Tandai setiap siswa sebagai Hadir, Sakit, Izin, atau Alpha.
                Gunakan tombol simpan untuk menyimpan sesi sebelumnya,
                lalu klik Simpan Absensi.
            </p>

            <a href="{{ route('guru.dashboard') }}" class="panduan-link">
                Kelola absensi
            </a>
        </article>

    </div>

</div>

<style>
    .panduan-page {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    .panduan-header {
        margin: 0 0 23px 5px;
    }

    .panduan-header h2 {
        margin: 0 0 5px;
        color: #173D2B;
        font-size: 26px;
        line-height: 1.25;
        font-weight: 700;
    }

    .panduan-header p {
        margin: 0;
        color: #40574F;
        font-size: 12px;
    }

    .panduan-welcome {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
        padding: 16px 18px;
        border: 1px solid #C9E5D7;
        border-radius: 10px;
        background: linear-gradient(90deg, #D7EDE3 0%, #C2E0D3 100%);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    .panduan-welcome > i {
        flex: 0 0 auto;
        color: #4A9B72;
        font-size: 32px;
        line-height: 1;
    }

    .panduan-welcome h3 {
        margin: 0 0 7px;
        color: #101A15;
        font-size: 16px;
        line-height: 1.3;
        font-weight: 700;
    }

    .panduan-welcome p {
        margin: 0;
        color: #263B32;
        font-size: 10px;
        line-height: 1.6;
    }

    .panduan-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        padding: 0 2px;
    }

    .panduan-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 190px;
        padding: 24px 26px 20px;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
        background: #FFFFFF;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
    }

    .panduan-number {
        position: absolute;
        top: 14px;
        right: 18px;
        color: #173D2B;
        font-size: 24px;
        font-weight: 700;
    }

    .panduan-card h3 {
        margin: 12px 34px 12px 0;
        color: #173D2B;
        font-size: 11px;
        line-height: 1.4;
        font-weight: 700;
    }

    .panduan-card p {
        margin: 0 0 18px;
        color: #303A35;
        font-size: 10px;
        line-height: 1.65;
    }

    .panduan-link {
        margin-top: auto;
        color: #0A4C2E;
        font-size: 9px;
        font-weight: 700;
        text-decoration: none;
    }

    .panduan-link:hover {
        color: #244c39;
        text-decoration: underline;
    }

    @media (max-width: 900px) {
        .panduan-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .panduan-card {
            padding: 22px 20px 18px;
        }
    }

    @media (max-width: 600px) {
        .panduan-header {
            margin-bottom: 22px;
        }

        .panduan-header h2 {
            font-size: 22px;
        }

        .panduan-header p {
            font-size: 12px;
        }

        .panduan-welcome {
            align-items: flex-start;
            padding: 14px;
        }

        .panduan-welcome h3 {
            font-size: 14px;
        }

        .panduan-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .panduan-card {
            min-height: 160px;
        }
    }
</style>
@endsection
