
@extends('layouts.app')

@section('title', 'Jurnal Harian Guru - SIGURU')

@section('content')
<div class="admin-jurnal">

    <div class="jurnal-heading">
        <h1>Jurnal Harian Guru</h1>
        <p>Melihat catatan kegiatan mengajar guru</p>
    </div>

    {{-- Filter jurnal --}}
    <section class="jurnal-filter">
        <div class="jurnal-filter-field">
            <label for="tahunAjaran">Tahun Ajaran</label>
            <select id="tahunAjaran">
                <option value="2025/2026">2025/2026</option>
                <option value="2026/2027">2026/2027</option>
            </select>
        </div>

        <div class="jurnal-filter-field">
            <label for="filterGuru">Guru</label>
            <select id="filterGuru">
                <option value="">Semua Guru</option>
                <option>Siti Rahma, S.Pd.</option>
                <option>Budi Santoso, S.Pd.</option>
                <option>Aisyah Putri, S.Pd.</option>
                <option>Fikri Maulana, S.Pd.</option>
                <option>Dewi Lestari, S.Pd.</option>
                <option>Andi Pratama, S.Pd.</option>
                <option>Nina Oktaviani, S.Pd.</option>
                <option>Fajar Hidayat, S.Pd.</option>
                <option>Lestari Wulandari, S.Pd.</option>
                <option>Yoga Setiawan, S.Pd.</option>
            </select>
        </div>

        <div class="jurnal-filter-field">
            <label for="filterStatus">Status Validasi</label>
            <select id="filterStatus">
                <option value="">Semua Status</option>
                <option value="Belum Divalidasi">Belum Divalidasi</option>
                <option value="Tervalidasi">Tervalidasi</option>
                <option value="Perlu Revisi">Perlu Revisi</option>
            </select>
        </div>

        <button type="button" class="jurnal-filter-button" id="tampilkanJurnal">
            <span aria-hidden="true">⌕</span> Tampilkan
        </button>
    </section>

    {{-- Tabel daftar jurnal --}}
    <section class="jurnal-table-panel">

        <div class="jurnal-table-heading">
            <span aria-hidden="true">▤</span>
            <h2>Daftar Jurnal Harian Guru</h2>
        </div>

        <div class="jurnal-table-scroll">
            <table class="jurnal-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Tahun Ajaran</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody id="jurnalTableBody">
                    @php
                        $jurnalContoh = [
                            ['Siti Rahma, S.Pd.', 'Matematika', '2025/2026', 'Belum Divalidasi', '129/129'],
                            ['Budi Santoso, S.Pd.', 'IPA', '2025/2026', 'Tervalidasi', '138/138'],
                            ['Aisyah Putri, S.Pd.', 'Bahasa Indonesia', '2025/2026', 'Belum Divalidasi', '129/129'],
                            ['Fikri Maulana, S.Pd.', 'IPS', '2025/2026', 'Perlu Revisi', '129/129'],
                            ['Dewi Lestari, S.Pd.', 'Bahasa Inggris', '2025/2026', 'Tervalidasi', '129/129'],
                            ['Andi Pratama, S.Pd.', 'PJOK', '2025/2026', 'Belum Divalidasi', '130/131'],
                            ['Nina Oktaviani, S.Pd.', 'IPA', '2025/2026', 'Tervalidasi', '129/129'],
                            ['Fajar Hidayat, S.Pd.', 'Informatika', '2025/2026', 'Perlu Revisi', '129/129'],
                            ['Lestari Wulandari, S.Pd.', 'Agama', '2025/2026', 'Tervalidasi', '129/129'],
                            ['Yoga Setiawan, S.Pd.', 'Seni Budaya', '2025/2026', 'Belum Divalidasi', '129/129'],
                        ];
                    @endphp

                    @foreach ($jurnalContoh as $index => $jurnal)
                    <tr data-guru="{{ $jurnal[0] }}"
                        data-tahun="{{ $jurnal[2] }}"
                        data-status="{{ $jurnal[3] }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jurnal[0] }}</td>
                        <td>{{ $jurnal[1] }}</td>
                        <td>{{ $jurnal[2] }}</td>
                        <td>
                            @if ($jurnal[3] === 'Tervalidasi')
                                <span class="jurnal-status status-valid">{{ $jurnal[3] }}</span>
                            @elseif ($jurnal[3] === 'Perlu Revisi')
                                <span class="jurnal-status status-revisi">{{ $jurnal[3] }}</span>
                            @else
                                <span class="jurnal-status status-pending">{{ $jurnal[3] }}</span>
                            @endif
                        </td>
                        <td>{{ $jurnal[4] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="jurnal-table-footer">
            <span id="jurnalInfo">Menampilkan 1-10 dari 320 jurnal</span>

            <div class="jurnal-pagination">
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
.admin-jurnal {
    width: 100%;
    min-width: 0;
    color: #263b35;
    font-family: inherit;
}

.admin-jurnal *,
.admin-jurnal *::before,
.admin-jurnal *::after {
    box-sizing: border-box;
}

.jurnal-heading {
    margin-bottom: 10px;
}

.jurnal-heading h1 {
    margin: 0;
    color: #17211f;
    font-size: 25px;
    font-weight: 700;
    line-height: 1.35;
}

.jurnal-heading p {
    margin: 3px 0 0;
    color: #52665e;
    font-size: 12px;
}

/* Filter */

.jurnal-filter {
    display: grid;
    grid-template-columns: 1.1fr 1.1fr 1.1fr auto;
    align-items: end;
    gap: 12px;
    margin-bottom: 15px;
    padding: 11px;
    background: #fff;
    border: 1px solid #e0e7e4;
    border-radius: 7px;
}

.jurnal-filter-field {
    display: flex;
    flex-direction: column;
    min-width: 0;
    gap: 5px;
}

.jurnal-filter-field label {
    color: #40534b;
    font-size: 11px;
    font-weight: 600;
}

.jurnal-filter-field select {
    width: 100%;
    min-width: 0;
    height: 32px;
    padding: 0 8px;
    color: #46574f;
    background: #fff;
    border: 1px solid #dce4e0;
    border-radius: 5px;
    font: inherit;
    font-size: 11px;
}

.jurnal-filter-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    min-height: 32px;
    padding: 0 13px;
    color: #fff;
    background: #145b3c;
    border: none;
    border-radius: 5px;
    font: inherit;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
}

.jurnal-filter-button:hover {
    background: #10482f;
}

/* Tabel */

.jurnal-table-panel {
    overflow: hidden;
    background: #fff;
    border: 1px solid #e0e7e4;
    border-radius: 7px;
}

.jurnal-table-heading {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 11px 12px 8px;
}

.jurnal-table-heading > span {
    color: #29845a;
    font-size: 15px;
}

.jurnal-table-heading h2 {
    margin: 0;
    color: #284239;
    font-size: 12px;
    font-weight: 700;
}

.jurnal-table-scroll {
    width: 100%;
    overflow-x: auto;
    padding: 0 10px;
}

.jurnal-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    font-size: 10px;
}

