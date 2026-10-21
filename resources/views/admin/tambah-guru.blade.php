
@extends('layouts.app')

@section('title', 'Tambah Guru - SIGURU')

@section('content')
<div class="tambah-guru-page">

    <div class="tambah-guru-heading">
        <h1>Data Guru</h1>
        <p>Kelola profil dan informasi tenaga pendidik sekolah.</p>
    </div>

    <section class="form-guru-card">
        <div class="form-guru-title">
            <div class="form-guru-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="4"/>
                    <path d="M4.5 21v-2a7.5 7.5 0 0 1 15 0v2"/>
                </svg>
            </div>

            <div>
                <h2>Informasi Pribadi</h2>
                <p>Data akun dan identitas guru</p>
            </div>
        </div>

        <form id="formTambahGuru">
            <div class="form-guru-grid">

                <div class="form-guru-field">
                    <label for="namaGuru">Nama Lengkap <span>*</span></label>
                    <input type="text" id="namaGuru"
                           placeholder="Nama Lengkap Guru" required>
                </div>

                <div class="form-guru-field">
                    <label for="nipGuru">NIP <span>*</span></label>
                    <input type="text" id="nipGuru"
                           placeholder="NIP Guru" required>
                </div>

                <div class="form-guru-field">
                    <label for="usernameGuru">Username <span>*</span></label>
                    <input type="text" id="usernameGuru"
                           placeholder="Buat Username" required>
                </div>

                <div class="form-guru-field">
                    <label for="passwordGuru">Password <span>*</span></label>
                    <input type="password" id="passwordGuru"
                           placeholder="Buat Password" required>
                </div>

                <div class="form-guru-field">
                    <label for="teleponGuru">Nomor Telepon</label>
                    <input type="tel" id="teleponGuru"
                           placeholder="Nomor Telepon Guru">
                </div>

                <div class="form-guru-field">
                    <label for="mapelGuru">Mata Pelajaran <span>*</span></label>
                    <select id="mapelGuru" required>
                        <option value="" selected disabled>
                            Mata Pelajaran yang Diampu
                        </option>
                        <option>Bahasa Indonesia</option>
                        <option>Matematika</option>
                        <option>IPA</option>
                        <option>IPS</option>
                        <option>Bahasa Inggris</option>
                        <option>PJOK</option>
                        <option>Informatika</option>
                    </select>
                </div>

            </div>

            <div class="form-guru-actions">
                <button type="submit" class="btn-simpan-guru">
                    SIMPAN
                </button>

                <a href="{{ route('admin.data-guru') }}"
                   class="btn-batalkan-guru">
                    BATALKAN
                </a>
            </div>
        </form>
    </section>

</div>

<style>
.tambah-guru-page {
    width: 100%;
    color: #244437;
    font-family: inherit;
}

.tambah-guru-page *,
.tambah-guru-page *::before,
.tambah-guru-page *::after {
    box-sizing: border-box;
}

.tambah-guru-heading {
    margin-bottom: 14px;
}

.tambah-guru-heading h1 {
    margin: 0;
    color: #17211f;
    font-size: 25px;
    font-weight: 700;
    line-height: 1.35;
}

.tambah-guru-heading p {
    margin: 3px 0 0;
    color: #40594e;
    font-size: 12px;
}

.form-guru-card {
    width: 100%;
    max-width: 850px;
    margin: 0 auto;
    padding: 24px 28px 22px;
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 25px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.13);
}

.form-guru-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 17px;
}

.form-guru-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 25px;
    height: 30px;
    flex-shrink: 0;
    color: #285d43;
}

.form-guru-icon svg {
    width: 23px;
    height: 23px;
}

.form-guru-title h2 {
    margin: 0;
    color: #28513d;
    font-size: 15px;
    font-weight: 700;
}

.form-guru-title p {
    margin: 2px 0 0;
    color: #8a9990;
    font-size: 10px;
}

.form-guru-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 30px;
    row-gap: 12px;
    max-width: 720px;
    margin: 0 auto;
}

.form-guru-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
}

.form-guru-field label {
    color: #52665b;
    font-size: 10px;
    font-weight: 500;
}

.form-guru-field label span {
    color: #f04444;
}

.form-guru-field input,
.form-guru-field select {
    width: 100%;
    height: 34px;
    padding: 0 10px;
    color: #344a3d;
    background: #fff;
    border: 1px solid #d3d9d5;
    border-radius: 6px;
    outline: none;
    font: inherit;
    font-size: 11px;
}

.form-guru-field input::placeholder {
    color: #8a8f8b;
}

.form-guru-field input:focus,
.form-guru-field select:focus {
    border-color: #56b78d;
    box-shadow: 0 0 0 2px rgba(86, 183, 141, 0.13);
}

.form-guru-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-top: 23px;
}

.btn-simpan-guru,
.btn-batalkan-guru {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 105px;
    height: 36px;
    padding: 0 17px;
    border: none;
    border-radius: 20px;
    font: inherit;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s ease;
}

.btn-simpan-guru {
    color: #28734f;
    background: #94edc5;
}

.btn-simpan-guru:hover {
    background: #78dfb2;
}

.btn-batalkan-guru {
    color: #a9561e;
    background: #ff9b3f;
}

.btn-batalkan-guru:hover {
    background: #f58a2a;
}

@media (max-width: 600px) {
    .form-guru-card {
        padding: 20px 16px;
        border-radius: 18px;
    }

    .form-guru-grid {
        grid-template-columns: 1fr;
        gap: 13px;
    }

    .form-guru-actions {
        flex-wrap: wrap;
    }
}
</style>

<script>
document.getElementById('formTambahGuru').addEventListener('submit', function (event) {
    event.preventDefault();

    alert('Tampilan formulir berhasil diuji. Penyimpanan data belum dihubungkan ke backend.');
});
</script>
@endsection
