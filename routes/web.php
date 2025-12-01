<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Homepage
Route::get('/', function () {
    return view('welcome');
});

// 2. Authentication Routes (Login, etc.)
require __DIR__.'/auth.php';

// 3. Admin Custom Login
Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin.login.submit');

// 4. 2FA Routes (Protected by Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('verify', [TwoFactorController::class, 'index'])->name('verify.index');
    Route::post('verify', [TwoFactorController::class, 'store'])->name('verify.store');
    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
});

// 5. USER Dashboard (Protected by 2FA)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', '2fa'])->name('dashboard');

// 6. ADMIN Routes (Protected by Admin Middleware + 2FA)
Route::middleware(['auth', 'admin', '2fa'])->prefix('admin')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Employee Management
    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');
});

// 7. Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// View Details
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('admin.employees.show');
    
    // NEW: Archive Route
    Route::post('/employees/{id}/archive', [EmployeeController::class, 'archive'])->name('admin.employees.archive');