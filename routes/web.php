<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerSatisfactionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])
        ->middleware('throttle:5,1'); 
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    
    // Dashboard 
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Customer Satisfaction 
    Route::prefix('customer-satisfaction')->name('customer-satisfaction.')->group(function () {
        Route::get('/', [CustomerSatisfactionController::class, 'index'])->name('index');
        Route::get('/export-pdf', [CustomerSatisfactionController::class, 'exportPdf'])->name('export-pdf');
    });
    
    // Staff Management
    Route::resource('staff', StaffController::class)->except(['show']);
    
    // Support Routes
    Route::prefix('support')->name('support.')->group(function () {
        // Main support page
        Route::get('/', [SupportController::class, 'index'])->name('index');
        
        // Knowledge base
        Route::get('/faq', [SupportController::class, 'faq'])->name('faq');
        Route::get('/guides', [SupportController::class, 'guides'])->name('guides');
        Route::get('/troubleshooting', [SupportController::class, 'troubleshooting'])->name('troubleshooting');
        
        // Tickets
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [SupportController::class, 'tickets'])->name('index');
            Route::get('/create', [SupportController::class, 'createTicket'])->name('create');
            Route::post('/', [SupportController::class, 'storeTicket'])->name('store');
            Route::get('/{ticket}', [SupportController::class, 'showTicket'])->name('show');
            
            // Admin only routes
            Route::middleware('role:admin')->group(function () {
                Route::patch('/{ticket}/status', [SupportController::class, 'updateStatus'])->name('update-status');
                Route::post('/{ticket}/reply', [SupportController::class, 'replyTicket'])->name('reply');
            });
        });
    });
});

// Redirect root to dashboard or login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});