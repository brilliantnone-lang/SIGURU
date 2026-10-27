@extends('layouts.app')

@section('title', 'Tambah Cover - Jurnal Mengajar Guru')

@section('content')
    <h1 style="font-size:26px;font-weight:650;margin:0 0 5px;color:#111;">Tambah Cover Jurnal</h1>
    <p style="font-size:12px;color:#555;margin:0 0 20px;">Isi data identitas sekolah untuk cover jurnal baru.</p>

    <form action="{{ route('admin.data-cover.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Tahun Ajaran *</label>
                    <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" placeholder="Contoh: 2026/2027" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Semester *</label>
                    <select name="semester" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Sekolah *</label>
                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', 'SMP NEGERI 15 BANJARMASIN') }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Kepala Sekolah *</label>
                    <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek') }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">NIP Kepala Sekolah *</label>
                    <input type="text" name="nip_kepsek" value="{{ old('nip_kepsek') }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Logo Sekolah</label>
                <input type="file" name="logo" accept="image/png,image/jpeg" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                <small style="color:#5D756B;">Format PNG atau JPG, maksimal 5 MB</small>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <a href="{{ route('admin.data-cover.index') }}" style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
                <button type="submit" style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan Cover</button>
            </div>
        </div>
    </form>
@endsection