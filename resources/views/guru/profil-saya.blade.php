@extends('layouts.app')

@section('title', 'Profil Saya')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
<div class="profil-page">

    {{-- HEADER --}}
    <div class="profil-header">
        <h2>Profil {{ Auth::user()->name }}</h2>
        <p>Kelola informasi profil dan keamanan akun Anda</p>
    </div>

    {{-- KARTU IDENTITAS GURU --}}
    <section class="profil-identity">
        <div class="profil-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>

        <div class="identity-info">
            <h3>{{ Auth::user()->name }}</h3>
            <p>Guru Bahasa Indonesia</p>

            <span class="guru-active">
                <i class="bi bi-check-circle"></i>
                Guru Aktif
            </span>
        </div>
    </section>

    {{-- DETAIL PROFIL --}}
    <div class="profil-grid">

        {{-- INFORMASI PRIBADI --}}
        <section class="profil-card personal-card">
            <div class="profil-card-header">
                <i class="bi bi-person"></i>

                <div class="card-heading-text">
                    <h3>Informasi Pribadi</h3>
                    <p>Data akun dan identitas guru</p>
                </div>

                {{-- TOMBOL MENUJU HALAMAN EDIT PROFIL --}}
                <a href="{{ route('guru.edit-profil') }}"
                   class="btn-edit-profil">
                    <i class="bi bi-pencil-fill"></i>
                    Edit Profil
                </a>
            </div>

            <div class="personal-info-grid">

                <div class="personal-info-item">
                    <span>Nama Lengkap</span>
                    <strong>{{ Auth::user()->name }}</strong>
                </div>

                <div class="personal-info-item">
                    <span>NIP</span>
                    <strong>19870512 201403 2 004</strong>
                </div>

                <div class="personal-info-item">
                    <span>Username</span>
                    <strong>{{ Auth::user()->username }}</strong>
                </div>

                <div class="personal-info-item">
                    <span>Nomor Telepon</span>
                    <strong>0812-3456-7890</strong>
                </div>

            </div>
        </section>

        {{-- MATA PELAJARAN LINEAR --}}
        <section class="profil-card subject-card">
            <div class="profil-card-header">
                <i class="bi bi-mortarboard"></i>

                <div class="card-heading-text">
                    <h3>Mata Pelajaran Linear</h3>
                </div>
            </div>

            <p class="subject-description">
                Penugasan mata pelajaran tetap
            </p>

            <div class="subject-info">
                <i class="bi bi-book"></i>

                <div>
                    <strong>Bahasa Indonesia</strong>
                    <p>Kelas VII, VIII, IX · Tahun Ajaran 2026/2027</p>
                </div>

                <i class="bi bi-check-circle subject-check"></i>
            </div>
        </section>

    </div>
</div>

<style>
    .profil-page {
        width: 100%;
        color: #222;
        font-family: inherit;
    }

    /* HEADER */
    .profil-header {
        margin: 0 0 22px 5px;
    }

    .profil-header h2 {
        margin: 0 0 7px;
        font-size: 26px;
        font-weight: 650;
        color: #111;
    }

    .profil-header p {
        margin: 0;
        font-size: 12px;
        color: #555;
    }

    /* IDENTITAS GURU */
    .profil-identity {
        display: flex;
        align-items: center;
        gap: 16px;
        min-height: 99px;
        padding: 16px 27px;
        margin-bottom: 24px;
        border-radius: 26px;
        background: #e6eee9;
        box-shadow: 0 4px 9px rgba(0, 0, 0, .18);
        box-sizing: border-box;
    }

    .profil-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 59px;
        height: 59px;
        min-width: 59px;
        border: 4px solid #fff;
        border-radius: 50%;
        background: #9bc7b4;
        color: #245541;
        font-size: 19px;
        font-weight: 700;
        box-sizing: border-box;
    }

    .identity-info {
        min-width: 0;
    }

    .identity-info h3 {
        margin: 0 0 5px;
        color: #245541;
        font-size: 18px;
        font-weight: 500;
        overflow-wrap: anywhere;
    }

    .identity-info p {
        margin: 0 0 6px;
        color: #89938d;
        font-size: 10px;
    }

    .guru-active {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 7px;
        border-radius: 12px;
        background: #fff;
        color: #39765f;
        font-size: 10px;
        font-weight: 600;
    }

    /* GRID KARTU */
    .profil-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(220px, 1fr);
        gap: 14px;
        align-items: stretch;
        padding: 0 3px;
    }

    .profil-card {
        min-width: 0;
        padding: 17px 19px;
        border-radius: 27px;
        background: #fff;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .18);
        box-sizing: border-box;
    }

    /* HEADER KARTU */
    .profil-card-header {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 15px;
    }

    .profil-card-header > i {
        flex-shrink: 0;
        color: #245541;
        font-size: 19px;
    }

    .card-heading-text {
        min-width: 0;
        flex: 1;
    }

    .card-heading-text h3 {
        margin: 1px 0 3px;
        font-size: 16px;
        font-weight: 700;
        color: #244c39;
    }

    .card-heading-text p {
        margin: 0;
        font-size: 10px;
        color: #929b95;
    }

    /* TOMBOL EDIT PROFIL */
    .btn-edit-profil {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        flex-shrink: 0;
        padding: 6px 10px;
        border: 1px solid #39765f;
        border-radius: 7px;
        background: #39765f;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s, border-color .2s;
    }

    .btn-edit-profil:hover {
        background: #2e624e;
        border-color: #2e624e;
        color: #fff;
    }

    /* INFORMASI PRIBADI */
    .personal-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 17px;
        row-gap: 12px;
        padding-left: 13px;
    }

    .personal-info-item {
        min-width: 0;
    }

    .personal-info-item span {
        display: block;
        margin-bottom: 5px;
        color: #89938d;
        font-size: 10px;
    }

    .personal-info-item strong {
        display: block;
        overflow-wrap: anywhere;
        color: #244c39;
        font-size: 12px;
        font-weight: 650;
    }

    /* MATA PELAJARAN */
    .subject-card {
        padding-left: 18px;
        padding-right: 15px;
    }

    .subject-card .profil-card-header {
        margin-bottom: 15px;
    }

    .subject-description {
        margin: 0 0 14px;
        color: #89938d;
        font-size: 10px;
    }

    .subject-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .subject-info > i:first-child {
        flex-shrink: 0;
        color: #62a784;
        font-size: 18px;
    }

    .subject-info > div {
        flex: 1;
        min-width: 0;
    }

    .subject-info strong {
        display: block;
        margin-bottom: 4px;
        color: #245541;
        font-size: 12px;
        font-weight: 650;
    }

    .subject-info p {
        margin: 0;
        color: #89938d;
        font-size: 10px;
        line-height: 1.5;
    }

    .subject-info .subject-check {
        flex-shrink: 0;
        color: #245541;
        font-size: 12px;
    }

    /* RESPONSIVE */
    @media (max-width: 760px) {
        .profil-grid {
            grid-template-columns: 1fr;
        }

        .profil-identity {
            padding: 15px 18px;
            border-radius: 20px;
        }

        .profil-card {
            border-radius: 20px;
        }
    }

    @media (max-width: 480px) {
        .profil-header h2 {
            font-size: 22px;
        }

        .profil-card {
            padding: 15px;
        }

        .profil-card-header {
            flex-wrap: wrap;
        }

        .card-heading-text h3 {
            font-size: 14px;
        }

        .btn-edit-profil {
            font-size: 10px;
            padding: 6px 8px;
        }

        .personal-info-grid {
            padding-left: 0;
            column-gap: 10px;
        }
    }
</style>
@endsection