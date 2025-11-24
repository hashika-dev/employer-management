<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeApiController;

// Public API Routes (Anyone can access these)
Route::get('/employees', [EmployeeApiController::class, 'index']);
Route::get('/employees/{id}', [EmployeeApiController::class, 'show']);

// Protected Routes (Optional)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});