<?php

use App\Http\Controllers\API\AlihmediaController;
use App\Http\Controllers\API\KlasifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ValidasidataController;
use App\Http\Controllers\ReferensiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('alihmedia/image/{file}', [AlihmediaController::class, 'image']);

Route::get('/getImage/{file}', [AlihmediaController::class, 'getImage']);
Route::get('/getImage/{file}', [ValidasidataController::class, 'getImage']);

Route::get('/app/alihmedia/{id}', [AlihmediaController::class, 'getPdf']);

Route::get('getKlasifikasi', [ReferensiController::class, 'getKlasifikasi']);
Route::get('getOPD', [ReferensiController::class, 'getOPD']);

// Klasifikasi
Route::prefix('klasifikasi')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [KlasifikasiController::class, 'getData']);
    Route::get('/getById/{id}', [KlasifikasiController::class, 'getById']);
    Route::post('/store', [KlasifikasiController::class, 'store']);
    Route::post('/destroy/{id}', [KlasifikasiController::class, 'destroy']);
});

// Alih Media
Route::prefix('alihmedia')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AlihmediaController::class, 'getData']);
    Route::get('/getById/{id}', [AlihmediaController::class, 'getById']);
    Route::post('/store', [AlihmediaController::class, 'store']);
    Route::post('/destroy/{id}', [AlihmediaController::class, 'destroy']);
});

// Validasi Data
Route::prefix('validasidata')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ValidasidataController::class, 'getData']);
    Route::get('/getById/{id}', [ValidasidataController::class, 'getById']);
    Route::post('/store', [ValidasidataController::class, 'store']);
    Route::post('/destroy/{id}', [ValidasidataController::class, 'destroy']);
});

// Manajemen Akun
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'getData']);
    Route::post('/store', [UserController::class, 'store']);
    Route::post('/reset/{id}', [UserController::class, 'reset']);
    Route::post('/changePassword', [UserController::class, 'changePassword']);
    Route::post('/activate/{id}', [UserController::class, 'activate']);
    Route::post('/destroy/{id}', [UserController::class, 'destroy']);
});
