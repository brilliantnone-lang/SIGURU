<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CoverJurnalController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MuridController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\EventSekolahController;
use App\Http\Controllers\Admin\KalenderAkademikController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\BahanAjarController;
use App\Http\Controllers\Admin\RekapAbsensiController;

// Guru Controllers
use App\Http\Controllers\Guru\JurnalController;
use App\Http\Controllers\Guru\AbsensiController;
use App\Http\Controllers\Guru\BahanAjarController as GuruBahanAjarController;
use App\Http\Controllers\Guru\ProfilController as GuruProfilController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;

// Kepsek Controllers
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboardController;
use App\Http\Controllers\Kepsek\ValidasiJurnalController;
use App\Http\Controllers\Kepsek\BahanAjarController as KepsekBahanAjarController;
use App\Http\Controllers\Kepsek\RekapAbsensiController as KepsekRekapController;
use App\Http\Controllers\Kepsek\ProfilController as KepsekProfilController;

// ===== AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect('/login');
});

// ===== ADMIN =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('data-cover', CoverJurnalController::class);
    Route::resource('data-guru', GuruController::class)->names([
        'index' => 'guru.index', 'create' => 'tambah-guru', 'store' => 'guru.store',
        'edit' => 'guru.edit', 'update' => 'guru.update', 'destroy' => 'guru.destroy',
    ]);
    Route::resource('data-mapel', MataPelajaranController::class)->names([
        'index' => 'mapel.index', 'create' => 'mapel.create', 'store' => 'mapel.store',
        'edit' => 'mapel.edit', 'update' => 'mapel.update', 'destroy' => 'mapel.destroy',
    ]);
    Route::resource('data-kelas', KelasController::class)->names([
        'index' => 'kelas.index', 'create' => 'kelas.create', 'store' => 'kelas.store',
        'edit' => 'kelas.edit', 'update' => 'kelas.update', 'destroy' => 'kelas.destroy',
    ]);
    Route::resource('data-murid', MuridController::class)->names([
        'index' => 'murid.index', 'create' => 'murid.create', 'store' => 'murid.store',
        'edit' => 'murid.edit', 'update' => 'murid.update', 'destroy' => 'murid.destroy',
    ]);
    Route::resource('data-pengajaran', JadwalController::class)->names([
        'index' => 'pengajaran.index', 'create' => 'pengajaran.create', 'store' => 'pengajaran.store',
        'edit' => 'pengajaran.edit', 'update' => 'pengajaran.update', 'destroy' => 'pengajaran.destroy',
    ]);
    Route::resource('event-sekolah', EventSekolahController::class)->names([
        'index' => 'event.index', 'create' => 'event.create', 'store' => 'event.store',
        'edit' => 'event.edit', 'update' => 'event.update', 'destroy' => 'event.destroy',
    ]);
    Route::resource('kalender', KalenderAkademikController::class)->names([
        'index' => 'kalender.index', 'create' => 'kalender.create', 'store' => 'kalender.store',
        'edit' => 'kalender.edit', 'update' => 'kalender.update', 'destroy' => 'kalender.destroy',
    ]);

    // Monitoring
    Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])->name('rekap-absensi.index');
    Route::get('/jurnal', [JournalController::class, 'index'])->name('jurnal.index');
    Route::get('/bahan-ajar', [BahanAjarController::class, 'index'])->name('bahan-ajar.index');
    Route::get('/panduan', fn() => view('admin.panduan'))->name('panduan');
});

