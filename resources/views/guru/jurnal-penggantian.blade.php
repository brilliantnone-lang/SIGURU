@extends('layouts.app')

@section('title', 'Jurnal Penggantian')

@section('content')
<div class="jurnal-page" style="width:100%; font-family:inherit;">
    <header style="margin-bottom:23px;">
        <h2 style="margin:0 0 6px; color:#173d2b; font-size:26px; font-weight:700;">Jurnal Penggantian</h2>
        <p style="margin:0; color:#7d8580; font-size:12px;">Jurnal guru yang Anda gantikan.</p>
    </header>

    <div style="width:100%; padding:16px; background:#fff; border:1px solid #c7d9cf; border-radius:10px;">
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead style="background:#e1eee8;">
                    <tr>
                        <th style="padding:10px; text-align:left; color:#77847c; font-size:10px; text-transform:uppercase;">Tanggal</th>
                        <th style="padding:10px; text-align:left; color:#77847c; font-size:10px; text-transform:uppercase;">Kelas / Mapel</th>
                        <th style="padding:10px; text-align:left; color:#77847c; font-size:10px; text-transform:uppercase;">Guru Digantikan</th>
                        <th style="padding:10px; text-align:left; color:#77847c; font-size:10px; text-transform:uppercase;">Status</th>
                        <th style="padding:10px; text-align:center; color:#77847c; font-size:10px; text-transform:uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $j)
                    <tr style="border-bottom:1px solid #e8ece9;">
                        <td style="padding:10px;">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}</td>
                        <td style="padding:10px;">
                            <strong>{{ $j->kelas->nama_kelas ?? '-' }}</strong><br>
                            <small style="color:#909991;">{{ $j->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}</small>
                        </td>
                        <td style="padding:10px;">{{ $j->guruDigantikan->user->name ?? '-' }}</td>
                        <td style="padding:10px;">
                            @if($j->status_penggantian === 'menunggu_diisi')
                            <span style="background:#fef3c7; color:#92400e; padding:5px 10px; border-radius:5px; font-size:10px;">⏳ Menunggu</span>
                            @elseif($j->status_penggantian === 'belum_direvisi')
                            <span style="background:#dbeafe; color:#1d4ed8; padding:5px 10px; border-radius:5px; font-size:10px;">🔄 Perlu Direvisi</span>
                            @else
                            <span style="background:#dcfce7; color:#166534; padding:5px 10px; border-radius:5px; font-size:10px;">✅ Selesai</span>
                            @endif
                        </td>
                        <td style="padding:10px; text-align:center;">
                            @if($j->status_penggantian === 'menunggu_diisi')
                            {{-- Tombol Isi --}}
                            <a href="{{ route('guru.edit-jurnal', $j->id) }}"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 12px; background:#39765f; color:#fff; text-decoration:none; border-radius:6px; font-size:11px; font-weight:600;">
                                <i class="bi bi-pencil-fill"></i> Isi
                            </a>
                            @elseif($j->status_penggantian === 'belum_direvisi')
                            {{-- Tombol Revisi --}}
                            <a href="{{ route('guru.edit-jurnal', $j->id) }}"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 12px; background:#2563eb; color:#fff; text-decoration:none; border-radius:6px; font-size:11px; font-weight:600;">
                                <i class="bi bi-arrow-repeat"></i> Revisi
                            </a>
                            @else
                            {{-- Tombol Lihat --}}
                            <a href="{{ route('guru.lihat-jurnal', $j->id) }}"
                                style="display:inline-flex; align-items:center; gap:5px; padding:6px 12px; background:#fff; color:#39765f; text-decoration:none; border:1px solid #39765f; border-radius:6px; font-size:11px; font-weight:600;">
                                <i class="bi bi-eye-fill"></i> Lihat
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:30px; text-align:center; color:#888;">
                            Belum ada jurnal penggantian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection