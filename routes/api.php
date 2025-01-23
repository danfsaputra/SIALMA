<?php

use App\Http\Controllers\API\AlihmediaController;
use App\Http\Controllers\API\KlasifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ValidasidataController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\API\BeritaacaraController;
use App\Http\Controllers\API\DaftararsipController;
use App\Http\Controllers\API\HakaksesController;
use App\Http\Controllers\API\KeamananController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute untuk file image dan pdf
Route::get('alihmedia/image/{file}', [AlihmediaController::class, 'getImage']);
Route::get('alihmedia/pdf/{file}', [AlihmediaController::class, 'getPdf']);

// Referensi
Route::get('getKlasifikasi', [ReferensiController::class, 'getKlasifikasi']);
Route::get('getOPD', [ReferensiController::class, 'getOPD']);

// Klasifikasi
Route::prefix('klasifikasi')->group(function () {
    Route::get('/', [KlasifikasiController::class, 'getData']);
    Route::get('/getById/{id}', [KlasifikasiController::class, 'getById']);
    Route::post('/store', [KlasifikasiController::class, 'store']);
    Route::post('/destroy/{id}', [KlasifikasiController::class, 'destroy']);
    Route::get('/validated', [KlasifikasiController::class, 'getValidatedData']);
    Route::get('/alihmedia', [KlasifikasiController::class, 'getAlihmediaData']); // Tambahkan rute ini
});

// Alih Media
Route::prefix('alihmedia')->group(function () {
    Route::get('/', [AlihmediaController::class, 'getData']);
    Route::get('/getById/{id}', [AlihmediaController::class, 'getById']);
    Route::post('/store', [AlihmediaController::class, 'store']);
    Route::post('/destroy/{id}', [AlihmediaController::class, 'destroy']);
});

// Validasi Data
Route::prefix('validasidata')->group(function () {
    Route::get('/', [ValidasidataController::class, 'getData']);
    Route::get('/getById/{id}', [ValidasidataController::class, 'getById']);
    Route::post('/store', [ValidasidataController::class, 'store']);
    Route::post('/destroy/{id}', [ValidasidataController::class, 'destroy']);
});

// Manajemen Akun
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'getData']);
    Route::post('/store', [UserController::class, 'store']);
    Route::post('/reset/{id}', [UserController::class, 'reset']);
    Route::post('/changePassword', [UserController::class, 'changePassword']);
    Route::post('/activate/{id}', [UserController::class, 'activate']);
    Route::post('/destroy/{id}', [UserController::class, 'destroy']);
});

// Berita Acara
Route::prefix('berita')->group(function () {
    Route::get('/', [BeritaacaraController::class, 'getData']);
    Route::get('/getById/{id}', [BeritaacaraController::class, 'getById']);
    Route::post('/store', [BeritaacaraController::class, 'store']);
    Route::post('/destroy/{id}', [BeritaacaraController::class, 'destroy']);
    Route::get('/image/{file}', [BeritaacaraController::class, 'getImage']);
});

// Daftar
Route::prefix('daftararsip')->group(function () {
    Route::get('/', [DaftararsipController::class, 'getData']);
    Route::get('/getById/{id}', [DaftararsipController::class, 'getById']);
    Route::post('/store', [DaftararsipController::class, 'store']);
    Route::post('/destroy/{id}', [DaftararsipController::class, 'destroy']);
});

// Hak Akses
Route::prefix('hak')->group(function () {
    Route::get('/', [HakaksesController::class, 'getData']);
    Route::get('/getById/{id}', [HakaksesController::class, 'getById']);
    Route::post('/store', [HakaksesController::class, 'store']);
    Route::post('/destroy/{id}', [HakaksesController::class, 'destroy']);
});

// SKKAAD
Route::prefix('skkaad')->group(function () {
    Route::get('/', [KeamananController::class, 'getData']);
    Route::get('/getById/{id}', [KeamananController::class, 'getById']);
    Route::post('/store', [KeamananController::class, 'store']);
    Route::post('/destroy/{id}', [KeamananController::class, 'destroy']);
});