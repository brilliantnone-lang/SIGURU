@extends('layouts.app')

@section('title', 'Jurnal Harian Guru')

@section('content')
<div class="jurnal-page">

    {{-- HEADER HALAMAN --}}
    <div class="jurnal-page-header">
        <div>
            <h2>Jurnal Harian Guru</h2>
            <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
        </div>

        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            {{-- 🔧 DIPERBAIKI: tombol menu jurnal penggantian --}}
            <a href="{{ route('guru.jurnal-penggantian') }}" class="btn-tambah-jurnal"
                style="background:#fff; color:#39765f; border:1px solid #39765f;">
                <i class="bi bi-people-fill"></i>
                <span>Jurnal Penggantian</span>
            </a>

            <a href="{{ route('guru.tambah-jurnal') }}" class="btn-tambah-jurnal">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Jurnal</span>
            </a>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
    <div class="jurnal-alert alert-success">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="jurnal-alert alert-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        {{ session('error') }}
    </div>
    @endif

    {{-- VALIDASI JURNAL --}}
    <section class="jurnal-section validation-section">

        <div class="section-heading">
            <div class="heading-icon">
                <i class="bi bi-clipboard-check"></i>
            </div>

            <div>
                <h3>Validasi Jurnal</h3>
                <p>Rekap status dan tindak lanjut jurnal Anda.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="jurnal-table validation-table">
                <thead>
                    <tr>
                        <th>Semester</th>
                        <th>Tahun Ajaran</th>
                        <th>Status Jurnal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $kelompokValidasi = $jurnals->groupBy(function ($jurnal) {
                    return $jurnal->cover_jurnal_id ?? 'tanpa-cover';
                    });
                    @endphp

                    @forelse($kelompokValidasi as $kelompok)
                    @php
                    $jurnalPertama = $kelompok->first();
                    $cover = $jurnalPertama->coverJurnal;

                    $jurnalRevisi = $kelompok->firstWhere('status_validasi', 'menunggu_revisi');
                    $adaRevisi = $jurnalRevisi !== null;
                    $semuaValid = $kelompok->every(fn($jurnal) => $jurnal->status_validasi === 'valid');
                    $sudahRevisi = !$adaRevisi && $kelompok->contains('status_validasi', 'sudah_revisi');
                    @endphp

                    <tr>
                        <td>{{ $cover->semester ?? '-' }}</td>
                        <td>{{ $cover->tahun_ajaran ?? '-' }}</td>

                        <td>
                            @if($adaRevisi)
                            <span class="validation-status status-revision">
                                Perlu Revisi
                            </span>
                            @elseif($semuaValid)
                            <span class="validation-status status-approved">
                                Sudah Divalidasi
                            </span>
                            @elseif($sudahRevisi)
                            <span class="validation-status status-revised">
                                Sudah Direvisi
                            </span>
                            @else
                            <span class="validation-status status-process">
                                Sedang Berjalan
                            </span>
                            @endif
                        </td>

                        <td>
                            <div class="validation-actions">
                                @if($adaRevisi)
                                <a href="{{ route('guru.catatan-revisi', $jurnalRevisi->id) }}"
                                    class="validation-action action-revision" title="Ikuti catatan perbaikan">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Ikuti Catatan Perbaikan</span>
                                </a>
                                @elseif($semuaValid && $jurnalPertama->cover_jurnal_id)
                                <a href="{{ route('guru.export-jurnal-pdf', ['cover_id' => $jurnalPertama->cover_jurnal_id]) }}"
                                    class="validation-action action-export" target="_blank" title="Ekspor PDF">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                    <span>Ekspor PDF</span>
                                </a>
                                @elseif($semuaValid)
                                <span class="validation-dash">-</span>
                                @else
                                <span class="validation-dash">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-validation">
                            Belum ada jurnal untuk ditampilkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- RIWAYAT JURNAL --}}
    <section class="jurnal-section history-section">

        <div class="section-heading history-heading">
            <div class="heading-icon">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>

            <div>
                <h3>Riwayat Jurnal</h3>
                <p>{{ $jurnals->count() }} catatan jurnal tersimpan</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="jurnal-table history-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kelas/Jam</th>
                        <th>Pokok Bahasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    // 🔧 DIPERBAIKI: id guru login untuk cek hak akses
                    $guruLoginId = auth()->user()->guru->id ?? null;
                    @endphp

                    @forelse($jurnals as $j)
                    <tr>
                        <td class="date-cell">
                            {{ $j->tanggal
                                        ? \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y')
                                        : '-' }}
                        </td>

                        <td class="class-cell">
                            <strong>
                                {{ $j->kelas->nama_kelas ?? '-' }}
                            </strong>

                            <small>
                                Jam ke {{ $j->jam_mulai_ke }}-{{ $j->jam_selesai_ke }}
                                {{ $j->jadwal->mataPelajaran->nama_mata_pelajaran ?? '' }}
                            </small>

                            {{-- 🔧 DIPERBAIKI: badge status penggantian --}}
                            @if($j->status_penggantian === 'menunggu_diisi')
                            <span class="history-status" style="background:#fef3c7; color:#92400e;">
                                ⏳ Menunggu diisi {{ $j->guruPengganti->user->name ?? 'guru pengganti' }}
                            </span>
                            @elseif($j->status_penggantian === 'belum_direvisi')
                            <span class="history-status" style="background:#dbeafe; color:#1d4ed8;">
                                🔄 Perlu direvisi {{ $j->guruPengganti->user->name ?? 'guru pengganti' }}
                            </span>
                            @elseif($j->status_penggantian === 'selesai_diisi')
                            <span class="history-status" style="background:#dcfce7; color:#166534;">
                                ✅ Diisi oleh {{ $j->guruPengganti->user->name ?? 'guru pengganti' }}
                            </span>
                            @endif
                        </td>

                        <td class="topic-cell">
                            {{ $j->pokok_bahasan }}
                        </td>

                        <td>
                            @if($j->status_validasi === 'valid')
                            <span class="history-status status-approved">
                                Tuntas
                            </span>
                            @elseif($j->status_validasi === 'menunggu_revisi')
                            <span class="history-status status-revision">
                                Perlu Revisi
                            </span>
                            @elseif($j->status_validasi === 'sudah_revisi')
                            <span class="history-status status-revised">
                                Sudah Direvisi
                            </span>
                            @else
                            <span class="history-status status-process">
                                Sedang Berjalan
                            </span>
                            @endif
                        </td>

                        <td>
                            @php
                            $bolehEdit = false;

                            if ($j->status_validasi !== 'valid') {
                            if ($j->status_penggantian === 'menunggu_diisi') {
                            // Hanya guru pengganti yang bisa isi
                            $bolehEdit = $j->guru_pengganti_id === $guruLoginId;
                            } else {
                            // Jurnal biasa / selesai_diisi → pemilik atau pengganti
                            $bolehEdit = ($j->guru_id === $guruLoginId)
                            || ($j->guru_pengganti_id === $guruLoginId);
                            }
                            }
                            @endphp

                            <div class="history-actions">

                                {{-- LIHAT JURNAL (selalu tersedia) --}}
                                <a href="{{ route('guru.lihat-jurnal', $j->id) }}" class="icon-action action-detail"
                                    title="Lihat jurnal" aria-label="Lihat jurnal">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                {{-- 🔧 DIPERBAIKI: EDIT hanya kalau berhak --}}
                                @if($bolehEdit)
                                <a href="{{ route('guru.edit-jurnal', $j->id) }}" class="icon-action action-edit"
                                    title="Edit jurnal" aria-label="Edit jurnal">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- HAPUS JURNAL --}}
                                <form action="{{ route('guru.jurnal.destroy', $j->id) }}" method="POST"
                                    class="delete-form" style="display:inline; margin:0; padding:0;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="icon-action action-delete" title="Hapus jurnal"
                                        aria-label="Hapus jurnal" onclick="showDeleteModal(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-history">
                            <i class="bi bi-journal-x"></i>
                            <strong>Belum ada jurnal</strong>
                            <span>Silakan klik Tambah Jurnal untuk membuat catatan baru.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- RINGKASAN BAWAH TABEL --}}
        <div class="table-footer">
            <span>
                Menampilkan
                {{ $jurnals->count() > 0 ? '1-' . $jurnals->count() : '0' }}
                dari {{ $jurnals->count() }} jurnal
            </span>
        </div>

    </section>

