@extends('layouts.app')

@section('title', 'Edit Cover - Jurnal Mengajar Guru')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Edit Cover Jurnal</h1>
            <p style="margin:0; font-size:12px; color:#555;">Perbarui data identitas sekolah untuk cover jurnal ini.</p>
        </div>
        <a href="{{ route('admin.data-cover.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <form action="{{ route('admin.data-cover.update', ['data_cover' => $cover->id]) }}" method="POST" enctype="multipart/form-data">
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

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Tahun Ajaran *</label>
                    <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $cover->tahun_ajaran) }}" placeholder="Contoh: 2026/2027" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Semester *</label>
                    <select name="semester" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="Ganjil" {{ old('semester', $cover->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester', $cover->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Sekolah *</label>
                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $cover->nama_sekolah) }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Kepala Sekolah *</label>
                    <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $cover->nama_kepsek) }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">NIP Kepala Sekolah *</label>
                    <input type="text" name="nip_kepsek" value="{{ old('nip_kepsek', $cover->nip_kepsek) }}" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Logo Sekolah</label>
                
                @if($cover->logo)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('storage/' . $cover->logo) }}" alt="Logo Saat Ini" style="max-height:80px; border:1px solid #E1ECE6; border-radius:5px; padding:5px;">
                        <p style="font-size:11px; color:#5D756B; margin:5px 0 0;">Logo saat ini. Abaikan input di bawah jika tidak ingin mengubah.</p>
                    </div>
                @endif

                <input type="file" name="logo" accept="image/png,image/jpeg" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                <small style="color:#5D756B;">Format PNG atau JPG, maksimal 5 MB</small>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
                <a href="{{ route('admin.data-cover.index') }}" style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
                <button type="submit" style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan Perubahan</button>
            </div>
        </div>
    </form>
@endsection