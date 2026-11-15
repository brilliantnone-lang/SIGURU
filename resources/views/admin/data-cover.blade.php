@extends('layouts.app')

@section('title', 'Data Cover - Jurnal Mengajar Guru')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:15px; margin-bottom:18px;">
        <div>
            <h1 style="margin:0 0 5px; font-size:26px; font-weight:650; color:#111;">Data Cover Jurnal</h1>
            <p style="margin:0; font-size:12px; color:#555;">Kelola cover jurnal per tahun ajaran dan semester</p>
        </div>

        <a href="{{ route('admin.data-cover.create') }}" class="cover-add-button">
            <i class="bi bi-plus-lg"></i>
            Tambah Cover
        </a>
    </div>

    @if(session('success'))
        <div class="cover-alert cover-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="cover-alert cover-alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="cover-table-card">
        <table class="cover-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th>Nama Sekolah</th>
                    <th>Kepala Sekolah</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($covers as $i => $cover)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $cover->tahun_ajaran }}</td>
                        <td>{{ $cover->semester }}</td>
                        <td>{{ $cover->nama_sekolah }}</td>
                        <td>{{ $cover->nama_kepsek }}</td>

                        <td>
                            <div class="cover-actions">

                                {{-- Edit --}}
                                <a href="{{ route('admin.data-cover.edit', ['data_cover' => $cover->id]) }}"
                                    class="cover-action action-edit" title="Edit Cover" aria-label="Edit Cover">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.data-cover.destroy', $cover->id) }}" method="POST"
                                    class="delete-form" style="display:inline; margin:0; padding:0;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="cover-action action-delete" title="Hapus Cover"
                                        aria-label="Hapus Cover" onclick="showDeleteModal(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:#888;">
                            Belum ada cover jurnal. Silakan tambah baru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- POPUP KONFIRMASI HAPUS --}}
    <div class="delete-modal-overlay" id="deleteModal" style="display: none;">
        <div class="delete-modal">
            <div class="delete-modal-header"></div>

            <div class="delete-modal-content">
                <div class="delete-icon">
                    <i class="bi bi-trash"></i>
                </div>

                <h3>Hapus Cover Jurnal?</h3>
                <p>Apakah kamu yakin ingin menghapus cover jurnal ini?</p>

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
        .cover-add-button {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 5px;
            background: #39765f;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: background .15s ease;
        }

        .cover-add-button:hover {
            background: #285b46;
            color: #fff;
        }

        .cover-alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .cover-alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .cover-alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .cover-table-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #E1ECE6;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            overflow-x: auto;
        }

        .cover-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cover-table thead {
            background: #F0F6F2;
        }

        .cover-table th {
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #173D2B;
            text-transform: uppercase;
        }

        .cover-table td {
            padding: 12px 10px;
            font-size: 13px;
            color: #40574F;
            border-bottom: 1px solid #E8EFEB;
        }

        .cover-table th:last-child,
        .cover-table td:last-child {
            text-align: center;
            width: 150px;
        }

        .cover-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
        }

        .cover-action {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 31px;
            height: 31px;
            padding: 0;
            border: 1px solid;
            border-radius: 7px;
            background: #fff;
            font-size: 17px;
            text-decoration: none;
            cursor: pointer;
            transition: background .15s ease, color .15s ease;
        }

        /* Lihat */
        .action-detail {
            border-color: #7CB69A;
            color: #16834F;
        }

        .action-detail:hover {
            background: #EAF5EE;
            color: #126B40;
        }

        /* Edit */
        .action-edit {
            border-color: #aebfb5;
            color: #39765f;
        }

        /* Hapus */
        .action-delete {
            border-color: #FF7777;
            color: #E53945;
        }

        .action:hover {
            background: #f4f8f5;
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

        @media (max-width: 768px) {
            .cover-table-card {
                padding: 12px;
            }

            .cover-table {
                min-width: 650px;
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