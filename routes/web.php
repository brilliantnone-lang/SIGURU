<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CoverJurnalController;
use \App\Http\Controllers\Admin\GuruController;
use \App\Http\Controllers\Admin\MataPelajaranController;
use \App\Http\Controllers\Admin\KalenderAkademikController;
use \App\Http\Controllers\Admin\JournalController;
use \App\Http\Controllers\Admin\BahanAjarController;
use \App\Http\Controllers\Admin\RekapAbsensiController;
use \App\Http\Controllers\Admin\DashboardController;

// ===== AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect('/login');
});

// ===== ADMIN =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Cover (CRUD Lengkap)
    Route::resource('data-cover', CoverJurnalController::class);

    // Data Guru
    Route::resource('data-guru', GuruController::class)->names([
        'index' => 'guru.index',
        'create' => 'tambah-guru',
        'store' => 'guru.store',
        'edit' => 'guru.edit',
        'update' => 'guru.update',
        'destroy' => 'guru.destroy',
    ]);

    // Data Mata Pelajaran
    Route::resource('data-mapel', MataPelajaranController::class)->names([
        'index' => 'mapel.index',
        'create' => 'mapel.create',
        'store' => 'mapel.store',
        'edit' => 'mapel.edit',
        'update' => 'mapel.update',
        'destroy' => 'mapel.destroy',
    ]);


    Route::get('/data-guru/tambah', function () {
        return view('admin.tambah-guru');
    })->name('tambah-guru');


    // Data Kelas
    Route::resource('data-kelas', \App\Http\Controllers\Admin\KelasController::class)->names([
        'index' => 'kelas.index',
        'create' => 'kelas.create',
        'store' => 'kelas.store',
        'edit' => 'kelas.edit',
        'update' => 'kelas.update',
        'destroy' => 'kelas.destroy',
    ]);

    // Data Murid
    Route::resource('data-murid', \App\Http\Controllers\Admin\MuridController::class)->names([
        'index' => 'murid.index',
        'create' => 'murid.create',
        'store' => 'murid.store',
        'edit' => 'murid.edit',
        'update' => 'murid.update',
        'destroy' => 'murid.destroy',
    ]);

    // Data Pengajaran
    Route::resource('data-pengajaran', \App\Http\Controllers\Admin\JadwalController::class)->names([
        'index' => 'pengajaran.index',
        'create' => 'pengajaran.create',
        'store' => 'pengajaran.store',
        'edit' => 'pengajaran.edit',
        'update' => 'pengajaran.update',
        'destroy' => 'pengajaran.destroy',
    ]);

    // Event Sekolah
    Route::resource('event-sekolah', \App\Http\Controllers\Admin\EventSekolahController::class)->names([
        'index' => 'event.index',
        'create' => 'event.create',
        'store' => 'event.store',
        'edit' => 'event.edit',
        'update' => 'event.update',
        'destroy' => 'event.destroy',
    ]);

    // Panduan Penggunaan
    Route::get('/panduan', function () {
        return view('admin.panduan');
    })->name('panduan');

    // ===== Menu yang belum ada file-nya (sementara redirect ke dashboard) =====
    Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])->name('rekap-absensi.index');
    Route::get('/rekap-absensi/detail', [RekapAbsensiController::class, 'detail'])->name('rekap-absensi.detail');

    Route::resource('kalender', KalenderAkademikController::class)->names([
        'index' => 'kalender.index',
        'create' => 'kalender.create',
        'store' => 'kalender.store',
        'edit' => 'kalender.edit',
        'update' => 'kalender.update',
        'destroy' => 'kalender.destroy',
    ]);

    Route::get('/jurnal', [JournalController::class, 'index'])->name('jurnal.index');

    Route::get('/bahan-ajar', [BahanAjarController::class, 'index'])->name('bahan-ajar.index');
});

// ===== GURU =====
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');

    // Jurnal Harian
    Route::get('/jurnal-harian', function () {
        return view('guru.jurnal-harian');
    })->name('jurnal-harian');

    // Tambah Jurnal
    Route::get('/jurnal-harian/tambah', function () {
        return view('guru.tambah-jurnal');
    })->name('tambah-jurnal');

    // Lihat Jurnal
    Route::get('/jurnal-harian/lihat', function () {
        return view('guru.lihat-jurnal');
    })->name('lihat-jurnal');

    // Edit Jurnal
    Route::get('/jurnal-harian/edit', function () {
        return view('guru.edit-jurnal');
    })->name('edit-jurnal');

    // Catatan Revisi Jurnal
    Route::get('/jurnal-harian/revisi', function () {
        return view('guru.catatan-revisi');
    })->name('catatan-revisi');

    // Presensi Siswa
    Route::get('/presensi-siswa', function () {
        return view('guru.presensi-siswa');
    })->name('presensi-siswa');

    // Bahan Ajar
    Route::get('/bahan-ajar', function () {
        return view('guru.bahan-ajar');
    })->name('bahan-ajar');

    // Unggah Bahan Ajar
    Route::get('/bahan-ajar/unggah', function () {
        return view('guru.unggah-bahan-ajar');
    })->name('unggah-bahan-ajar');

    // Edit Bahan Ajar
    Route::get('/bahan-ajar/edit', function () {
        return view('guru.edit-bahan-ajar');
    })->name('edit-bahan-ajar');

    // Kalender Akademik
    Route::get('/kalender', function () {
        return view('guru.kalender');
    })->name('kalender');

    // Profil Saya
    Route::get('/profil-saya', function () {
        return view('guru.profil-saya');
    })->name('profil-saya');

    // Edit Profil
    Route::get('/profil-saya/edit', function () {
        return view('guru.edit-profil');
    })->name('edit-profil');

    // Panduan Penggunaan
    Route::get('/panduan', function () {
        return view('guru.panduan');
    })->name('panduan');
});

// ===== KEPSEK =====
Route::middleware(['auth', 'role:kepsek'])->prefix('kepsek')->name('kepsek.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Kepsek\DashboardController::class, 'index'])->name('dashboard');

    // Rekapitulasi Absensi Siswa (Sementara Closure, nanti kita buat Controllernya)
    Route::get('/rekapitulasi-absensi', [\App\Http\Controllers\Kepsek\RekapAbsensiController::class, 'index'])->name('rekapitulasi-absensi.index');

    // Validasi Jurnal (Sementara Closure)
    Route::get('/validasi-jurnal', [\App\Http\Controllers\Kepsek\ValidasiJurnalController::class, 'index'])->name('validasi-jurnal.index');
    Route::get('/validasi-jurnal/{id}', [\App\Http\Controllers\Kepsek\ValidasiJurnalController::class, 'show'])->name('validasi-jurnal.show');
    Route::put('/validasi-jurnal/{id}', [\App\Http\Controllers\Kepsek\ValidasiJurnalController::class, 'update'])->name('validasi-jurnal.update');

    Route::get('/form-validasi', function () {
        return view('kepsek.form-validasi');
    })->name('form-validasi');

    // Bahan Ajar
    Route::get('/bahan-ajar', [\App\Http\Controllers\Kepsek\BahanAjarController::class, 'index'])->name('bahan-ajar.index');

    // Kalender Akademik
    Route::get('/kalender', function () {
        $kalenderAktif = \App\Models\KalenderAkademik::getKalenderAktif();
        return view('kepsek.kalender', compact('kalenderAktif'));
    })->name('kalender');

    // Panduan Penggunaan
    Route::get('/panduan', function () {
        return view('kepsek.panduan');
    })->name('panduan');
});
