<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CoverJurnalController;
use \App\Http\Controllers\Admin\GuruController;
use \App\Http\Controllers\Admin\MataPelajaranController;

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

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
    Route::get('/data-kelas', function () {
        return view('admin.data-kelas');
    })->name('kelas.index');

    // Data Pengajaran
    Route::get('/data-pengajaran', function () {
        return view('admin.data-pengajaran');
    })->name('pengajaran');

    // Event Sekolah
    Route::get('/event-sekolah', function () {
        return view('admin.event-sekolah');
    })->name('event');

    // Panduan Penggunaan
    Route::get('/panduan', function () {
        return view('admin.panduan');
    })->name('panduan');

    // ===== Menu yang belum ada file-nya (sementara redirect ke dashboard) =====
    Route::get('/rekap-absensi', function () {
        return view('admin.absensi'); // ganti nanti
    })->name('rekap-absensi');

    Route::get('/kalender', function () {
        return view('admin.kalender'); // ganti nanti
    })->name('kalender');

    Route::get('/jurnal', function () {
        return view('admin.jurnal'); // ganti nanti
    })->name('jurnal');

    Route::get('/bahan-ajar', function () {
        return view('admin.bahan-ajar'); // ganti nanti
    })->name('bahan-ajar');
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

    // Presensi Siswa
    Route::get('/presensi-siswa', function () {
        return view('guru.presensi-siswa');
    })->name('presensi-siswa');

    // Bahan Ajar
    Route::get('/bahan-ajar', function () {
        return view('guru.bahan-ajar');
    })->name('bahan-ajar');

    // Kalender Akademik
    Route::get('/kalender', function () {
        return view('guru.kalender');
    })->name('kalender');

    // Profil Saya
    Route::get('/profil-saya', function () {
        return view('guru.profil-saya');
    })->name('profil-saya');

    // Panduan Penggunaan
    Route::get('/panduan', function () {
        return view('guru.panduan');
    })->name('panduan');
});


// ===== KEPSEK =====
Route::middleware(['auth', 'role:kepsek'])
    ->prefix('kepsek')
    ->name('kepsek.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('kepsek.dashboard');
        })->name('dashboard');

        // Rekapitulasi Absensi Siswa
        Route::get('/rekapitulasi-absensi', function () {
            return view('kepsek.rekapitulasi-absensi');
        })->name('rekapitulasi-absensi');

        // Validasi Jurnal
        Route::get('/validasi-jurnal', function () {
            return view('kepsek.validasi-jurnal');
        })->name('validasi-jurnal');

        // Bahan Ajar
        Route::get('/bahan-ajar', function () {
            return view('kepsek.bahan-ajar');
        })->name('bahan-ajar');

        // Kalender Akademik
        Route::get('/kalender', function () {
            return view('kepsek.kalender');
        })->name('kalender');

        // Panduan Penggunaan
        Route::get('/panduan', function () {
            return view('kepsek.panduan');
        })->name('panduan');
    });
