<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

    // Data Cover
    Route::get('/data-cover', function () {
        return view('admin.datacover');
    })->name('data-cover');

    // Data Guru
    Route::get('/data-guru', function () {
        return view('admin.dataguru');
    })->name('guru.index');

    // Data Kelas
    Route::get('/data-kelas', function () {
        return view('admin.datakelas');
    })->name('kelas.index');

    // Data Pengajaran
    Route::get('/data-pengajaran', function () {
        return view('admin.datapengajaran');
    })->name('pengajaran');

    // Event Sekolah
    Route::get('/event-sekolah', function () {
        return view('admin.eventsekolah');
    })->name('event');

    // Panduan Penggunaan
    Route::get('/panduan', function () {
        return view('admin.panduan');
    })->name('panduan');

    // ===== Menu yang belum ada file-nya (sementara redirect ke dashboard) =====
    Route::get('/rekap-absensi', function () {
        return view('admin.dashboard'); // ganti nanti
    })->name('rekap-absensi');

    Route::get('/kalender', function () {
        return view('admin.dashboard'); // ganti nanti
    })->name('kalender');

    Route::get('/jurnal', function () {
        return view('admin.dashboard'); // ganti nanti
    })->name('jurnal');

    Route::get('/bahan-ajar', function () {
        return view('admin.dashboard'); // ganti nanti
    })->name('bahan-ajar');

});

// ===== GURU =====
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');
});

// ===== KEPSEK =====
Route::middleware(['auth', 'role:kepsek'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/dashboard', function () {
        return view('kepsek.dashboard');
    })->name('dashboard');
});