
@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}" class="active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<div class="guru-dashboard">

    {{-- Header Dashboard --}}
    <div class="dashboard-header">
        <h2>Hallo, {{ Auth::user()->name }}!</h2>
        <p>Selamat mengajar hari ini, berikut ringkasan dari aktivitas anda hari ini</p>

        <div class="dashboard-date">
            <i class="bi bi-calendar2-week-fill"></i>
            <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon stat-green">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Jam Mengajar Hari Ini</span>
                <div class="stat-number">2</div>
                <small>Sesi hari ini</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-blue">
                <i class="bi bi-journals"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Jurnal Terisi</span>
                <div class="stat-number">1<span class="stat-total">/2</span></div>
                <small>1 jurnal menunggu untuk diisi</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-orange">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Jurnal</span>
                <div class="stat-number">10<span class="stat-total">/12</span></div>
                <small>2 jurnal menunggu untuk diisi</small>
            </div>
        </div>
    </div>

    {{-- Jadwal Mengajar --}}
    <div class="schedule-card">
        <div class="schedule-heading">
            <div class="schedule-heading-icon">
                <i class="bi bi-calendar2-check"></i>
            </div>
            <div>
                <h3>Jadwal Mengajar Hari Ini</h3>
                <p>Kelola kegiatan belajar mengajar Anda hari ini</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Kelas &amp; Mata Pelajaran</th>
                        <th>Status Jurnal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>07.30 – 08.10</strong>
                            <small>Jam ke 1-2</small>
                        </td>
                        <td>
                            <div class="subject-info">
                                <div class="subject-icon">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div>
                                    <strong>Kelas VII A</strong>
                                    <small>Bahasa Indonesia</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="journal-status status-done">
                                <i class="bi bi-circle-fill"></i>
                                Sudah Diisi
                            </span>
                        </td>
                        <td>
                            <a href="#" class="schedule-action action-view">
                                Lihat Jurnal <i class="bi bi-arrow-right"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>10.00 – 10.40</strong>
                            <small>Jam ke 3-4</small>
                        </td>
                        <td>
                            <div class="subject-info">
                                <div class="subject-icon">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div>
                                    <strong>Kelas IX E</strong>
                                    <small>Bahasa Indonesia</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="journal-status status-pending">
                                <i class="bi bi-circle-fill"></i>
                                Belum Diisi
                            </span>
                        </td>
                        <td>
                            <a href="#" class="schedule-action action-fill">
                                Isi Jurnal <i class="bi bi-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pengingat --}}
    <div class="journal-reminder">
        <div class="reminder-icon">
            <i class="bi bi-bell"></i>
        </div>

        <div class="reminder-text">
            <h3>Pengingat Jurnal Mengajar</h3>
            <p>Belum mengisi jurnal pada hari Rabu, 30 September 2026 kelas VIIID. Yuk, lengkapi sekarang</p>
        </div>

        <a href="#" class="reminder-action">
            Isi Jurnal <i class="bi bi-arrow-right"></i>
        </a>
    </div>

</div>

