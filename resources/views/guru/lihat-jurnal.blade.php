@extends('layouts.app')

@section('title', 'Detail Jurnal Harian')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<style>
    /* 100% COPY DARI TAMBAH-JURNAL */
    .jurnal-page { width: 100%; color: #17221c; font-family: inherit; }
    .jurnal-page *, .jurnal-page *::before, .jurnal-page *::after { box-sizing: border-box; }
    .jurnal-header { margin: 0 0 23px 5px; }
    .jurnal-header h2 { margin: 0 0 6px; color: #173d2b; font-size: 26px; font-weight: 700; }
    .jurnal-header p { margin: 0; color: #7d8580; font-size: 12px; }
    .jurnal-card { width: 100%; padding: 22px 24px; background: #fff; border: 1px solid #c7d9cf; border-radius: 10px; box-shadow: 0 2px 4px rgba(25, 55, 39, .12); }
    .jurnal-heading { display: flex; align-items: center; gap: 12px; margin-bottom: 23px; }
    .jurnal-heading i { color: #39745b; font-size: 34px; }
    .jurnal-heading h3 { margin: 0 0 5px; font-size: 21px; font-weight: 700; }
    .jurnal-heading p { margin: 0; color: #858b87; font-size: 12px; }
    .jurnal-panel { margin-bottom: 20px; padding: 12px; background: #eff9f4; border: 2px solid #d0e5d9; border-radius: 13px; }
    .jurnal-panel-title { margin: 0 0 5px; font-size: 17px; line-height: 1.4; font-weight: 700; }
    .jurnal-panel-description { margin: 0 0 12px; color: #89928c; font-size: 10px; }
    .role-options { display: flex; flex-wrap: wrap; gap: 8px; }
    .role-option { display: inline-flex; align-items: center; gap: 8px; min-height: 38px; padding: 7px 12px; color: #858d87; background: #fff; border: 1px solid #d6dfd9; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: not-allowed; }
    .role-option input { width: 15px; height: 15px; margin: 0; accent-color: #39745b; flex-shrink: 0; }
    .role-option:has(input:checked) { color: #39745b; background: #d8f6e8; border-color: #75c4a0; }
    .replacement-fields { display: none; margin-top: 14px; }
    .replacement-fields.active { display: block; }
    .replacement-label { display: block; margin: 0 0 6px; font-size: 17px; font-weight: 700; }
    .required { color: #ed3434; }
    .jurnal-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 13px 28px; }
    .jurnal-field { min-width: 0; }
    .jurnal-field.full { grid-column: 1 / -1; }
    .jurnal-field > label, .jurnal-field > .field-label { display: block; margin-bottom: 6px; font-size: 15px; font-weight: 700; }
    .jurnal-control { display: block; width: 100%; min-width: 0; height: 39px; padding: 8px 11px; color: #303832; background: #f5f5f5; border: 1px solid #b8c0ba; border-radius: 10px; outline: none; font-family: inherit; font-size: 13px; cursor: not-allowed; }
    textarea.jurnal-control { min-height: 58px; height: auto; resize: none; }
    .attendance-panel { margin-bottom: 20px; }
    .attendance-methods { display: flex; flex-direction: column; gap: 12px; margin: 8px 0 14px; }
    .attendance-method { display: flex; align-items: center; gap: 9px; margin: 0; color: #222a24; font-size: 14px; font-weight: 400; cursor: not-allowed; }
    .attendance-method:has(input:not(:checked)) { color: #c1c7c3; }
    .attendance-details { display: none; }
    .attendance-details.active { display: block; }
    .manual-attendance-row { display: grid; grid-template-columns: 70px 46px minmax(0, 1fr); align-items: center; gap: 12px; margin-bottom: 9px; }
    .manual-attendance-label { font-size: 14px; font-weight: 700; text-align: right; }
    .manual-count { width: 46px; height: 35px; padding: 5px; text-align: center; background: #f5f5f5; border: 1px solid #b8c0ba; border-radius: 10px; font-size: 13px; cursor: not-allowed; }
    .manual-name-select { width: 100%; min-width: 0; height: 35px; padding: 5px 10px; background: #f5f5f5; border: 1px solid #b8c0ba; border-radius: 10px; font-family: inherit; font-size: 13px; cursor: not-allowed; }
    .manual-name-list { display: flex; flex-direction: column; gap: 7px; margin-top: 7px; }
    .attendance-table-wrap { width: 100%; overflow-x: auto; }
    .attendance-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .attendance-table th, .attendance-table td { padding: 9px; border-bottom: 1px solid #d9e7de; text-align: left; }
    .attendance-table th { color: #285b43; background: #e1f1e8; }
    .attendance-table select { width: 100%; min-width: 100px; padding: 7px; border: 1px solid #c7d6cc; border-radius: 7px; background: #f5f5f5; cursor: not-allowed; }
    .attendance-message { padding: 10px 4px; color: #78847b; font-size: 12px; }
    .photo-box { display: flex; align-items: center; justify-content: center; min-height: 120px; padding: 10px; background: #eff9f4; border: 2px solid #d0e5d9; border-radius: 13px; }
    .photo-preview { display: block; max-width: 100%; max-height: 250px; margin: 10px auto 0; border-radius: 8px; }
    .jurnal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; }
    .jurnal-btn { display: inline-flex; min-height: 39px; padding: 8px 15px; align-items: center; justify-content: center; border-radius: 7px; font-family: inherit; font-size: 13px; text-decoration: none; cursor: pointer; }
    .btn-cancel { color: #555; background: white; border: 1px solid #aaa; }
    @media (max-width: 760px) { .jurnal-card { padding: 16px; } .jurnal-grid { gap: 13px; } .manual-attendance-row { grid-template-columns: 60px 42px minmax(0, 1fr); gap: 8px; } .manual-count { width: 42px; } }
    @media (max-width: 540px) { .jurnal-header h2 { font-size: 22px; } .jurnal-grid { grid-template-columns: minmax(0, 1fr); } .jurnal-field.full { grid-column: auto; } .manual-attendance-row { grid-template-columns: 58px 40px minmax(0, 1fr); gap: 7px; } .manual-attendance-label { font-size: 12px; } .manual-count, .manual-name-select { font-size: 12px; } }
</style>

<div class="jurnal-page">
    <header class="jurnal-header">
        <h2>Detail Jurnal Harian Guru</h2>
        <p>Informasi kegiatan pembelajaran yang telah dicatat.</p>
    </header>

    <div class="jurnal-card">
        <div class="jurnal-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Detail Jurnal Mengajar</h3>
                <p>Informasi kegiatan pembelajaran yang telah dicatat.</p>
            </div>
        </div>

        {{-- STATUS MENGAJAR --}}
        <section class="jurnal-panel">
            <h4 class="jurnal-panel-title">Status Mengajar</h4>
            <p class="jurnal-panel-description">Peran guru pada sesi pembelajaran ini.</p>
            <div class="role-options">
                <label class="role-option">
                    <input type="radio" disabled {{ $jurnal->guru_pendamping_id ? '' : 'checked' }}>
                    <span>Guru Pengampu</span>
                </label>
                <label class="role-option">
                    <input type="radio" disabled {{ $jurnal->guru_pendamping_id ? 'checked' : '' }}>
                    <span>Guru Pengganti</span>
                </label>
            </div>
            @if($jurnal->guru_pendamping_id)
                <div class="replacement-fields active" style="margin-top:14px;">
                    <label class="replacement-label">Guru Pendamping</label>
                    <input type="text" class="jurnal-control" value="{{ $jurnal->guruPendamping->user->name ?? '-' }}" readonly>
                </div>
            @endif
        </section>

        {{-- DATA JURNAL --}}
        <div class="jurnal-grid">
            <div class="jurnal-field">
                <label>Tanggal Mengajar</label>
                <input type="text" class="jurnal-control" value="{{ $jurnal->tanggal->translatedFormat('d F Y') }}" readonly>
            </div>
            <div class="jurnal-field">
                <label>Kelas</label>
                <input type="text" class="jurnal-control" value="{{ $jurnal->kelas->nama_kelas ?? '-' }}" readonly>
            </div>
            <div class="jurnal-field">
                <label>Mata Pelajaran</label>
                <input type="text" class="jurnal-control" value="{{ $jurnal->jadwal->mataPelajaran->nama_mata_pelajaran ?? '-' }}" readonly>
            </div>
            <div class="jurnal-field">
                <label>Jam Pelajaran</label>
                <input type="text" class="jurnal-control" value="Jam ke-{{ $jurnal->jam_mulai_ke }}-{{ $jurnal->jam_selesai_ke }}" readonly>
            </div>
            <div class="jurnal-field full">
                <label>Pokok Bahasan/Materi</label>
                <textarea class="jurnal-control" readonly>{{ $jurnal->pokok_bahasan }}</textarea>
            </div>
            <div class="jurnal-field">
                <label>Status Penyelesaian</label>
                <input type="text" class="jurnal-control" value="{{ ucfirst($jurnal->status_penyelesaian) }}" readonly>
            </div>
            <div class="jurnal-field">
                <label>Semester Akademik</label>
                <input type="text" class="jurnal-control" value="{{ $jurnal->coverJurnal ? $jurnal->coverJurnal->tahun_ajaran . ' Semester ' . $jurnal->coverJurnal->semester : '-' }}" readonly>
            </div>
            @if($jurnal->alasan_belum_selesai)
            <div class="jurnal-field full">
                <label>Alasan Belum Selesai</label>
                <textarea class="jurnal-control" readonly>{{ $jurnal->alasan_belum_selesai }}</textarea>
            </div>
            @endif

            {{-- ABSENSI SISWA (TAMPILAN SAMA SEPERTI TAMBAH) --}}
            <div class="jurnal-field full">
                <label class="field-label">Absensi Siswa</label>
                <div class="attendance-methods">
                    <label class="attendance-method">
                        <input type="radio" disabled checked>
                        <span>Ambil Data dari Absensi Siswa</span>
                    </label>
                </div>

                <div id="automaticAttendance" class="attendance-details active">
                    <div class="attendance-table-wrap">
                        <table id="attendanceTable" class="attendance-table" style="display:table;">
                            <thead><tr><th>No.</th><th>Nama Siswa</th><th>Status Kehadiran</th></tr></thead>
                            <tbody id="murid-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="jurnal-field full">
                <label>Catatan Tambahan</label>
                <input type="text" class="jurnal-control" value="{{ $jurnal->keterangan ?? '-' }}" readonly>
            </div>

            <div class="jurnal-field full">
                <label>Foto Kegiatan</label>
                <div class="photo-box">
                    @if($jurnal->foto_kegiatan)
                        <img src="{{ asset('storage/' . $jurnal->foto_kegiatan) }}" alt="Foto Kegiatan" class="photo-preview">
                    @else
                        <span style="color:#39745b;">Belum ada foto kegiatan.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="jurnal-actions">
        <a href="{{ route('guru.jurnal-harian') }}" class="jurnal-btn btn-cancel">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Data murid dan absensi dari controller
    const daftarMurid = @json($murids);
    const absensiLama = @json($jurnal->attendances->pluck('status_kehadiran', 'murid_id'));

    const muridList = document.getElementById('murid-list');

    // Render tabel absensi otomatis (hanya tampilan)
    muridList.innerHTML = '';
    daftarMurid.forEach((murid, index) => {
        const status = absensiLama[murid.id] || 'hadir';
        muridList.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${murid.nama_siswa}</td>
                <td>
                    <select disabled>
                        <option value="hadir" ${status === 'hadir' ? 'selected' : ''}>Hadir</option>
                        <option value="sakit" ${status === 'sakit' ? 'selected' : ''}>Sakit</option>
                        <option value="izin" ${status === 'izin' ? 'selected' : ''}>Izin</option>
                        <option value="alpa" ${status === 'alpa' ? 'selected' : ''}>Alpha</option>
                    </select>
                </td>
            </tr>
        `;
    });
});
</script>
@endsection