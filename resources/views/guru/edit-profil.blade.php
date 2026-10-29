@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="edit-profil-page">

    {{-- HEADER --}}
    <div class="page-heading">
        <h2>Edit Profil</h2>
        <p>Perbarui informasi pribadi dan identitas akun Anda.</p>
    </div>

    {{-- KARTU FORM --}}
    <div class="edit-profil-card">

        <div class="card-heading">
            <div class="heading-icon">
                <i class="bi bi-person-fill-gear"></i>
            </div>

            <div>
                <h3>Informasi Profil</h3>
                <p>Pastikan informasi profil Anda sudah benar.</p>
            </div>
        </div>

        <form action="#" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA LENGKAP --}}
            <div class="form-group">
                <label for="nama">
                    Nama Lengkap <span>*</span>
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama', Auth::user()->name) }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>

            {{-- USERNAME --}}
            <div class="form-group">
                <label for="username">
                    Username <span>*</span>
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username', Auth::user()->username) }}"
                    placeholder="Masukkan username"
                    required
                >
            </div>

            {{-- NIP --}}
            <div class="form-group">
                <label for="nip">NIP</label>

                <input
                    type="text"
                    id="nip"
                    name="nip"
                    value="{{ old('nip', '') }}"
                    placeholder="Masukkan NIP"
                >

                <small>Isi jika Anda memiliki NIP.</small>
            </div>

            {{-- NOMOR TELEPON --}}
            <div class="form-group">
                <label for="no_telepon">Nomor Telepon</label>

                <input
                    type="tel"
                    id="no_telepon"
                    name="no_telepon"
                    value="{{ old('no_telepon', '') }}"
                    placeholder="Contoh: 081234567890"
                >
            </div>

            {{-- EMAIL --}}
            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', Auth::user()->email) }}"
                    placeholder="Masukkan alamat email"
                >
            </div>

            {{-- MATA PELAJARAN --}}
            <div class="form-group">
                <label for="mata_pelajaran">Mata Pelajaran</label>

                <input
                    type="text"
                    id="mata_pelajaran"
                    name="mata_pelajaran"
                    value="{{ old('mata_pelajaran', 'Bahasa Indonesia') }}"
                    placeholder="Masukkan mata pelajaran"
                >

                <small>Informasi mata pelajaran ditampilkan sebagai data profil.</small>
            </div>

            {{-- TOMBOL --}}
            <div class="form-actions">
                <a href="{{ route('guru.profil-saya') }}" class="btn-cancel">
                    Batal
                </a>

                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<style>
    .edit-profil-page {
        width: 100%;
        padding-bottom: 20px;
        color: #26332F;
        font-family: inherit;
    }

    /* HEADER */
    .page-heading {
        margin-bottom: 22px;
    }

    .page-heading h2 {
        margin: 0 0 5px;
        color: #111;
        font-size: 30px;
        line-height: 1.3;
        font-weight: 500;
    }

    .page-heading p {
        margin: 0;
        color: #999;
        font-size: 14px;
        font-weight: 300;
    }

    /* KARTU FORM */
    .edit-profil-card {
        box-sizing: border-box;
        width: 100%;
        padding: 24px;
        background: #fff;
        border: 1px solid #B9D0C5;
        border-radius: 10px;
        box-shadow: 0 2px 3px rgba(0, 0, 0, .08);
    }

    /* JUDUL KARTU */
    .card-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 1px solid #E1ECE6;
    }

    .heading-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        border-radius: 10px;
        background: #E0F0E7;
        color: #39765f;
        font-size: 22px;
    }

    .card-heading h3 {
        margin: 0 0 5px;
        color: #244c39;
        font-size: 18px;
        font-weight: 700;
    }

    .card-heading p {
        margin: 0;
        color: #999;
        font-size: 12px;
    }

    /* INPUT FORM */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 20px;
    }

    .form-group label {
        color: #111;
        font-size: 15px;
        font-weight: 650;
    }

    .form-group label span {
        color: #ef4444;
    }

    .form-group input {
        box-sizing: border-box;
        width: 100%;
        min-height: 46px;
        padding: 11px 13px;
        border: 1px solid #c8c8c8;
        border-radius: 8px;
        background: #fff;
        color: #333;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .form-group input::placeholder {
        color: #aaa;
    }

    .form-group input:focus {
        border-color: #39765f;
        box-shadow: 0 0 0 3px rgba(57, 118, 95, .12);
    }

    .form-group small {
        color: #89938d;
        font-size: 11px;
    }

    /* TOMBOL */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #E1ECE6;
    }

    .btn-cancel,
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        box-sizing: border-box;
        min-height: 43px;
        padding: 10px 20px;
        border-radius: 9px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .btn-cancel {
        border: 1px solid #c8c8c8;
        background: #fff;
        color: #555;
    }

    .btn-cancel:hover {
        background: #f5f5f5;
        color: #333;
    }

    .btn-save {
        border: 1px solid #39765f;
        background: #39765f;
        color: #fff;
    }

    .btn-save:hover {
        border-color: #2e624e;
        background: #2e624e;
        color: #fff;
    }

    /* RESPONSIVE */
    @media (max-width: 576px) {
        .page-heading h2 {
            font-size: 25px;
        }

        .page-heading p {
            font-size: 12px;
        }

        .edit-profil-card {
            padding: 16px;
        }

        .card-heading h3 {
            font-size: 16px;
        }

        .form-group label {
            font-size: 14px;
        }

        .form-group input {
            min-height: 43px;
            font-size: 13px;
        }

        .form-actions {
            justify-content: stretch;
        }

        .btn-cancel,
        .btn-save {
            flex: 1;
            padding: 10px 12px;
            font-size: 12px;
        }
    }
</style>
@endsection