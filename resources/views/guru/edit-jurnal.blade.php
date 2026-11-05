@extends('layouts.app')

@section('title', 'Edit Jurnal Harian')

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
    .jurnal-panel { margin-bottom: 20px; padding: 12px; background: #eff9f4; border: 2px solid #d0e5d9; border-radius: 13px; box-shadow: 0 1px 3px rgba(39, 88, 62, .10); }
    .jurnal-panel-title { margin: 0 0 5px; font-size: 17px; line-height: 1.4; font-weight: 700; }
    .jurnal-panel-description { margin: 0 0 12px; color: #89928c; font-size: 10px; }
    .role-options { display: flex; flex-wrap: wrap; gap: 8px; }
    .role-option { display: inline-flex; align-items: center; gap: 8px; min-height: 38px; padding: 7px 12px; color: #858d87; background: #fff; border: 1px solid #d6dfd9; border-radius: 10px; cursor: pointer; font-size: 15px; font-weight: 600; }
    .role-option input, .replacement-radio input, .attendance-method input { width: 15px; height: 15px; margin: 0; accent-color: #39745b; flex-shrink: 0; }
    .role-option:has(input:checked) { color: #39745b; background: #d8f6e8; border-color: #75c4a0; }
    .replacement-fields { display: none; margin-top: 14px; }
    .replacement-fields.active { display: block; }
    .replacement-options { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; margin-bottom: 12px; }
    .replacement-radio { display: inline-flex; align-items: center; gap: 7px; margin: 0; color: #737d76; cursor: pointer; font-size: 14px; }
    .replacement-radio:has(input:checked) { color: #171d19; }
    .replacement-label { display: block; margin: 0 0 6px; font-size: 17px; font-weight: 700; }
    .required { color: #ed3434; }
    .jurnal-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 13px 28px; }
    .jurnal-field { min-width: 0; }
    .jurnal-field.full { grid-column: 1 / -1; }
    .jurnal-field > label, .jurnal-field > .field-label { display: block; margin-bottom: 6px; font-size: 15px; font-weight: 700; }
    .jurnal-control { display: block; width: 100%; min-width: 0; height: 39px; padding: 8px 11px; color: #303832; background: #fff; border: 1px solid #b8c0ba; border-radius: 10px; outline: none; font-family: inherit; font-size: 13px; }
    .jurnal-control:focus { border-color: #5a9d79; box-shadow: 0 0 0 2px rgba(57, 116, 91, .10); }
    .jurnal-control[readonly] { background: #f5f5f5; cursor: not-allowed; }
    textarea.jurnal-control { min-height: 58px; height: auto; resize: vertical; }
    .field-help { display: block; margin-top: 5px; color: #78847b; font-size: 11px; line-height: 1.5; }
    .attendance-panel { margin-bottom: 20px; }
    .attendance-methods { display: flex; flex-direction: column; gap: 12px; margin: 8px 0 14px; }
    .attendance-method { display: flex; align-items: center; gap: 9px; margin: 0; color: #222a24; cursor: pointer; font-size: 14px; font-weight: 400; }
    .attendance-method:has(input:not(:checked)) { color: #c1c7c3; }
    .attendance-details { display: none; }
    .attendance-details.active { display: block; }
    .manual-attendance-row { display: grid; grid-template-columns: 70px 46px minmax(0, 1fr); align-items: center; gap: 12px; margin-bottom: 9px; }
    .manual-attendance-label { font-size: 14px; font-weight: 700; text-align: right; }
    .manual-count { width: 46px; height: 35px; padding: 5px; text-align: center; background: #fff; border: 1px solid #b8c0ba; border-radius: 10px; font-size: 13px; }
    .manual-name-select { width: 100%; min-width: 0; height: 35px; padding: 5px 10px; background: #fff; border: 1px solid #b8c0ba; border-radius: 10px; font-family: inherit; font-size: 13px; }
    .manual-name-list { display: flex; flex-direction: column; gap: 7px; margin-top: 7px; }
    .attendance-table-wrap { width: 100%; overflow-x: auto; }
    .attendance-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .attendance-table th, .attendance-table td { padding: 9px; border-bottom: 1px solid #d9e7de; text-align: left; }
    .attendance-table th { color: #285b43; background: #e1f1e8; }
    .attendance-table select { width: 100%; min-width: 100px; padding: 7px; border: 1px solid #c7d6cc; border-radius: 7px; background: white; }
    .attendance-message { padding: 10px 4px; color: #78847b; font-size: 12px; }
    .photo-upload { display: flex; min-height: 125px; padding: 18px; align-items: center; justify-content: center; flex-direction: column; gap: 7px; color: #39745b; background: #eff9f4; border: 2px solid #d0e5d9; border-radius: 13px; cursor: pointer; text-align: center; }
    .photo-upload i { font-size: 34px; }
    .photo-upload strong { font-size: 14px; }
    .photo-upload small { font-size: 11px; }
    .photo-preview { display: none; max-width: 100%; max-height: 250px; margin: 10px auto 0; border-radius: 8px; }
    .jurnal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; }
    .jurnal-btn { display: inline-flex; min-height: 39px; padding: 8px 15px; align-items: center; justify-content: center; border-radius: 7px; font-family: inherit; font-size: 13px; text-decoration: none; cursor: pointer; }
    .btn-cancel { color: #555; background: white; border: 1px solid #aaa; }
    .btn-save { color: white; background: #39745b; border: 1px solid #39745b; font-weight: 600; }
    .btn-save:hover { color: white; background: #2d6049; }
    .jurnal-alert { margin-bottom: 14px; padding: 12px; border-radius: 7px; font-size: 13px; }
    .jurnal-alert.error { color: #842029; background: #f8d7da; }
    .jurnal-alert.success { color: #0f5132; background: #d1e7dd; }
    @media (max-width: 760px) { .jurnal-card { padding: 16px; } .jurnal-grid { gap: 13px; } .manual-attendance-row { grid-template-columns: 60px 42px minmax(0, 1fr); gap: 8px; } .manual-count { width: 42px; } }
    @media (max-width: 540px) { .jurnal-header h2 { font-size: 22px; } .jurnal-grid { grid-template-columns: minmax(0, 1fr); } .jurnal-field.full { grid-column: auto; } .replacement-options { gap: 10px; } .replacement-radio { font-size: 12px; } .manual-attendance-row { grid-template-columns: 58px 40px minmax(0, 1fr); gap: 7px; } .manual-attendance-label { font-size: 12px; } .manual-count, .manual-name-select { font-size: 12px; } }
</style>

<div class="jurnal-page">
    <header class="jurnal-header">
        <h2>Edit Jurnal Harian Guru</h2>
        <p>Perbarui catatan kegiatan pembelajaran Anda.</p>
    </header>

    @if (session('error')) <div class="jurnal-alert error">{{ session('error') }}</div> @endif
    @if ($errors->any())
        <div class="jurnal-alert error">
            <strong>Periksa kembali data berikut:</strong>
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('guru.jurnal.update', $jurnal->id) }}" method="POST" enctype="multipart/form-data" id="formEditJurnal">
        @csrf
        @method('PUT')

        <div class="jurnal-card">
            <div class="jurnal-heading">
                <i class="bi bi-journal-bookmark-fill"></i>
                <div>
                    <h3>Edit Jurnal Mengajar</h3>
                    <p>Ubah informasi pembelajaran sesuai kegiatan yang dilaksanakan.</p>
                </div>
            </div>

            {{-- STATUS MENGAJAR (readonly, tapi tetap tampilannya) --}}
            <section class="jurnal-panel">
                <h4 class="jurnal-panel-title">Status Mengajar</h4>
                <p class="jurnal-panel-description">Pilih peran Anda pada sesi pembelajaran ini.</p>
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

            {{-- DATA JURNAL (SAMA PERSIS) --}}
            <div class="jurnal-grid">
                <div class="jurnal-field">
                    <label>Tanggal Mengajar *</label>
                    <input type="date" name="tanggal" id="tanggal" class="jurnal-control" value="{{ old('tanggal', $jurnal->tanggal->format('Y-m-d')) }}" required>
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
                    <label>Pokok Bahasan/Materi *</label>
                    <textarea name="pokok_bahasan" id="pokok_bahasan" class="jurnal-control" required>{{ old('pokok_bahasan', $jurnal->pokok_bahasan) }}</textarea>
                </div>
                <div class="jurnal-field">
                    <label>Status Penyelesaian *</label>
                    <select name="status_penyelesaian" id="status_penyelesaian" class="jurnal-control" required>
                        <option value="selesai" {{ old('status_penyelesaian', $jurnal->status_penyelesaian) === 'selesai' ? 'selected' : '' }}>Tuntas</option>
                        <option value="belum_selesai" {{ old('status_penyelesaian', $jurnal->status_penyelesaian) === 'belum_selesai' ? 'selected' : '' }}>Belum Tuntas</option>
                    </select>
                </div>
                <div class="jurnal-field">
                    <label>Semester Akademik</label>
                    <input type="text" class="jurnal-control" value="{{ $coverAktif ? $coverAktif->tahun_ajaran . ' Semester ' . $coverAktif->semester : '-' }}" readonly>
                </div>
                <div class="jurnal-field full" id="alasanContainer" style="{{ old('status_penyelesaian', $jurnal->status_penyelesaian) === 'belum_selesai' ? '' : 'display:none;' }}">
                    <label>Alasan Belum Tuntas</label>
                    <textarea name="alasan_belum_selesai" id="alasan_belum_selesai" class="jurnal-control">{{ old('alasan_belum_selesai', $jurnal->alasan_belum_selesai) }}</textarea>
                </div>

                {{-- ABSENSI SISWA (PERSIS STRUKTUR TAMBAH, TAPI SUDAH TERISI) --}}
                <div class="jurnal-field full">
                    <label class="field-label">Absensi Siswa <span class="required">*</span></label>
                    <div class="attendance-methods">
                        <label class="attendance-method">
                            <input type="radio" name="metode_absensi" value="otomatis" checked>
                            <span>Ambil Data dari Absensi Siswa</span>
                        </label>
                        <label class="attendance-method">
                            <input type="radio" name="metode_absensi" value="manual">
                            <span>Masukkan Data Absen Sendiri</span>
                        </label>
                    </div>

                    <div id="automaticAttendance" class="attendance-details active">
                        <div id="attendanceMessage" class="attendance-message" style="display:none;"></div>
                        <div class="attendance-table-wrap">
                            <table id="attendanceTable" class="attendance-table" style="display:table;">
                                <thead><tr><th>No.</th><th>Nama Siswa</th><th>Status Kehadiran</th></tr></thead>
                                <tbody id="murid-list"></tbody>
                            </table>
                        </div>
                    </div>

                    <div id="manualAttendance" class="attendance-details">
                        <div class="manual-attendance-row">
                            <label class="manual-attendance-label">Sakit :</label>
                            <input type="number" id="jumlah_sakit" class="manual-count" min="0" max="100" value="0">
                            <div id="nama_sakit" class="manual-name-list">
                                <select class="manual-name-select"><option value="">-</option></select>
                            </div>
                        </div>
                        <div class="manual-attendance-row">
                            <label class="manual-attendance-label">Izin :</label>
                            <input type="number" id="jumlah_izin" class="manual-count" min="0" max="100" value="0">
                            <div id="nama_izin" class="manual-name-list">
                                <select class="manual-name-select"><option value="">-</option></select>
                            </div>
                        </div>
                        <div class="manual-attendance-row">
                            <label class="manual-attendance-label">Alpha :</label>
                            <input type="number" id="jumlah_alpa" class="manual-count" min="0" max="100" value="0">
                            <div id="nama_alpa" class="manual-name-list">
                                <select class="manual-name-select"><option value="">-</option></select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="jurnal-field full">
                    <label>Catatan Tambahan</label>
                    <input type="text" name="keterangan" id="keterangan" class="jurnal-control" value="{{ old('keterangan', $jurnal->keterangan) }}">
                </div>

                <div class="jurnal-field full">
                    <label>Foto Kegiatan</label>
                    @if($jurnal->foto_kegiatan)
                        <div style="margin-bottom:10px;">
                            <img src="{{ asset('storage/' . $jurnal->foto_kegiatan) }}" alt="Foto saat ini" style="max-height:150px; border-radius:8px;">
                        </div>
                    @endif
                    <label for="foto_kegiatan" class="photo-upload">
                        <i class="bi bi-images"></i>
                        <strong id="photoLabel">Klik untuk {{ $jurnal->foto_kegiatan ? 'mengganti' : 'pilih' }} foto kegiatan</strong>
                        <small>JPG atau PNG - Batas Ukuran 3 MB</small>
                    </label>
                    <input type="file" name="foto_kegiatan" id="foto_kegiatan" accept=".jpg,.jpeg,.png" hidden>
                    <img id="photoPreview" class="photo-preview">
                </div>
            </div>
        </div>

        <div class="jurnal-actions">
            <a href="{{ route('guru.jurnal-harian') }}" class="jurnal-btn btn-cancel">Batal</a>
            <button type="submit" class="jurnal-btn btn-save">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data awal dari server
    const daftarMurid = @json($murids);
    const absensiLama = @json($jurnal->attendances->pluck('status_kehadiran', 'murid_id'));

    // 2. Inisialisasi variabel
    const form = document.getElementById('formEditJurnal');
    const muridList = document.getElementById('murid-list');
    const attendanceTable = document.getElementById('attendanceTable');
    const attendanceMessage = document.getElementById('attendanceMessage');

    const statusPenyelesaian = document.getElementById('status_penyelesaian');
    const alasanContainer = document.getElementById('alasanContainer');

    const automaticAttendance = document.getElementById('automaticAttendance');
    const manualAttendance = document.getElementById('manualAttendance');

    // 3. Render tabel otomatis (seperti di tambah)
    function renderAutomaticAttendance() {
        muridList.innerHTML = '';
        if (!daftarMurid.length) {
            attendanceTable.style.display = 'none';
            attendanceMessage.style.display = 'block';
            attendanceMessage.textContent = 'Belum ada data siswa untuk jadwal ini.';
            return;
        }
        attendanceMessage.style.display = 'none';
        attendanceTable.style.display = 'table';
        daftarMurid.forEach((murid, index) => {
            const status = absensiLama[murid.id] || 'hadir';
            muridList.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${murid.nama_siswa}</td>
                    <td>
                        <select name="absensi[${murid.id}]">
                            <option value="hadir" ${status === 'hadir' ? 'selected' : ''}>Hadir</option>
                            <option value="sakit" ${status === 'sakit' ? 'selected' : ''}>Sakit</option>
                            <option value="izin" ${status === 'izin' ? 'selected' : ''}>Izin</option>
                            <option value="alpa" ${status === 'alpa' ? 'selected' : ''}>Alpha</option>
                        </select>
                    </td>
                </tr>
            `;
        });
    }
    renderAutomaticAttendance();

    // 4. Toggle Alasan
    function updateAlasan() {
        alasanContainer.style.display = statusPenyelesaian.value === 'belum_selesai' ? '' : 'none';
    }
    statusPenyelesaian.addEventListener('change', updateAlasan);
    updateAlasan();

    // 5. Toggle Metode Absensi
    function updateMetodeAbsensi() {
        const manual = document.querySelector('input[name="metode_absensi"]:checked').value === 'manual';
        automaticAttendance.classList.toggle('active', !manual);
        manualAttendance.classList.toggle('active', manual);
        if (manual) {
            renderManualAttendance();
        }
    }
    document.querySelectorAll('input[name="metode_absensi"]').forEach(input => {
        input.addEventListener('change', updateMetodeAbsensi);
    });
    updateMetodeAbsensi();

    // 6. Logika Manual (PERSIS SEPERTI TAMBAH)
    const attendanceCategories = [
        { status: 'sakit', countId: 'jumlah_sakit', containerId: 'nama_sakit' },
        { status: 'izin', countId: 'jumlah_izin', containerId: 'nama_izin' },
        { status: 'alpa', countId: 'jumlah_alpa', containerId: 'nama_alpa' }
    ];

    function renderManualAttendance() {
        if (document.querySelector('input[name="metode_absensi"]:checked').value !== 'manual') return;
        attendanceCategories.forEach(category => {
            const countInput = document.getElementById(category.countId);
            const container = document.getElementById(category.containerId);
            const count = Math.max(0, Math.min(100, parseInt(countInput.value, 10) || 0));
            container.innerHTML = '';

            if (count === 0) {
                const emptySelect = document.createElement('select');
                emptySelect.className = 'manual-name-select';
                emptySelect.disabled = true;
                emptySelect.innerHTML = '<option value="">-</option>';
                container.appendChild(emptySelect);
                return;
            }
            if (!daftarMurid.length) {
                const emptySelect = document.createElement('select');
                emptySelect.className = 'manual-name-select';
                emptySelect.disabled = true;
                emptySelect.innerHTML = '<option value="">Data siswa belum ada</option>';
                container.appendChild(emptySelect);
                return;
            }
            for (let i = 0; i < count; i++) {
                const select = document.createElement('select');
                select.className = 'manual-name-select';
                select.dataset.status = category.status;
                select.required = true;
                select.innerHTML = '<option value="">-- Pilih nama siswa --</option>';
                daftarMurid.forEach(murid => {
                    select.innerHTML += `<option value="${murid.id}">${murid.nama_siswa}</option>`;
                });
                container.appendChild(select);
            }
        });
    }

    attendanceCategories.forEach(cat => {
        document.getElementById(cat.countId).addEventListener('input', renderManualAttendance);
    });

    // 7. Foto Preview
    const fotoInput = document.getElementById('foto_kegiatan');
    const photoLabel = document.getElementById('photoLabel');
    const photoPreview = document.getElementById('photoPreview');
    let photoUrl = null;
    fotoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (photoUrl) { URL.revokeObjectURL(photoUrl); photoUrl = null; }
        photoPreview.style.display = 'none'; photoPreview.removeAttribute('src');
        if (!file) { photoLabel.textContent = 'Klik untuk pilih foto kegiatan pembelajaran'; return; }
        if (!['image/jpeg', 'image/png'].includes(file.type)) { alert('Foto harus berformat JPG atau PNG.'); this.value = ''; return; }
        if (file.size > 3 * 1024 * 1024) { alert('Ukuran foto maksimal 3 MB.'); this.value = ''; return; }
        photoLabel.textContent = file.name;
        photoUrl = URL.createObjectURL(file);
        photoPreview.src = photoUrl;
        photoPreview.style.display = 'block';
    });
});
</script>
@endsection