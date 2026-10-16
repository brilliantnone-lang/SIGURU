@extends('layouts.app')

@section('title', 'Panduan Penggunaan - Jurnal Mengajar Guru')

@section('content')

    <div class="guide-intro">
        <h1>Panduan Penggunaan</h1>
        <p>Semua yang perlu Anda ketahui untuk menggunakan sistem jurnal mengajar sebagai Admin.</p>
    </div>

    <div class="guide-welcome">
        <div class="guide-book-icon" aria-hidden="true">♧</div>
        <div>
            <h2>Selamat datang di Halaman Panduan Penggunaan Admin</h2>
            <p>Ikuti panduan singkat ini untuk mengelola data, mengatur sistem, dan memastikan seluruh informasi pada sistem jurnal mengajar berjalan dengan baik.</p>
        </div>
    </div>

    <div class="guide-grid">
        <article class="guide-card">
            <span class="guide-number">01</span>
            <h3>Melihat Dashboard</h3>
            <p>Buka menu Dashboard untuk melihat ringkasan data seperti jumlah guru, siswa, kelas, mata pelajaran, dan jumlah mengajar yang telah masuk ke sistem.</p>
            <span class="guide-link">Buka dashboard</span>
        </article>

        <article class="guide-card">
            <span class="guide-number">02</span>
            <h3>Mengelola Data Guru</h3>
            <p>Gunakan menu Data Guru untuk menambah, mengubah, melihat, dan mengelola data guru. Pastikan data guru selalu diperbarui agar dapat digunakan dalam pengisian jurnal.</p>
            <span class="guide-link">Kelola data guru</span>
        </article>

        <article class="guide-card">
            <span class="guide-number">03</span>
            <h3>Mengelola Data Siswa &amp; Kelas</h3>
            <p>Gunakan menu Data Siswa dan Data Kelas untuk menambah, mengubah, dan mengelola data siswa serta kelas yang terdaftar dalam sistem.</p>
            <span class="guide-link">Kelola data siswa dan kelas</span>
        </article>

        <article class="guide-card">
            <span class="guide-number">04</span>
            <h3>Mengelola Data Pengajaran</h3>
            <p>Gunakan menu Data Pengajaran untuk mengatur hubungan antara guru, mata pelajaran, dan kelas. Data ini digunakan pada saat guru mengisi jurnal mengajar harian.</p>
            <span class="guide-link">Atur data pengajaran</span>
        </article>

        <article class="guide-card">
            <span class="guide-number">05</span>
            <h3>Mengelola Kalender Akademik</h3>
            <p>Gunakan menu Kalender Akademik untuk menambahkan dan mengatur informasi kalender akademik seperti tahun ajaran, semester, hari libur, dan kegiatan penting lainnya.</p>
            <span class="guide-link">Kelola kalender akademik</span>
        </article>

        <article class="guide-card">
            <span class="guide-number">06</span>
            <h3>Melihat Jurnal</h3>
            <p>Gunakan menu Jurnal Harian Guru untuk melihat data jurnal yang telah diunggah oleh guru.</p>
            <span class="guide-link">Lihat jurnal</span>
        </article>
    </div>

@endsection

@push('styles')
<style>
    /* ====== CSS khusus halaman Panduan Penggunaan ====== */
    .guide-intro {
        margin-bottom: 30px;
    }

    .guide-intro h1 {
        margin: 0 0 5px;
        color: #173D2B;
        font-size: 26px;
        line-height: 1.25;
        font-weight: 700;
    }

    .guide-intro p {
        margin: 0;
        color: #40574F;
        font-size: 12px;
    }

    .guide-welcome {
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

    .guide-book-icon {
        flex: 0 0 auto;
        color: #4A9B72;
        font-size: 32px;
        line-height: 1;
    }

    .guide-welcome h2 {
        margin: 0 0 7px;
        color: #101A15;
        font-size: 16px;
        line-height: 1.3;
    }

    .guide-welcome p {
        margin: 0;
        color: #263B32;
        font-size: 10px;
        line-height: 1.6;
    }

    .guide-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .guide-card {
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

    .guide-number {
        position: absolute;
        top: 14px;
        right: 18px;
        color: #173D2B;
        font-size: 24px;
        font-weight: 700;
    }

    .guide-card h3 {
        margin: 12px 34px 12px 0;
        color: #173D2B;
        font-size: 11px;
        line-height: 1.4;
        font-weight: 700;
    }

    .guide-card p {
        margin: 0 0 18px;
        color: #303A35;
        font-size: 10px;
        line-height: 1.65;
    }

    .guide-link {
        margin-top: auto;
        color: #0A4C2E;
        font-size: 9px;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .guide-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .guide-card { padding: 22px 20px 18px; }
    }

    @media (max-width: 600px) {
        .guide-intro { margin-bottom: 22px; }
        .guide-welcome { align-items: flex-start; padding: 14px; }
        .guide-welcome h2 { font-size: 14px; }
        .guide-grid { grid-template-columns: 1fr; gap: 14px; }
        .guide-card { min-height: 160px; }
    }
</style>
@endpush