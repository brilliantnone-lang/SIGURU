@extends('layouts.app')

@section('title', 'Tambah Mapel - Jurnal Mengajar Guru')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Tambah Mata Pelajaran</h1>
            <p style="margin:0; font-size:12px; color:#555;">Masukkan nama mata pelajaran baru.</p>
        </div>
    </div>

    <form action="{{ route('admin.mapel.store') }}" method="POST">
        @csrf
        <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
            @if($errors->any())
                <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:20px;">@foreach($errors->all() as $error)
                    <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Mata Pelajaran *</label>
                <input type="text" name="nama_mata_pelajaran" value="{{ old('nama_mata_pelajaran') }}"
                    placeholder="Contoh: Matematika" required
                    style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
                <a href="{{ route('admin.mapel.index') }}"
                    style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
                <button type="submit"
                    style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan
                    Mapel</button>
            </div>
        </div>
    </form>

    {{-- POPUP BERHASIL TAMBAH --}}
    @if(session('success'))
        <div class="success-modal-overlay" id="successModal">
            <div class="success-modal">
                <div class="success-modal-header"></div>

                <div class="success-modal-content">
                    <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <h3>Berhasil Ditambahkan!</h3>
                    <p>{{ session('success') }}</p>

                    <div class="success-modal-actions">
                        <a href="{{ route('admin.mapel.index') }}" class="success-ok-button">
                            Oke
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .success-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.25);
        }

        .success-modal {
            width: 90%;
            max-width: 470px;
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            animation: modalAppear 0.25s ease;
        }

        .success-modal-header {
            height: 30px;
            background: #39765f;
        }

        .success-modal-content {
            padding: 10px 20px 20px;
            text-align: center;
        }

        .success-icon {
            font-size: 65px;
            color: #39765f;
            margin-bottom: 8px;
        }

        .success-modal-content h3 {
            color: #39765f;
            font-size: 27px;
            font-weight: bold;
            margin: 0 0 10px;
        }

        .success-modal-content p {
            color: #666;
            margin-bottom: 20px;
        }

        .success-modal-actions {
            display: flex;
            justify-content: center;
        }

        .success-ok-button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 120px;
            height: 48px;
            border-radius: 16px;
            background: #39765f;
            color: #fff;
            font-size: 17px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.2s;
        }

        .success-ok-button:hover {
            background: #285943;
            color: #fff;
        }

        @keyframes modalAppear {
            from {
                transform: scale(0.92);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endsection