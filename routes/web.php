<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'formMasuk'])->name('login');
    Route::post('/masuk', [AuthController::class, 'masuk'])->middleware('throttle:5,1');
    Route::get('/daftar', [AuthController::class, 'formDaftar']);
    Route::post('/daftar', [AuthController::class, 'daftar']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect(auth()->user()->isAdmin() ? '/kelola' : '/laporan'));
    Route::post('/keluar', [AuthController::class, 'keluar']);

    Route::view('/laporan', 'reports.index');

    Route::middleware(Admin::class)->group(function () {
        Route::view('/kelola', 'admin.index');
    });
});
