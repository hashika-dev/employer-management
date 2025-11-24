<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// 1. Homepage
Route::get('/', function () {
    return view('welcome');
});

// 2FA VERIFICATION ROUTES
Route::middleware(['auth'])->group(function () {
    // 1. Show the "Enter Code" page
    Route::get('verify', [TwoFactorController::class, 'index'])->name('verify.index');
    
    // 2. Check the code (Submit button)
    Route::post('verify', [TwoFactorController::class, 'store'])->name('verify.store');
    
    // 3. Resend the email
    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
});

// 2. Admin & Employee Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard
    // ✅ NEW (Points to the Controller logic)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Employee Management
    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('admin.employees.store');

});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');

// 4. Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- EMPLOYEE MANAGEMENT ROUTES ---
    // 1. List & Create
    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
    
    // 2. Edit & Update (New!)
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('admin.employees.update');
    
    // 3. Delete (New!)
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin.login.submit');
require __DIR__.'/auth.php';