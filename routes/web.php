<?php

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
    Route::get('/sk/index', function () {
        return Inertia::render('Surat/Index');
    })->name('index');
    Route::get('/sk/read', function () {
        return Inertia::render('Surat/Read');
    })->name('ReadSK');
    Route::get('/sk/create', function () {
        return Inertia::render('Surat/Create');
    })->name('CreateSK');
    Route::get('/sk/update', function () {
        return Inertia::render('Surat/Update');
    })->name('UpdateSK');
    // Route::get('/surat',[SuratController::class,'index'])->name('surat');
});
