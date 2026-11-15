@extends('layouts.app')

@section('title', 'Jurnal Guru')

@section('content')
    <div class="validasi-guru-page">

        {{-- HEADER HALAMAN --}}
        <div class="validasi-guru-header">
            <div class="header-info">
                <h2>Jurnal: {{ $guru->user->name ?? '-' }}</h2>

                <div class="header-meta">
                    <span class="semester-info">
                        Semester {{ $cover->semester }} {{ $cover->tahun_ajaran }}
                    </span>

                    <span class="jumlah-jurnal">
                        {{ $jurnals->count() }} Jurnal
                    </span>

                    @if($isSelesai)
                        @if($statusUtama === 'valid')
                            <span class="status-badge status-valid">Tervalidasi</span>
                        @elseif($statusUtama === 'menunggu_revisi')
                            <span class="status-badge status-revisi">Perlu Revisi</span>
                        @else
                            <span class="status-badge status-belum">Belum Divalidasi</span>
                        @endif
                    @endif
                </div>
            </div>

            <a href="{{ route('kepsek.validasi-jurnal.show', $cover->id) }}" class="btn-kembali">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="validasi-alert alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="validasi-alert alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- FORM VALIDASI --}}
        @if($isSelesai)
            <section class="validasi-card">
                <div class="card-heading">
                    <div class="heading-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div>
                        <h3>Validasi Jurnal</h3>
                        <p>
                            Periksa seluruh jurnal sebelum memberikan hasil validasi
                            kepada {{ $guru->user->name ?? 'guru' }}.
                        </p>
                    </div>
                </div>

                <div class="validasi-form-content">
                    <form id="formValidasi"
                        action="{{ route('kepsek.validasi-jurnal.validasi-guru', [$cover->id, $guru->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div id="catatanWrapper" class="catatan-wrapper" style="display:none;">
                            <label for="catatan_validasi">
                                Catatan Revisi <span>*</span>
                            </label>

                            <textarea name="catatan_validasi" id="catatan_validasi" rows="3"
                                placeholder="Tulis catatan perbaikan untuk guru..."></textarea>
                        </div>

                        <div class="validasi-buttons">
                            <button type="submit" name="status_validasi" value="valid" class="btn-validasi"
                                onclick="return confirm('Validasi SEMUA jurnal guru ini?')">
                                <i class="bi bi-check2-circle"></i>
                                Validasi Semua Jurnal
                            </button>

                            <button type="button" class="btn-revisi" onclick="tampilkanCatatan(this)">
                                <i class="bi bi-exclamation-triangle"></i>
                                Perlu Revisi
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        @else
            <div class="semester-warning">
                <i class="bi bi-info-circle-fill"></i>
                <span>
                    Semester ini masih berjalan. Validasi hanya bisa dilakukan
                    setelah semester selesai (sesuai Kalender Akademik).
                </span>
            </div>
        @endif

        {{-- TABEL DAFTAR JURNAL --}}
        <section class="daftar-jurnal-card">
            <div class="card-heading">
                <div class="heading-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div>
                    <h3>Daftar Jurnal</h3>
                    <p>Daftar jurnal guru berdasarkan tanggal kegiatan pembelajaran.</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="jurnal-guru-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($jurnals as $i => $j)
                            <tr>
                                <td>{{ $i + 1 }}</td>

                                <td class="tanggal-cell">
                                    {{ $j->tanggal->translatedFormat('d M Y') }}
                                </td>

                                <td>
                                    {{ $j->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}
                                </td>

                                <td>
                                    {{ $j->kelas->nama_kelas ?? '-' }}
                                </td>

                                <td>
                                    <div class="jurnal-actions">
                                        <a href="{{ route('kepsek.validasi-jurnal.detail', $j->id) }}"
                                            class="icon-action action-detail" title="Lihat isi jurnal"
                                            aria-label="Lihat isi jurnal">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-jurnal">
                                    <i class="bi bi-journal-x"></i>
                                    <strong>Belum ada jurnal</strong>
                                    <span>Belum terdapat jurnal yang tercatat untuk guru ini.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                Menampilkan {{ $jurnals->count() }} jurnal
            </div>
        </section>

    </div>

    <style>
        /* =========================
           HALAMAN JURNAL GURU
        ========================= */

        .validasi-guru-page {
            width: 100%;
            color: #333a35;
            font-family: inherit;
        }

        .validasi-guru-page *,
        .validasi-guru-page *::before,
        .validasi-guru-page *::after {
            box-sizing: border-box;
        }

        /* HEADER */

        .validasi-guru-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .header-info h2 {
            margin: 0 0 8px;
            color: #173d2b;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.3;
        }

        .header-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .semester-info {
            color: #77827b;
            font-size: 12px;
        }

        .jumlah-jurnal {
            padding: 4px 9px;
            border-radius: 5px;
            background: #e1ece6;
            color: #39765f;
            font-size: 10px;
            font-weight: 700;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-valid {
            background: #dcfce7;
            color: #166534;
        }

        .status-revisi {
            background: #ffe4e6;
            color: #be123c;
        }

        .status-belum {
            background: #fff0c9;
            color: #a86600;
        }

        /* TOMBOL KEMBALI */

        .btn-kembali {
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

        .btn-kembali:hover {
            color: #fff;
            background: #285b46;
            border-color: #285b46;
            transform: translateY(-1px);
        }

        /* NOTIFIKASI */

        .validasi-alert {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 16px;
            padding: 11px 14px;
            border: 1px solid;
            border-radius: 7px;
            font-size: 12px;
        }

        .alert-success {
            background: #dcfce7;
            border-color: #bbf7d0;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            border-color: #fecaca;
            color: #991b1b;
        }

        /* CARD */

        .validasi-card,
        .daftar-jurnal-card {
            width: 100%;
            margin-bottom: 18px;
            overflow: hidden;
            border: 1px solid #c7d9cf;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 3px rgba(0, 0, 0, .08);
        }

        .card-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-bottom: 1px solid #edf1ee;
        }

        .heading-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            color: #39765f;
            font-size: 23px;
        }

        .card-heading h3 {
            margin: 0 0 3px;
            color: #252b27;
            font-size: 16px;
            font-weight: 700;
        }

        .card-heading p {
            margin: 0;
            color: #929b95;
            font-size: 10px;
            line-height: 1.5;
        }

        /* FORM VALIDASI */

        .validasi-form-content {
            padding: 15px;
        }

        .catatan-wrapper {
            margin-bottom: 15px;
        }

        .catatan-wrapper label {
            display: block;
            margin-bottom: 7px;
            color: #37443b;
            font-size: 12px;
            font-weight: 600;
        }

        .catatan-wrapper label span {
            color: #dc2626;
        }

        .catatan-wrapper textarea {
            display: block;
            width: 100%;
            min-height: 85px;
            padding: 10px 12px;
            border: 1px solid #c7d9cf;
            border-radius: 7px;
            outline: none;
            color: #333a35;
            background: #fff;
            font-family: inherit;
            font-size: 12px;
            resize: vertical;
        }

        .catatan-wrapper textarea:focus {
            border-color: #75a88c;
            box-shadow: 0 0 0 3px rgba(57, 118, 95, .10);
        }

        .validasi-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-validasi,
        .btn-revisi {
            display: inline-flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 39px;
            padding: 9px 14px;
            border: 1px solid;
            border-radius: 7px;
            color: #fff;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s ease;
        }

        .btn-validasi {
            border-color: #39765f;
            background: #39765f;
        }

        .btn-validasi:hover {
            border-color: #285840;
            background: #285840;
        }

        .btn-revisi {
            border-color: #be123c;
            background: #be123c;
        }

        .btn-revisi:hover {
            border-color: #9f1235;
            background: #9f1235;
        }

        /* PERINGATAN SEMESTER */

        .semester-warning {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid #ffe4a1;
            border-radius: 8px;
            background: #fff0c9;
            color: #a86600;
            font-size: 12px;
            line-height: 1.6;
        }

        .semester-warning i {
            margin-top: 1px;
            font-size: 15px;
        }

        /* TABEL */

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .jurnal-guru-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        .jurnal-guru-table thead {
            background: #e1eee8;
        }

        .jurnal-guru-table th {
            padding: 10px 12px;
            color: #77847c;
            font-size: 10px;
            font-weight: 700;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .jurnal-guru-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e8ece9;
            color: #333a35;
            font-size: 11px;
            vertical-align: middle;
        }

        .jurnal-guru-table tbody tr:last-child td {
            border-bottom: none;
        }

        .jurnal-guru-table tbody tr:hover {
            background: #fbfdfb;
        }

        .jurnal-guru-table th:first-child,
        .jurnal-guru-table td:first-child {
            width: 55px;
            text-align: center;
        }

        .jurnal-guru-table th:last-child,
        .jurnal-guru-table td:last-child {
            width: 90px;
            text-align: center;
        }

        .tanggal-cell {
            white-space: nowrap;
            font-weight: 600;
        }

        /* TOMBOL AKSI - MENGIKUTI JURNAL HARIAN GURU */

        .jurnal-actions {
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

        /* DATA KOSONG */

        .empty-jurnal {
            padding: 30px 15px !important;
            text-align: center;
        }

        .empty-jurnal i {
            display: block;
            margin-bottom: 8px;
            color: #86a996;
            font-size: 25px;
        }

        .empty-jurnal strong,
        .empty-jurnal span {
            display: block;
        }

        .empty-jurnal strong {
            margin-bottom: 5px;
            color: #3c5144;
            font-size: 12px;
        }

        .empty-jurnal span {
            color: #8a938d;
            font-size: 10px;
        }

        .table-footer {
            min-height: 32px;
            padding: 9px 12px;
            border-top: 1px solid #edf1ee;
            color: #737d76;
            font-size: 10px;
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {
            .validasi-guru-header {
                gap: 10px;
            }

            .header-info h2 {
                font-size: 22px;
            }

            .card-heading h3 {
                font-size: 15px;
            }

            .jurnal-guru-table th,
            .jurnal-guru-table td {
                padding: 9px 10px;
            }
        }

        @media (max-width: 480px) {
            .validasi-guru-header {
                align-items: flex-start;
            }

            .header-info h2 {
                font-size: 19px;
            }

            .semester-info {
                font-size: 10px;
            }

            .btn-kembali {
                min-height: 32px;
                padding: 6px 9px;
                font-size: 10px;
            }

            .validasi-buttons {
                flex-direction: column;
            }

            .btn-validasi,
            .btn-revisi {
                width: 100%;
            }

            .validasi-form-content {
                padding: 12px;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        function tampilkanCatatan(button) {
            const wrapper = document.getElementById('catatanWrapper');
            const textarea = document.getElementById('catatan_validasi');

            wrapper.style.display = 'block';
            textarea.required = true;
            textarea.focus();

            // Ubah tombol Perlu Revisi menjadi tombol Kirim Revisi
            button.innerHTML = '<i class="bi bi-send"></i> Kirim Revisi';
            button.setAttribute('type', 'submit');
            button.setAttribute('name', 'status_validasi');
            button.setAttribute('value', 'menunggu_revisi');

            // Hapus onclick agar klik berikutnya mengirim form
            button.removeAttribute('onclick');
        }
    </script>
@endpush