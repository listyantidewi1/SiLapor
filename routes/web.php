<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
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
    Route::get('/laporan/buat', [ReportController::class, 'create']);
    Route::post('/laporan', [ReportController::class, 'store']);
    Route::get('/laporan/{report}', [ReportController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/{report}/foto', [ReportController::class, 'foto'])->name('laporan.foto');

    Route::middleware(Admin::class)->group(function () {
        Route::view('/kelola', 'admin.index');
    });
});
