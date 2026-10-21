
@extends('layouts.app')

@section('title', 'Validasi Jurnal')

@section('content')
<style>
    .validasi-page {
        width: 100%;
        min-width: 0;
        color: #26332f;
        font-family: inherit;
    }

    .validasi-page *,
    .validasi-page *::before,
    .validasi-page *::after {
        box-sizing: border-box;
    }

    .validasi-heading {
        margin-bottom: 25px;
    }

    .validasi-heading h3 {
        margin: 0;
        color: #17211f;
        font-size: 24px;
        font-weight: 700;
    }

    .validasi-heading p {
        margin: 3px 0 0;
        color: #52665e;
        font-size: 12px;
    }

    /* Filter */
    .validasi-filter {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        align-items: end;
        gap: 14px;
        margin-bottom: 10px;
        padding: 12px;
        background: #fff;
        border: 1px solid #e1e8e4;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(38, 51, 47, .04);
    }

    .validasi-filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 0;
    }

    .validasi-filter-group label {
        color: #35483e;
        font-size: 10px;
        font-weight: 600;
    }

    .validasi-filter-group select {
        width: 100%;
        min-width: 0;
        height: 31px;
        padding: 0 8px;
        color: #48574f;
        background-color: #fff;
        border: 1px solid #dce4df;
        border-radius: 5px;
        font-size: 10px;
        outline: none;
    }

    .validasi-filter-group select:focus {
        border-color: #299b6b;
        box-shadow: 0 0 0 2px rgba(41, 155, 107, .1);
    }

    .validasi-filter-button {
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

    .validasi-filter-button:hover {
        background: #12583b;
    }

    /* Panel tabel */
    .validasi-table-panel {
        min-width: 0;
        padding: 12px;
        background: #fff;
        border: 1px solid #e2eae5;
        border-radius: 8px;
    }

    .validasi-table-heading {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
        color: #28684c;
    }

    .validasi-table-heading i {
        font-size: 13px;
    }

    .validasi-table-heading h4 {
        margin: 0;
        color: #294238;
        font-size: 12px;
        font-weight: 700;
    }

    .validasi-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .validasi-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 9px;
    }

    .validasi-table thead {
        background: #eaf6ef;
    }

    .validasi-table th {
        padding: 8px 6px;
        color: #28684c;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .validasi-table td {
        padding: 6px;
        color: #35423d;
        border-bottom: 1px solid #edf1ee;
        vertical-align: middle;
    }

    .validasi-table tbody tr:nth-child(even) {
        background: #fbfcfb;
    }

    .validasi-table tbody tr:last-child td {
        border-bottom: none;
    }

    .validasi-number {
        width: 30px;
        text-align: center;
    }

    .validasi-status {
        display: inline-block;
        padding: 4px 7px;
        border-radius: 10px;
        font-size: 8px;
        line-height: 1.2;
        text-align: center;
        white-space: nowrap;
    }

    .status-belum {
        color: #a86600;
        background: #fff0d9;
    }

    .status-valid {
        color: #18804b;
        background: #dff5e8;
    }

    .status-revisi {
        color: #7541b4;
        background: #eee5ff;
    }

    .status-direvisi {
        color: #176b99;
        background: #dff2ff;
    }

    .validasi-action {
        min-width: 48px;
        padding: 4px 10px;
        color: #fff;
        background: #176b48;
        border: none;
        border-radius: 4px;
        font-size: 9px;
        cursor: pointer;
    }

    .validasi-action:hover {
        background: #12583b;
    }

    .validasi-empty {
        padding: 22px !important;
        color: #77857d !important;
        text-align: center;
    }

    /* Footer tabel */
    .validasi-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 13px;
        color: #52665e;
        font-size: 9px;
    }

    .validasi-pagination {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .validasi-pagination button {
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

    .validasi-pagination button.active {
        color: #fff;
        background: #176b48;
        border-color: #176b48;
    }

    .validasi-pagination button:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    @media (max-width: 850px) {
        .validasi-filter {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .validasi-filter-button {
            width: 100%;
        }

        .validasi-table {
            min-width: 720px;
        }
    }

    @media (max-width: 500px) {
        .validasi-heading h3 {
            font-size: 21px;
        }

        .validasi-filter {
            gap: 10px;
            padding: 10px;
        }

        .validasi-table-panel {
            padding: 9px;
        }

        .validasi-table-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="validasi-page">

    {{-- Judul halaman --}}
    <div class="validasi-heading">
        <h3>Jurnal Harian Guru</h3>
        <p>Melihat catatan kegiatan mengajar guru</p>
    </div>

    {{-- Filter --}}
    <form class="validasi-filter" id="validasiFilter">

        <div class="validasi-filter-group">
            <label for="filterSemester">Semester</label>
            <select id="filterSemester">
                <option value="">Semua Semester</option>
                <option value="Ganjil 2025/2026">Ganjil 2025/2026</option>
                <option value="Genap 2025/2026">Genap 2025/2026</option>
            </select>
        </div>

        <div class="validasi-filter-group">
            <label for="filterKelas">Kelas</label>
            <select id="filterKelas">
                <option value="">Semua Kelas</option>
                <option value="VII-A">VII-A</option>
                <option value="VII-B">VII-B</option>
                <option value="VII-C">VII-C</option>
                <option value="VIII-A">VIII-A</option>
                <option value="VIII-B">VIII-B</option>
                <option value="VIII-C">VIII-C</option>
                <option value="IX-A">IX-A</option>
                <option value="IX-B">IX-B</option>
                <option value="IX-C">IX-C</option>
            </select>
        </div>

        <div class="validasi-filter-group">
            <label for="filterStatus">Status Validasi</label>
            <select id="filterStatus">
                <option value="">Semua Status</option>
                <option value="Belum Divalidasi">Belum Divalidasi</option>
                <option value="Tervalidasi">Tervalidasi</option>
                <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                <option value="Sudah Direvisi">Sudah Direvisi</option>
            </select>
        </div>

        <button type="submit" class="validasi-filter-button">
            <i class="bi bi-search"></i>
            Tampilkan
        </button>

    </form>

    {{-- Tabel jurnal --}}
    <section class="validasi-table-panel">

        <div class="validasi-table-heading">
            <i class="bi bi-card-list"></i>
            <h4>Daftar Jurnal Harian Guru</h4>
        </div>

        @php
            $jurnals = [
                ['Siti Rahma, S.Pd.', 'Matematika', 'VII-A', '29 Sep 2026', 'Belum Divalidasi', 'Ganjil 2025/2026'],
                ['Budi Santoso, S.Pd.', 'IPA', 'VIII-B', '29 Sep 2026', 'Tervalidasi', 'Ganjil 2025/2026'],
                ['Aisyah Putri, S.Pd.', 'Bahasa Indonesia', 'IX-A', '29 Sep 2026', 'Belum Divalidasi', 'Ganjil 2025/2026'],
                ['Rizki Maulana, S.Pd.', 'IPS', 'VII-B', '28 Sep 2026', 'Perlu Perbaikan', 'Ganjil 2025/2026'],
                ['Dewi Lestari, S.Pd.', 'Bahasa Inggris', 'VIII-A', '28 Sep 2026', 'Sudah Direvisi', 'Ganjil 2025/2026'],
                ['Andi Pratama, S.Pd.', 'PJOK', 'IX-B', '28 Sep 2026', 'Belum Divalidasi', 'Ganjil 2025/2026'],
                ['Nina Oktavianti, S.Pd.', 'IPA', 'VIII-C', '27 Sep 2026', 'Tervalidasi', 'Ganjil 2025/2026'],
                ['Fajar Hidayat, S.Pd.', 'Informatika', 'IX-C', '27 Sep 2026', 'Perlu Perbaikan', 'Ganjil 2025/2026'],
                ['Lestari Wulandari, S.Pd.', 'Agama', 'VII-A', '27 Sep 2026', 'Tervalidasi', 'Ganjil 2025/2026'],
                ['Yoga Setiawan, S.Pd.', 'Seni Budaya', 'VIII-D', '26 Sep 2026', 'Belum Divalidasi', 'Ganjil 2025/2026'],
            ];
        @endphp

        <div class="validasi-table-wrapper">
            <table class="validasi-table">
                <thead>
                    <tr>
                        <th class="validasi-number">No.</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Status Validasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="validasiTableBody">
                    @foreach ($jurnals as $index => $jurnal)
                        @php
                            $statusClass = match ($jurnal[4]) {
                                'Tervalidasi' => 'status-valid',
                                'Perlu Perbaikan' => 'status-revisi',
                                'Sudah Direvisi' => 'status-direvisi',
                                default => 'status-belum',
                            };
                        @endphp

                        <tr
                            data-semester="{{ $jurnal[5] }}"
                            data-kelas="{{ $jurnal[2] }}"
                            data-status="{{ $jurnal[4] }}"
                        >
                            <td class="validasi-number">{{ $index + 1 }}</td>
                            <td>{{ $jurnal[0] }}</td>
                            <td>{{ $jurnal[1] }}</td>
                            <td>{{ $jurnal[2] }}</td>
                            <td>{{ $jurnal[3] }}</td>
                            <td>
                                <span class="validasi-status {{ $statusClass }}">
                                    {{ $jurnal[4] }}
                                </span>
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="validasi-action"
                                    onclick="alert('Detail jurnal ini masih berupa contoh tampilan.')"
                                >
                                    Lihat
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="validasi-table-footer">
            <span id="validasiCount">Menampilkan 1-10 dari 320 jurnal</span>

            <div class="validasi-pagination" id="validasiPagination">
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
    const form = document.getElementById('validasiFilter');
    const semester = document.getElementById('filterSemester');
    const kelas = document.getElementById('filterKelas');
    const status = document.getElementById('filterStatus');
    const tbody = document.getElementById('validasiTableBody');
    const count = document.getElementById('validasiCount');
    const pagination = document.getElementById('validasiPagination');

    function filterJurnal() {
        const rows = Array.from(tbody.querySelectorAll('tr'));
        let visible = 0;

        rows.forEach(function (row) {
            const cocokSemester =
                !semester.value || row.dataset.semester === semester.value;
            const cocokKelas =
                !kelas.value || row.dataset.kelas === kelas.value;
            const cocokStatus =
                !status.value || row.dataset.status === status.value;

            const cocok = cocokSemester && cocokKelas && cocokStatus;

            row.style.display = cocok ? '' : 'none';

            if (cocok) {
                visible++;
                row.querySelector('.validasi-number').textContent = visible;
            }
        });

        count.textContent = visible
            ? `Menampilkan 1-${visible} dari ${visible} jurnal contoh`
            : 'Tidak ada jurnal yang sesuai dengan filter';

        pagination.style.display = visible ? 'flex' : 'none';
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        filterJurnal();
    });
});
</script>
@endsection
