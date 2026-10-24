@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('sidebar')

    <a href="{{ route('guru.dashboard') }}">

        <i class="bi bi-speedometer2"></i> Dashboard

    </a>

@endsection

@section('content')

<div class="presensi-page">

    {{-- Header --}}

    <div class="presensi-header">

        <h2>Absensi Siswa</h2>

        <p>Catat dan pantau kehadiran siswa pada setiap sesi pembelajaran.</p>

        <div class="presensi-date">

            <i class="bi bi-calendar2-week-fill"></i>

            <span>Kamis, 01 Oktober 2026</span>

        </div>

    </div>

    {{-- Daftar Siswa --}}

    <section class="presensi-card">

        <div class="presensi-card-header">

            <i class="bi bi-people-fill"></i>

            <div>

                <h3>Daftar Siswa Kelas VII A</h3>

                <p>10 siswa · Jam Ke-1 · 2 Oktober 2026</p>

            </div>

        </div>

        {{-- Ringkasan Kehadiran --}}

        <div class="presensi-summary">

            <div class="summary-item summary-hadir">

                <span>Hadir</span>

                <strong id="count-hadir">30</strong>

            </div>

            <div class="summary-item summary-sakit">

                <span>Sakit</span>

                <strong id="count-sakit">0</strong>

            </div>

            <div class="summary-item summary-izin">

                <span>Izin</span>

                <strong id="count-izin">0</strong>

            </div>

            <div class="summary-item summary-alpa">

                <span>Alpa</span>

                <strong id="count-alpa">0</strong>

            </div>

        </div>

        {{-- Tabel Presensi --}}

        <div class="table-responsive">

            <table class="presensi-table">

                <thead>

                    <tr>

                        <th>No.</th>

                        <th>Nama Siswa</th>

                        <th>Status Kehadiran</th>

                    </tr>

                </thead>

                <tbody>

                    @php

                        $siswa = [

                            ['nama' => 'Ahmad Rizky Pratama', 'status' => 'hadir'],

                            ['nama' => 'Anna Hyusa', 'status' => 'hadir'],

                            ['nama' => 'None Azlias', 'status' => 'hadir'],

                            ['nama' => 'Aliya Garbisan', 'status' => 'hadir'],

                            ['nama' => 'Olie Chritiani', 'status' => 'hadir'],

                        ];

                    @endphp

                    @foreach ($siswa as $index => $item)

                        <tr>

                            <td>{{ sprintf('%02d', $index + 1) }}</td>

                            <td class="student-name">{{ $item['nama'] }}</td>

                            <td>

                                <div class="attendance-options">

                                    @foreach ([

                                        'hadir' => 'Hadir',

                                        'sakit' => 'Sakit',

                                        'izin' => 'Izin',

                                        'alpa' => 'Alpa',

                                    ] as $value => $label)

                                        <button

                                            type="button"

                                            class="attendance-btn {{ $item['status'] === $value ? 'selected selected-' . $value : '' }}"

                                            data-status="{{ $value }}"

                                            aria-pressed="{{ $item['status'] === $value ? 'true' : 'false' }}"

                                        >

                                            {{ $label }}

                                        </button>

                                    @endforeach

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </section>

    {{-- Pagination --}}

    <div class="presensi-pagination">

        <span>Menampilkan 1-5 dari 30 siswa</span>

        <div class="pagination-list">

            <button type="button" disabled aria-label="Halaman sebelumnya">

                <i class="bi bi-chevron-left"></i>

            </button>

            <button type="button" class="page-active">1</button>

            <button type="button">2</button>

            <button type="button">3</button>

            <button type="button">4</button>

            <button type="button">5</button>

            <span>...</span>

        </div>

    </div>

    {{-- Tombol Simpan --}}

    <div class="presensi-footer">

        <button type="button" class="btn-simpan-presensi" id="btn-simpan-presensi">

            Simpan Absen

        </button>

    </div>

</div>

