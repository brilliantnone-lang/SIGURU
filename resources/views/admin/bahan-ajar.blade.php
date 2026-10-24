@extends('layouts.app')

@section('title', 'Bahan Ajar Guru - SIGURU')

@section('content')
    <div class="admin-bahan-ajar">

        <div class="bahan-ajar-heading">
            <h1>Bahan Ajar Guru</h1>
            <p>Melihat bahan ajar yang digunakan guru</p>
        </div>

        {{-- Filter --}}
        <section class="bahan-ajar-filter">
            <div class="bahan-filter-field">
                <label for="filterGuruBahan">Guru</label>
                <select id="filterGuruBahan">
                    <option value="">Semua Guru</option>
                    <option>Siti Rahmah, S.Pd.</option>
                    <option>Budi Santoso, S.Pd.</option>
                    <option>Aisyah Putri, S.Pd.</option>
                    <option>Rizki Maulana, S.Pd.</option>
                    <option>Dewi Lestari, S.Pd.</option>
                </select>
            </div>

            <div class="bahan-filter-field">
                <label for="filterMapelBahan">Mata Pelajaran</label>
                <select id="filterMapelBahan">
                    <option value="">Semua Mata Pelajaran</option>
                    <option>Matematika</option>
                    <option>IPA</option>
                    <option>Bahasa Indonesia</option>
                    <option>IPS</option>
                    <option>Bahasa Inggris</option>
                </select>

            </div>

            <div class="bahan-filter-field">
                <label for="filterTahunAjaranBahan">Tahun Ajaran</label>
                <select id="filterTahunAjaranBahan">
                    <option value="">Semua Tahun Ajaran</option>
                    <option>2024/2025</option>
                    <option>2025/2026</option>
                    <option>2026/2027</option>
                </select>
            </div>

            <button type="button" id="btnFilterBahan" class="bahan-filter-button">
                <i class="bi bi-search"></i>
                Tampilkan
            </button>
        </section>

        {{-- Daftar bahan ajar --}}
        <section class="bahan-ajar-panel">
            <div class="bahan-ajar-panel-heading">
                <span aria-hidden="true">▱</span>
                <h2>Daftar Bahan Ajar Guru</h2>
            </div>

            <div class="bahan-ajar-table-scroll">
                <table class="bahan-ajar-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Mata Pelajaran</th>
                            <th>File Bahan Ajar</th>
                            <th>TimeStamp</th>
                            <th>Tahun Ajaran</th>
                        </tr>
                    </thead>
                    <tbody id="bahanAjarTableBody">
                        @php
                            $bahanAjar = [
                                [
                                    'Siti Rahmah, S.Pd.',
                                    'Matematika',
                                    [
                                        'Persamaan Linear Satu Variabel.pdf',
                                        'Latihan Soal PLSV.pdf',
                                        'LKPD PLSV.pdf'
                                    ],
                                    '29 Sep 2026',
                                    '2025/2026'
                                ],
                                [
                                    'Budi Santoso, S.Pd.',
                                    'IPA',
                                    [
                                        'Sistem Pernapasan Manusia.pdf',
                                        'LKPD Sistem Pernapasan.pdf'
                                    ],
                                    '29 Sep 2026',
                                    '2025/2026'
                                ],
                                [
                                    'Aisyah Putri, S.Pd.',
                                    'Bahasa Indonesia',
                                    [
                                        'Teks Eksposisi.pdf',
                                        'LKPD Teks Eksposisi.pdf'
                                    ],
                                    '28 Sep 2026',
                                    '2025/2026'
                                ],
                                [
                                    'Rizki Maulana, S.Pd.',
                                    'IPS',
                                    [
                                        'Kondisi Geografis Indonesia.pdf',
                                        'Modul IPS Bab 1.pdf'
                                    ],
                                    '28 Sep 2026',
                                    '2025/2026'
                                ],
                                [
                                    'Dewi Lestari, S.Pd.',
                                    'Bahasa Inggris',
                                    [
                                        'Describing People.pdf',
                                        'Daily Activity.pdf'
                                    ],
                                    '27 Sep 2026',
                                    '2025/2026'
                                ],
                            ];
                        @endphp

                        @foreach ($bahanAjar as $index => $item)
                            <tr data-guru="{{ $item[0] }}" data-mapel="{{ $item[1] }}" data-tahun="{{ $item[4] }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item[0] }}</td>
                                <td>{{ $item[1] }}</td>
                                <td>
                                    <div class="bahan-file-list">
                                        @foreach ($item[2] as $file)
                                            @php
                                                $extension = strtolower(
                                                    pathinfo($file, PATHINFO_EXTENSION)
                                                );
                                            @endphp

                                            <div class="bahan-file-item">
                                                <span class="bahan-file-icon file-{{ $extension }}">
                                                    {{ strtoupper($extension) }}
                                                </span>
                                                <span class="bahan-file-name">
                                                    {{ $file }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $item[3] }}</td>
                                <td>{{ $item[4] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bahan-ajar-footer">
                <span id="bahanAjarInfo">
                    Menampilkan 1-5 dari 48 bahan ajar
                </span>

                <div class="bahan-ajar-pagination">
                    <button type="button" disabled aria-label="Halaman sebelumnya">&lt;</button>
                    <button type="button" class="active" aria-current="page">1</button>
                    <button type="button">2</button>
                    <button type="button">3</button>
                    <button type="button">4</button>
                    <button type="button">5</button>
                    <span>...</span>
                </div>
            </div>
        </section>

    </div>

    <style>
        .admin-bahan-ajar {
            width: 100%;
            min-width: 0;
            color: #263b35;
            font-family: inherit;
        }

        .admin-bahan-ajar *,
        .admin-bahan-ajar *::before,
        .admin-bahan-ajar *::after {
            box-sizing: border-box;
        }

        .bahan-ajar-heading {
            margin-bottom: 16px;
        }

        .bahan-ajar-heading h1 {
            margin: 0;
            color: #17211f;
            font-size: 25px;
            font-weight: 700;
            line-height: 1.35;
        }

        .bahan-ajar-heading p {
            margin: 3px 0 0;
            color: #52665e;
            font-size: 13px;
        }

        /* Filter */

        .bahan-ajar-filter {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) minmax(0, 1fr) auto;
            align-items: end;
            gap: 16px;
            margin-bottom: 10px;
            padding: 14px;
            background: #fff;
            border: 1px solid #dfe5e2;
            border-radius: 7px;
            box-shadow: 0 2px 3px rgba(30, 50, 40, 0.04);
        }

        .bahan-filter-field {
            display: flex;
            flex-direction: column;
            gap: 7px;
            min-width: 0;
        }

        .bahan-filter-field label {
            color: #40534b;
            font-size: 11px;
            font-weight: 600;
        }

        .bahan-filter-field select {
            width: 100%;
            max-width: none;
            min-width: 0;
            height: 34px;
            padding: 0 9px;
            color: #46574f;
            background: #fff;
            border: 1px solid #dce4e0;
            border-radius: 5px;
            font: inherit;
            font-size: 11px;
        }

        .bahan-filter-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 95px;
            height: 34px;
            padding: 0 13px;
            color: #fff;
            background: #145b3c;
            border: none;
            border-radius: 5px;
            font: inherit;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .bahan-filter-button:hover {
            background: #10482f;
        }

        /* Panel dan tabel */

        .bahan-ajar-panel {
            min-width: 0;
            padding: 12px;
            background: #fff;
            border: 1px solid #e0e7e4;
            border-radius: 7px;
        }

        .bahan-ajar-panel-heading {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
        }

        .bahan-ajar-panel-heading>span {
            color: #26935c;
            font-size: 19px;
        }

        .bahan-ajar-panel-heading h2 {
            margin: 0;
            color: #263b35;
            font-size: 15px;
            font-weight: 700;
        }

        .bahan-ajar-table-scroll {
            width: 100%;
            overflow-x: auto;
        }

        .bahan-ajar-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 10px;
        }

        .bahan-ajar-table thead {
            background: #fff;
        }

        .bahan-ajar-table th {
            padding: 9px 7px;
            color: #30483c;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .bahan-ajar-table td {
            padding: 8px 7px;
            color: #35443c;
            border-bottom: 1px solid #f0f2f1;
            vertical-align: middle;
        }

        .bahan-ajar-table tbody tr:last-child td {
            border-bottom: none;
        }

        .bahan-ajar-table tbody tr:hover {
            background: #fafcfb;
        }

        .bahan-ajar-table th:first-child,
        .bahan-ajar-table td:first-child {
            width: 35px;
        }

        .bahan-ajar-table th:nth-child(4) {
            min-width: 200px;
        }

        .bahan-ajar-table th:nth-child(5),
        .bahan-ajar-table th:nth-child(6) {
            white-space: nowrap;
        }

        /* Daftar file */

        .bahan-file-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 190px;
        }

        .bahan-file-item {
            display: flex;
            align-items: center;
            gap: 5px;
            min-width: 0;
        }

        .bahan-file-icon {
            display: inline-flex;
            flex: 0 0 11px;
            width: 11px;
            height: 14px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            background: #d85d52;
            border-radius: 2px;
            font-size: 4px;
            font-weight: 700;
        }

        .bahan-file-name {
            overflow-wrap: anywhere;
            line-height: 1.4;
        }

        /* Footer dan pagination */

        .bahan-ajar-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 12px;
            padding: 5px 3px 10px;
        }

        .bahan-ajar-footer>span {
            color: #52665e;
            font-size: 11px;
        }

        .bahan-ajar-pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .bahan-ajar-pagination button {
            min-width: 24px;
            height: 24px;
            padding: 0 6px;
            color: #43574b;
            background: #fff;
            border: 1px solid #dce4df;
            border-radius: 4px;
            font: inherit;
            font-size: 10px;
            cursor: pointer;
        }

        .bahan-ajar-pagination button.active {
            color: #1e653e;
            background: #dff5e5;
            border-color: #a5d9b5;
        }

        .bahan-ajar-pagination button:disabled {
            color: #aab4ae;
            cursor: not-allowed;
        }

        .bahan-ajar-pagination span {
            padding: 0 2px;
            color: #6c7b73;
            font-size: 11px;
        }

        /* Responsif */

        @media (max-width: 760px) {
            .bahan-ajar-filter {
                grid-template-columns: 1fr 1fr;
            }

            .bahan-filter-button {
                grid-column: 1 / -1;
            }

            .bahan-filter-button {
                width: 100%;
            }

            .bahan-filter-field select {
                max-width: none;
            }

            .bahan-ajar-table {
                min-width: 650px;
            }
        }

        @media (max-width: 480px) {
            .bahan-ajar-heading h1 {
                font-size: 22px;
            }

            .bahan-ajar-filter {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .bahan-ajar-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .bahan-ajar-pagination {
                flex-wrap: wrap;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const guruFilter = document.getElementById('filterGuruBahan');
            const mapelFilter = document.getElementById('filterMapelBahan');
            const tahunAjaranFilter = document.getElementById('filterTahunAjaranBahan');
            const tombolFilter = document.getElementById('btnFilterBahan');
            const tableBody = document.getElementById('bahanAjarTableBody');
            const info = document.getElementById('bahanAjarInfo');

            tombolFilter.addEventListener('click', function () {
                const guru = guruFilter.value;
                const mapel = mapelFilter.value;
                const tahunAjaran = tahunAjaranFilter.value;
                const rows = Array.from(tableBody.querySelectorAll('tr'));

                let jumlahTampil = 0;

                rows.forEach(function (row) {
                    const cocokGuru = !guru || row.dataset.guru === guru;
                    const cocokMapel = !mapel || row.dataset.mapel === mapel;
                    const cocokTahun = !tahunAjaran || row.dataset.tahun === tahunAjaran;
                    const tampil = cocokGuru && cocokMapel && cocokTahun;

                    row.hidden = !tampil;

                    if (tampil) jumlahTampil++;
                });

                info.textContent = jumlahTampil
                    ? 'Menampilkan ' + jumlahTampil + ' dari data contoh bahan ajar'
                    : 'Tidak ada bahan ajar yang sesuai dengan filter';
            });
        });
    </script>
@endsection