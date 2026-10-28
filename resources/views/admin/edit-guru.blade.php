@extends('layouts.app')

@section('title', 'Edit Guru - Jurnal Mengajar Guru')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Edit Data Guru</h1>
            <p style="margin:0; font-size:12px; color:#555;">Perbarui profil dan akun login guru.</p>
        </div>
        <a href="{{ route('admin.guru.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
            
            @if($errors->any())
                <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 style="margin:0 0 15px; font-size:16px; border-bottom:1px solid #E1ECE6; padding-bottom:10px;">Akun Login</h3>
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $guru->user->name) }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $guru->user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $guru->user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Username *</label>
                    <input type="text" name="username" value="{{ old('username', $guru->user->username) }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Password Baru</label>
                    <input type="text" name="password" placeholder="Kosongkan jika tidak ingin ganti password" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                    <small style="color:#5D756B;">Isi hanya jika ingin mengganti password.</small>
                </div>
            </div>

            <h3 style="margin:25px 0 15px; font-size:16px; border-bottom:1px solid #E1ECE6; padding-bottom:10px;">Profil Guru</h3>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">NIP Guru *</label>
                    <input type="text" name="nip_guru" value="{{ old('nip_guru', $guru->nip_guru) }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Mata Pelajaran *</label>
                    <select name="mata_pelajaran_id" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mataPelajaran as $mapel)
                            <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id', $guru->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mata_pelajaran }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $guru->nomor_telepon) }}" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
                <a href="{{ route('admin.guru.index') }}" style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
                <button type="submit" style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan Perubahan</button>
            </div>
        </div>
    </form>
@endsection