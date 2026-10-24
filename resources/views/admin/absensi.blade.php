@extends('layouts.app')

@section('title', 'Rekapitulasi Absensi - SIGURU')

@section('content')
    <div class="admin-rekap">

        <div class="rekap-heading">
            <h1>Rekapitulasi Absensi Siswa</h1>
            <p>Data kehadiran siswa berdasarkan kelas dan tanggal</p>
        </div>

        {{-- Filter --}}
        <section class="rekap-filter">
            <div class="filter-field">
                <label for="filter-tanggal">Tanggal</label>
                <input type="date" id="filter-tanggal" value="2026-09-29">
            </div>

            <div class="filter-field">
                <label for="filter-kelas">Kelas</label>
                <select id="filter-kelas">
                    <option value="">Semua Kelas</option>
                    <option>VII-A</option>
                    <option>VII-B</option>
                    <option>VII-C</option>
                    <option>VIII-A</option>
                    <option>VIII-B</option>
                    <option>VIII-C</option>
                    <option>IX-A</option>
                    <option>IX-B</option>
                    <option>IX-C</option>
                </select>
            </div>

            <div class="filter-field">
                <label for="filter-status">Status Kehadiran</label>
                <select id="filter-status">
                    <option value="">Semua Status</option>
                    <option>Hadir</option>
                    <option>Izin</option>
                    <option>Sakit</option>
                    <option>Alpa</option>
                </select>
            </div>

            <button type="submit" class="bahan-filter-button">
                <i class="bi bi-search"></i>
                Tampilkan
            </button>
        </section>

        {{-- Tabel rekap --}}
        <section class="rekap-table-panel">
            <div class="rekap-table-heading">
                <span aria-hidden="true">♟</span>
                <h2>Rekapitulasi Kehadiran Siswa per Kelas</h2>
            </div>

            <div class="rekap-table-scroll">
                <table class="rekap-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Hadir</th>
                            <th>Izin</th>
                            <th>Sakit</th>
                            <th>Alpa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="rekap-table-body">
                        @php
                            $dataKelas = [
                                ['VII-A', 30, 29, 0, 0, 1],
                                ['VII-B', 29, 26, 1, 1, 1],
                                ['VII-C', 28, 23, 3, 1, 1],
                                ['VIII-A', 30, 27, 1, 2, 0],
                                ['VIII-B', 30, 25, 2, 2, 1],
                                ['VIII-C', 30, 26, 1, 2, 1],
                                ['IX-A', 32, 29, 1, 1, 1],
                                ['IX-B', 31, 27, 2, 1, 1],
                                ['IX-C', 31, 28, 1, 1, 1],
                                ['IX-D', 30, 28, 4, 0, 0],
                            ];
                        @endphp

                        @foreach ($dataKelas as $index => $kelas)
                            <tr data-kelas="{{ $kelas[0] }}">
                                <td>{{ $index + 1 }}</td>
                                <td class="kelas-name">{{ $kelas[0] }}</td>
                                <td>{{ $kelas[1] }}</td>
                                <td><span class="rekap-badge badge-hadir">{{ $kelas[2] }}</span></td>
                                <td><span class="rekap-badge badge-izin">{{ $kelas[3] }}</span></td>
                                <td><span class="rekap-badge badge-sakit">{{ $kelas[4] }}</span></td>
                                <td><span class="rekap-badge badge-alpa">{{ $kelas[5] }}</span></td>
                                <td>
                                    <button type="button" class="detail-button" data-detail-kelas="{{ $kelas[0] }}">
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="rekap-table-footer">
                <span id="rekap-info">Menampilkan 1-10 dari 15 Kelas</span>

                <div class="rekap-pagination" aria-label="Navigasi halaman">
                    <button type="button" disabled aria-label="Halaman sebelumnya">&lt;</button>
                    <button type="button" class="active" aria-current="page">1</button>
                    <button type="button">2</button>
                    <button type="button">3</button>
                    <button type="button">4</button>
                    <button type="button">5</button>
                    <span>...</span>
                    <button type="button" aria-label="Halaman berikutnya">&gt;</button>
                </div>
            </div>
        </section>

    </div>

    <style>
        .admin-rekap {
            width: 100%;
            min-width: 0;
            color: #263b35;
            font-family: inherit;
        }

        .admin-rekap *,
        .admin-rekap *::before,
        .admin-rekap *::after {
            box-sizing: border-box;
        }

        .rekap-heading {
            margin: 0 0 17px;
        }

        .rekap-heading h1 {
            margin: 0;
            color: #17211f;
            font-size: 25px;
            font-weight: 700;
            line-height: 1.35;
        }

        .rekap-heading p {
            margin: 3px 0 0;
            color: #52665e;
            font-size: 12px;
        }

        /* Filter */

        .rekap-filter {
            display: grid;
            grid-template-columns: 1.1fr 1fr 1fr auto;
            align-items: end;
            gap: 12px;
            margin-bottom: 16px;
            padding: 12px;
            background: #fff;
            border: 1px solid #e0e7e4;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(27, 55, 43, 0.05);
        }

        .filter-field {
            display: flex;
            flex-direction: column;
            min-width: 0;
            gap: 5px;
        }

        .filter-field label {
            color: #40534b;
            font-size: 11px;
            font-weight: 600;
        }

        .filter-field input,
        .filter-field select {
            width: 100%;
            min-width: 0;
            height: 34px;
            padding: 0 9px;
            color: #46574f;
            background: #fff;
            border: 1px solid #dce4e0;
            border-radius: 5px;
            font: inherit;
            font-size: 11px;
            outline: none;
        }

        .filter-field input:focus,
        .filter-field select:focus {
            border-color: #24734e;
            box-shadow: 0 0 0 2px rgba(36, 115, 78, 0.1);
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

        /* Tabel rekap */

        .rekap-table-panel {
            overflow: hidden;
            background: #fff;
            border: 1px solid #e0e7e4;
            border-radius: 8px;
        }

        .rekap-table-heading {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 12px 13px 8px;
        }

        .rekap-table-heading>span {
            color: #17844e;
            font-size: 16px;
        }

        .rekap-table-heading h2 {
            margin: 0;
            color: #284239;
            font-size: 13px;
            font-weight: 700;
        }

        .rekap-table-scroll {
            width: 100%;
            overflow-x: auto;
            padding: 0 10px;
        }

        .rekap-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 10px;
        }

        .rekap-table thead {
            background: #edf6f0;
        }

        .rekap-table th {
            padding: 9px 7px;
            color: #52685c;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .rekap-table td {
            padding: 7px;
            color: #36463e;
            border-bottom: 1px solid #edf0ee;
            white-space: nowrap;
        }

        .rekap-table tbody tr:hover {
            background: #f8fbf9;
        }

        .rekap-table tbody tr:last-child td {
            border-bottom: none;
        }

        .rekap-table th:nth-child(4),
        .rekap-table th:nth-child(5),
        .rekap-table th:nth-child(6),
        .rekap-table th:nth-child(7),
        .rekap-table td:nth-child(4),
        .rekap-table td:nth-child(5),
        .rekap-table td:nth-child(6),
        .rekap-table td:nth-child(7) {
            text-align: center;
        }

        .rekap-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 23px;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .badge-hadir {
            color: #247448;
            background: #d8f2e2;
        }

        .badge-izin {
            color: #946800;
            background: #fff0c9;
        }

        .badge-sakit {
            color: #b83e48;
            background: #ffe0e1;
        }

        .badge-alpa {
            color: #475b52;
            background: #edf1ef;
        }

        .detail-button {
            padding: 5px 9px;
            color: #fff;
            background: #246b49;
            border: none;
            border-radius: 4px;
            font: inherit;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
        }

        /* Footer dan pagination */

        .rekap-table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 13px 14px;
        }

        .rekap-table-footer>span {
            color: #53665c;
            font-size: 11px;
        }

        .rekap-pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .rekap-pagination button {
            min-width: 25px;
            height: 25px;
            padding: 0 6px;
            color: #43574b;
            background: #fff;
            border: 1px solid #dce4df;
            border-radius: 4px;
            font: inherit;
            font-size: 10px;
            cursor: pointer;
        }

        .rekap-pagination button.active {
            color: #1e653e;
            background: #dff5e5;
            border-color: #a5d9b5;
        }

        .rekap-pagination button:disabled {
            color: #aab4ae;
            cursor: not-allowed;
        }

        .rekap-pagination span {
            padding: 0 3px;
            color: #6c7b73;
            font-size: 11px;
        }

        /* Responsif */

        @media (max-width: 900px) {
            .rekap-filter {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .rekap-button {
                width: 100%;
            }
        }

        @media (max-width: 520px) {
            .rekap-heading h1 {
                font-size: 21px;
            }

            .rekap-filter {
                grid-template-columns: 1fr;
            }

            .rekap-table-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .rekap-pagination {
                flex-wrap: wrap;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kelasFilter = document.getElementById('filter-kelas');
            const statusFilter = document.getElementById('filter-status');
            const tampilkanButton = document.getElementById('btn-tampilkan');
            const tableBody = document.getElementById('rekap-table-body');
            const info = document.getElementById('rekap-info');

            // Filter ini hanya bekerja pada data contoh yang tersedia di halaman.
            tampilkanButton.addEventListener('click', function () {
                const kelasTerpilih = kelasFilter.value;
                const statusTerpilih = statusFilter.value;
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                let jumlahTampil = 0;

                rows.forEach(function (row) {
                    const cocokKelas = !kelasTerpilih ||
                        row.dataset.kelas === kelasTerpilih;

                    // Status disimpulkan dari angka pada kolom kehadiran.
                    const cells = row.querySelectorAll('td');
                    const jumlahHadir = Number(cells[3].textContent.trim());
                    const jumlahIzin = Number(cells[4].textContent.trim());
                    const jumlahSakit = Number(cells[5].textContent.trim());
                    const jumlahAlpa = Number(cells[6].textContent.trim());

                    let cocokStatus = true;

                    if (statusTerpilih === 'Hadir') cocokStatus = jumlahHadir > 0;
                    if (statusTerpilih === 'Izin') cocokStatus = jumlahIzin > 0;
                    if (statusTerpilih === 'Sakit') cocokStatus = jumlahSakit > 0;
                    if (statusTerpilih === 'Alpa') cocokStatus = jumlahAlpa > 0;

                    const tampil = cocokKelas && cocokStatus;
                    row.hidden = !tampil;

                    if (tampil) jumlahTampil++;
                });

                info.textContent = jumlahTampil
                    ? 'Menampilkan ' + jumlahTampil + ' kelas dari data contoh'
                    : 'Tidak ada data yang sesuai dengan filter';
            });

            // Tombol detail masih berupa interaksi frontend.
            document.querySelectorAll('[data-detail-kelas]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const namaKelas = this.dataset.detailKelas;
                    alert('Detail absensi kelas ' + namaKelas +
                        ' belum dihubungkan ke halaman detail.');
                });
            });
        });
    </script>
@endsection