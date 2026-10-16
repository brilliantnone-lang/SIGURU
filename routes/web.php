<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::view('/datacover', 'admin.datacover');
Route::view('/dataguru', 'admin.dataguru');
Route::view('/datakelas', 'admin.datakelas');
Route::view('/datapengajaran', 'admin.datapengajaran');
Route::view('/eventsekolah', 'admin.eventsekolah');
Route::view('/panduanpenggunaan', 'admin.panduanpenggunaan');

// Guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');
});

// Kepsek
Route::middleware(['auth', 'role:kepsek'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/dashboard', function () {
        return view('kepsek.dashboard');
    })->name('dashboard');
});