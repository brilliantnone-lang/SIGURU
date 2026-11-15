@extends('layouts.app')

@section('title', 'Data Siswa - Jurnal Mengajar Guru')


@section('content')
    <div class="kelas-heading-row">
        <div>
            <h1>Daftar Siswa Kelas {{ $kelasAktif->nama_kelas }}</h1>
            <p class="subtitle">Kelola data siswa untuk kelas ini.</p>
        </div>

        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.kelas.index') }}"
                style="padding:10px 16px; border-radius:6px; background:#f3f4f6; color:#111; text-decoration:none; font-weight:600; font-size:12px;">
                <i class="bi bi-arrow-left"></i> Kembali ke Kelas
            </a>

            <a href="{{ route('admin.murid.create', ['kelas_id' => $kelasAktif->id]) }}" class="add-kelas-button"
                style="text-decoration:none;">
                <span aria-hidden="true">＋</span> Tambah Siswa
            </a>
        </div>
    </div>


    @if(session('success'))
        <div
            style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">
            {{ session('success') }}
        </div>
    @endif

    <div class="kelas-table-card">
        <div class="kelas-table-wrap">
            <table class="kelas-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>L/P</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($murid as $i => $m)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $m->nis }}</td>
                                        <td>{{ $m->nama_siswa }}</td>
                                        <td>{{ $m->kelas->nama_kelas ?? '-' }}</td>
                                        <td>{{ $m->jenis_kelamin }}</td>
                                        <td>
                                            <div class="kelas-actions">
                                                <a href="{{ route('admin.murid.edit', [
                            'data_murid' => $m->id,
                            'return_kelas_id' => $kelasAktif->id
                        ]) }}" class="table-action edit" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                {{-- Hapus Siswa --}}
                                                <form action="{{ route('admin.murid.destroy', $m->id) }}" method="POST" class="delete-form"
                                                    style="display:inline; margin:0; padding:0;">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" class="table-action delete" title="Hapus"
                                                        onclick="showDeleteModal(this)">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px; color:#888;">Belum ada data siswa di
                                sini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="kelas-table-footer">
            <span>Menampilkan {{ count($murid) }} siswa</span>
        </div>
    </div>

    {{-- POPUP KONFIRMASI HAPUS SISWA --}}
    <div class="delete-modal-overlay" id="deleteModal" style="display: none;">
        <div class="delete-modal">
            <div class="delete-modal-header"></div>

            <div class="delete-modal-content">
                <div class="delete-icon">
                    <i class="bi bi-trash"></i>
                </div>

                <h3>Hapus Siswa?</h3>
                <p>Apakah kamu yakin ingin menghapus data siswa ini?</p>

                <div class="delete-modal-actions">
                    <button type="button" class="delete-cancel-button" onclick="closeDeleteModal()">
                        Batal
                    </button>

                    <button type="button" class="delete-confirm-button" onclick="confirmDelete()">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* CSS yang sama seperti sebelumnya */
        .kelas-heading-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 22px;
        }

        .kelas-heading-row h1 {
            margin: 0 0 5px;
            font-size: 26px;
            font-weight: 700;
            color: #111;
        }

        .kelas-heading-row .subtitle {
            margin: 0;
            font-size: 14px;
        }

        .add-kelas-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 40px;
            padding: 0 16px;
            border: 0;
            border-radius: 6px;
            background: #0A4C2E;
            color: #FFFFFF;
            font: inherit;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
        }

        .kelas-table-card {
            width: 100%;
            padding: 12px;
            border: 1px solid #E1ECE6;
            border-radius: 10px;
            background: #FFFFFF;
        }

        .kelas-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .kelas-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            color: #173D2B;
            font-size: 12px;
            white-space: nowrap;
        }

        .kelas-table thead {
            background: #FFFFFF;
        }

        .kelas-table th {
            padding: 12px 10px;
            color: #173D2B;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
        }

        .kelas-table th:last-child {
            text-align: center;
        }

        .kelas-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #E8EFEB;
            vertical-align: middle;
        }

        .kelas-table tbody tr:nth-child(even) {
            background: #F8FAF9;
        }

        .kelas-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
        }

        .table-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 31px;
            height: 31px;
            padding: 0;
            border: 1px solid;
            border-radius: 7px;
            background: #fff;
            font-size: 15px;
            line-height: 1;
            cursor: pointer;
            transition: background .15s ease;
        }

        .table-action.edit {
            border-color: #aebfb5;
            color: #39765f;
        }

        .table-action.delete {
            border-color: #ff7777;
            color: #ff3333;
        }

        .kelas-table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 18px;
            color: #40574F;
            font-size: 12px;
        }

        /* POPUP KONFIRMASI HAPUS */
        .delete-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.25);
        }

        .delete-modal {
            width: 90%;
            max-width: 470px;
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            animation: modalAppear 0.25s ease;
        }

        .delete-modal-header {
            height: 30px;
            background: #FF0000;
        }

        .delete-modal-content {
            padding: 10px 20px 20px;
            text-align: center;
        }

        .delete-icon {
            font-size: 65px;
            color: #FF0000;
            margin-bottom: 8px;
        }

        .delete-modal-content h3 {
            color: #FF0000;
            font-size: 27px;
            font-weight: bold;
            margin: 0 0 10px;
        }

        .delete-modal-content p {
            color: #666;
            margin-bottom: 20px;
        }

        .delete-modal-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .delete-cancel-button,
        .delete-confirm-button {
            width: 120px;
            height: 48px;
            border: none;
            border-radius: 16px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        .delete-cancel-button {
            background: #eee;
            color: #555;
        }

        .delete-cancel-button:hover {
            background: #ddd;
        }

        .delete-confirm-button {
            background: #FF0000;
            color: #fff;
        }

        .delete-confirm-button:hover {
            background: #cc0000;
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
        let selectedDeleteForm = null;

        function showDeleteModal(button) {
            selectedDeleteForm = button.closest('form');
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            selectedDeleteForm = null;
        }

        function confirmDelete() {
            if (selectedDeleteForm) {
                selectedDeleteForm.submit();
            }
        }

        document.getElementById('deleteModal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endpush