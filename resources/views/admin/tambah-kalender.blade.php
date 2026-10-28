@extends('layouts.app')

@section('title', 'Tambah Kalender - Jurnal Mengajar Guru')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <div>
        <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Tambah Kalender Akademik</h1>
        <p style="margin:0; font-size:12px; color:#555;">Unggah dokumen kalender akademik baru.</p>
    </div>
    <a href="{{ route('admin.kalender.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<form action="{{ route('admin.kalender.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
        @if($errors->any())
        <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
        @endif

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; margin-bottom:7px;">Tahun Ajaran *</label>
            <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" placeholder="Contoh: 2026/2027" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Tanggal Mulai Aktif *</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Tanggal Selesai Aktif *</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; margin-bottom:7px;">Dokumen Kalender Akademik *</label>
            <input type="file" name="file_kalender" accept=".pdf,.doc,.docx" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            <small style="color:#5D756B;">Format PDF atau Word. Maksimal 10MB.</small>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
            <a href="{{ route('admin.kalender.index') }}" style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
            <button type="submit" style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan Kalender</button>
        </div>
    </div>
</form>
@endsection