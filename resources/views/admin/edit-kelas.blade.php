@extends('layouts.app')

@section('title', 'Edit Kelas - Jurnal Mengajar Guru')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <div>
        <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Edit Data Kelas</h1>
        <p style="margin:0; font-size:12px; color:#555;">Perbarui nama kelas dan kapasitas.</p>
    </div>
    <a href="{{ route('admin.kelas.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
        @if($errors->any())
        <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
        @endif

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Kelas *</label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Kapasitas *</label>
                <input type="number" name="kapasitas" value="{{ old('kapasitas', $kelas->kapasitas) }}" min="1" max="100" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
            <a href="{{ route('admin.kelas.index') }}" style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
            <button type="submit" style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan Perubahan</button>
        </div>
    </div>
</form>
@endsection