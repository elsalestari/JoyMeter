<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerSatisfactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kepuasan-pelanggan', [CustomerSatisfactionController::class, 'index'])->name('customer-satisfaction.index');
    Route::get('/kepuasan-pelanggan/export-pdf', [CustomerSatisfactionController::class, 'exportPdf'])->name('customer-satisfaction.export-pdf');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});
