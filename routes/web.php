<?php

use App\Http\Controllers\LaporanSKController;
use App\Http\Controllers\SubKategoriController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/sk/{Surat}/read', [LaporanSKController::class, 'show']);
    Route::get('/sk/{Surat}/edit', [LaporanSKController::class, 'edit']);
    Route::put('/sk/{Surat}/update', [LaporanSKController::class, 'update']);
    Route::get('/sk/index', [LaporanSKController::class, 'index'])->name('index');
    Route::get('/sk/create', [LaporanSKController::class, 'create'])->name('create_sk');
    Route::post('/subkategori/store', [SubKategoriController::class, 'store'])->name('sub_store');
    Route::post('/sk/store', [LaporanSKController::class, 'store'])->name('store_sk');
});
