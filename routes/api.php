<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Tugas Pemrograman Integratif
| Sistem API: CRUD User & Buku + Middleware Ownership
|--------------------------------------------------------------------------
*/

// Public (tanpa login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected (wajib token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // CRUD User
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('user.owner');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('user.owner');
    Route::patch('/users/{user}', [UserController::class, 'update'])->middleware('user.owner');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('user.owner');

    // Akses buku dari user via endpoint api (nested)
    // GET /api/users/{user}/bukus -> hanya milik sendiri, user lain = 403
    Route::get('/users/{user}/bukus', [UserController::class, 'bukus']);

    // CRUD Buku (hanya milik sendiri)
    Route::get('/bukus', [BukuController::class, 'index']);
    Route::post('/bukus', [BukuController::class, 'store']);

    Route::middleware('buku.owner')->group(function () {
        Route::get('/bukus/{buku}', [BukuController::class, 'show']);
        Route::put('/bukus/{buku}', [BukuController::class, 'update']);
        Route::patch('/bukus/{buku}', [BukuController::class, 'update']);
        Route::delete('/bukus/{buku}', [BukuController::class, 'destroy']);
    });
});
