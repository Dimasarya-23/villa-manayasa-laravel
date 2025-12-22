<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KamarApiController;

// TEST PERTAMA: Akses http://127.0.0.1:8000/api/test
Route::get('/test', function () {
    return response()->json(['message' => 'API Villa Manayasa Aktif!']);
});

// ROUTE UTAMA
Route::get('/kamar', [KamarApiController::class, 'index']);
Route::post('/kamar', [KamarApiController::class, 'store']);
Route::delete('/kamar/{id}', [KamarApiController::class, 'destroy']);
use App\Http\Controllers\KamarController;
Route::apiResource('kamar', KamarController::class);