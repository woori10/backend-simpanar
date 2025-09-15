<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TataKerjaController;
use App\Http\Controllers\MateriDiklatController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::get('/tata-kerja', [TataKerjaController::class, 'index']);
    Route::get('/tata-kerja/{id}', [TataKerjaController::class, 'show']);
    Route::post('/tata-kerja', [TataKerjaController::class, 'store']);
    Route::put('/tata-kerja/{id}', [TataKerjaController::class, 'update']);
    Route::delete('/tata-kerja/{id}', [TataKerjaController::class, 'destroy']);

    Route::get('/materi-diklat', [MateriDiklatController::class, 'index']);
    Route::get('/materi-diklat/{id}', [MateriDiklatController::class, 'show']);
    Route::post('/materi-diklat', [MateriDiklatController::class, 'store']);
    Route::put('/materi-diklat/{id}', [MateriDiklatController::class, 'update']);
    Route::delete('/materi-diklat/{id}', [MateriDiklatController::class, 'destroy']);
});