<style>
    .guru-dashboard {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    .dashboard-header {
        margin-bottom: 20px;
    }

    .dashboard-header h2 {
        font-size: 30px;
        font-weight: 650;
        margin: 0 0 8px;
        color: #111;
    }

    .dashboard-header p {
        font-size: 14px;
        color: #888;
        margin: 0 0 15px;
    }

    .dashboard-date {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-width: 198px;
        padding: 10px 12px;
        border: 1px solid #83c9a6;
        border-radius: 11px;
        color: #888;
        font-size: 12px;
    }

    .dashboard-date i {
        font-size: 21px;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        margin-bottom: 20px;
    }

    .stat-card {
        min-height: 105px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 12px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .20);
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        color: #fff;
        font-size: 21px;
    }

    .stat-green {
        background: #6bc9a2;
    }

    .stat-blue {
        background: #42bee9;
    }

    .stat-orange {
        background: #f57900;
    }

    .stat-info {
        min-width: 0;
    }

    .stat-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #707070;
        margin-bottom: 1px;
    }

    .stat-number {
        font-size: 39px;
        font-weight: 650;
        line-height: 1.1;
        color: #050505;
    }

    .stat-total {
        font-size: 24px;
        color: #777;
        font-weight: 500;
    }

    .stat-info small {
        display: block;
        font-size: 10px;
        color: #aaa;
        white-space: nowrap;
    }

    .schedule-card {
        background: #fff;
        border: 1px solid #b9d0c5;
        border-radius: 11px;
        overflow: hidden;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .18);
        margin-bottom: 17px;
    }

    .schedule-heading {
        min-height: 70px;
        padding: 14px 22px;
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .schedule-heading-icon {
        font-size: 25px;
        color: #39765f;
    }

    .schedule-heading h3 {
        margin: 0 0 4px;
        font-size: 20px;
        font-weight: 650;
        color: #111;
    }

    .schedule-heading p {
        margin: 0;
        font-size: 11px;
        color: #999;
    }

    .schedule-table {
        width: 100%;
        border-collapse: collapse;
    }

    .schedule-table thead {
        background: #e1eee8;
    }

    .schedule-table th {
        padding: 7px 15px;
        color: #858585;
        text-align: left;
        text-transform: uppercase;
        font-size: 13px;
        font-weight: 650;
        white-space: nowrap;
    }

    .schedule-table td {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
        font-size: 12px;
        vertical-align: middle;
    }

    .schedule-table tbody tr:last-child td {
        border-bottom: none;
    }

    .schedule-table td strong {
        display: block;
        font-size: 12px;
        font-weight: 650;
        color: #222;
    }

    .schedule-table td small {
        display: block;
        margin-top: 3px;
        color: #999;
        font-size: 10px;
    }

    .subject-info {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 145px;
    }

    .subject-icon {
        width: 35px;
        height: 35px;
        min-width: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 7px;
        background: #a7e2ca;
        color: #fff;
        font-size: 23px;
    }

    .journal-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 127px;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 12px;
        white-space: nowrap;
    }

    .journal-status i {
        font-size: 6px;
    }

    .status-done {
        color: #277d5b;
        background: #96ebc8;
    }

    .status-pending {
        color: #985000;
        background: #ff9a45;
    }

    .schedule-action {
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        width: 126px;
        padding: 9px 11px;
        border: 1px solid;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        white-space: nowrap;
    }

    .action-view {
        color: #39765f;
        background: #dce6e1;
        border-color: #7da894;
    }

    .action-fill {
        color: #b64d00;
        background: #f0d5c0;
        border-color: #cf6e2c;
    }

    .schedule-action:hover,
    .reminder-action:hover {
        filter: brightness(.96);
    }

    .journal-reminder {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        background: #fff8ef;
        border: 1px solid #ffdcac;
        border-radius: 11px;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .15);
        color: #b65300;
    }

    .reminder-icon {
        width: 35px;
        height: 35px;
        min-width: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 9px;
        background: #ffbf66;
        color: #9c5a00;
        font-size: 19px;
    }

    .reminder-text {
        flex: 1;
        min-width: 0;
    }

    .reminder-text h3 {
        margin: 0 0 3px;
        font-size: 18px;
        font-weight: 650;
        color: #b65300;
    }

    .reminder-text p {
        margin: 0;
        font-size: 10px;
        color: #c88b55;
    }

    .reminder-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #b65300;
        font-size: 14px;
        font-weight: 650;
        text-decoration: none;
        white-space: nowrap;
    }

    @media (max-width: 1050px) {
        .dashboard-stats {
            gap: 12px;
        }

        .stat-card {
            gap: 8px;
            padding: 12px 9px;
        }

        .stat-label {
            font-size: 12px;
        }

        .schedule-table th,
        .schedule-table td {
            padding-left: 10px;
            padding-right: 10px;
        }
    }

    @media (max-width: 760px) {
        .dashboard-header h2 {
            font-size: 25px;
        }

        .dashboard-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .stat-card {
            min-height: 90px;
            padding: 14px;
        }

        .schedule-card {
            overflow-x: auto;
        }

        .schedule-table {
            min-width: 700px;
        }

        .journal-reminder {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .reminder-text {
            flex-basis: calc(100% - 55px);
        }

        .reminder-action {
            margin-left: 45px;
        }
    }
</style>
@endsection