.jurnal-table thead {
    background: #edf6f0;
}

.jurnal-table th {
    padding: 8px 7px;
    color: #52685c;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.jurnal-table td {
    padding: 7px;
    color: #36463e;
    border-bottom: 1px solid #edf0ee;
    white-space: nowrap;
}

.jurnal-table tbody tr:last-child td {
    border-bottom: none;
}

.jurnal-table tbody tr:hover {
    background: #f8fbf9;
}

.jurnal-status {
    display: inline-block;
    padding: 4px 7px;
    border-radius: 4px;
    font-size: 9px;
    line-height: 1.2;
    white-space: nowrap;
}

.status-valid {
    color: #247448;
    background: #d8f2e2;
}

.status-pending {
    color: #956900;
    background: #fff0c9;
}

.status-revisi {
    color: #b83e48;
    background: #ffe0e1;
}

/* Footer dan pagination */

.jurnal-table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px;
}

.jurnal-table-footer > span {
    color: #53665c;
    font-size: 10px;
}

.jurnal-pagination {
    display: flex;
    align-items: center;
    gap: 4px;
}

.jurnal-pagination button {
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

.jurnal-pagination button.active {
    color: #1e653e;
    background: #dff5e5;
    border-color: #a5d9b5;
}

.jurnal-pagination button:disabled {
    color: #aab4ae;
    cursor: not-allowed;
}

.jurnal-pagination span {
    color: #6c7b73;
    font-size: 11px;
}

/* Responsif */

@media (max-width: 850px) {
    .jurnal-filter {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .jurnal-filter-button {
        width: 100%;
    }
}

@media (max-width: 520px) {
    .jurnal-heading h1 {
        font-size: 22px;
    }

    .jurnal-filter {
        grid-template-columns: 1fr;
    }

    .jurnal-table-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .jurnal-pagination {
        flex-wrap: wrap;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tahunFilter = document.getElementById('tahunAjaran');
    const guruFilter = document.getElementById('filterGuru');
    const statusFilter = document.getElementById('filterStatus');
    const tombolTampilkan = document.getElementById('tampilkanJurnal');
    const tabelBody = document.getElementById('jurnalTableBody');
    const info = document.getElementById('jurnalInfo');

    tombolTampilkan.addEventListener('click', function () {
        const tahun = tahunFilter.value;
        const guru = guruFilter.value;
        const status = statusFilter.value;

        const rows = Array.from(tabelBody.querySelectorAll('tr'));
        let jumlahTampil = 0;

        rows.forEach(function (row) {
            const cocokTahun = !tahun || row.dataset.tahun === tahun;
            const cocokGuru = !guru || row.dataset.guru === guru;
            const cocokStatus = !status || row.dataset.status === status;

            const tampil = cocokTahun && cocokGuru && cocokStatus;
            row.hidden = !tampil;

            if (tampil) jumlahTampil++;
        });

        info.textContent = jumlahTampil
            ? 'Menampilkan ' + jumlahTampil + ' jurnal dari data contoh'
            : 'Tidak ada jurnal yang sesuai dengan filter';
    });
});
</script>
@endsection
