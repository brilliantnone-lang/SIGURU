@extends('layouts.app')

@section('title', 'Tambah Jurnal')

@section('content')
<div class="create-jurnal-page">
    <div class="page-heading">
        <h2>Jurnal Harian Guru</h2>
        <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
    </div>

    <div class="form-card">
        <div class="form-card-heading">
            <i class="bi bi-journal-bookmark-fill"></i>
            <div>
                <h3>Isi Jurnal Mengajar</h3>
                <p>Lengkapi informasi pembelajaran di bawah ini</p>
            </div>
        </div>

        @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('guru.jurnal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Jadwal Mengajar *</label>
                    <select name="jadwal_id" id="jadwal_id" required>
                        <option value="">-- Pilih Jadwal --</option>
                        @foreach($jadwalTersedia as $j)
                        <option value="{{ $j->id }}">{{ $j->kelas->nama_kelas }} - {{ $j->mataPelajaran->nama_mata_pelajaran }} (Jam {{ $j->jam_mulai_ke }}-{{ $j->jam_selesai_ke }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Cover Jurnal (Semester) *</label>
                    <select name="cover_jurnal_id" required>
                        @if($coverAktif)
                        <option value="{{ $coverAktif->id }}">{{ $coverAktif->semester }} {{ $coverAktif->tahun_ajaran }}</option>
                        @else
                        <option value="">Tidak ada cover aktif</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label>Guru Pendamping (Opsional)</label>
                    <select name="guru_pendamping_id">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($gurus as $g)
                        <option value="{{ $g->id }}">{{ $g->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Mengajar *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group full-width">
                    <label>Pokok Bahasan *</label>
                    <input type="text" name="pokok_bahasan" value="{{ old('pokok_bahasan') }}" required>
                </div>

                <div class="form-group">
                    <label>Status Penyelesaian *</label>
                    <select name="status_penyelesaian" required>
                        <option value="selesai">Selesai</option>
                        <option value="belum_selesai">Belum Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Alasan Belum Selesai</label>
                    <input type="text" name="alasan_belum_selesai" value="{{ old('alasan_belum_selesai') }}">
                </div>

                <div class="form-group full-width" id="presensi-container" style="display:none; margin-top:20px; border-top:1px solid #eee; padding-top:15px;">
                    <h4 style="margin-bottom:10px;">Presensi Siswa</h4>
                    <table style="width:100%; border-collapse:collapse; font-size:12px;">
                        <thead>
                            <tr style="background:#edf6f0;">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="murid-list"></tbody>
                    </table>
                </div>

                <div class="form-group full-width">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan') }}">
                </div>

                <div class="form-group full-width">
                    <label>Foto Kegiatan</label>
                    <input type="file" name="foto_kegiatan" accept="image/*">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('guru.jurnal-harian') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">Simpan Jurnal</button>
            </div>
        </form>
    </div>
</div>

<style>
    .create-jurnal-page {
        width: 100%;
        color: #202720;
        font-family: inherit;
        padding-bottom: 15px;
    }

    .page-heading {
        margin: 0 0 14px;
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

    .form-card {
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
</style>

@push('scripts')
<script>
    document.getElementById('jadwal_id').addEventListener('change', function() {
        const jadwalId = this.value;
        const container = document.getElementById('presensi-container');
        const muridList = document.getElementById('murid-list');

        if (!jadwalId) {
            container.style.display = 'none';
            return;
        }

        container.style.display = 'block';
        muridList.innerHTML = '<tr><td colspan="3" style="text-align:center;">Memuat data...</td></tr>';

        fetch(`/guru/get-murid/${jadwalId}`)
            .then(response => response.json())
            .then(data => {
                muridList.innerHTML = '';
                data.forEach((murid, index) => {
                    muridList.innerHTML += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${murid.nama_siswa}</td>
                        <td>
                            <select name="absensi[${murid.id}]">
                                <option value="hadir">Hadir</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="alpa">Alpa</option>
                            </select>
                        </td>
                    </tr>
                `;
                });
            });
    });
</script>
@endpush
@endsection