@extends('layouts.app')

@section('title', 'Validasi Jurnal')

@section('content')
<div class="form-validasi-page">

    {{-- Header Halaman --}}
    <div class="validasi-page-header">
        <div>
            <h2>Validasi Jurnal</h2>
            <p>Validasi atau revisi jurnal harian guru</p>
        </div>
    </div>

    {{-- Form Validasi --}}
    <div class="validasi-content">
        <form action="#" method="POST">
            @csrf

            <div class="form-group-catatan">
                <label for="catatan_validasi">Catatan (Opsional)</label>

                <textarea
                    name="catatan_validasi"
                    id="catatan_validasi"
                    placeholder="Tulis catatan disini jika perlu revisi ataupun tervalidasi"
                >{{ old('catatan_validasi') }}</textarea>
            </div>

            {{-- Tombol Aksi --}}
            <div class="validasi-actions">
                <button type="submit" name="status_validasi" value="valid"
                    class="btn-validasi">
                    Validasi
                </button>

                <button type="submit" name="status_validasi" value="menunggu_revisi"
                    class="btn-perbaikan">
                    Perlu Perbaikan
                </button>
            </div>
        </form>
    </div>

</div>

<style>
    /* Halaman Utama */
    .form-validasi-page {
        width: 100%;
        color: #26332F;
        font-family: inherit;
    }

    /* Header Halaman */
    .validasi-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 22px;
    }

    .validasi-page-header h2 {
        margin: 0 0 5px;
        font-size: 26px;
        font-weight: 650;
        color: #111111;
    }

    .validasi-page-header p {
        margin: 0;
        font-size: 12px;
        color: #888888;
    }

    /* Konten Form */
    .validasi-content {
        width: 100%;
        padding: 0 4px;
        box-sizing: border-box;
    }

    .form-group-catatan {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .form-group-catatan label {
        margin-bottom: 7px;
        font-size: 20px;
        font-weight: 700;
        color: #111111;
    }

    .form-group-catatan textarea {
        display: block;
        width: 100%;
        min-height: 290px;
        padding: 14px;
        border: 1px solid #BDBDBD;
        border-radius: 7px;
        background: #FFFFFF;
        color: #26332F;
        font-family: inherit;
        font-size: 16px;
        line-height: 1.6;
        resize: vertical;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-group-catatan textarea::placeholder {
        color: #AAAAAA;
        opacity: 1;
    }

    .form-group-catatan textarea:focus {
        border-color: #8AB9A2;
        box-shadow: 0 0 0 3px rgba(138, 185, 162, 0.15);
    }

    /* Tombol Aksi */
    .validasi-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-top: 22px;
        padding: 0 12px;
    }

    .validasi-actions button {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-height: 50px;
        padding: 10px 28px;
        border: none;
        border-radius: 17px;
        font-family: inherit;
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    /* Tombol Validasi */
    .btn-validasi {
        min-width: 140px;
        background: #91E8C3;
        color: #39765F;
    }

    .btn-validasi:hover {
        background: #7ADCB3;
    }

    /* Tombol Perlu Perbaikan */
    .btn-perbaikan {
        min-width: 230px;
        background: #FF9848;
        color: #A95616;
    }

    .btn-perbaikan:hover {
        background: #F18835;
        color: #87430E;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .validasi-page-header {
            margin-bottom: 18px;
        }

        .validasi-page-header h2 {
            font-size: 23px;
        }

        .validasi-content {
            padding: 0;
        }

        .form-group-catatan label {
            font-size: 18px;
        }

        .form-group-catatan textarea {
            min-height: 240px;
            padding: 12px;
            font-size: 15px;
        }

        .validasi-actions {
            gap: 12px;
            padding: 0 4px;
            margin-top: 18px;
        }

        .validasi-actions button {
            min-width: 0;
            min-height: 44px;
            padding: 10px 18px;
            border-radius: 14px;
            font-size: 15px;
        }

        .btn-validasi {
            flex: 0.8;
        }

        .btn-perbaikan {
            flex: 1.4;
        }
    }

    /* HP Kecil */
    @media (max-width: 380px) {
        .validasi-actions {
            gap: 8px;
        }

        .validasi-actions button {
            padding: 9px 12px;
            font-size: 13px;
        }
    }
</style>
@endsection