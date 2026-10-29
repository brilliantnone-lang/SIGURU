@extends('layouts.app')

@section('title', 'Profil Kepala Sekolah')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Profil Saya</h1>
            <p style="margin:0; font-size:12px; color:#555;">Kelola tanda tangan digital Anda untuk validasi jurnal.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">{{ session('success') }}</div>
    @endif

    <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6; max-width:600px;">
        <h3 style="margin:0 0 15px; font-size:18px;">Tanda Tangan Digital</h3>
        
        <div style="margin-bottom:20px; text-align:center; padding:20px; background:#f8faf9; border-radius:8px; border:1px dashed #ccc;">
            @if($user->ttd_kepsek)
                <img src="{{ asset('storage/' . $user->ttd_kepsek) }}" alt="TTD" style="max-height:120px; margin-bottom:10px;">
                <p style="margin:0; font-size:12px; color:#555;">Tanda tangan saat ini</p>
            @else
                <p style="margin:0; font-size:13px; color:#888;">Belum ada tanda tangan yang diunggah.</p>
            @endif
        </div>

        <form action="{{ route('kepsek.profil.ttd') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Unggah TTD Baru (PNG/JPG)</label>
                <input type="file" name="ttd_kepsek" accept="image/png,image/jpeg" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                <small style="color:#5D756B;">Maksimal 2MB. Disarankan latar belakang transparan (PNG).</small>
            </div>
            <button type="submit" style="padding:10px 20px; background:#0A4C2E; color:#fff; border:none; border-radius:6px; font-weight:600; cursor:pointer;">Simpan TTD</button>
        </form>
    </div>
@endsection