<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController; // Ensure this is imported
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Admin Login
Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin.login.submit');

// 2FA
Route::middleware(['auth'])->group(function () {
    Route::get('verify', [TwoFactorController::class, 'index'])->name('verify.index');
    Route::post('verify', [TwoFactorController::class, 'store'])->name('verify.store');
    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
});

// User Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', '2fa'])->name('dashboard');

// User Attendance Actions
Route::post('/attendance/timein', [AttendanceController::class, 'timeIn'])->name('attendance.timein');
Route::post('/attendance/timeout', [AttendanceController::class, 'timeOut'])->name('attendance.timeout');

// ADMIN ROUTES
Route::middleware(['auth', 'admin', '2fa'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('departments', DepartmentController::class)->names('admin.departments');
    
    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('admin.employees.show');
    Route::post('/employees/{id}/archive', [EmployeeController::class, 'archive'])->name('admin.employees.archive');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');

   // 1. Attendance List (Employee Directory)
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');

    // 2. Individual Attendance History
    Route::get('/attendance/{user_id}', [AttendanceController::class, 'show'])->name('admin.attendance.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

