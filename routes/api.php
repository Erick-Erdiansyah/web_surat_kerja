<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanSKController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('api.home.index');
// Route::get('/login', [WelcomeController::class, 'index'])->name('api.auth.login');
// Route::get('/register', [WelcomeController::class, 'index'])->name('api.auth.register');
Route::get('/read/{Surat}', [WelcomeController::class, 'show'])->name('api.home.read');
Route::get('/surat/download/{filename}', [LaporanSKController::class, 'downloadFile'])->name('api.sk.download');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('api.dashboard.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/surat/{Surat}/read', [LaporanSKController::class, 'show'])->name('api.sk.show');
    Route::get('/surat/{Surat}/edit', [LaporanSKController::class, 'edit'])->name('api.sk.edit');
    Route::put('/surat/{Surat}/update', [LaporanSKController::class, 'update'])->name('api.sk.update');
    Route::delete('/surat/{Surat}/delete', [LaporanSKController::class, 'destroy'])->name('api.sk.destroy');
    Route::get('/surat/index', [LaporanSKController::class, 'index'])->name('api.sk.index');
    Route::get('/surat/create', [LaporanSKController::class, 'create'])->name('api.sk.create');
    Route::post('/surat/store', [LaporanSKController::class, 'store'])->name('api.sk.store');
    Route::post('/subkategori/store', [SubKategoriController::class, 'store'])->name('api.subkategori.store');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('api.bookmarks.store');
    Route::delete('/bookmarks/{laporan}', [BookmarkController::class, 'destroy'])->name('api.bookmarks.destroy');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('api.notifications.index');
    Route::post('/notifications/{notifId}', [NotificationController::class, 'markRead'])->name('api.notifications.read');
});
