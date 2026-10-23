
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
        color: #244c39;
        font-size: 17px;
        font-weight: 700;
    }

    .panduan-header p {
        margin: 0;
        color: #444;
        font-size: 8px;
    }

    .panduan-welcome {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 48px;
        padding: 10px 12px;
        margin-bottom: 30px;
        border: 1px solid #b5ddca;
        border-radius: 6px;
        background: #c5e1d5;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .15);
    }

    .panduan-welcome > i {
        flex: 0 0 auto;
        color: #39765f;
        font-size: 22px;
        font-weight: 400;
    }

    .panduan-welcome h3 {
        margin: 0 0 5px;
        color: #111;
        font-size: 12px;
        font-weight: 700;
    }

    .panduan-welcome p {
        margin: 0;
        color: #263a30;
        font-size: 7px;
        line-height: 1.6;
    }

    .panduan-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 9px;
        padding: 0 2px;
    }

    .panduan-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 157px;
        padding: 34px 24px 16px;
        border: 1px solid #ededed;
        border-radius: 7px;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .18);
    }

    .panduan-number {
        position: absolute;
        top: 15px;
        right: 17px;
        color: #244c39;
        font-size: 17px;
        font-weight: 700;
    }

    .panduan-card h3 {
        margin: 0 0 7px;
        padding-right: 0;
        color: #244c39;
        font-size: 9px;
        font-weight: 700;
    }

    .panduan-card p {
        margin: 0 0 12px;
        color: #444;
        font-size: 7px;
        line-height: 1.65;
    }

    .panduan-link {
        display: inline-block;
        align-self: flex-start;
        margin-top: auto;
        color: #39765f;
        font-size: 7px;
        font-weight: 650;
        text-decoration: none;
    }

    .panduan-link:hover {
        color: #244c39;
        text-decoration: underline;
    }

    @media (max-width: 760px) {
        .panduan-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .panduan-card {
            min-height: 145px;
            padding: 35px 20px 18px;
        }

        .panduan-card h3 {
            font-size: 12px;
        }

        .panduan-card p {
            font-size: 10px;
        }

        .panduan-link {
            font-size: 9px;
        }

        .panduan-welcome p {
            font-size: 9px;
        }
    }
</style>
@endsection
