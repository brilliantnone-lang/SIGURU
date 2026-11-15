@extends('layouts.app')

@section('title', 'Data Kelas - Jurnal Mengajar Guru')

@section('content')

    <div class="kelas-heading-row">
        <div>
            <h1>Data Kelas</h1>
            <p class="subtitle">Kelola data kelas dan siswa</p>
        </div>
        <a href="{{ route('admin.kelas.create') }}" class="add-kelas-button" style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Tambah Kelas
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

    <div class="kelas-table-card">
        <div class="kelas-table-wrap">
            <table class="kelas-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas ?? [] as $i => $k)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $k->nama_kelas }}</td>
                            <td>{{ $k->kapasitas }} Siswa</td>
                            <td>
                                <div class="kelas-actions">
                                    {{-- Tambah Siswa --}}
                                    <a href="{{ route('admin.murid.index', ['kelas_id' => $k->id]) }}"
                                        class="table-action add-siswa" title="Lihat / Tambah Siswa">
                                        <i class="bi bi-person-plus-fill"></i>
                                    </a>

                                    {{-- Edit Kelas --}}
                                    <a href="{{ route('admin.kelas.edit', $k->id) }}" class="table-action edit"
                                        title="Edit kelas">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    {{-- Hapus Kelas --}}
                                    <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" class="delete-form"
                                        style="display:inline; margin:0; padding:0;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="table-action delete" title="Hapus kelas"
                                            onclick="showDeleteModal(this)">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; padding:40px; color:#888;">Belum ada data kelas. Silakan
                                tambah baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="kelas-table-footer">
            <span>Menampilkan {{ count($kelas ?? []) }} data kelas</span>
        </div>
    </div>
    {{-- POPUP KONFIRMASI HAPUS KELAS --}}
    <div class="delete-modal-overlay" id="deleteModal" style="display: none;">
        <div class="delete-modal">
            <div class="delete-modal-header"></div>

            <div class="delete-modal-content">
                <div class="delete-icon">
                    <i class="bi bi-trash"></i>
                </div>

                <h3>Hapus Kelas?</h3>
                <p>Apakah kamu yakin ingin menghapus kelas ini?</p>

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
        /* HEADER - MENGIKUTI STANDAR DATA COVER */
        .kelas-heading-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 18px;
        }

        .kelas-heading-row h1 {
            margin: 0 0 5px;
            font-size: 26px;
            font-weight: 650;
            color: #111111;
        }

        .kelas-heading-row .subtitle {
            margin: 0;
            font-size: 12px;
            color: #555555;
        }

        .add-kelas-button {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 5px;
            border: 0;
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

        .add-kelas-button:hover {
            background: #285b46;
            color: #FFFFFF;
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
            font-size: 17px;
            line-height: 1;
            cursor: pointer;
            transition: background .15s ease;
        }

        .table-action.add-siswa {
            border-color: #C5C900;
            color: #C5C900;
            font-size: 16px;
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

        @media (max-width: 700px) {
            .kelas-heading-row {
                align-items: flex-start;
                flex-direction: row;
                justify-content: space-between;
                gap: 10px;
            }

            .kelas-heading-row>div {
                min-width: 0;
            }

            .kelas-heading-row h1 {
                font-size: 22px;
            }

            .add-kelas-button {
                flex-shrink: 0;
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