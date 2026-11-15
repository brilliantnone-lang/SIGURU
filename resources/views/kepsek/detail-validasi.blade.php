@extends('layouts.app')

@section('title', 'Validasi Semester')

@section('content')
    <style>
        .validasi-page {
            width: 100%;
            color: #26332f;
            font-family: inherit;
        }

        .validasi-page *,
        .validasi-page *::before,
        .validasi-page *::after {
            box-sizing: border-box;
        }

        /* HEADER */
        .validasi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 23px;
        }

        .validasi-header h1 {
            margin: 0 0 6px;
            color: #173d2b;
            font-size: 26px;
            font-weight: 700;
        }

        .validasi-header p {
            margin: 0;
            color: #7d8580;
            font-size: 12px;
        }

        .semester-status {
            display: inline-flex;
            align-items: center;
            margin-left: 8px;
            padding: 4px 9px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            vertical-align: middle;
        }

        .semester-status.ongoing {
            color: #a86600;
            background: #fff0c9;
        }

        .semester-status.completed {
            color: #166534;
            background: #dcfce7;
        }

        /* TOMBOL KEMBALI */
        .back-button {
            display: inline-flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 38px;
            padding: 8px 15px;
            color: #fff;
            background: #39765f;
            border: 1px solid #39765f;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s ease, transform .2s ease;
        }

        .back-button:hover {
            color: #fff;
            background: #285b46;
            border-color: #285b46;
            transform: translateY(-1px);
        }

        /* STATISTIK */
        .validasi-statistics {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 23px;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
            padding: 17px 20px;
            background: #fff;
            border: 1px solid #c7d9cf;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(25, 55, 39, .08);
        }

        .stat-icon {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            color: #39765f;
            background: #e5f6eb;
            border-radius: 10px;
            font-size: 21px;
        }

        .stat-info {
            min-width: 0;
        }

        .stat-info span {
            display: block;
            margin-bottom: 3px;
            color: #7d8580;
            font-size: 12px;
        }

        .stat-info strong {
            display: block;
            color: #26332f;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.2;
        }

        /* TABEL */
        .validasi-card {
            width: 100%;
            padding: 21px 22px;
            background: #fff;
            border: 1px solid #c7d9cf;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(25, 55, 39, .08);
        }

        .validasi-card-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 17px;
        }

        .validasi-card-heading i {
            color: #39765f;
            font-size: 21px;
        }

        .validasi-card-heading h3 {
            margin: 0;
            color: #26332f;
            font-size: 16px;
            font-weight: 700;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .validasi-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .validasi-table thead th {
            padding: 13px 12px;
            color: #315b45;
            background: #edf6f0;
            border-bottom: 1px solid #d5e5db;
            font-weight: 700;
            text-align: left;
            white-space: nowrap;
        }

        .validasi-table thead th:first-child {
            border-radius: 7px 0 0 0;
        }

        .validasi-table thead th:last-child {
            border-radius: 0 7px 0 0;
        }

        .validasi-table tbody td {
            padding: 13px 12px;
            color: #4c5951;
            border-bottom: 1px solid #edf0ed;
            vertical-align: middle;
        }

        .validasi-table tbody tr:last-child td {
            border-bottom: none;
        }

        .validasi-table tbody tr:hover {
            background: #f8fbf9;
        }

        .validasi-table .text-center {
            text-align: center;
        }

        .teacher-name {
            color: #26332f;
            font-weight: 600;
        }

        .journal-count {
            display: inline-block;
            padding: 5px 9px;
            color: #39765f;
            background: #e5f2e9;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        /* STATUS BADGE */
        .status-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-valid {
            color: #166534;
            background: #dcfce7;
        }

        .status-revision {
            color: #be123c;
            background: #ffe4e6;
        }

        .status-revised {
            color: #0369a1;
            background: #e0f2fe;
        }

        .status-pending {
            color: #a86600;
            background: #fff0c9;
        }

        .status-dash {
            color: #a0aaa3;
        }

        /* TOMBOL AKSI */
        .validasi-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .icon-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 31px;
            height: 31px;
            padding: 0;
            border: 1px solid;
            border-radius: 7px;
            background: #fff;
            font-size: 19px;
            text-decoration: none;
            cursor: pointer;
            transition: background .15s ease;
        }

        .action-detail {
            border-color: #9ab7a7;
            color: #39765f;
        }

        .action-detail:hover {
            background: #e8f5ed;
            color: #285840;
        }

        /* EMPTY STATE */
        .empty-state {
            padding: 40px 15px !important;
            color: #89958e !important;
            text-align: center;
        }

        .empty-state i {
            display: block;
            margin-bottom: 9px;
            color: #a9c5b4;
            font-size: 30px;
        }

        /* RESPONSIVE */
        @media (max-width: 760px) {
            .validasi-header {
                align-items: flex-start;
            }

            .validasi-header h1 {
                font-size: 22px;
            }

            .validasi-statistics {
                gap: 10px;
            }

            .stat-card {
                padding: 14px;
                gap: 10px;
            }

            .stat-icon {
                width: 38px;
                height: 38px;
                font-size: 18px;
            }

            .validasi-card {
                padding: 16px;
            }
        }

        @media (max-width: 540px) {
            .validasi-header {
                flex-direction: column;
                align-items: stretch;
            }

            .validasi-header h1 {
                font-size: 20px;
            }

            .back-button {
                align-self: flex-start;
            }

            .validasi-statistics {
                grid-template-columns: 1fr 1fr;
            }

            .stat-card {
                padding: 12px 10px;
                gap: 8px;
            }

            .stat-icon {
                width: 33px;
                height: 33px;
                font-size: 16px;
            }

            .stat-info span {
                font-size: 10px;
            }

            .stat-info strong {
                font-size: 21px;
            }

            .validasi-table {
                min-width: 760px;
            }
        }
    </style>

    <div class="validasi-page">

        {{-- HEADER --}}
        <div class="validasi-header">
            <div>
                <h1>
                    Validasi Semester: {{ $cover->semester }} {{ $cover->tahun_ajaran }}
                </h1>

                <p>
                    Pilih guru untuk melihat detail jurnal.

                    @if(!$isSelesai)
                        <span class="semester-status ongoing">
                            Sedang Berjalan
                        </span>
                    @else
                        <span class="semester-status completed">
                            Selesai
                        </span>
                    @endif
                </p>
            </div>

            <a href="{{ route('kepsek.validasi-jurnal.index') }}" class="back-button">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>

        {{-- STATISTIK --}}
        <div class="validasi-statistics">

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="stat-info">
                    <span>Total Guru</span>
                    <strong>{{ $gurus->count() }}</strong>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-journal-text"></i>
                </div>

                <div class="stat-info">
                    <span>Total Jurnal</span>
                    <strong>{{ $gurus->sum('journal_count') }}</strong>
                </div>
            </div>

        </div>

        {{-- TABEL DAFTAR GURU --}}
        <div class="validasi-card">

            <div class="validasi-card-heading">
                <i class="bi bi-people"></i>
                <h3>Daftar Guru Pengampu</h3>
            </div>

            <div class="table-wrapper">
                <table class="validasi-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Guru</th>
                            <th>Mata Pelajaran</th>
                            <th class="text-center">Total Jurnal</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($gurus as $i => $g)
                            <tr>
                                <td>{{ $i + 1 }}</td>

                                <td>
                                    <span class="teacher-name">
                                        {{ $g->user->name ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $g->mataPelajaran->nama_mata_pelajaran ?? '-' }}
                                </td>

                                <td class="text-center">
                                    <span class="journal-count">
                                        {{ $g->journal_count }} Jurnal
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if(!$isSelesai)
                                        <span class="status-dash">-</span>
                                    @elseif($g->status_keseluruhan === 'valid')
                                        <span class="status-badge status-valid">
                                            Tervalidasi
                                        </span>
                                    @elseif($g->status_keseluruhan === 'menunggu_revisi')
                                        <span class="status-badge status-revision">
                                            Perlu Revisi
                                        </span>
                                    @elseif($g->status_keseluruhan === 'sudah_revisi')
                                        <span class="status-badge status-revised">
                                            Sudah Direvisi — Menunggu Validasi
                                        </span>
                                    @else
                                        <span class="status-badge status-pending">
                                            Belum Divalidasi
                                        </span>
                                    @endif
                                </td>

                               <td>
                                    <div class="validasi-actions">
                                        <a href="{{ route('kepsek.validasi-jurnal.guru', [$cover->id, $g->id]) }}"
                                        class="icon-action action-detail"
                                        title="Lihat jurnal"
                                        aria-label="Lihat jurnal">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="bi bi-journal-x"></i>
                                    Belum ada guru yang mengumpulkan jurnal di semester ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endsection