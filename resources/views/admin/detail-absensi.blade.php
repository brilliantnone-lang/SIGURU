@extends('layouts.app')

@section('title', 'Detail Absensi - SIGURU')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Detail Absensi Kelas</h1>
            <p style="margin:0; font-size:12px; color:#555;">
                Kelas: <strong>{{ $kelas->nama_kelas }}</strong> | 
                Tanggal: <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong>
            </p>
        </div>
        <a href="{{ url()->previous() }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div style="background:#fff; padding:20px; border-radius:10px; border:1px solid #E1ECE6;">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:#edf6f0;">
                    <th style="padding:10px; text-align:left; color:#52685c; font-size:11px;">No.</th>
                    <th style="padding:10px; text-align:left; color:#52685c; font-size:11px;">NIS</th>
                    <th style="padding:10px; text-align:left; color:#52685c; font-size:11px;">Nama Siswa</th>
                    <th style="padding:10px; text-align:center; color:#52685c; font-size:11px;">Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($murids as $i => $m)
                    <tr>
                        <td style="padding:10px; border-bottom:1px solid #E8EFEB;">{{ $i + 1 }}</td>
                        <td style="padding:10px; border-bottom:1px solid #E8EFEB;">{{ $m->nis }}</td>
                        <td style="padding:10px; border-bottom:1px solid #E8EFEB;">{{ $m->nama_siswa }}</td>
                        <td style="padding:10px; border-bottom:1px solid #E8EFEB; text-align:center;">
                            @php
                                $status = $statusMap[$m->id] ?? '-';
                            @endphp
                            @if($status === 'hadir')
                                <span style="background:#d8f2e2; color:#247448; padding:3px 8px; border-radius:4px; font-weight:600; font-size:11px;">Hadir</span>
                            @elseif($status === 'izin')
                                <span style="background:#fff0c9; color:#946800; padding:3px 8px; border-radius:4px; font-weight:600; font-size:11px;">Izin</span>
                            @elseif($status === 'sakit')
                                <span style="background:#ffe0e1; color:#b83e48; padding:3px 8px; border-radius:4px; font-weight:600; font-size:11px;">Sakit</span>
                            @elseif($status === 'alpa')
                                <span style="background:#edf1ef; color:#475b52; padding:3px 8px; border-radius:4px; font-weight:600; font-size:11px;">Alpa</span>
                            @else
                                <span style="color:#888;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:40px; color:#888;">Belum ada siswa di kelas ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection