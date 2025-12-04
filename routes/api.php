<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeApiController;

// 1. GET (Retrieve)
Route::get('/employees', [EmployeeApiController::class, 'index']);
Route::get('/employees/{id}', [EmployeeApiController::class, 'show']);

// 2. POST (Create)
Route::post('/employees', [EmployeeApiController::class, 'store']);

// 3. PUT/PATCH (Update)
Route::put('/employees/{id}', [EmployeeApiController::class, 'update']);

// 4. DELETE (Delete)
Route::delete('/employees/{id}', [EmployeeApiController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});