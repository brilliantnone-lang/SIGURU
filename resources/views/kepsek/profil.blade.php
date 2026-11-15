@extends('layouts.app')

@section('title', 'TTD Digital')

@section('content')

    <div class="ttd-heading">
        <div>
            <h1>TTD Digital</h1>
            <p>Kelola tanda tangan digital untuk pengesahan jurnal mengajar.</p>
        </div>
    </div>

    <div class="ttd-container">
        <div class="ttd-card">
            <div class="ttd-card-heading">
                <i class="bi bi-pen"></i>
                <div>
                    <h3>Tanda Tangan Digital</h3>
                    <p>Unggah tanda tangan Kepala Sekolah untuk pengesahan jurnal.</p>
                </div>
            </div>
            <div class="ttd-preview">
                @if($user->ttd_kepsek)
                    <img src="{{ asset('storage/' . $user->ttd_kepsek) }}" alt="TTD" id="ttdPreview"
                        onerror="console.error('Gagal memuat gambar TTD:', this.src)">
                    <p>Tanda tangan saat ini</p>
                @else
                    <div class="ttd-empty" id="ttdEmpty">
                        <i class="bi bi-image"></i>
                        <strong>Belum ada tanda tangan yang diunggah.</strong>
                    </div>
                    <img id="ttdPreview" alt="Pratinjau tanda tangan" style="display:none;">
                @endif
        </div>

        <form action="{{ route('kepsek.profil.ttd') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ttd-upload-group">
                <label>Unggah TTD Baru <span>(PNG/JPG)</span></label>

                <label for="ttd_kepsek" class="ttd-upload-box">
                    <input type="file" name="ttd_kepsek" id="ttd_kepsek" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                        required>

                    <div class="ttd-upload-content" id="ttdUploadContent">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <strong>Klik tombol untuk memilih file</strong>
                        <span>PNG atau JPG - Batas Ukuran 2 MB</span>
                    </div>

                    <div class="ttd-selected-file" id="ttdSelectedFile" hidden>
                        <i class="bi bi-file-earmark-check"></i>
                        <strong id="ttdFileName"></strong>
                        <span id="ttdFileSize"></span>
                        <small>Klik area ini untuk mengganti file</small>
                    </div>
                </label>

                <small>
                    <i class="bi bi-info-circle"></i>
                    Disarankan menggunakan PNG dengan latar belakang transparan.
                </small>
            </div>
            <div class="ttd-form-actions">
                <button type="submit" class="ttd-save-button">
                    Simpan TTD
                </button>
            </div>
        </form>
    </div>
    </div>

    {{-- POPUP BERHASIL DISIMPAN --}}
    @if(session('success'))
        <div class="success-modal-overlay" id="successModal">
            <div class="success-modal">
                <div class="success-modal-header"></div>

                <div class="success-modal-content">
                    <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <h3>Berhasil Disimpan!</h3>
                    <p>{{ session('success') }}</p>

                    <div class="success-modal-actions">
                        <button type="button" class="success-ok-button" onclick="closeSuccessModal()">Oke</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
    <style>
        /* TTD DIGITAL */
        .ttd-heading {
            margin-bottom: 20px;
        }

        .ttd-heading h1 {
            margin: 0 0 5px;
            color: #111;
            font-size: 26px;
            font-weight: 650;
        }

        .ttd-heading p {
            margin: 0;
            color: #555;
            font-size: 12px;
        }

        .ttd-container {
            width: 100%;
        }

        .ttd-card {
            width: 100%;
            padding: 24px;
            background: #fff;
            border: 1px solid #E1ECE6;
            border-radius: 12px;
        }

        .ttd-card-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .ttd-card-heading>i {
            display: flex;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #e5f6eb;
            color: #39765f;
            font-size: 20px;
        }

        .ttd-card-heading h3 {
            margin: 0;
            color: #26332f;
            font-size: 17px;
            font-weight: 700;
        }

        .ttd-card-heading p {
            margin: 4px 0 0;
            color: #7a8780;
            font-size: 11px;
        }

        .ttd-preview {
            display: flex;
            min-height: 190px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            padding: 20px;
            background: #f8faf9;
            border: 1px dashed #cbd9d1;
            border-radius: 10px;
        }

        .ttd-preview img {
            display: block;
            max-width: 100%;
            max-height: 140px;
            object-fit: contain;
        }

        .ttd-preview p {
            margin: 12px 0 0;
            color: #66756d;
            font-size: 11px;
        }

        .ttd-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-align: center;
        }

        .ttd-empty i {
            color: #80a995;
            font-size: 34px;
        }

        .ttd-empty strong {
            color: #40574f;
            font-size: 13px;
        }

        .ttd-empty span {
            color: #89958e;
            font-size: 11px;
        }

        .ttd-upload-group {
            margin-bottom: 22px;
        }

        .ttd-upload-group>label {
            display: block;
            margin-bottom: 10px;
            color: #26332f;
            font-size: 13px;
            font-weight: 600;
        }

        .ttd-upload-group>label span {
            color: #7a8780;
            font-weight: 400;
        }


        .ttd-upload-box {
            display: flex;
            width: 100%;
            min-height: 125px;
            padding: 18px;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 7px;
            color: #39765f;
            background: #eff9f4;
            border: 2px dashed #b9d9c8;
            border-radius: 10px;
            cursor: pointer;
            text-align: center;
            transition: background .2s ease, border-color .2s ease;
        }

        .ttd-upload-box:hover {
            background: #e5f4eb;
            border-color: #75b99a;
        }

        .ttd-upload-box input[type="file"] {
            display: none;
        }

        .ttd-upload-content,
        .ttd-selected-file {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 7px;
        }

        .ttd-upload-content i,
        .ttd-selected-file i {
            font-size: 34px;
        }

        .ttd-upload-content strong,
        .ttd-selected-file strong {
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .ttd-upload-content span,
        .ttd-selected-file span {
            color: #78847b;
            font-size: 11px;
        }

        .ttd-selected-file small {
            color: #39765f;
            font-size: 11px;
        }

        /* TOMBOL TTD DIGITAL */
        .ttd-form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 15px;
        }

        .ttd-save-button {
            display: inline-flex;
            min-height: 39px;
            padding: 8px 15px;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            font-family: inherit;
            font-size: 13px;
            color: white;
            background: #39745b;
            border: 1px solid #39745b;
            font-weight: 600;
            cursor: pointer;
        }

        .ttd-save-button:hover {
            color: white;
            background: #2d6049;
        }


        @media(max-width: 600px) {
            .ttd-card {
                padding: 16px;
            }

            .ttd-upload-box {
                align-items: flex-start;
                flex-direction: column;
            }

            .ttd-form-actions {
                justify-content: stretch;
            }

            .ttd-save-button {
                width: 100%;
            }
        }

        /* POPUP BERHASIL DISIMPAN */
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
            border: none;
            border-radius: 16px;
            background: #39765f;
            color: #fff;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        .success-ok-button:hover {
            background: #285943;
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
        function closeSuccessModal() {
            const modal = document.getElementById('successModal');

            if (modal) {
                modal.style.display = 'none';
            }
        }

        const ttdInput = document.getElementById('ttd_kepsek');
        const ttdUploadContent = document.getElementById('ttdUploadContent');
        const ttdSelectedFile = document.getElementById('ttdSelectedFile');
        const ttdFileName = document.getElementById('ttdFileName');
        const ttdFileSize = document.getElementById('ttdFileSize');
        const ttdPreview = document.getElementById('ttdPreview');
        const ttdEmpty = document.getElementById('ttdEmpty');

        if (ttdInput) {
            let previewObjectUrl = null;

            ttdInput.addEventListener('change', function () {
                const file = this.files[0];

                if (!file) {
                    ttdUploadContent.hidden = false;
                    ttdSelectedFile.hidden = true;
                    return;
                }

                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    alert('File harus berformat JPG atau PNG.');
                    this.value = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2 MB.');
                    this.value = '';
                    return;
                }

                ttdUploadContent.hidden = true;
                ttdSelectedFile.hidden = false;

                ttdFileName.textContent = file.name;
                ttdFileSize.textContent =
                    (file.size / (1024 * 1024)).toFixed(2) + ' MB';

                if (ttdPreview) {
                    if (previewObjectUrl) {
                        URL.revokeObjectURL(previewObjectUrl);
                    }

                    previewObjectUrl = URL.createObjectURL(file);

                    ttdPreview.src = previewObjectUrl;
                    ttdPreview.style.display = 'block';

                    if (ttdEmpty) {
                        ttdEmpty.style.display = 'none';
                    }
                }
            });
        }
    </script>
@endpush