</div>

{{-- POPUP KONFIRMASI HAPUS JURNAL --}}
<div class="delete-modal-overlay" id="deleteModal" style="display: none;">
    <div class="delete-modal">
        <div class="delete-modal-header"></div>

        <div class="delete-modal-content">
            <div class="delete-icon">
                <i class="bi bi-trash"></i>
            </div>

            <h3>Hapus Jurnal?</h3>

            <p>Apakah kamu yakin ingin menghapus jurnal ini?</p>

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
    /* ============================
           HALAMAN JURNAL GURU
        ============================ */

    .jurnal-page {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    .jurnal-page *,
    .jurnal-page *::before,
    .jurnal-page *::after {
        box-sizing: border-box;
    }

    .jurnal-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 18px;
    }

    .jurnal-page-header h2 {
        margin: 0 0 5px;
        color: #173d2b;
        font-size: 26px;
        font-weight: 700;
        line-height: 1.3;
    }

    .jurnal-page-header p {
        margin: 0;
        color: #77827b;
        font-size: 12px;
    }

    .btn-tambah-jurnal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 12px;
        border: 1px solid #39765f;
        border-radius: 5px;
        background: #39765f;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s ease;
    }

    .btn-tambah-jurnal:hover {
        background: #2e624e;
        color: #fff;
    }

    /* ============================
           NOTIFIKASI
        ============================ */

    .jurnal-alert {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 15px;
        padding: 11px 14px;
        border: 1px solid;
        border-radius: 7px;
        font-size: 12px;
    }

    .alert-success {
        color: #166534;
        background: #dcfce7;
        border-color: #bbf7d0;
    }

    .alert-error {
        color: #991b1b;
        background: #fee2e2;
        border-color: #fecaca;
    }

    /* ============================
           KARTU SECTION
        ============================ */

    .jurnal-section {
        width: 100%;
        margin-bottom: 18px;
        overflow: hidden;
        border: 1px solid #c7d9cf;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .10);
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 10px 13px 7px;
    }

    .heading-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 24px;
        height: 28px;
        color: #39765f;
        font-size: 23px;
    }

    .section-heading h3 {
        margin: 0 0 2px;
        color: #252b27;
        font-size: 17px;
        font-weight: 700;
        line-height: 1.3;
    }

    .validation-dash {
        color: #9aa39d;
        font-size: 14px;
        font-weight: 700;
    }

    .validation-action.action-export {
        border-color: #b91c1c;
        color: #b91c1c;
    }

    .validation-action.action-export:hover {
        background: #fef2f2;
        color: #7f1d1d;
    }

    .section-heading p {
        margin: 0;
        color: #929b95;
        font-size: 10px;
    }

    /* ============================
           TABEL
        ============================ */

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .jurnal-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    .jurnal-table thead {
        background: #e1eee8;
    }

    .jurnal-table th {
        padding: 6px 10px;
        color: #77847c;
        font-size: 10px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .jurnal-table td {
        padding: 6px 10px;
        border-bottom: 1px solid #e8ece9;
        color: #333a35;
        font-size: 10px;
        vertical-align: middle;
    }

    .jurnal-table tbody tr:last-child td {
        border-bottom: none;
    }

    .jurnal-table tbody tr:hover {
        background: #fbfdfb;
    }

    /* ============================
           VALIDASI JURNAL
        ============================ */

    .validation-table th:first-child {
        width: 20%;
    }

    .validation-table th:nth-child(2) {
        width: 25%;
    }

    .validation-table th:nth-child(3) {
        width: 30%;
    }

    .validation-table th:last-child,
    .validation-table td:last-child {
        text-align: center;
    }

    .validation-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 5px;
        font-size: 9px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-approved {
        background: #dcfce7;
        color: #166534;
    }

    .status-revision {
        background: #ffe4e6;
        color: #be123c;
    }

    .status-revised {
        background: #e0f2fe;
        color: #0369a1;
    }

    .validation-table td:nth-child(3) {
        text-align: left;
    }

    .status-process {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .validation-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .validation-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        min-height: 23px;
        padding: 4px 7px;
        border: 1px solid #b9cec2;
        border-radius: 5px;
        background: #fff;
        color: #39765f;
        font-size: 9px;
        text-decoration: none;
        white-space: nowrap;
    }

    .validation-action:hover {
        background: #eff8f2;
        color: #285840;
    }

    .validation-action.action-revision {
        border-color: #e7b5a1;
        color: #b45309;
    }

    .validation-action.action-revision:hover {
        background: #fff7ed;
    }

    .empty-validation {
        padding: 15px !important;
        color: #89938d !important;
        text-align: center;
    }

    /* ============================
           RIWAYAT JURNAL
        ============================ */

    .history-heading {
        padding-top: 10px;
        padding-bottom: 7px;
    }

    .history-table th:first-child {
        white-space: nowrap;
    }

    .history-table th:nth-child(2) {
        min-width: 150px;
    }

    .history-table th:nth-child(3) {
        min-width: 130px;
    }

    .history-table th:nth-child(4) {
        min-width: 65px;
    }

    .history-table th:last-child,
    .history-table td:last-child {
        text-align: center;
    }

    .history-table .date-cell {
        white-space: nowrap;
        font-weight: 600;
    }

    .class-cell strong {
        display: block;
        margin-bottom: 3px;
        color: #303a33;
        font-size: 10px;
        font-weight: 700;
    }

    .class-cell small {
        display: block;
        color: #909991;
        font-size: 9px;
        line-height: 1.5;
    }

    .topic-cell {
        max-width: 230px;
        line-height: 1.5;
    }

    .history-status {
        display: inline-block;
        min-width: 56px;
        padding: 5px 8px;
        border-radius: 5px;
        font-size: 9px;
        text-align: center;
        white-space: nowrap;
    }

    .history-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .icon-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 31px;
        height: 31px;
        padding: 0;
        border: 1px solid;
        border-radius: 7px;
        background: #fff;
        font-size: 19px;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s ease;
    }

    .action-detail {
        border-color: #9ab7a7;
        color: #39765f;
    }

    .action-detail:hover {
        background: #e8f5ed;
        color: #285840;
    }

    .action-edit {
        border-color: #aebfb5;
        color: #39765f;
    }

    .action-edit:hover {
        background: #fff7ed;
        color: #285840;
    }

    .action-delete {
        border-color: #ff7777;
        color: #ff3333;
    }

    .action-delete:hover {
        background: #fff1f1;
        color: #dc2626;
    }

    /* ============================
           KOSONG & FOOTER
        ============================ */

    .empty-history {
        padding: 28px 15px !important;
        text-align: center;
    }

    .empty-history i {
        display: block;
        margin-bottom: 8px;
        color: #86a996;
        font-size: 25px;
    }

    .empty-history strong,
    .empty-history span {
        display: block;
    }

    .empty-history strong {
        margin-bottom: 5px;
        color: #3c5144;
        font-size: 12px;
    }

    .empty-history span {
        color: #8a938d;
        font-size: 10px;
    }

    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 30px;
        padding: 7px 10px;
        color: #737d76;
        font-size: 9px;
    }

    /* ============================
           POPUP KONFIRMASI HAPUS
        ============================ */

    .delete-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
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

    /* ============================
           RESPONSIVE
        ============================ */

    @media (max-width: 768px) {
        .jurnal-page-header h2 {
            font-size: 22px;
        }

        .jurnal-page-header p {
            max-width: 300px;
            line-height: 1.5;
        }

        .section-heading h3 {
            font-size: 15px;
        }

        .jurnal-table th,
        .jurnal-table td {
            padding: 7px 9px;
        }

        .topic-cell {
            min-width: 150px;
        }
    }

    @media (max-width: 480px) {
        .jurnal-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .jurnal-page-header h2 {
            font-size: 19px;
        }

        .jurnal-page-header p {
            font-size: 10px;
        }

        .btn-tambah-jurnal {
            padding: 7px 9px;
            font-size: 10px;
        }

        .btn-tambah-jurnal i {
            font-size: 11px;
        }

        .validation-action {
            font-size: 9px;
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
</script>

@endsection