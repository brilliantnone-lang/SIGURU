@extends('layouts.app')

@section('title', 'Bahan Ajar Guru')

@section('content')
    <style>
        .kepsek-bahan-page {
            width: 100%;
            min-width: 0;
            color: #26332f;
            font-family: inherit;
        }

        .kepsek-bahan-page *,
        .kepsek-bahan-page *::before,
        .kepsek-bahan-page *::after {
            box-sizing: border-box;
        }

        /* Heading */
        .bahan-heading {
            margin-bottom: 20px;
        }

        .bahan-heading h3 {
            margin: 0;
            color: #17211f;
            font-size: 24px;
            font-weight: 700;
        }

        .bahan-heading p {
            margin: 3px 0 0;
            color: #52665e;
            font-size: 12px;
        }

        /* Filter */
        .bahan-filter {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr)) auto;
            align-items: end;
            gap: 14px;
            margin: 0 0 8px;
            padding: 11px;
            background: #fff;
            border: 1px solid #e1e8e4;
            border-radius: 7px;
            box-shadow: 0 2px 5px rgba(38, 51, 47, .05);
        }

        .bahan-filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 0;
        }

        .bahan-filter-group label {
            color: #35483e;
            font-size: 10px;
            font-weight: 600;
        }

        .bahan-filter-group select {
            width: 100%;
            min-width: 0;
            height: 31px;
            padding: 0 8px;
            color: #48574f;
            background: #fff;
            border: 1px solid #dce4df;
            border-radius: 5px;
            font-family: inherit;
            font-size: 10px;
            outline: none;
        }

        .bahan-filter-group select:focus {
            border-color: #299b6b;
            box-shadow: 0 0 0 2px rgba(41, 155, 107, .1);
        }

        .bahan-filter-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 31px;
            padding: 0 13px;
            color: #fff;
            background: #176b48;
            border: none;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        .bahan-filter-button:hover {
            background: #12583b;
        }

        /* Panel tabel */
        .bahan-table-panel {
            min-width: 0;
            padding: 11px;
            background: #fff;
            border: 1px solid #e2eae5;
            border-radius: 7px;
        }

        .bahan-panel-heading {
            display: flex;
            align-items: center;
            gap: 7px;
            margin: 0 0 12px 2px;
        }

        .bahan-panel-heading i {
            color: #299b6b;
            font-size: 13px;
        }

        .bahan-panel-heading h4 {
            margin: 0;
            color: #263b35;
            font-size: 12px;
            font-weight: 700;
        }

        .bahan-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .bahan-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 9px;
        }

        .bahan-table th {
            padding: 7px 6px;
            color: #35483e;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .bahan-table td {
            padding: 7px 6px;
            color: #35423d;
            border-bottom: 1px solid #edf1ee;
            vertical-align: top;
        }

        .bahan-table tbody tr:last-child td {
            border-bottom: none;
        }

        .bahan-table tbody tr:hover {
            background: #f8fbf9;
        }

        .bahan-number {
            width: 30px;
        }

        .bahan-files {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 150px;
        }

        .bahan-file-link {
            display: flex;
            align-items: flex-start;
            gap: 5px;
            color: #35423d;
            text-decoration: none;
            line-height: 1.4;
            overflow-wrap: anywhere;
        }

        .bahan-file-link:hover {
            color: #176b48;
            text-decoration: underline;
        }

        .bahan-file-link i {
            flex-shrink: 0;
            font-size: 12px;
        }

        .file-pdf {
            color: #e34d4d;
        }

        .bahan-empty {
            padding: 22px !important;
            color: #7a8780 !important;
            text-align: center;
        }

        /* Footer */
        .bahan-table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 13px;
            padding: 0 3px;
            color: #52665e;
            font-size: 9px;
        }

        .bahan-pagination {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .bahan-pagination button {
            min-width: 23px;
            height: 23px;
            padding: 0 5px;
            color: #52665e;
            background: #fff;
            border: 1px solid #dce4df;
            border-radius: 4px;
            font-size: 9px;
            cursor: pointer;
        }

        .bahan-pagination button.active {
            color: #176b48;
            background: #e0f4e7;
            border-color: #8fd3a8;
        }

        .bahan-pagination button:disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        @media (max-width: 750px) {
            .bahan-filter {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .bahan-filter-button {
                grid-column: 1 / -1;
                width: 100%;
            }

            .bahan-table {
                min-width: 650px;
            }
        }

        @media (max-width: 480px) {
            .bahan-heading h3 {
                font-size: 21px;
            }

            .bahan-filter {
                gap: 10px;
                padding: 9px;
            }

            .bahan-table-panel {
                padding: 8px;
            }

            .bahan-table-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="kepsek-bahan-page">

        {{-- Heading --}}
        <div class="bahan-heading">
            <h3>Bahan Ajar Guru</h3>
            <p>Melihat bahan ajar yang digunakan guru</p>
        </div>

        {{-- Filter --}}
        <form id="bahanFilter" class="bahan-filter">

            <div class="bahan-filter-group">
                <label for="filterGuru">Guru</label>
                <select id="filterGuru">
                    <option value="">Semua Guru</option>
                    <option value="Siti Rahmah, S.Pd.">Siti Rahmah, S.Pd.</option>
                    <option value="Budi Santoso, S.Pd.">Budi Santoso, S.Pd.</option>
                    <option value="Aisyah Putri, S.Pd.">Aisyah Putri, S.Pd.</option>
                    <option value="Rizki Maulana, S.Pd.">Rizki Maulana, S.Pd.</option>
                    <option value="Dewi Lestari, S.Pd.">Dewi Lestari, S.Pd.</option>
                </select>
            </div>

            <div class="bahan-filter-group">
                <label for="filterMapel">Mata Pelajaran</label>
                <select id="filterMapel">
                    <option value="">Semua Mata Pelajaran</option>
                    <option value="Matematika">Matematika</option>
                    <option value="IPA">IPA</option>
                    <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                    <option value="IPS">IPS</option>
                    <option value="Bahasa Inggris">Bahasa Inggris</option>
                </select>
            </div>

            <div class="bahan-filter-group">
                <label for="filterTahunAjaranBahan">Tahun Ajaran</label>
                <select id="filterTahunAjaranBahan">
                    <option value="">Semua Tahun Ajaran</option>
                    <option>2024/2025</option>
                    <option>2025/2026</option>
                    <option>2026/2027</option>
                </select>
            </div>

            <button type="submit" class="bahan-filter-button">
                <i class="bi bi-search"></i>
                Tampilkan
            </button>

        </form>

        {{-- Daftar bahan ajar --}}
        <section class="bahan-table-panel">

            <div class="bahan-panel-heading">
                <i class="bi bi-folder2"></i>
                <h4>Daftar Bahan Ajar Guru</h4>
            </div>

            @php
                $bahanAjar = [
                    [
                        'Siti Rahmah, S.Pd.',
                        'Matematika',
                        [
                            ['Persamaan Linear Satu Variabel.pdf', 'pdf'],
                            ['Latihan Soal PLSV.pdf', 'pdf'],
                            ['LKPD PLSV.pdf', 'pdf'],
                        ],
                        '29 Sep 2026',
                        '2025/2026',
                    ],
                    [
                        'Budi Santoso, S.Pd.',
                        'IPA',
                        [
                            ['Sistem Pernapasan Manusia.pdf', 'pdf'],
                            ['LKPD Sistem Pernapasan.pdf', 'pdf'],
                        ],
                        '29 Sep 2026',
                        '2025/2026',
                    ],
                    [
                        'Aisyah Putri, S.Pd.',
                        'Bahasa Indonesia',
                        [
                            ['Teks Eksposisi.pdf', 'pdf'],
                            ['LKPD Teks Eksposisi.pdf', 'pdf'],
                        ],
                        '28 Sep 2026',
                        '2025/2026',
                    ],
                    [
                        'Rizki Maulana, S.Pd.',
                        'IPS',
                        [
                            ['Kondisi Geografis Indonesia.pdf', 'pdf'],
                            ['Modul IPS Bab 1.pdf', 'pdf'],
                        ],
                        '28 Sep 2026',
                        '2025/2026',
                    ],
                    [
                        'Dewi Lestari, S.Pd.',
                        'Bahasa Inggris',
                        [
                            ['Describing People.pdf', 'pdf'],
                            ['Daily Activity.pdf', 'pdf'],
                        ],
                        '27 Sep 2026',
                        '2025/2026',
                    ],
                ];
            @endphp

            <div class="bahan-table-wrapper">
                <table class="bahan-table">
                    <thead>
                        <tr>
                            <th class="bahan-number">No</th>
                            <th>Nama</th>
                            <th>Mata Pelajaran</th>
                            <th>File Bahan Ajar</th>
                            <th>TimeStamp</th>
                            <th>Tahun Ajaran</th>
                        </tr>
                    </thead>

                    <tbody id="bahanTableBody">
                        @foreach ($bahanAjar as $index => $item)
                            <tr data-guru="{{ $item[0] }}" data-mapel="{{ $item[1] }}" data-tahun="{{ $item[4] }}">
                                <td class="bahan-number">{{ $index + 1 }}</td>
                                <td>{{ $item[0] }}</td>
                                <td>{{ $item[1] }}</td>

                                <td>
                                    <div class="bahan-files">
                                        @foreach ($item[2] as $file)
                                            @php
                                                $fileIcon = match ($file[1]) {
                                                    'pdf' => 'bi-file-earmark-pdf-fill',
                                                    default => 'bi-file-earmark',
                                                };

                                                $fileClass = match ($file[1]) {
                                                    'pdf' => 'file-pdf',
                                                    default => '',
                                                };
                                            @endphp

                                            <a href="#" class="bahan-file-link"
                                                onclick="event.preventDefault(); alert('File contoh belum terhubung ke dokumen asli.');">
                                                <i class="bi {{ $fileIcon }} {{ $fileClass }}"></i>
                                                <span>{{ $file[0] }}</span>
                                            </a>
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

            <div class="bahan-table-footer">
                <span id="bahanCount">Menampilkan 1-5 dari 48 bahan ajar</span>

                <div class="bahan-pagination" id="bahanPagination">
                    <button type="button" disabled aria-label="Halaman sebelumnya">
                        &lt;
                    </button>
                    <button type="button" class="active">1</button>
                    <button type="button">2</button>
                    <button type="button">3</button>
                    <button type="button">4</button>
                    <button type="button">5</button>
                    <button type="button" disabled>...</button>
                    <button type="button" aria-label="Halaman berikutnya">
                        &gt;
                    </button>
                </div>
            </div>

        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('bahanFilter');
            const filterGuru = document.getElementById('filterGuru');
            const filterMapel = document.getElementById('filterMapel');
            const filterTahun = document.getElementById('filterTahunAjaranBahan');
            const tbody = document.getElementById('bahanTableBody');
            const count = document.getElementById('bahanCount');
            const pagination = document.getElementById('bahanPagination');

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const rows = Array.from(tbody.querySelectorAll('tr'));
                let visible = 0;

                rows.forEach(function (row) {
                    const cocokGuru =
                        !filterGuru.value || row.dataset.guru === filterGuru.value;

                    const cocokMapel =
                        !filterMapel.value || row.dataset.mapel === filterMapel.value;

                    const cocokTahun =
                        !filterTahun.value || row.dataset.tahun === filterTahun.value;

                    const cocok = cocokGuru && cocokMapel && cocokTahun;
                    row.style.display = cocok ? '' : 'none';

                    if (cocok) {
                        visible++;
                        row.cells[0].textContent = visible;
                    }
                });

                count.textContent = visible
                    ? `Menampilkan 1-${visible} dari ${visible} bahan ajar contoh`
                    : 'Tidak ada bahan ajar yang sesuai dengan filter';

                pagination.style.display = visible ? 'flex' : 'none';
            });
        });
    </script>
@endsection