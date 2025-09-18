<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TataKerjaController;
use App\Http\Controllers\MateriDiklatController;
use App\Http\Controllers\DaftarAlatController;
use App\Http\Controllers\VideoTutorialController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\KeluhanController;


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

    Route::post('/daftar-alat', [DaftarAlatController::class, 'store']);
    Route::get('/daftar-alat', [DaftarAlatController::class, 'index']);
    Route::get('/daftar-alat/{id}', [DaftarAlatController::class, 'show']);
    Route::put('/daftar-alat/{id}', [DaftarAlatController::class, 'update']);
    Route::delete('/daftar-alat/{id}', [DaftarAlatController::class, 'destroy']);

    Route::get('/faq', [FaqController::class, 'index']);
    Route::get('/faq/{id}', [FaqController::class, 'show']);
    Route::post('/faq', [FaqController::class, 'store']);
    Route::put('/faq/{id}', [FaqController::class, 'update']);
    Route::delete('/faq/{id}', [FaqController::class, 'destroy']);

    Route::post('/keluhan', [KeluhanController::class, 'store']);
    Route::get('/keluhan', [KeluhanController::class, 'index']);
    Route::get('/keluhan/{id}', [KeluhanController::class, 'show']);
    Route::delete('/keluhan/{id}', [KeluhanController::class, 'destroy']);

});
