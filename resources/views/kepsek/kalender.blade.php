
@extends('layouts.app')

@section('title', 'Kalender Akademik')

@section('content')
<style>
    .kepsek-kalender {
        width: 100%;
        min-width: 0;
        color: #26332f;
        font-family: inherit;
    }

    .kepsek-kalender *,
    .kepsek-kalender *::before,
    .kepsek-kalender *::after {
        box-sizing: border-box;
    }

    .kalender-heading {
        margin-bottom: 27px;
    }

    .kalender-heading h3 {
        margin: 0;
        color: #17211f;
        font-size: 24px;
        font-weight: 700;
    }

    .kalender-heading p {
        margin: 3px 0 0;
        color: #52665e;
        font-size: 12px;
    }

    .kalender-pdf-wrapper {
        width: 100%;
        height: 560px;
        overflow: hidden;
        background: #26332f;
        border: 1px solid #d5ded9;
        border-radius: 4px;
    }

    .kalender-pdf {
        display: block;
        width: 100%;
        height: 100%;
        border: 0;
        background: #26332f;
    }

    .kalender-pdf-empty {
        display: flex;
        height: 100%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 24px;
        color: #fff;
        text-align: center;
    }

    .kalender-pdf-empty i {
        font-size: 42px;
        color: #cbd8d1;
    }

    .kalender-pdf-empty h4 {
        margin: 0;
        font-size: 16px;
    }

    .kalender-pdf-empty p {
        max-width: 420px;
        margin: 0;
        color: #d5dfda;
        font-size: 12px;
        line-height: 1.7;
    }

    .kalender-pdf-empty code {
        padding: 3px 6px;
        color: #e4f5eb;
        background: #3b4b44;
        border-radius: 4px;
    }

    .kalender-open-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 5px;
        padding: 9px 13px;
        color: #fff;
        background: #176b48;
        border-radius: 5px;
        font-size: 11px;
        text-decoration: none;
    }

    .kalender-open-link:hover {
        background: #12583b;
        color: #fff;
    }

    @media (max-width: 700px) {
        .kalender-heading h3 {
            font-size: 21px;
        }

        .kalender-heading {
            margin-bottom: 20px;
        }

        .kalender-pdf-wrapper {
            height: 460px;
        }
    }
</style>

<div class="kepsek-kalender">

    <div class="kalender-heading">
        <h3>Kalender Akademik</h3>
        <p>Dokumen kalender akademik tahun ajaran berjalan</p>
    </div>

    <div class="kalender-pdf-wrapper">
        @if (file_exists(public_path('dokumen/kalender-akademik.pdf')))
            <iframe
                class="kalender-pdf"
                src="{{ asset('dokumen/kalender-akademik.pdf') }}#toolbar=1&navpanes=1&view=FitH"
                title="Dokumen Kalender Akademik"
            ></iframe>
        @else
            <div class="kalender-pdf-empty">
                <i class="bi bi-file-earmark-pdf"></i>

                <h4>Dokumen Kalender Akademik</h4>

                <p>
                    File PDF kalender akademik belum ditemukan.
                    Letakkan dokumen kalender sekolah pada folder
                    <code>public/dokumen/kalender-akademik.pdf</code>
                    agar tampil di halaman ini.
                </p>
            </div>
        @endif
    </div>

</div>
@endsection
