@extends('layouts.app')

@section('title', 'Tambah Siswa - Jurnal Mengajar Guru')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Tambah Data Siswa</h1>
            <p style="margin:0; font-size:12px; color:#555;">Masukkan profil siswa baru.</p>
        </div>
        <a href="{{ route('admin.murid.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <form action="{{ route('admin.murid.store') }}" method="POST">
        @csrf
        <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
            @if($errors->any())
                <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:20px;">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                </div>
            @endif

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">NIS (Nomor Induk Siswa) *</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Lengkap *</label>
                    <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Kelas *</label>
                    <select name="kelas_id" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $selectedKelas) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
                <a href="{{ route('admin.murid.index') }}" style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
                <button type="submit" style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan Siswa</button>
            </div>
        </div>
    </form>
@endsection