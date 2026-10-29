@extends('layouts.app')

@section('title', 'Catatan Revisi Jurnal')

@section('content')
<div class="jurnal-page">

    {{-- Header Halaman --}}
    <div class="jurnal-page-header">
        <div>
            <h2>Jurnal Harian Guru</h2>
            <p>Dokumentasikan setiap kegiatan pembelajaran dengan mudah dan rapi.</p>
        </div>
    </div>

    {{-- Konten Catatan Revisi --}}
    <div class="catatan-revisi-page">

        {{-- Informasi Tahun Ajaran --}}
        <div class="tahun-ajaran-card">
            <h3>Tahun Ajaran 2025/2026</h3>
            <p>Semester Ganjil</p>
        </div>

        {{-- Catatan Kepala Sekolah --}}
        <div class="catatan-section">
            <h4>Catatan Kepala Sekolah</h4>

            <div class="catatan-box">
                <p>
                    Terima kasih jurnalnya, Bu Putri. Mohon maaf ini saya kembalikan
                    dulu sebentar ya. Sepertinya ada sedikit kekeliruan pada pemilihan
                    jam pelajaran di aplikasinya. Coba dicek kembali jam yang diinput
                    hari ini ya, Bu. Kalau sudah diperbaiki, silakan diajukan lagi.
                    Semangat!
                </p>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="catatan-actions">
            <a href="{{ route('guru.jurnal-harian') }}" class="btn-kembali">
                KEMBALI
            </a>

            <a href="{{ route('guru.edit-jurnal') }}" class="btn-ajukan-ulang">
                AJUKAN ULANG
            </a>
        </div>

    </div>
</div>

<style>
    /* Halaman Utama */
    .jurnal-page {
        width: 100%;
        color: #222222;
        font-family: inherit;
    }

    /* Header Halaman - disamakan dengan halaman Jurnal Harian */
    .jurnal-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 18px;
    }

    .jurnal-page-header h2 {
        margin: 0 0 5px;
        font-size: 26px;
        font-weight: 650;
        color: #111111;
    }

    .jurnal-page-header p {
        margin: 0;
        font-size: 12px;
        color: #555555;
    }

    /* Konten Catatan Revisi */
    .catatan-revisi-page {
        width: 100%;
        padding: 0 4px 24px;
        color: #26332F;
    }

    /* Kartu Tahun Ajaran */
    .tahun-ajaran-card {
        width: 100%;
        min-height: 85px;
        padding: 19px 15px;
        margin-bottom: 14px;
        background: #FFFFFF;
        border: 1px solid #A8C2B5;
        border-radius: 11px;
        box-shadow: 0 2px 3px rgba(38, 51, 47, 0.16);
        box-sizing: border-box;
    }

    .tahun-ajaran-card h3 {
        margin: 0 0 2px;
        font-size: 22px;
        font-weight: 600;
        line-height: 1.35;
        color: #111111;
    }

    .tahun-ajaran-card p {
        margin: 0;
        font-size: 12px;
        color: #929292;
    }

    /* Bagian Catatan Kepala Sekolah */
    .catatan-section {
        padding: 0 16px;
    }

    .catatan-section h4 {
        margin: 0 0 17px;
        font-size: 20px;
        font-weight: 700;
        color: #111111;
    }

    .catatan-box {
        display: flex;
        align-items: flex-start;
        width: 100%;
        min-height: 172px;
        padding: 19px 21px;
        background: #FFFFFF;
        border: 1px solid #A8A8A8;
        border-radius: 12px;
        box-sizing: border-box;
    }

    .catatan-box p {
        margin: 0;
        font-size: 18px;
        line-height: 1.65;
        font-weight: 400;
        color: #111111;
    }

    /* Tombol Aksi */
    .catatan-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 16px;
        padding: 0 22px;
        margin-top: 22px;
    }

    .catatan-actions a {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-width: 113px;
        min-height: 34px;
        padding: 7px 20px;
        border-radius: 22px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.2;
        box-sizing: border-box;
        transition: background-color 0.2s ease;
    }

    /* Tombol Kembali */
    .btn-kembali {
        background: #D6D6D6;
        color: #696969;
    }

    .btn-kembali:hover {
        background: #C5C5C5;
        color: #555555;
    }

    /* Tombol Ajukan Ulang */
    .btn-ajukan-ulang {
        background: #FF9848;
        color: #A95616;
    }

    .btn-ajukan-ulang:hover {
        background: #F18835;
        color: #87430E;
    }

    /* Tampilan Tablet dan HP */
    @media (max-width: 768px) {
        .jurnal-page-header {
            margin-bottom: 16px;
        }

        .jurnal-page-header h2 {
            font-size: 23px;
        }

        .catatan-revisi-page {
            padding: 0 0 24px;
        }

        .tahun-ajaran-card {
            padding: 16px 13px;
        }

        .tahun-ajaran-card h3 {
            font-size: 19px;
        }

        .catatan-section {
            padding: 0 8px;
        }

        .catatan-section h4 {
            margin-bottom: 12px;
            font-size: 18px;
        }

        .catatan-box {
            min-height: 150px;
            padding: 16px;
        }

        .catatan-box p {
            font-size: 15px;
            line-height: 1.6;
        }

        .catatan-actions {
            gap: 10px;
            padding: 0 8px;
            margin-top: 18px;
        }

        .catatan-actions a {
            min-width: 0;
            padding: 9px 17px;
            font-size: 12px;
        }
    }

    /* Tampilan HP Kecil */
    @media (max-width: 380px) {
        .jurnal-page-header h2 {
            font-size: 21px;
        }

        .catatan-actions {
            gap: 8px;
        }

        .catatan-actions a {
            padding: 9px 13px;
        }
    }
</style>
@endsection