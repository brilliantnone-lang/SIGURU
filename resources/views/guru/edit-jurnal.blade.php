@extends('layouts.app')

@section('title', 'Edit Jurnal')

@section('content')
<div class="edit-jurnal-page">
    <div class="page-heading">
        <h2>Edit Jurnal Harian Guru</h2>
        <p>Perbarui catatan kegiatan pembelajaran Anda.</p>
    </div>

    <div class="edit-card">
        <div class="form-card-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Edit Jurnal Mengajar</h3>
                <p>Ubah informasi pembelajaran sesuai kegiatan yang dilaksanakan.</p>
            </div>
        </div>

        @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('guru.jurnal.update', $jurnal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">

                {{-- INFO JADWAL (TIDAK BISA DIUBAH) --}}
                <div class="form-group full-width">
                    <label>Jadwal Mengajar</label>
                    <input type="text" value="{{ $jadwal->kelas->nama_kelas ?? '-' }} - {{ $jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }} (Jam {{ $jadwal->jam_mulai_ke }}-{{ $jadwal->jam_selesai_ke }})" readonly style="background:#f5f5f5;">
                </div>

                {{-- TANGGAL (BISA DIEDIT) --}}
                <div class="form-group">
                    <label>Tanggal Mengajar *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $jurnal->tanggal ? \Carbon\Carbon::parse($jurnal->tanggal)->format('Y-m-d') : date('Y-m-d')) }}" required>
                </div>

                {{-- COVER JURNAL (READONLY) --}}
                <div class="form-group">
                    <label>Cover Jurnal (Semester)</label>
                    <input type="text" value="{{ $coverAktif ? $coverAktif->semester . ' ' . $coverAktif->tahun_ajaran : 'Tidak ada cover aktif' }}" readonly style="background:#f5f5f5;">
                </div>

                {{-- GURU PENDAMPING --}}
                <div class="form-group">
                    <label>Guru Pendamping (Opsional)</label>
                    <select name="guru_pendamping_id">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($gurus as $g)
                        <option value="{{ $g->id }}" {{ $jurnal->guru_pendamping_id == $g->id ? 'selected' : '' }}>{{ $g->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- FOTO KEGIATAN --}}
                <div class="form-group">
                    <label>Foto Kegiatan</label>
                    <input type="file" name="foto_kegiatan" accept="image/*">
                    @if($jurnal->foto_kegiatan)
                    <small style="color:#555;">Foto saat ini: <a href="{{ asset('storage/' . $jurnal->foto_kegiatan) }}" target="_blank">Lihat</a></small>
                    @endif
                </div>

                {{-- POKOK BAHASAN --}}
                <div class="form-group full-width">
                    <label>Pokok Bahasan *</label>
                    <input type="text" name="pokok_bahasan" value="{{ old('pokok_bahasan', $jurnal->pokok_bahasan) }}" required>
                </div>

                {{-- STATUS PENYELESAIAN --}}
                <div class="form-group">
                    <label>Status Penyelesaian *</label>
                    <select name="status_penyelesaian" required>
                        <option value="selesai" {{ $jurnal->status_penyelesaian == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="belum_selesai" {{ $jurnal->status_penyelesaian == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    </select>
                </div>

                {{-- ALASAN BELUM SELESAI --}}
                <div class="form-group">
                    <label>Alasan Belum Selesai</label>
                    <input type="text" name="alasan_belum_selesai" value="{{ old('alasan_belum_selesai', $jurnal->alasan_belum_selesai) }}">
                </div>

                {{-- KETERANGAN --}}
                <div class="form-group full-width">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan', $jurnal->keterangan) }}">
                </div>

                {{-- PRESENSI SISWA --}}
                <div class="form-group full-width" style="margin-top:20px; border-top:1px solid #eee; padding-top:15px;">
                    <h4 style="margin-bottom:10px;">Presensi Siswa</h4>
                    <table style="width:100%; border-collapse:collapse; font-size:12px;">
                        <thead>
                            <tr style="background:#edf6f0;">
                                <th style="padding:8px; text-align:left;">No.</th>
                                <th style="padding:8px; text-align:left;">Nama Siswa</th>
                                <th style="padding:8px; text-align:center;">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($murids as $index => $murid)
                            @php
                            $att = $jurnal->attendances->where('murid_id', $murid->id)->first();
                            $status = $att ? $att->status_kehadiran : 'hadir';
                            @endphp
                            <tr>
                                <td style="padding:8px; border-bottom:1px solid #eee;">{{ $index+1 }}</td>
                                <td style="padding:8px; border-bottom:1px solid #eee;">{{ $murid->nama_siswa }}</td>
                                <td style="padding:8px; border-bottom:1px solid #eee; text-align:center;">
                                    <select name="absensi[{{ $murid->id }}]" style="padding:6px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="sakit" {{ $status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="alpa" {{ $status == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('guru.jurnal-harian') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<style>
    .edit-jurnal-page {
        width: 100%;
        color: #202720;
        font-family: inherit;
        padding-bottom: 15px;
    }

    .page-heading {
        margin-bottom: 14px;
    }

    .page-heading h2 {
        margin: 0 0 6px;
        color: #111;
        font-size: 26px;
        line-height: 1.3;
        font-weight: 700;
    }

    .page-heading p {
        margin: 0;
        color: #858585;
        font-size: 12px;
        line-height: 1.5;
    }

    .edit-card {
        padding: 13px 15px 15px;
        background: #fff;
        border: 1px solid #b9d0c5;
        border-radius: 7px;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .12);
    }

    .form-card-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 12px;
    }

    .form-card-heading>i {
        flex-shrink: 0;
        font-size: 27px;
        color: #39765f;
    }

    .form-card-heading h3 {
        margin: 0 0 3px;
        color: #171717;
        font-size: 16px;
        font-weight: 700;
    }

    .form-card-heading p {
        margin: 0;
        color: #999;
        font-size: 10px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 12px 38px;
        padding: 0 12px;
    }

    .form-group {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 5px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group>label {
        margin: 0;
        color: #111;
        font-size: 13px;
        font-weight: 700;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        min-height: 34px;
        padding: 6px 9px;
        border: 1px solid #bdbdbd;
        border-radius: 8px;
        font-family: inherit;
        font-size: 12px;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #39765f;
        box-shadow: 0 0 0 2px rgba(57, 118, 95, .12);
    }

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
        margin-top: 13px;
    }

    .btn-cancel,
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 34px;
        padding: 7px 12px;
        border-radius: 5px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-cancel {
        border: 1px solid #aaa;
        background: #fff;
        color: #555;
    }

    .btn-save {
        border: 1px solid #39765f;
        background: #39765f;
        color: #fff;
    }

    .btn-save:hover {
        background: #2e624e;
    }

    @media (max-width: 650px) {
        .page-heading h2 {
            font-size: 22px;
        }

        .edit-card {
            padding: 12px 10px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 12px;
            padding: 0 2px;
        }

        .form-group.full-width {
            grid-column: auto;
        }
    }
</style>
@endsection