@extends('layouts.app')

@section('title', 'Detail & Validasi Jurnal')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Validasi Jurnal Mengajar</h1>
            <p style="margin:0; font-size:12px; color:#555;">Periksa isi jurnal dan berikan validasi.</p>
        </div>
        <a href="{{ route('kepsek.validasi-jurnal.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    {{-- BAGIAN 1: FORM VALIDASI (ATAS) --}}
    <div style="background:#f0fdf4; padding:24px; border-radius:12px; border:1px solid #bbf7d0; margin-bottom:25px;">
        <h3 style="margin:0 0 15px; font-size:18px; color:#166534;">
            <i class="bi bi-check2-square"></i> Form Validasi
        </h3>

        <form action="{{ route('kepsek.validasi-jurnal.update', $jurnal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns: 1fr 2fr; gap:20px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px; color:#14532d;">Status Validasi *</label>
                    <select name="status_validasi" required style="width:100%; padding:10px; border:1px solid #bbf7d0; border-radius:5px; background:#fff;">
                        <option value="valid" {{ $jurnal->status_validasi == 'valid' ? 'selected' : '' }}>Tervalidasi (Setujui)</option>
                        <option value="menunggu_revisi" {{ $jurnal->status_validasi == 'menunggu_revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px; color:#14532d;">Catatan Revisi (Opsional)</label>
                    <input type="text" name="catatan_validasi" value="{{ $jurnal->catatan_validasi }}" placeholder="Tulis catatan perbaikan untuk guru..." style="width:100%; padding:10px; border:1px solid #bbf7d0; border-radius:5px; background:#fff;">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" style="padding:10px 24px; border-radius:6px; background:#166534; color:#fff; border:none; font-weight:600; cursor:pointer;">
                    Simpan Validasi
                </button>
            </div>
        </form>
    </div>

    {{-- BAGIAN 2: DETAIL JURNAL (BAWAH) --}}
    <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6; box-shadow:0 2px 4px rgba(0,0,0,0.02);">
        <h3 style="margin:0 0 20px; font-size:18px; color:#111; border-bottom:1px solid #E1ECE6; padding-bottom:12px;">
            <i class="bi bi-journal-text"></i> Detail Isi Jurnal
        </h3>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px 40px;">
            <div>
                <table style="width:100%; font-size:13px;">
                    <tr>
                        <td style="width:130px; padding:8px 0; color:#555;">Tanggal</td>
                        <td style="padding:8px 0;">: <strong>{{ $jurnal->tanggal->translatedFormat('d F Y') }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;">Guru Pengampu</td>
                        <td style="padding:8px 0;">: <strong>{{ $jurnal->guru->user->name ?? '-' }}</strong></td>
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
                </table>
            </div>
            
            <div>
                <table style="width:100%; font-size:13px;">
                    <tr>
                        <td style="width:130px; padding:8px 0; color:#555;">Jam Mengajar</td>
                        <td style="padding:8px 0;">: Jam ke-{{ $jurnal->jam_mulai_ke }} s/d {{ $jurnal->jam_selesai_ke }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;">Status Penyelesaian</td>
                        <td style="padding:8px 0;">: 
                            @if($jurnal->status_penyelesaian == 'selesai')
                                <span style="color:#166534; font-weight:600;">Selesai</span>
                            @else
                                <span style="color:#991b1b; font-weight:600;">Belum Selesai</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;">Alasan Belum Selesai</td>
                        <td style="padding:8px 0;">: {{ $jurnal->alasan_belum_selesai ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;">Keterangan Tambahan</td>
                        <td style="padding:8px 0;">: {{ $jurnal->keterangan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin-top:15px; padding-top:15px; border-top:1px dashed #E1ECE6;">
            <p style="margin:0 0 5px; font-size:13px; color:#555;">Pokok Bahasan:</p>
            <p style="margin:0; font-size:14px; font-weight:600; color:#111; background:#f8faf9; padding:12px; border-radius:6px; border:1px solid #E1ECE6;">
                {{ $jurnal->pokok_bahasan }}
            </p>
        </div>

        {{-- Foto Kegiatan --}}
        @if($jurnal->foto_kegiatan)
            <div style="margin-top:20px;">
                <p style="margin:0 0 8px; font-size:13px; color:#555;">Foto Kegiatan:</p>
                <img src="{{ asset('storage/' . $jurnal->foto_kegiatan) }}" alt="Foto Kegiatan" style="max-height:250px; border-radius:8px; border:1px solid #ddd; object-fit:cover;">
            </div>
        @endif
    </div>
@endsection