<style>

    .presensi-page {

        width: 100%;

        color: #222;

        font-family: inherit;

    }

    .presensi-header {

        margin-bottom: 13px;

    }

    .presensi-header h2 {

        margin: 0 0 6px;

        font-size: 26px;

        font-weight: 650;

        color: #111;

    }

    .presensi-header p {

        margin: 0 0 10px;

        font-size: 12px;

        color: #888;

    }

    .presensi-date {

        display: inline-flex;

        align-items: center;

        gap: 7px;

        padding: 8px 10px;

        border: 1px solid #a2d8bf;

        border-radius: 9px;

        color: #888;

        font-size: 11px;

    }

    .presensi-date i {

        font-size: 16px;

    }

    .presensi-card {

        background: #fff;

        border: 1px solid #b9d0c5;

        border-radius: 8px;

        overflow: hidden;

        box-shadow: 0 2px 3px rgba(0, 0, 0, .15);

    }

    .presensi-card-header {

        display: flex;

        align-items: center;

        gap: 9px;

        padding: 10px 12px 7px;

    }

    .presensi-card-header > i {

        color: #39765f;

        font-size: 24px;

    }

    .presensi-card-header h3 {

        margin: 0 0 3px;

        font-size: 18px;

        font-weight: 650;

        color: #111;

    }

    .presensi-card-header p {

        margin: 0;

        font-size: 12px;

        color: #999;

    }

    .presensi-summary {

        display: flex;

        gap: 18px;

        padding: 2px 7px 6px;

    }

    .summary-item {

        display: flex;

        justify-content: center;

        align-items: center;

        gap: 4px;

        min-width: 76px;

        padding: 4px 8px;

        border: 1px solid #d0d0d0;

        border-radius: 6px;

        background: #fff;

        font-size: 11px;

    }

    .summary-item strong {

        font-weight: 600;

    }

    .summary-hadir {

        color: #39765f;

    }

    .summary-sakit {

        color: #304fbb;

    }

    .summary-izin {

        color: #b78300;

    }

    .summary-alpa {

        color: #777;

    }

    .table-responsive {

        width: 100%;

        overflow-x: auto;

    }

    .presensi-table {

        width: 100%;

        border-collapse: collapse;

    }

    .presensi-table thead {

        background: #e1eee8;

    }

    .presensi-table th {

        padding: 6px 9px;

        text-align: left;

        text-transform: uppercase;

        font-size: 11px;

        font-weight: 650;

        color: #54816c;

        white-space: nowrap;

    }

    .presensi-table th:nth-child(1) {

        width: 12%;

    }

    .presensi-table th:nth-child(2) {

        width: 26%;

    }

    .presensi-table th:nth-child(3) {

        text-align: center;

    }

    .presensi-table td {

        padding: 7px 9px;

        border-bottom: 1px solid #e5e5e5;

        font-size: 11px;

        vertical-align: middle;

    }

    .presensi-table tbody tr:last-child td {

        border-bottom: none;

    }

    .student-name {

        font-weight: 500;

        color: #222;

        white-space: nowrap;

    }

    .attendance-options {

        display: grid;

        grid-template-columns: repeat(4, minmax(55px, 1fr));

        gap: 7px;

    }

    .attendance-btn {

        min-height: 22px;

        padding: 4px 5px;

        border: 1px solid #ccc;

        border-radius: 6px;

        background: #fff;

        color: #111;

        font-family: inherit;

        font-size: 10px;

        cursor: pointer;

        transition: background .15s, border-color .15s;

    }

    .attendance-btn:hover {

        background: #f2f7f4;

    }

    .attendance-btn.selected-hadir {

        background: #dcece5;

        border-color: #9acbb5;

        color: #39765f;

    }

    .attendance-btn.selected-sakit {

        background: #e5eaff;

        border-color: #a9b8ef;

        color: #304fbb;

    }

    .attendance-btn.selected-izin {

        background: #fff3d3;

        border-color: #e5cb79;

        color: #967000;

    }

    .attendance-btn.selected-alpa {

        background: #eeeeee;

        border-color: #bdbdbd;

        color: #555;

    }

    .presensi-pagination {

        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 10px;

        margin-top: 9px;

        font-size: 10px;

        color: #52675d;

    }

    .pagination-list {

        display: flex;

        align-items: center;

        gap: 3px;

    }

    .pagination-list button {

        min-width: 15px;

        height: 15px;

        padding: 0 3px;

        border: 1px solid #d5d5d5;

        border-radius: 4px;

        background: #fff;

        color: #555;

        font-size: 10px;

        cursor: pointer;

    }

    .pagination-list button:disabled {

        color: #aaa;

        cursor: default;

    }

    .pagination-list .page-active {

        background: #b7edbd;

        border-color: #91d99a;

        color: #28643b;

    }

    .pagination-list span {

        margin-left: 3px;

    }

    .presensi-footer {

        display: flex;

        justify-content: flex-end;

        margin-top: 15px;

    }

    .btn-simpan-presensi {

        padding: 9px 13px;

        border: none;

        border-radius: 6px;

        background: #39765f;

        color: #fff;

        font-family: inherit;

        font-size: 13px;

        font-weight: 550;

        cursor: pointer;

    }

    .btn-simpan-presensi:hover {

        background: #2e624e;

    }

    @media (max-width: 700px) {

        .presensi-header h2 {

            font-size: 22px;

        }

        .presensi-summary {

            gap: 6px;

            flex-wrap: wrap;

        }

        .summary-item {

            min-width: 65px;

        }

        .presensi-table {

            min-width: 570px;

        }

        .presensi-pagination {

            flex-wrap: wrap;

        }

    }

</style>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const rows = document.querySelectorAll('.presensi-table tbody tr');

        const statusNames = ['hadir', 'sakit', 'izin', 'alpa'];

        function updateSummary() {

            const counts = {

                hadir: 0,

                sakit: 0,

                izin: 0,

                alpa: 0

            };

            rows.forEach(function (row) {

                const selected = row.querySelector('.attendance-btn.selected');

                if (selected) {

                    counts[selected.dataset.status]++;

                }

            });

            statusNames.forEach(function (status) {

                const element = document.getElementById('count-' + status);

                if (element) {

                    element.textContent = counts[status];

                }

            });

        }

        document.querySelectorAll('.attendance-btn').forEach(function (button) {

            button.addEventListener('click', function () {

                const row = button.closest('tr');

                row.querySelectorAll('.attendance-btn').forEach(function (item) {

                    item.classList.remove(

                        'selected',

                        'selected-hadir',

                        'selected-sakit',

                        'selected-izin',

                        'selected-alpa'

                    );

                    item.setAttribute('aria-pressed', 'false');

                });

                button.classList.add('selected', 'selected-' + button.dataset.status);

                button.setAttribute('aria-pressed', 'true');

                updateSummary();

            });

        });

        updateSummary();

        document.getElementById('btn-simpan-presensi').addEventListener('click', function () {

            alert('Pilihan presensi masih berupa simulasi frontend dan belum disimpan ke database.');

        });

    });

</script>

@endsection
