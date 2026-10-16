@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan kegiatan pembelajaran')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-custom d-flex align-items-center gap-3">
                <div style="width:48px; height:48px; background:#dcfce7; color:#16a34a; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:20px;">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:12px;">Jurnal</div>
                    <div class="fw-bold" style="font-size:20px;">127/300</div>
                    <div class="text-muted" style="font-size:11px;">Jurnal terkumpul</div>
                </div>
            </div>
        </div>
        {{-- tambah card lain sesuai gambar --}}
    </div>

    <div class="card-custom">
        <h5 class="fw-bold mb-3" style="font-size:16px;">Jurnal Terbaru</h5>
        <p class="text-muted">Konten tabel di sini...</p>
    </div>
@endsection