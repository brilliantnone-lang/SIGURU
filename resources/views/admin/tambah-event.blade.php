@extends('layouts.app')

@section('title', 'Tambah Event - Jurnal Mengajar Guru')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <div>
        <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Tambah Event Sekolah</h1>
        <p style="margin:0; font-size:12px; color:#555;">Masukkan kegiatan sekolah di luar pembelajaran.</p>
    </div>
    <a href="{{ route('admin.event.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<form action="{{ route('admin.event.store') }}" method="POST">
    @csrf
    <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
        @if($errors->any())
        <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
        @endif

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Event *</label>
            <input type="text" name="nama_event" value="{{ old('nama_event') }}" placeholder="Contoh: Upacara Kemerdekaan" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; margin-bottom:7px;">Deskripsi (Opsional)</label>
            <textarea name="deskripsi" rows="3" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- CHECKBOX RUTIN --}}
        <div style="margin-bottom:15px; padding:15px; background:#f0fdf4; border-radius:8px; border:1px solid #bbf7d0;">
            <label style="display:flex; align-items:center; gap:10px; font-weight:600; cursor:pointer; color:#166534;">
                <input type="checkbox" name="is_rutin" id="is_rutin" value="1" {{ old('is_rutin') ? 'checked' : '' }} style="width:18px; height:18px;">
                Event Rutin Mingguan (Contoh: Upacara Tiap Senin)
            </label>
        </div>

        {{-- KOLOM TANGGAL (Muncul jika BUKAN rutin) --}}
        <div id="tanggal-container" class="form-group" style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Tanggal Mulai *</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Tanggal Selesai (Opsional)</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>
        </div>

        {{-- KOLOM HARI RUTIN (Muncul jika RUTIN) --}}
        <div id="hari-container" class="form-group" style="display:none; margin-bottom:20px;">
            <label style="display:block; font-weight:600; margin-bottom:7px;">Pilih Hari Rutin *</label>
            <select name="hari_rutin" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                <option value="">-- Pilih Hari --</option>
                @foreach(['senin','selasa','rabu','kamis','jumat','sabtu'] as $h)
                <option value="{{ $h }}" {{ old('hari_rutin') == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                @endforeach
            </select>
        </div>

        {{-- CHECKBOX FULL DAY --}}
        <div style="margin-bottom:15px; padding:15px; background:#f8faf9; border-radius:8px; border:1px solid #E1ECE6;">
            <label style="display:flex; align-items:center; gap:10px; font-weight:600; cursor:pointer;">
                <input type="checkbox" name="is_full_day" id="is_full_day" value="1" {{ old('is_full_day') ? 'checked' : '' }} style="width:18px; height:18px;">
                Acara Seharian (Full Day)
            </label>
        </div>

        {{-- KOLOM JAM --}}
        <div id="jam-container" style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Jam Mulai Ke- *</label>
                <input type="number" name="jam_mulai_ke" value="{{ old('jam_mulai_ke', 1) }}" min="1" max="8" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Jam Selesai Ke- *</label>
                <input type="number" name="jam_selesai_ke" value="{{ old('jam_selesai_ke', 1) }}" min="1" max="8" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
            <a href="{{ route('admin.event.index') }}" style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
            <button type="submit" style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan Event</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isRutin = document.getElementById('is_rutin');
        const isFullDay = document.getElementById('is_full_day');
        const tanggalContainer = document.getElementById('tanggal-container');
        const hariContainer = document.getElementById('hari-container');
        const jamContainer = document.getElementById('jam-container');

        // Fungsi untuk mengatur tampilan Form
        function toggleForm() {
            // Atur Rutin vs Tanggal
            if (isRutin.checked) {
                tanggalContainer.style.display = 'none';
                hariContainer.style.display = 'block';
            } else {
                tanggalContainer.style.display = 'grid';
                hariContainer.style.display = 'none';
            }

            // Atur Full Day vs Jam
            if (isFullDay.checked) {
                jamContainer.style.display = 'none';
            } else {
                jamContainer.style.display = 'grid';
            }
        }

        // Jalankan saat pertama kali load (untuk handle error validasi)
        toggleForm();

        // Jalankan setiap kali checkbox diubah
        isRutin.addEventListener('change', toggleForm);
        isFullDay.addEventListener('change', toggleForm);
    });
</script>
@endpush