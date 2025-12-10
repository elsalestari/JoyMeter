<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerSatisfactionController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

// Guest Routes (hanya bisa diakses jika belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])
        ->middleware('throttle:5,1'); // Max 5 attempts per minute
});

// Authenticated Routes (hanya bisa diakses jika sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    
    // Dashboard - hanya staff dan admin
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Customer Satisfaction - hanya staff dan admin
    Route::prefix('customer-satisfaction')->name('customer-satisfaction.')->group(function () {
        Route::get('/', [CustomerSatisfactionController::class, 'index'])->name('index');
        Route::get('/export-pdf', [CustomerSatisfactionController::class, 'exportPdf'])->name('export-pdf');
    });
    
    // Staff Management
    Route::resource('staff', StaffController::class)->except(['show']);
});

// Redirect root to dashboard or login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});