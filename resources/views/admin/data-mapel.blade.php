@extends('layouts.app')

@section('title', 'Data Mata Pelajaran - Jurnal Mengajar Guru')

@section('content')
    <div class="guru-heading-row">
        <div>
            <h1>Data Mata Pelajaran</h1>
            <p class="subtitle">Kelola daftar mata pelajaran yang diajarkan di sekolah.</p>
        </div>

        <a href="{{ route('admin.mapel.create') }}" class="add-guru-button" style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Tambah Mapel
        </a>
    </div>

    @if(session('success'))
        <div
            style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div
            style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fecaca;">
            {{ session('error') }}
        </div>
    @endif

    <div class="guru-table-card">
        <div class="guru-table-wrap">
            <table class="guru-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel as $i => $m)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="font-weight: 600;">{{ $m->nama_mata_pelajaran }}</td>
                            <td>
                                <div class="guru-actions">
                                    <a href="{{ route('admin.mapel.edit', $m->id) }}" class="table-action edit"
                                        title="Edit mapel">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" class="delete-form"
                                        style="display:inline; margin:0; padding:0;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="table-action delete" title="Hapus mapel"
                                            onclick="showDeleteModal(this)">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; padding:40px; color:#888;">Belum ada data mata pelajaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="guru-table-footer">
            <span>Menampilkan {{ count($mapel) }} mata pelajaran</span>
        </div>
    </div>

    {{-- POPUP KONFIRMASI HAPUS --}}
    <div class="delete-modal-overlay" id="deleteModal" style="display: none;">
        <div class="delete-modal">
            <div class="delete-modal-header"></div>

            <div class="delete-modal-content">
                <div class="delete-icon">
                    <i class="bi bi-trash"></i>
                </div>

                <h3>Hapus Mata Pelajaran?</h3>
                <p>Apakah kamu yakin ingin menghapus mata pelajaran ini?</p>

                <div class="delete-modal-actions">
                    <button type="button" class="delete-cancel-button" onclick="closeDeleteModal()">Batal</button>

                    <button type="button" class="delete-confirm-button" onclick="confirmDelete()">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Menggunakan CSS yang sama dengan Data Guru agar konsisten */

        /* HEADER - MENGIKUTI STANDAR DATA COVER */
        .guru-heading-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 18px;
        }

        .guru-heading-row h1 {
            margin: 0 0 5px;
            font-size: 26px;
            font-weight: 650;
            color: #111111;
        }

        .guru-heading-row .subtitle {
            margin: 0;
            font-size: 12px;
            color: #555555;
        }

        .add-guru-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px 12px;
            border: 0;
            border-radius: 5px;
            background: #39765f;
            color: #FFFFFF;
            text-decoration: none;
            font-family: inherit;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            cursor: pointer;
            transition: background .15s ease;
        }

        .add-guru-button:hover {
            background: #285b46;
            color: #FFFFFF;
        }


        .guru-table-card {
            width: 100%;
            padding: 24px;
            border: 1px solid #E1ECE6;
            border-radius: 10px;
            background: #FFFFFF;
        }

        .guru-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .guru-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            color: #173D2B;
            font-size: 13px;
        }

        .guru-table thead {
            background: #F0F6F2;
        }

        .guru-table th {
            padding: 12px 10px;
            color: #5D756B;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 700;
        }

        .guru-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #E8EFEB;
            vertical-align: middle;
        }

        .guru-actions {
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

        .table-action:hover {
            background: #f4f8f5;
        }

        .guru-table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 22px;
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

            const modal = document.getElementById('deleteModal');
            modal.style.display = 'flex';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'none';
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