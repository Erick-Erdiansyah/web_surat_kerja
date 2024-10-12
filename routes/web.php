<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanSKController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/login', [WelcomeController::class, 'index'])->name('login');
Route::get('/register', [WelcomeController::class, 'index'])->name('register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/sk/{Surat}/read', [LaporanSKController::class, 'show'])->name('sk.show');
    Route::get('/sk/{Surat}/edit', [LaporanSKController::class, 'edit'])->name('sk.edit');
    Route::put('/sk/{Surat}/update', [LaporanSKController::class, 'update'])->name('sk.update');
    Route::delete('/sk/{Surat}/delete', [LaporanSKController::class, 'destroy'])->name('sk.destroy');
    Route::get('/sk/index', [LaporanSKController::class, 'index'])->name('index');
    Route::get('/sk/create', [LaporanSKController::class, 'create'])->name('sk.create');
    Route::post('/sk/store', [LaporanSKController::class, 'store'])->name('sk.store');
    Route::post('/subkategori/store', [SubKategoriController::class, 'store'])->name('subkategori.store');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{laporan}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
});

