@extends('layouts.app')

@section('title', 'Tambah Pengajaran - Jurnal Mengajar Guru')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Tambah Jadwal Pengajaran</h1>
            <p style="margin:0; font-size:12px; color:#555;">Hubungkan Guru, Kelas, dan Mata Pelajaran.</p>
        </div>
    </div>

    <form action="{{ route('admin.pengajaran.store') }}" method="POST">
        @csrf
        <div style="background:#fff; padding:24px; border-radius:12px; border:1px solid #E1ECE6;">
            @if($errors->any())
                <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:20px;">@foreach($errors->all() as $error)
                    <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Guru *</label>
                    <select name="guru_id" id="select-guru" required
                        style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $g)
                            {{-- Simpan mapel_id guru di atribut data-mapel --}}
                            <option value="{{ $g->id }}" data-mapel="{{ $g->mata_pelajaran_id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Mata Pelajaran *</label>
                    <select name="mata_pelajaran_id" id="select-mapel" required
                        style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mataPelajaran as $m)
                            <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mata_pelajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:22px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Kelas *</label>
                    <select name="kelas_id" required
                        style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Hari *</label>
                    <select name="hari" required
                        style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px;">
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $h)
                            <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-weight:600; margin-bottom:7px;">Jam *</label>
                    <div style="display:flex; align-items:center; gap:5px;">
                        <input type="number" name="jam_mulai_ke" value="{{ old('jam_mulai_ke', 1) }}" min="1" max="8"
                            required
                            style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px; text-align:center;">
                        <span style="font-weight:600;">s/d</span>
                        <input type="number" name="jam_selesai_ke" value="{{ old('jam_selesai_ke', 1) }}" min="1" max="8"
                            required
                            style="width:100%; padding:10px; border:1px solid #E1ECE6; border-radius:5px; text-align:center;">
                    </div>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #E1ECE6; padding-top:20px;">
                <a href="{{ route('admin.pengajaran.index') }}"
                    style="padding:12px 20px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600;">Batal</a>
                <button type="submit"
                    style="padding:12px 20px; border-radius:6px; background:#0A4C2E; color:#fff; border:none; font-weight:600; cursor:pointer;">Simpan
                    Jadwal</button>
            </div>
        </div>
    </form>
    {{-- POPUP BERHASIL TAMBAH PENGAJARAN --}}
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
                        <a href="{{ route('admin.pengajaran.index') }}" class="success-ok-button">
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
            const selectGuru = document.getElementById('select-guru');
            const selectMapel = document.getElementById('select-mapel');

            selectGuru.addEventListener('change', function () {
                // Ambil mapel_id dari atribut data-mapel pada opsi yang dipilih
                const selectedOption = this.options[this.selectedIndex];
                const mapelId = selectedOption.getAttribute('data-mapel');

                if (mapelId) {
                    // Ubah dropdown mapel sesuai dengan mapel linear guru
                    selectMapel.value = mapelId;
                } else {
                    // Jika tidak ada guru yang dipilih (kosongkan)
                    selectMapel.value = "";
                }
            });
        });
    </script>
@endpush