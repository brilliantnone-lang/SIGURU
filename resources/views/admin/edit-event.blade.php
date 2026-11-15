@extends('layouts.app')

@section('title', 'Edit Event - Jurnal Mengajar Guru')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Edit Event Sekolah</h1>
            <p style="margin:0; font-size:12px; color:#555;">Perbarui kegiatan sekolah di luar pembelajaran.</p>
        </div>
    </div>

    <form action="{{ route('admin.event.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
            @if($errors->any())
                <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:20px;">@foreach($errors->all() as $error)
                    <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Nama Event *</label>
                <input type="text" name="nama_event" value="{{ old('nama_event') }}"
                    placeholder="Contoh: Upacara Kemerdekaan" required
                    style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3"
                    style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- CHECKBOX RUTIN --}}
            <div style="margin-bottom:15px; padding:15px; background:#f0fdf4; border-radius:8px; border:1px solid #bbf7d0;">
                <label style="display:flex; align-items:center; gap:10px; font-weight:600; cursor:pointer; color:#166534;">
                    <input type="checkbox" name="is_rutin" id="is_rutin" value="1" {{ old('is_rutin') ? 'checked' : '' }}
                        style="width:18px; height:18px;">
                    Event Rutin Mingguan (Contoh: Upacara Tiap Senin)
                </label>
            </div>

            {{-- KOLOM TANGGAL (Muncul jika BUKAN rutin) --}}
            <div id="tanggal-container" class="form-group"
                style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Tanggal Mulai *</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                        style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Tanggal Selesai (Opsional)</label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                        style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
            </div>

            {{-- KOLOM HARI RUTIN (Muncul jika RUTIN) --}}
            <div id="hari-container" class="form-group" style="display:none; margin-bottom:20px;">
                <label style="display:block; font-weight:600; margin-bottom:7px;">Pilih Hari Rutin *</label>
                <select name="hari_rutin" style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                    <option value="">-- Pilih Hari --</option>
                    @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $h)
                        <option value="{{ $h }}" {{ old('hari_rutin') == $h ? 'selected' : '' }}>
                            {{ ucfirst($h) }}
                        </option>
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
                    <input type="number" name="jam_mulai_ke" value="{{ old('jam_mulai_ke') }}" min="1" max="8"
                        style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Jam Selesai Ke- *</label>
                    <input type="number" name="jam_selesai_ke" value="{{ old('jam_selesai_ke') }}" min="1" max="8"
                        style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
                <a href="{{ route('admin.event.index') }}"
                    style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
                <button type="submit" style="border: 1px solid #39765f;
                                background: #39765f;
                                color: #fff;padding:12px 20px; border-radius:6px;             background: #39765f;
                ; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan
                    Perubahan</button>
            </div>
        </div>
    </form>
    {{-- POPUP BERHASIL UPDATE EVENT --}}
    @if(session('success'))
        <div class="success-modal-overlay" id="successModal">
            <div class="success-modal">
                <div class="success-modal-header"></div>

                <div class="success-modal-content">
                    <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <h3>Berhasil Diperbarui!</h3>
                    <p>{{ session('success') }}</p>

                    <div class="success-modal-actions">
                        <a href="{{ route('admin.event.index') }}" class="success-ok-button">
                            Oke
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('styles')
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
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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

            // Jalankan saat pertama kali load (untuk menyesuaikan data yang sudah ada)
            toggleForm();

            // Jalankan setiap kali checkbox diubah
            isRutin.addEventListener('change', toggleForm);
            isFullDay.addEventListener('change', toggleForm);
        });
    </script>
@endpush