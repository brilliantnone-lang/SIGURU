@extends('layouts.app')

@section('title', 'Validasi Jurnal Per Semester')

@section('content')
<style>
    .validasi-page { width: 100%; min-width: 0; color: #26332f; font-family: inherit; }
    .validasi-heading { margin-bottom: 25px; }
    .validasi-heading h3 { margin: 0; color: #17211f; font-size: 24px; font-weight: 700; }
    .validasi-heading p { margin: 3px 0 0; color: #52665e; font-size: 12px; }
    .validasi-table-panel { min-width: 0; padding: 12px; background: #fff; border: 1px solid #e2eae5; border-radius: 8px; }
    .validasi-table-heading { display: flex; align-items: center; gap: 7px; margin-bottom: 10px; color: #28684c; }
    .validasi-table-heading h4 { margin: 0; color: #294238; font-size: 12px; font-weight: 700; }
    .validasi-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 11px; }
    .validasi-table thead { background: #eaf6ef; }
    .validasi-table th { padding: 10px 8px; color: #28684c; font-size: 11px; font-weight: 700; white-space: nowrap; }
    .validasi-table td { padding: 10px 8px; color: #35423d; border-bottom: 1px solid #edf1ee; vertical-align: middle; }
    .validasi-table tbody tr:nth-child(even) { background: #fbfcfb; }
    .validasi-action { min-width: 80px; padding: 6px 12px; color: #fff; background: #176b48; border: none; border-radius: 4px; font-size: 11px; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; }
    .validasi-action:hover { background: #12583b; color: #fff; }
</style>

<div class="validasi-page">
    <div class="validasi-heading">
        <h3>Validasi Jurnal</h3>
        <p>Pilih semester untuk melihat dan memvalidasi seluruh jurnal</p>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">{{ session('error') }}</div>
    @endif

    <section class="validasi-table-panel">
        <div class="validasi-table-heading">
            <i class="bi bi-journal-bookmark"></i>
            <h4>Daftar Semester</h4>
        </div>

        <div style="overflow-x:auto;">
            <table class="validasi-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($covers as $index => $cover)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $cover->tahun_ajaran }}</strong></td>
                            <td>{{ $cover->semester }}</td>
                            <td>
                                @if($cover->status_berjalan)
                                    <span style="background:#fff0c9; color:#a86600; padding:4px 8px; border-radius:4px; font-weight:600; font-size:10px;">Sedang Berjalan</span>
                                @else
                                    <span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:4px; font-weight:600; font-size:10px;">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('kepsek.validasi-jurnal.show', $cover->id) }}" class="validasi-action">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:#888;">Belum ada Cover Jurnal yang dibuat oleh Admin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection