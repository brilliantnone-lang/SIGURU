@extends('layouts.app')

@section('title', 'Edit Pengajaran - Jurnal Mengajar Guru')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <div>
        <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Edit Jadwal Pengajaran</h1>
        <p style="margin:0; font-size:12px; color:#555;">Perbarui jadwal pengajaran.</p>
    </div>
    <a href="{{ route('admin.pengajaran.index') }}" style="color:#40574F; text-decoration:none; font-size:13px;"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<form action="{{ route('admin.pengajaran.update', $jadwal->id) }}" method="POST">
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
                <label style="display:block; font-weight:600; margin-bottom:7px;">Guru *</label>
                <select name="guru_id" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                    @foreach($guru as $g)
                    <option value="{{ $g->id }}" {{ old('guru_id', $jadwal->guru_id) == $g->id ? 'selected' : '' }}>{{ $g->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Mata Pelajaran *</label>
                <select name="mata_pelajaran_id" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                    @foreach($mataPelajaran as $m)
                    <option value="{{ $m->id }}" {{ old('mata_pelajaran_id', $jadwal->mata_pelajaran_id) == $m->id ? 'selected' : '' }}>{{ $m->nama_mata_pelajaran }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:22px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Kelas *</label>
                <select name="kelas_id" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id', $jadwal->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Hari *</label>
                <select name="hari" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                    @foreach(['senin','selasa','rabu','kamis','jumat','sabtu'] as $h)
                    <option value="{{ $h }}" {{ old('hari', $jadwal->hari) == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:7px;">Jam *</label>
                <div style="display:flex; align-items:center; gap:5px;">
                    <input type="number" name="jam_mulai_ke" value="{{ old('jam_mulai_ke', $jadwal->jam_mulai_ke) }}" min="1" max="8" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px; text-align:center;">
                    <span style="font-weight:600;">s/d</span>
                    <input type="number" name="jam_selesai_ke" value="{{ old('jam_selesai_ke', $jadwal->jam_selesai_ke) }}" min="1" max="8" required style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px; text-align:center;">
                </div>
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
            <a href="{{ route('admin.pengajaran.index') }}" style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
            <button type="submit" style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan Perubahan</button>
        </div>
    </div>
</form>
@endsection