@extends('layouts.app')

@section('title', 'Data Pengajaran - Jurnal Mengajar Guru')

@section('content')

    <div class="pengajaran-heading-row">
        <div>
            <h1>Data Pengajaran</h1>
            <p class="subtitle">Hubungkan Guru, Kelas, dan Mata Pelajaran</p>
        </div>
        <a href="{{ route('admin.pengajaran.create') }}" class="add-pengajaran-button" style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Tambah Data
        </a>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">
            {{ session('error') }}
        </div>
    @endif

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
                            <td>
                                Jam ke-{{ $j->jam_mulai_ke }}@if($j->jam_selesai_ke != $j->jam_mulai_ke) s/d
                                {{ $j->jam_selesai_ke }}@endif
                            </td>
                            <td>
                                <div class="pengajaran-actions">
                                    <a href="{{ route('admin.pengajaran.edit', $j->id) }}" class="table-action edit" title="Edit data">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('admin.pengajaran.destroy', $j->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');" style="display:inline; margin:0; padding:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action delete" title="Hapus data">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px; color:#888;">Belum ada data pengajaran. Silakan tambah baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pengajaran-table-footer">
            <span>Menampilkan {{ count($jadwal ?? []) }} data pengajaran</span>
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
            font-size: 15px;
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