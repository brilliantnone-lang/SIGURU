@extends('layouts.app')

@section('title', 'Detail Jurnal')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Detail Jurnal Mengajar</h1>
            <p style="margin:0; font-size:12px; color:#555;">Informasi lengkap jurnal yang diisi oleh guru.</p>
        </div>
        <a href="{{ url()->previous() }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6; box-shadow:0 2px 4px rgba(0,0,0,0.02);">
        <table style="width:100%; font-size:14px;">
            <tr>
                <td style="width:150px; padding:8px 0; color:#555;">Tanggal</td>
                <td style="padding:8px 0;">: <strong>{{ $jurnal->tanggal->translatedFormat('d F Y') }}</strong></td>
            </tr>
            <tr>
                <td style="padding:8px 0; color:#555;">Guru Pengampu</td>
                <td style="padding:8px 0;">: {{ $jurnal->guru->user->name ?? '-' }}</td>
            </tr>
            @if($jurnal->guruPendamping)
            <tr>
                <td style="padding:8px 0; color:#555;">Guru Pendamping</td>
                <td style="padding:8px 0;">: {{ $jurnal->guruPendamping->user->name ?? '-' }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding:8px 0; color:#555;">Mata Pelajaran</td>
                <td style="padding:8px 0;">: {{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0; color:#555;">Kelas</td>
                <td style="padding:8px 0;">: {{ $jurnal->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0; color:#555;">Jam Pelajaran</td>
                <td style="padding:8px 0;">: Jam ke-{{ $jurnal->jam_mulai_ke }} s/d {{ $jurnal->jam_selesai_ke }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0; color:#555;">Pokok Bahasan</td>
                <td style="padding:8px 0;">: <strong>{{ $jurnal->pokok_bahasan }}</strong></td>
            </tr>
            <tr>
                <td style="padding:8px 0; color:#555;">Status Penyelesaian</td>
                <td style="padding:8px 0;">: {{ ucfirst($jurnal->status_penyelesaian) }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0; color:#555;">Keterangan</td>
                <td style="padding:8px 0;">: {{ $jurnal->keterangan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0; color:#555;">Status Validasi</td>
                <td style="padding:8px 0;">: 
                    @if($jurnal->status_validasi === 'valid')
                        <span style="color:#166534; font-weight:600;">Tervalidasi</span>
                    @elseif($jurnal->status_validasi === 'menunggu_revisi')
                        <span style="color:#be123c; font-weight:600;">Perlu Revisi</span>
                    @elseif($jurnal->status_validasi === 'sudah_revisi')
                        <span style="color:#2563eb; font-weight:600;">Sudah Direvisi</span>
                    @else
                        <span style="color:#a86600; font-weight:600;">Sedang Berjalan</span>
                    @endif
                </td>
            </tr>
            @if($jurnal->catatan_validasi)
            <tr>
                <td style="padding:8px 0; color:#555;">Catatan Validasi</td>
                <td style="padding:8px 0;">: <em>{{ $jurnal->catatan_validasi }}</em></td>
            </tr>
            @endif
        </table>

        {{-- Foto Kegiatan --}}
        @if($jurnal->foto_kegiatan)
            <div style="margin-top:20px;">
                <p style="margin:0 0 5px; font-size:13px; color:#555;">Foto Kegiatan:</p>
                <img src="{{ asset('storage/' . $jurnal->foto_kegiatan) }}" alt="Foto Kegiatan" style="max-height:200px; border-radius:8px; border:1px solid #ddd;">
            </div>
        @endif

        {{-- TTD KEPSEK (MUNCUL JIKA SUDAH VALID) --}}
        @if($jurnal->status_validasi === 'valid')
            @php
                $kepsek = \App\Models\User::where('role', 'kepsek')->first();
            @endphp
            @if($kepsek && $kepsek->ttd_kepsek)
                <div style="margin-top:30px; text-align:right; border-top:1px dashed #ccc; padding-top:20px;">
                    <p style="margin:0 0 5px; font-size:12px; color:#555;">Disahkan oleh,</p>
                    <img src="{{ asset('storage/' . $kepsek->ttd_kepsek) }}" alt="TTD" style="max-height:80px;">
                    <p style="margin:0; font-size:13px; font-weight:600; color:#111;">{{ $kepsek->name }}</p>
                </div>
            @endif
        @endif
    </div>
@endsection