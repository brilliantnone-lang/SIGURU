
@extends('layouts.app')

@section('title', 'Kalender Akademik')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<div class="kalender-page">

    {{-- Header --}}
    <div class="kalender-header">
        <h2>Kalender Akademik</h2>
        <p>Dokumen kalender akademik tahun ajaran berjalan</p>
    </div>

    {{-- Pratinjau Dokumen --}}
    <section class="kalender-document">
        <div class="pdf-toolbar">
            <div class="pdf-menu">
                <i class="bi bi-list"></i>
                <span>Kalender Akademik.pdf</span>
            </div>

            <div class="pdf-controls">
                <button type="button" class="pdf-control" id="pdf-prev" aria-label="Halaman sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span class="pdf-page-number">
                    <span id="current-page">1</span>
                    <span>/</span>
                    <span id="total-pages">1</span>
                </span>
                <button type="button" class="pdf-control" id="pdf-next" aria-label="Halaman berikutnya">
                    <i class="bi bi-chevron-right"></i>
                </button>
                <span class="pdf-divider"></span>
                <button type="button" class="pdf-control" id="pdf-zoom-out" aria-label="Perkecil">
                    <i class="bi bi-dash-lg"></i>
                </button>
                <span id="pdf-zoom-value">75%</span>
                <button type="button" class="pdf-control" id="pdf-zoom-in" aria-label="Perbesar">
                    <i class="bi bi-plus-lg"></i>
                </button>
                <button type="button" class="pdf-control" id="pdf-fullscreen" aria-label="Layar penuh">
                    <i class="bi bi-arrows-fullscreen"></i>
                </button>
            </div>
        </div>

        <div class="pdf-viewer" id="pdf-viewer">
            <div class="pdf-thumbnail">
                <div class="thumbnail-page">
                    <i class="bi bi-file-earmark-pdf"></i>
                    <span>1</span>
                </div>
            </div>

            <div class="pdf-canvas-area">
                <div class="pdf-placeholder">
                    <i class="bi bi-file-earmark-pdf"></i>
                    <h3>Kalender Akademik</h3>
                    <p>Dokumen kalender akademik akan ditampilkan di sini.</p>
                    <small>Tambahkan file PDF kalender akademik untuk mengaktifkan pratinjau.</small>
                </div>
            </div>
        </div>
    </section>

</div>

<style>
    .kalender-page {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    .kalender-header {
        margin: 0 0 22px;
    }

    .kalender-header h2 {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 650;
        color: #111;
    }

    .kalender-header p {
        margin: 0;
        font-size: 10px;
        color: #385447;
    }

    .kalender-document {
        width: 100%;
        height: 315px;
        margin-top: 24px;
        overflow: hidden;
        border-radius: 4px;
        background: #333d3b;
    }

    .pdf-toolbar {
        height: 31px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        padding: 0 8px;
        background: #333d3b;
        color: #fff;
    }

    .pdf-menu {
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 0;
        font-size: 7px;
    }

    .pdf-menu i {
        font-size: 12px;
    }

    .pdf-menu span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .pdf-controls {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 8px;
        white-space: nowrap;
    }

    .pdf-control {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 17px;
        height: 20px;
        padding: 0;
        border: none;
        background: transparent;
        color: #fff;
        cursor: pointer;
        font-size: 10px;
    }

    .pdf-control:hover {
        background: #53615d;
        border-radius: 3px;
    }

    .pdf-page-number {
        display: flex;
        gap: 3px;
    }

    .pdf-divider {
        height: 14px;
        width: 1px;
        background: #67716e;
        margin: 0 3px;
    }

    .pdf-viewer {
        height: calc(100% - 31px);
        display: flex;
        overflow: hidden;
        background: #303a37;
    }

    .pdf-thumbnail {
        flex: 0 0 43px;
        padding: 10px 5px;
        background: #35413e;
        border-right: 1px solid #59625f;
    }

    .thumbnail-page {
        width: 100%;
        aspect-ratio: 0.7;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        background: #fff;
        color: #39765f;
        font-size: 9px;
    }

    .thumbnail-page i {
        font-size: 19px;
    }

    .thumbnail-page span {
        color: #444;
    }

    .pdf-canvas-area {
        flex: 1;
        min-width: 0;
        padding: 13px 12px;
        overflow: auto;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .pdf-placeholder {
        width: min(100%, 600px);
        min-height: 260px;
        padding: 40px 20px;
        background: #fff;
        text-align: center;
        color: #39765f;
    }

    .pdf-placeholder > i {
        font-size: 35px;
    }

    .pdf-placeholder h3 {
        margin: 10px 0 7px;
        font-size: 17px;
    }

    .pdf-placeholder p {
        margin: 0 0 8px;
        color: #777;
        font-size: 11px;
    }

    .pdf-placeholder small {
        color: #999;
        font-size: 9px;
    }

    @media (max-width: 600px) {
        .kalender-document {
            height: 350px;
        }

        .pdf-controls {
            gap: 2px;
        }

        .pdf-thumbnail {
            flex-basis: 35px;
        }

        .pdf-placeholder {
            padding: 35px 12px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const viewer = document.getElementById('pdf-viewer');
        const zoomValue = document.getElementById('pdf-zoom-value');
        let zoom = 75;

        document.getElementById('pdf-zoom-in').addEventListener('click', function () {
            zoom = Math.min(150, zoom + 10);
            zoomValue.textContent = zoom + '%';
        });

        document.getElementById('pdf-zoom-out').addEventListener('click', function () {
            zoom = Math.max(50, zoom - 10);
            zoomValue.textContent = zoom + '%';
        });

        document.getElementById('pdf-fullscreen').addEventListener('click', function () {
            if (!document.fullscreenElement) {
                viewer.requestFullscreen?.();
            } else {
                document.exitFullscreen?.();
            }
        });
    });
</script>
@endsection
