@extends('layouts.app')

@section('title', 'Validasi Semester')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">
                Validasi Semester: {{ $cover->semester }} {{ $cover->tahun_ajaran }}
            </h1>
            <p style="margin:0; font-size:12px; color:#555;">
                Pilih guru untuk melihat detail jurnal.
                @if(!$isSelesai)
                    <span style="background:#fff0c9; color:#a86600; padding:2px 8px; border-radius:4px; margin-left:10px; font-weight:600; font-size:10px;">Sedang Berjalan</span>
                @else
                    <span style="background:#dcfce7; color:#166534; padding:2px 8px; border-radius:4px; margin-left:10px; font-weight:600; font-size:10px;">Selesai</span>
                @endif
            </p>
        </div>
        <a href="{{ route('kepsek.validasi-jurnal.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    {{-- Statistik --}}
    <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:15px; margin-bottom:25px;">
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #E1ECE6; text-align:center;">
            <div style="font-size:12px; color:#555;">Total Guru</div>
            <div style="font-size:24px; font-weight:700; color:#111;">{{ $gurus->count() }}</div>
        </div>
        <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #E1ECE6; text-align:center;">
            <div style="font-size:12px; color:#555;">Total Jurnal</div>
            <div style="font-size:24px; font-weight:700; color:#111;">{{ $gurus->sum('journal_count') }}</div>
        </div>
    </div>

    {{-- Tabel Daftar Guru --}}
    <div style="background:#fff; padding:20px; border-radius:10px; border:1px solid #E1ECE6;">
        <h3 style="margin:0 0 15px; font-size:16px; color:#111;">Daftar Guru Pengampu</h3>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:#edf6f0;">
                        <th style="padding:12px; text-align:left;">No.</th>
                        <th style="padding:12px; text-align:left;">Nama Guru</th>
                        <th style="padding:12px; text-align:left;">Mata Pelajaran</th>
                        <th style="padding:12px; text-align:center;">Total Jurnal</th>
                        <th style="padding:12px; text-align:center;">Status</th>
                        <th style="padding:12px; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $i => $g)
                        <tr>
                            <td style="padding:12px; border-bottom:1px solid #eee;">{{ $i+1 }}</td>
                            <td style="padding:12px; border-bottom:1px solid #eee;"><strong>{{ $g->user->name ?? '-' }}</strong></td>
                            <td style="padding:12px; border-bottom:1px solid #eee;">{{ $g->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
                            <td style="padding:12px; border-bottom:1px solid #eee; text-align:center;">
                                <span style="background:#e1ece6; padding:4px 8px; border-radius:4px; font-weight:600;">{{ $g->journal_count }} Jurnal</span>
                            </td>
                            <td style="padding:12px; border-bottom:1px solid #eee; text-align:center;">
                                {{-- LOGIKA BARU: Jika semester berjalan, tampilkan strip --}}
                                @if(!$isSelesai)
                                    <span style="color:#aaa;">-</span>
                                @else
                                    @if($g->status_keseluruhan === 'valid')
                                        <span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:4px; font-weight:600; font-size:11px;">Tervalidasi</span>
                                    @elseif($g->status_keseluruhan === 'menunggu_revisi')
                                        <span style="background:#ffe4e6; color:#be123c; padding:4px 8px; border-radius:4px; font-weight:600; font-size:11px;">Perlu Revisi</span>
                                    @else
                                        <span style="background:#fff0c9; color:#a86600; padding:4px 8px; border-radius:4px; font-weight:600; font-size:11px;">Belum Divalidasi</span>
                                    @endif
                                @endif
                            </td>
                            <td style="padding:12px; border-bottom:1px solid #eee; text-align:center;">
                                <a href="{{ route('kepsek.validasi-jurnal.guru', [$cover->id, $g->id]) }}" style="display:inline-block; padding:6px 12px; background:#176b48; color:#fff; text-decoration:none; border-radius:4px; font-size:12px; font-weight:600;">
                                    Lihat Jurnal
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px; color:#888;">Belum ada guru yang mengumpulkan jurnal di semester ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection