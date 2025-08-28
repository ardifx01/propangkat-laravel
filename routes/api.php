<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Routes accessible only to admins
    Route::middleware(['ability:admin'])->prefix('admin')->group(function () {
        // Admin specific routes
    });
    
    // Routes accessible only to operators
    Route::middleware(['ability:operator'])->prefix('operator')->group(function () {
        // Operator specific routes
    });
    
    // Routes accessible only to pegawai
    Route::middleware(['ability:pegawai'])->prefix('pegawai')->group(function () {
        // Pegawai specific routes
    });
});
