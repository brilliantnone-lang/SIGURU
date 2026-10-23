@extends('layouts.app')

@section('title', 'Data Pengajaran - Jurnal Mengajar Guru')

@section('content')

    <div class="pengajaran-heading-row">
        <div>
            <h1>Data Pengajaran</h1>
            <p class="subtitle">Hubungkan Guru, Kelas, dan Mata Pelajaran</p>
        </div>
        <button class="add-pengajaran-button" type="button">
            <span aria-hidden="true">＋</span> Tambah Data
        </button>
    </div>

    <div class="pengajaran-table-card">
        <div class="pengajaran-table-wrap">
            <table class="pengajaran-table">
                <thead>
                    <tr>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>Jam Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal ?? [] as $j)
                        <tr>
                            <td>{{ $j->guru->user->name ?? '-' }}</td>
                            <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $j->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
                            <td>{{ ucfirst($j->hari) }}</td>
                            <td>Jam ke-{{ $j->jam_mulai_ke }}@if($j->jam_selesai_ke != $j->jam_mulai_ke) s/d
                            {{ $j->jam_selesai_ke }}@endif
                            </td>
                            <td>
                                <div class="pengajaran-actions">
                                    <button class="table-action edit" type="button" aria-label="Edit data">✎</button>

                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Data dummy --}}
                        <tr>
                            <td>Siti Rahmawati, S.Pd.</td>
                            <td>VII A</td>
                            <td>Bahasa Indonesia</td>
                            <td>Senin</td>
                            <td>Jam ke-1</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Ahmad Fauzi, S.Pd.</td>
                            <td>VII B</td>
                            <td>Matematika</td>
                            <td>Senin</td>
                            <td>Jam ke-2</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nurul Hidayah, S.Pd.</td>
                            <td>VII C</td>
                            <td>IPA</td>
                            <td>Selasa</td>
                            <td>Jam ke-3</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Budi Santoso, S.Pd.</td>
                            <td>VIII A</td>
                            <td>Bahasa Inggris</td>
                            <td>Selasa</td>
                            <td>Jam ke-4</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Dewi Anggraini, S.Pd.</td>
                            <td>VIII B</td>
                            <td>IPS</td>
                            <td>Rabu</td>
                            <td>Jam ke-5</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Muhammad Rizky, S.Pd.</td>
                            <td>VIII C</td>
                            <td>PJOK</td>
                            <td>Rabu</td>
                            <td>Jam ke-6</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Rina Wulandari, S.Pd.</td>
                            <td>VIII D</td>
                            <td>Seni Budaya</td>
                            <td>Kamis</td>
                            <td>Jam ke-7</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Fajar Maulana, S.Pd.</td>
                            <td>IX A</td>
                            <td>PKn</td>
                            <td>Kamis</td>
                            <td>Jam ke-8</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Lilis Kartika, S.Pd.</td>
                            <td>IX B</td>
                            <td>Prakarya</td>
                            <td>Jumat</td>
                            <td>Jam ke-1</td>
                            <td>
                                <div class="pengajaran-actions"><button class="table-action edit" type="button">✎</button>
                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Andi Pratama, S.Pd.</td>
                            <td>IX C</td>
                            <td>TIK</td>
                            <td>Jumat</td>
                            <td>Jam ke-2</td>
                            <td>
                                <div class="pengajaran-actions">
                                    <button class="table-action edit" type="button" aria-label="Edit guru" title="Edit guru">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <button class="table-action delete" type="button" aria-label="Hapus guru"
                                        title="Hapus guru">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>

                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pengajaran-table-footer">
            <span>Menampilkan 1-10 dari 48 data pengajaran</span>
            <div class="pagination" aria-label="Pagination">
                <button class="page-button" type="button">‹</button>
                <button class="page-button active" type="button">1</button>
                <button class="page-button" type="button">2</button>
                <button class="page-button" type="button">3</button>
                <button class="page-button" type="button">4</button>
                <button class="page-button" type="button">5</button>
                <span>…</span>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* ====== CSS khusus halaman Data Pengajaran ====== */
        .pengajaran-heading-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .pengajaran-heading-row h1 {
            margin: 0 0 4px;
            font-size: 26px;
        }

        .pengajaran-heading-row .subtitle {
            margin: 0;
            font-size: 14px;
        }

        .add-pengajaran-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 34px;
            padding: 0 13px;
            border: 0;
            border-radius: 6px;
            background: #0A4C2E;
            color: #FFFFFF;
            font: inherit;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
        }

        .pengajaran-table-card {
            width: 100%;
            padding: 10px 12px 16px;
            border: 1px solid #E1ECE6;
            border-radius: 8px;
            background: #FFFFFF;
        }

        .pengajaran-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .pengajaran-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            color: #173D2B;
            font-size: 10px;
            white-space: normal;
        }

        .pengajaran-table thead {
            background: #E8F6F0;
        }

        .pengajaran-table th {
            padding: 10px 8px;
            color: #0A4C2E;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
        }

        .pengajaran-table th:last-child {
            text-align: center;
        }

        .pengajaran-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #E8EFEB;
            vertical-align: middle;
            overflow-wrap: anywhere;
        }

        .pengajaran-table tbody tr:nth-child(even) {
            background: #FAFCFB;
        }

        /* Lebar kolom */
        .pengajaran-table th:nth-child(1),
        .pengajaran-table td:nth-child(1) {
            width: 20%;
        }

        .pengajaran-table th:nth-child(2),
        .pengajaran-table td:nth-child(2) {
            width: 12%;
        }

        .pengajaran-table th:nth-child(3),
        .pengajaran-table td:nth-child(3) {
            width: 17%;
        }

        .pengajaran-table th:nth-child(4),
        .pengajaran-table td:nth-child(4) {
            width: 10%;
        }

        .pengajaran-table th:nth-child(5),
        .pengajaran-table td:nth-child(5) {
            width: 18%;
        }

        .pengajaran-table th:nth-child(6),
        .pengajaran-table td:nth-child(6) {
            width: 10%;
            text-align: center;
        }

        .pengajaran-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .table-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 31px;
            height: 31px;
            padding: 0;
            border: 1px solid;
            border-radius: 7px;
            background: #fff;
            font-size: 17px;
            line-height: 1;
            cursor: pointer;
            transition: background .15s ease;
        }

        .table-action.edit {
            border-color: #aebfb5;
            color: #39765f;
        }

        .table-action.delete {
            border-color: #ff7777;
            color: #ff3333;
        }

        .table-action:hover {
            background: #f4f8f5;
        }

        .pengajaran-table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 16px;
            color: #40574F;
            font-size: 10px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-button {
            min-width: 24px;
            height: 24px;
            padding: 0 7px;
            border: 1px solid #D8E2DC;
            border-radius: 5px;
            background: #FFFFFF;
            color: #173D2B;
            font: inherit;
            font-size: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
            cursor: pointer;
        }

        .page-button.active {
            background: #B9F4B2;
            border-color: #70C86B;
            color: #173D2B;
        }

        @media (max-width: 700px) {
            .pengajaran-heading-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .pengajaran-table-card {
                padding: 8px;
            }

            .pengajaran-table {
                min-width: 650px;
            }

            .pengajaran-table-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush