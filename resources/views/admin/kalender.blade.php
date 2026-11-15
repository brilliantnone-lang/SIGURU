@extends('layouts.app')

@section('title', 'Kalender Akademik - SIGURU')

@section('content')
    <div class="admin-kalender">

        <div class="kalender-heading">
            <div>
                <h1>Kalender Akademik</h1>
                <p>Mengelola dokumen kalender akademik sekolah</p>
            </div>
            <a href="{{ route('admin.kalender.create') }}" class="btn-tambah-kalender" style="text-decoration:none;">
                <span>＋</span> Tambah Kalender
            </a>
        </div>

        @if(session('success'))
            <div
                style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #bbf7d0;">
                {{ session('success') }}
            </div>
        @endif

        <section class="kalender-table-panel">
            <div class="kalender-table-scroll">
                <table class="kalender-table">
                    <thead>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Periode Aktif</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kalenders as $k)
                            <tr>
                                <td><strong>{{ $k->tahun_ajaran }}</strong></td>
                                <td><span
                                        style="background:#E1ECE6; padding:3px 8px; border-radius:4px; font-size:10px; font-weight:600;">{{ $k->semester }}</span>
                                </td>
                                <td style="font-size:11px;">
                                    {{ $k->tanggal_mulai->format('d M Y') }} - {{ $k->tanggal_selesai->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="nama-file-kalender">{{ $k->nama_file }}</span>
                                </td>

                                <td>
                                    <div class="kalender-actions">
                                        <a href="{{ asset('storage/' . $k->path_file) }}" target="_blank"
                                            class="kalender-action action-view" title="Lihat kalender">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <a href="{{ route('admin.kalender.edit', $k->id) }}" class="kalender-action action-edit"
                                            title="Edit kalender">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <form action="{{ route('admin.kalender.destroy', $k->id) }}" method="POST"
                                            class="delete-form" style="display:inline; margin:0; padding:0;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="kalender-action action-delete" title="Hapus kalender"
                                                onclick="showDeleteModal(this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:40px; color:#888;">Belum ada dokumen kalender
                                    akademik.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>


    {{-- POPUP KONFIRMASI HAPUS --}}
    <div class="delete-modal-overlay" id="deleteModal" style="display: none;">
        <div class="delete-modal">
            <div class="delete-modal-header"></div>

            <div class="delete-modal-content">
                <div class="delete-icon">
                    <i class="bi bi-trash"></i>
                </div>

                <h3>Hapus Kalender Akademik?</h3>
                <p>Apakah kamu yakin ingin menghapus dokumen kalender akademik ini?</p>

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


    <style>
        <style>.admin-kalender {
            width: 100%;
            min-width: 0;
            color: #263b35;
            font-family: inherit;
        }

        .admin-kalender *,
        .admin-kalender *::before,
        .admin-kalender *::after {
            box-sizing: border-box;
        }

        /* ===== HEADING ===== */
        .kalender-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 17px;
        }

        .kalender-heading h1 {
            margin: 0;
            color: #17211f;
            font-size: 25px;
            font-weight: 700;
            line-height: 1.35;
        }

        .kalender-heading p {
            margin: 3px 0 0;
            color: #52665e;
            font-size: 12px;
        }

        /* ===== TOMBOL TAMBAH ===== */
        .btn-tambah-kalender {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 36px;
            padding: 0 13px;
            color: #fff;
            background: #39765c;
            border: 1px solid #39765c;
            border-radius: 5px;
            font: inherit;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-tambah-kalender span {
            font-size: 18px;
            line-height: 1;
        }

        .btn-tambah-kalender:hover {
            background: #2e624e;
            color: #fff;
        }

        /* ===== PANEL TABEL ===== */
        .kalender-table-panel {
            padding: 12px;
            background: #fff;
            border: 1px solid #e2eae5;
            border-radius: 5px;
        }

        .kalender-table-scroll {
            width: 100%;
            overflow-x: auto;
        }

        .kalender-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            text-align: center;
        }

        .kalender-table thead {
            background: #f0f5f2;
        }

        .kalender-table th {
            padding: 10px;
            color: #52665c;
            font-size: 11px;
            font-weight: 600;
        }

        .kalender-table td {
            padding: 12px;
            color: #394c42;
            border-bottom: 1px solid #edf1ee;
            vertical-align: middle;
        }

        .kalender-table tbody tr:last-child td {
            border-bottom: none;
        }

        .nama-file-kalender {
            overflow-wrap: anywhere;
        }

        /* ===== AKSI KALENDER ===== */
        .kalender-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }

        .kalender-action {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 31px;
            height: 31px;
            padding: 0;
            border: 1px solid;
            border-radius: 7px;
            background: #fff;
            text-decoration: none;
            font-size: 19px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .kalender-action.action-view,
        .kalender-action.action-edit {
            border-color: #aebfb5;
            color: #39765f;
        }

        .kalender-action.action-delete {
            border-color: #ff7777;
            color: #ff3333;
        }

        .kalender-action:hover {
            background: #f4f8f5;
            text-decoration: none;
        }


        /* ===== POPUP KONFIRMASI HAPUS ===== */
        .delete-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.25);
        }

        .delete-modal {
            box-sizing: border-box;
            width: 100%;
            max-width: 470px;
            overflow: hidden;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            text-align: center;
            animation: modalAppear 0.25s ease;
        }

        .delete-modal-header {
            width: 100%;
            height: 30px;
            background: #FF0000;
        }

        .delete-modal-content {
            padding: 10px 20px 20px;
        }

        .delete-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 65px;
            height: 65px;
            margin: 0 auto 10px;
            color: #FF0000;
            font-size: 65px;
        }

        .delete-modal-content h3 {
            margin: 5px 0 10px;
            color: #FF0000;
            font-size: 27px;
            font-weight: 700;
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
            min-height: 48px;
            border: none;
            border-radius: 16px;
            font-family: inherit;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
        }

        .delete-cancel-button {
            background: #eee;
            color: #555;
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
                opacity: 0;
                transform: scale(.92);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }


        /* ===== RESPONSIF ===== */
        @media (max-width: 700px) {
            .kalender-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .kalender-heading h1 {
                font-size: 22px;
            }

            .kalender-table {
                min-width: 650px;
            }
        }
    </style>


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


@endsection