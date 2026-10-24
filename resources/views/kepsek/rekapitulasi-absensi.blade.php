
@extends('layouts.app')

@section('title', 'Rekapitulasi Absensi Siswa')

@section('content')
<style>
    .rekap-page {
        width: 100%;
        min-width: 0;
        color: #26332f;
        font-family: inherit;
    }

    .rekap-page *,
    .rekap-page *::before,
    .rekap-page *::after {
        box-sizing: border-box;
    }

    .rekap-heading {
        margin-bottom: 40px;
    }

    .rekap-heading h3 {
        margin: 0;
        color: #17211f;
        font-size: 24px;
        font-weight: 700;
    }

    .rekap-heading p {
        margin: 4px 0 0;
        color: #52665e;
        font-size: 12px;
    }

    /* Filter */
    .rekap-filter {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        align-items: end;
        gap: 14px;
        margin-bottom: 16px;
        padding: 11px;
        background: #fff;
        border: 1px solid #e0e7e3;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(38, 51, 47, .05);
    }

    .rekap-filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 0;
    }

    .rekap-filter-group label {
        color: #35483e;
        font-size: 10px;
        font-weight: 600;
    }

    .rekap-filter-group input,
    .rekap-filter-group select {
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

    .rekap-filter-group input:focus,
    .rekap-filter-group select:focus {
        border-color: #299b6b;
        box-shadow: 0 0 0 2px rgba(41, 155, 107, .1);
    }

    .rekap-filter-button {
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
        white-space: nowrap;
        cursor: pointer;
    }

    .rekap-filter-button:hover {
        background: #12583b;
    }

    /* Panel tabel */
    .rekap-panel {
        min-width: 0;
        padding: 11px;
        background: #fff;
        border: 1px solid #e2eae5;
        border-radius: 7px;
    }

    .rekap-panel-heading {
        display: flex;
        align-items: center;
        gap: 7px;
        margin: 0 0 9px 2px;
    }

    .rekap-panel-heading i {
        color: #299b6b;
        font-size: 13px;
    }

    .rekap-panel-heading h4 {
        margin: 0;
        color: #294238;
        font-size: 12px;
        font-weight: 700;
    }

    .rekap-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .rekap-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 9px;
    }

    .rekap-table thead {
        background: #f0f5f2;
    }

    .rekap-table th {
        padding: 7px 6px;
        color: #52665e;
        font-size: 9px;
        font-weight: 600;
        white-space: nowrap;
    }

    .rekap-table td {
        padding: 5px 6px;
        color: #35423d;
        border-bottom: 1px solid #edf1ee;
        vertical-align: middle;
        white-space: nowrap;
    }

    .rekap-table tbody tr:nth-child(even) {
        background: #fbfcfb;
    }

    .rekap-table tbody tr:last-child td {
        border-bottom: none;
    }

    .rekap-center {
        text-align: center;
    }

    /* Angka absensi */
    .rekap-count {
        display: inline-block;
        min-width: 19px;
        padding: 3px 5px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 600;
        text-align: center;
    }

    .count-hadir {
        color: #18804b;
        background: #dff5e8;
    }

    .count-izin {
        color: #9c6a00;
        background: #fff0c9;
    }

    .count-sakit {
        color: #b92d35;
        background: #ffe4e5;
    }

    .count-alpa {
        color: #56646c;
        background: #edf1f3;
    }

    .rekap-detail-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 4px 8px;
        color: #fff;
        background: #176b48;
        border: none;
        border-radius: 4px;
        font-size: 8px;
        cursor: pointer;
    }

    .rekap-detail-button:hover {
        background: #12583b;
    }

    /* Footer dan pagination */
    .rekap-footer {
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

    .rekap-pagination {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .rekap-pagination button {
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

    .rekap-pagination button.active {
        color: #fff;
        background: #176b48;
        border-color: #176b48;
    }

    .rekap-pagination button:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    /* Responsif */
    @media (max-width: 850px) {
        .rekap-heading {
            margin-bottom: 25px;
        }

        .rekap-filter {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .rekap-filter-button {
            width: 100%;
        }

        .rekap-table {
            min-width: 750px;
        }
    }

    @media (max-width: 500px) {
        .rekap-heading h3 {
            font-size: 21px;
        }

        .rekap-filter {
            gap: 10px;
            padding: 9px;
        }

        .rekap-panel {
            padding: 8px;
        }

        .rekap-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="rekap-page">

    {{-- Judul halaman --}}
    <div class="rekap-heading">
        <h3>Rekapitulasi Absensi Siswa</h3>
        <p>Data kehadiran siswa berdasarkan kelas dan tanggal</p>
    </div>

    {{-- Filter --}}
    <form class="rekap-filter" id="rekapFilter">

        <div class="rekap-filter-group">
            <label for="rekapTanggal">Tanggal</label>
            <input
                type="date"
                id="rekapTanggal"
                value="2026-09-29"
            >
        </div>

        <div class="rekap-filter-group">
            <label for="rekapKelas">Kelas</label>
            <select id="rekapKelas">
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
                <option value="IX-D">IX-D</option>
            </select>
        </div>

        <div class="rekap-filter-group">
            <label for="rekapStatus">Status Kehadiran</label>
            <select id="rekapStatus">
                <option value="">Semua Status</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpa">Alpa</option>
            </select>
        </div>

        <button type="submit" class="rekap-filter-button">
            <i class="bi bi-search"></i>
            Tampilkan
        </button>

    </form>

    {{-- Tabel rekap --}}
    <section class="rekap-panel">

        <div class="rekap-panel-heading">
            <i class="bi bi-person-check-fill"></i>
            <h4>Rekapitulasi Kehadiran Siswa per Kelas</h4>
        </div>

        @php
            $kelasAbsensi = [
                ['VII-A', 28, 24, 2, 1, 1],
                ['VII-B', 29, 26, 1, 1, 1],
                ['VII-C', 28, 23, 3, 1, 1],
                ['VIII-A', 30, 27, 1, 1, 1],
                ['VIII-B', 29, 25, 2, 2, 1],
                ['VIII-C', 28, 26, 1, 1, 1],
                ['IX-A', 32, 29, 1, 1, 1],
                ['IX-B', 31, 27, 2, 1, 1],
                ['IX-C', 31, 28, 1, 1, 1],
                ['IX-D', 31, 28, 4, 1, 1],
            ];
        @endphp

        <div class="rekap-table-wrapper">
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th class="rekap-center">No.</th>
                        <th>Kelas</th>
                        <th class="rekap-center">Jumlah Siswa</th>
                        <th class="rekap-center">Hadir</th>
                        <th class="rekap-center">Izin</th>
                        <th class="rekap-center">Sakit</th>
                        <th class="rekap-center">Alpa</th>
                        <th class="rekap-center">Aksi</th>
                    </tr>
                </thead>

                <tbody id="rekapTableBody">
                    @foreach ($kelasAbsensi as $index => $data)
                        <tr
                            data-kelas="{{ $data[0] }}"
                            data-hadir="{{ $data[2] }}"
                            data-izin="{{ $data[3] }}"
                            data-sakit="{{ $data[4] }}"
                            data-alpa="{{ $data[5] }}"
                        >
                            <td class="rekap-center">{{ $index + 1 }}</td>
                            <td>{{ $data[0] }}</td>
                            <td class="rekap-center">{{ $data[1] }}</td>
                            <td class="rekap-center">
                                <span class="rekap-count count-hadir">{{ $data[2] }}</span>
                            </td>
                            <td class="rekap-center">
                                <span class="rekap-count count-izin">{{ $data[3] }}</span>
                            </td>
                            <td class="rekap-center">
                                <span class="rekap-count count-sakit">{{ $data[4] }}</span>
                            </td>
                            <td class="rekap-center">
                                <span class="rekap-count count-alpa">{{ $data[5] }}</span>
                            </td>
                            <td class="rekap-center">
                                <button
                                    type="button"
                                    class="rekap-detail-button"
                                    data-kelas="{{ $data[0] }}"
                                    onclick="lihatDetailAbsensi(this)"
                                >
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="rekap-footer">
            <span id="rekapCount">Menampilkan 1-10 dari 24 kelas</span>

            <div class="rekap-pagination" id="rekapPagination">
                <button type="button" disabled aria-label="Halaman sebelumnya">&lt;</button>
                <button type="button" class="active">1</button>
                <button type="button">2</button>
                <button type="button">3</button>
                <button type="button">4</button>
                <button type="button">5</button>
                <button type="button" disabled>...</button>
                <button type="button" aria-label="Halaman berikutnya">&gt;</button>
            </div>
        </div>

    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('rekapFilter');
    const tanggal = document.getElementById('rekapTanggal');
    const kelas = document.getElementById('rekapKelas');
    const status = document.getElementById('rekapStatus');
    const tbody = document.getElementById('rekapTableBody');
    const count = document.getElementById('rekapCount');
    const pagination = document.getElementById('rekapPagination');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const rows = Array.from(tbody.querySelectorAll('tr'));
        let visible = 0;

        rows.forEach(function (row) {
            const cocokKelas =
                !kelas.value || row.dataset.kelas === kelas.value;

            const cocokStatus =
                !status.value || Number(row.dataset[status.value]) > 0;

            const cocok = cocokKelas && cocokStatus;

            row.style.display = cocok ? '' : 'none';

            if (cocok) {
                visible++;
                row.cells[0].textContent = visible;
            }
        });

        count.textContent = visible
            ? `Menampilkan 1-${visible} dari ${visible} kelas contoh`
            : 'Tidak ada data yang sesuai dengan filter';

        pagination.style.display = visible ? 'flex' : 'none';

        if (tanggal.value) {
            const [tahun, bulan, hari] = tanggal.value.split('-');
            console.log(`Filter tanggal: ${hari}-${bulan}-${tahun}`);
        }
    });
});

function lihatDetailAbsensi(button) {
    const kelas = button.dataset.kelas;
    alert(
        'Detail absensi kelas ' + kelas +
        ' belum terhubung ke halaman detail.'
    );
}
</script>
@endsection
