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
use App\Http\Controllers\API\PenyusutanController;
use App\Http\Controllers\API\JenisarsipController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Referensi
Route::get('getKlasifikasi', [ReferensiController::class, 'getKlasifikasi']);
Route::get('getOPD', [ReferensiController::class, 'getOPD']);
Route::get('getHakakses', [ReferensiController::class, 'getHakakses']);
Route::get('getKeamanan', [ReferensiController::class, 'getKeamanan']);
Route::get('getPenyusutan', [ReferensiController::class, 'getPenyusutan']);

// Klasifikasi
Route::prefix('klasifikasi')->group(function () {
    Route::get('/', [KlasifikasiController::class, 'getData']);
    Route::get('/getById/{id}', [KlasifikasiController::class, 'getById']);
    Route::post('/store', [KlasifikasiController::class, 'store']);
    Route::post('/destroy/{id}', [KlasifikasiController::class, 'destroy']);
    //Route::get('/validated', [KlasifikasiController::class, 'getValidatedData']);
    //Route::get('/alihmedia', [KlasifikasiController::class, 'getAlihmediaData']); 
});

// Alih Media
Route::prefix('alihmedia')->group(function () {
    Route::get('/', [AlihmediaController::class, 'getData']);
    Route::get('/getById/{id}', [AlihmediaController::class, 'getById']);
    Route::post('/store', [AlihmediaController::class, 'store']);
    Route::post('/destroy/{id}', [AlihmediaController::class, 'destroy']);
    Route::get('/getImage/{file}', [AlihmediaController::class, 'getImage']);
    //Route::get('/api/alihmedia/file/{file}', [AlihmediaController::class, 'getImage']);
});

// Validasi Data
Route::prefix('validasidata')->group(function () {
    Route::get('/', [ValidasidataController::class, 'getData']);
    Route::get('/getById/{id}', [ValidasidataController::class, 'getById']);
    Route::post('/store', [ValidasidataController::class, 'store']);
    Route::post('/destroy/{id}', [ValidasidataController::class, 'destroy']);
    Route::get('/getImage/{file}', [ValidasidataController::class, 'getImage']);
});

// Berita Acara
Route::prefix('berita')->group(function () {
    Route::get('/', [BeritaacaraController::class, 'getData']);
    Route::get('/getById/{id}', [BeritaacaraController::class, 'getById']);
    Route::post('/store', [BeritaacaraController::class, 'store']);
    Route::post('/destroy/{id}', [BeritaacaraController::class, 'destroy']);
    Route::get('/getImage/{file}', [BeritaAcaraController::class, 'getImage']);
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

// Penyusutan
Route::prefix('penyusutan')->group(function () {
    Route::get('/', [PenyusutanController::class, 'getData']);
    Route::get('/getById/{id}', [PenyusutanController::class, 'getById']);
    Route::post('/store', [PenyusutanController::class, 'store']);
    Route::post('/destroy/{id}', [PenyusutanController::class, 'destroy']);
    });

// Jenis
Route::prefix('jenis')->group(function () {
    Route::get('/', [JenisarsipController::class, 'getData']);
    Route::get('/getById/{id}', [JenisarsipController::class, 'getById']);
    Route::post('/store', [JenisarsipController::class, 'store']);
    Route::post('/destroy/{id}', [JenisarsipController::class, 'destroy']);
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