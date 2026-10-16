@extends('layouts.app')

@section('title', 'Data Cover - Jurnal Mengajar Guru')

@section('content')

    <h1>Data Cover</h1>
    <p class="subtitle">
        Atur identitas dan format halaman depan jurnal mengajar guru.
    </p>

    <div class="settings-card">
        <div class="settings-inner">
            <h2 class="settings-title">Pengaturan identitas</h2>
            <p class="settings-description">
                Perubahan langsung ditampilkan pada pratinjau cover
            </p>

            <div class="field-row">
                <div class="field">
                    <label class="field-label">Pemerintah Kota / Kabupaten</label>
                    <input class="input" value="PEMERINTAH KOTA BANJARMASIN" readonly>
                </div>

                <div class="field">
                    <label class="field-label">Dinas</label>
                    <input class="input" value="DINAS PENDIDIKAN" readonly>
                </div>
            </div>

            <div class="school-field">
                <label class="field-label">Nama Sekolah</label>
                <input class="input" value="SMP NEGERI 15 BANJARMASIN" readonly>
            </div>

            <label class="field-label upload-label">
                Logo sekolah / Tut Wuri Handayani
            </label>

            <div class="upload-box">
                <div class="upload-inner">
                    <svg class="cloud-icon" viewBox="0 0 32 28" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 21H6.5C3.5 21 1.5 18.8 1.5 16
                             C1.5 13.2 3.7 11 6.5 11
                             C7.4 6.6 11 4 15.5 4
                             C20.1 4 23.4 7 24 11
                             C27.6 10.9 30 13.1 30 16.2
                             C30 19 27.8 21 25 21H23" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 26V13M11.5 17.5L16 13L20.5 17.5" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <div class="upload-title">Upload Logo</div>
                    <div class="upload-text">
                        Klik untuk memilih file atau seret file ke sini
                    </div>
                    <div class="upload-text">
                        Format PNG, JPG - Maksimal 5 MB
                    </div>
                </div>
            </div>

            <p class="help-text">
                Unggah logo resmi berformat PNG atau JPG untuk ditampilkan pada cover.
            </p>

            <div class="button-row">
                <button class="save-button" type="button">
                    Simpan Pengaturan
                </button>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* ====== CSS khusus halaman Data Cover ====== */
    .settings-card {
        min-height: 325px;
        padding: 20px;
        border: 1px solid #E1ECE6;
        border-radius: 12px;
        background: #FFFFFF;
    }

    .settings-inner {
        padding: 10px 12px 14px;
        border-radius: 6px;
        background: rgba(228, 236, 231, 0.12);
    }

    .settings-title {
        margin: 0 0 5px;
        color: #173D2B;
        font-size: 18px;
        font-weight: 600;
    }

    .settings-description {
        margin: 0 0 22px;
        color: #5D756B;
        font-size: 12px;
    }

    .field-label {
        display: block;
        margin-bottom: 7px;
        color: #173D2B;
        font-size: 13px;
        font-weight: 600;
    }

    .field-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 22px;
        margin-bottom: 16px;
    }

    .field { min-width: 0; }

    .input {
        display: block;
        width: 100%;
        height: 42px;
        padding: 9px 12px;
        border: 1px solid #E1ECE6;
        border-radius: 5px;
        outline: none;
        background: #FFFFFF;
        color: #40574F;
        font: inherit;
        font-size: 13px;
    }

    .school-field { margin-bottom: 16px; }

    .upload-label { margin-bottom: 9px; }

    .upload-box {
        height: 180px;
        margin: 0 3px 18px;
        padding: 12px;
        border: 1px solid #E1ECE6;
        border-radius: 10px;
        background: #FFFFFF;
    }

    .upload-inner {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        border: 1px dashed #E1ECE6;
        border-radius: 8px;
        color: #173D2B;
    }

    .cloud-icon {
        width: 42px;
        height: 36px;
        margin-bottom: 7px;
    }

    .upload-title {
        margin-bottom: 5px;
        color: #173D2B;
        font-size: 14px;
        font-weight: 600;
    }

    .upload-text {
        color: #40574F;
        font-size: 13px;
        line-height: 1.6;
    }

    .help-text {
        margin: 0 0 24px;
        color: #5D756B;
        font-size: 12px;
    }

    .button-row {
        display: flex;
        justify-content: flex-end;
    }

    .save-button {
        width: 42%;
        min-height: 44px;
        border: none;
        border-radius: 6px;
        background: #0A4C2E;
        color: #FFFFFF;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    @media (max-width: 900px) {
        .field-row {
            grid-template-columns: 1fr;
            gap: 14px;
        }
    }

    @media (max-width: 600px) {
        .settings-card { padding: 10px; }
        .save-button { width: 100%; }
    }
</style>
@endpush