// ===== GURU =====
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    // Jurnal
    Route::get('/jurnal-harian', [JurnalController::class, 'index'])->name('jurnal-harian');
    Route::get('/jurnal-harian/tambah', [JurnalController::class, 'create'])->name('tambah-jurnal');
    Route::post('/jurnal-harian', [JurnalController::class, 'store'])->name('jurnal.store');
    Route::get('/jurnal-harian/{id}', [JurnalController::class, 'show'])->name('lihat-jurnal');
    Route::get('/jurnal-harian/{id}/edit', [JurnalController::class, 'edit'])->name('edit-jurnal');
    Route::put('/jurnal-harian/{id}', [JurnalController::class, 'update'])->name('jurnal.update');
    Route::get('/jurnal-harian/{id}/revisi', [JurnalController::class, 'catatanRevisi'])->name('catatan-revisi');
    Route::post('/jurnal-harian/{id}/ajukan-ulang', [JurnalController::class, 'ajukanUlang'])->name('ajukan-ulang');

    // AJAX get murid
    Route::get('/get-murid/{jadwal_id}', [JurnalController::class, 'getMurid'])->name('get-murid');

    // Presensi
    Route::get('/presensi-siswa', [AbsensiController::class, 'index'])->name('presensi-siswa');
    Route::post('/presensi-siswa', [AbsensiController::class, 'store'])->name('presensi-siswa.store');

    // Bahan Ajar
    Route::get('/bahan-ajar', [GuruBahanAjarController::class, 'index'])->name('bahan-ajar');
    Route::get('/bahan-ajar/unggah', [GuruBahanAjarController::class, 'create'])->name('unggah-bahan-ajar');
    Route::post('/bahan-ajar', [GuruBahanAjarController::class, 'store'])->name('bahan-ajar.store');
    Route::get('/bahan-ajar/{id}/edit', [GuruBahanAjarController::class, 'edit'])->name('edit-bahan-ajar');
    Route::put('/bahan-ajar/{id}', [GuruBahanAjarController::class, 'update'])->name('bahan-ajar.update');
    Route::delete('/bahan-ajar/{id}', [GuruBahanAjarController::class, 'destroy'])->name('bahan-ajar.destroy');

    // Kalender
    Route::get('/kalender', function () {
        $kalenderAktif = \App\Models\KalenderAkademik::getKalenderAktif();
        return view('guru.kalender', compact('kalenderAktif'));
    })->name('kalender');

    // Profil
    Route::get('/profil-saya', [GuruProfilController::class, 'index'])->name('profil-saya');
    Route::get('/profil-saya/edit', [GuruProfilController::class, 'edit'])->name('edit-profil');
    Route::put('/profil-saya', [GuruProfilController::class, 'update'])->name('profil-saya.update');

    // Panduan
    Route::get('/panduan', fn() => view('guru.panduan'))->name('panduan');
});

// ===== KEPSEK =====
Route::middleware(['auth', 'role:kepsek'])->prefix('kepsek')->name('kepsek.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [KepsekDashboardController::class, 'index'])->name('dashboard');

    // Rekap Absensi
    Route::get('/rekapitulasi-absensi', [KepsekRekapController::class, 'index'])->name('rekapitulasi-absensi.index');

    // Validasi Jurnal
    Route::get('/validasi-jurnal', [ValidasiJurnalController::class, 'index'])->name('validasi-jurnal.index');
    Route::get('/validasi-jurnal/semester/{id}', [ValidasiJurnalController::class, 'show'])->name('validasi-jurnal.show');
    Route::get('/validasi-jurnal/semester/{cover_id}/guru/{guru_id}', [ValidasiJurnalController::class, 'jurnalGuru'])->name('validasi-jurnal.guru');
    Route::put('/validasi-jurnal/semester/{cover_id}/guru/{guru_id}', [ValidasiJurnalController::class, 'validasiGuru'])->name('validasi-jurnal.validasi-guru');
    Route::get('/validasi-jurnal/detail/{id}', [ValidasiJurnalController::class, 'detailJurnal'])->name('validasi-jurnal.detail');

    // Bahan Ajar
    Route::get('/bahan-ajar', [KepsekBahanAjarController::class, 'index'])->name('bahan-ajar.index');

    // Kalender
    Route::get('/kalender', function () {
        $kalenderAktif = \App\Models\KalenderAkademik::getKalenderAktif();
        return view('kepsek.kalender', compact('kalenderAktif'));
    })->name('kalender');

    // Panduan
    Route::get('/panduan', fn() => view('kepsek.panduan'))->name('panduan');

    // Profil & TTD
    Route::get('/profil', [KepsekProfilController::class, 'index'])->name('profil');
    Route::post('/profil/ttd', [KepsekProfilController::class, 'updateTtd'])->name('profil.ttd');
});