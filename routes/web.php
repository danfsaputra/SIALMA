<?php

use App\Http\Controllers\API\AlihmediaController;
use App\Http\Controllers\API\BeritaacaraController;
use App\Http\Controllers\API\ValidasidataController;
use App\Models\Validasidata;
use App\Models\Alihmedia;
use App\Models\Beritaacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', function () {
    return Inertia::render('Auth/login');
});

// Front Pages
Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('PrimevueChart', ['title' => 'Beranda', 'submenu' => 'Dashboard']);
    });
    
    //Alih Media
    Route::get('/alihmedia', function () {
        return Inertia::render('Alihmedia/Main', ['title' => 'Data Alih Media', 'submenu' => 'Alih Media']);
    })->name('alihmedia');

    Route::get('/alihmedia-form', function (Request $request) {
        return Inertia::render('Alihmedia/Form', ['title' => 'Entry Data Alih Media', 'submenu' => 'Alih Media', 'id' => $request->id]);
    })->name('alihmedia-form');

    Route::get('/alihmedia-detail', function (Request $request) {
        return Inertia::render('Alihmedia/Detail', ['title' => 'Data Alih Media', 'submenu' => 'Alih Media', 'id' => $request->id]);
    })->name('alihmedia-detail');

    Route::post('/alihmedia/{id}', [AlihmediaController::class, 'store'])->name('store');

    Route::get('/alihmedia/pdf/preview/{file}', [AlihmediaController::class, 'getImage']);


    //Klasifikasi
    Route::get('/klasifikasi', function () {
        return Inertia::render('Klasifikasi/Main', ['title' => 'Data Klasifikasi', 'submenu' => 'Master Data']);
    })->name('klasifikasi');

    Route::get('/klasifikasi-detail', function (Request $request) {
        return Inertia::render('Klasifikasi/Detail', ['title' => 'Detail Klasifikasi', 'submenu' => 'Master Data', 'nm_klasifikasi' => $request->nm_klasifikasi]);
    })->name('klasifikasi-detail');

    //Validasi data
    Route::post('/validasidata/{id}', [ValidasidataController::class, 'store'])->name('store');

    Route::get('/validasidata', function () {
        return Inertia::render('Validasi/Main', ['title' => 'Validasi Data Alih Media', 'submenu' => 'Validasi Alih Media']);
    })->name('validasi');

    Route::get('/validasi-detail', function (Request $request) {
        return Inertia::render('Validasi/Detail', ['title' => 'Validasi Data Alih Media', 'submenu' => 'Alih Media', 'id' => $request->id]);
    })->name('validasi-detail');

    Route::get('/validasi-form', function (Request $request) {
        return Inertia::render('Validasi/Form', ['title' => 'Form Validasi Data Alih Media', 'submenu' => 'Alih Media', 'id' => $request->id]);
    })->name('validasi-form');

    Route::get('/validasi/pdf/preview/{file}', [ValidasidataController::class, 'getImage']);


    // Klasifikasi
    Route::get('/sarpras', function () {
        return Inertia::render('Sata/Sarpras/Main', ['title' => 'Sarana Prasarana', 'submenu' => 'Satu Data']);
    });

    // Pelanggaran
    Route::get('/pelanggaran', function () {
        return Inertia::render('Trantibum/Pelanggaran/Main', ['title' => 'Pelanggaran', 'submenu' => 'Trantibum']);
    });

    // Manajemen Akun
    Route::get('/akun', function () {
        return Inertia::render('Pengaturan/Akun/Main', ['title' => 'Manajemen Akun', 'submenu' => 'Pengaturan']);
    });

    Route::get('/ganti-password', function (Request $request) {
        $user = $request->user();

        return Inertia::render('Pengaturan/Akun/ChangePassword', ['title' => 'Ganti Password', 'submenu' => 'Pengaturan', 'items' => $user]);
    });

    // Berita Acara
    Route::get('/berita', function () {
        return Inertia::render('BeritaAcara/Main', ['title' => 'Berita Acara', 'submenu' => 'Berita Acara']);
    })->name('berita');

    Route::post('/berita/{id}', [BeritaacaraController::class, 'store'])->name('store');

    Route::get('/berita-form', function (Request $request) {
        return Inertia::render('BeritaAcara/Form', ['title' => 'Form Berita Acara', 'submenu' => 'Berita Acara', 'id' => $request->id]);
    })->name('berita-form');

    Route::get('/berita-detail', function (Request $request) {
        return Inertia::render('BeritaAcara/Detail', ['title' => 'Detail Berita Acara', 'submenu' => 'Berita Acara', 'id' => $request->id]);
    })->name('berita-detail');

    Route::get('/berita/pdf/preview/{file}', [BeritaacaraController::class, 'getImage']);

    // Daftar Arsip
    Route::get('/daftararsip', function () {
        return Inertia::render('Daftararsip/Main', ['title' => 'Daftar Arsip', 'submenu' => 'Daftar Arsip']);
    })->name('daftararsip');

    Route::get('/daftararsip-detail', function (Request $request) {
        return Inertia::render('Daftararsip/Detail', ['title' => 'Detail Arsip', 'submenu' => 'Daftar Arsip', 'id' => $request->id]);
    })->name('daftararsip-detail');

    // Hak Akses
    Route::get('/hak', function () {
        return Inertia::render('HakAkses/Main', ['title' => 'Hak Akses', 'submenu' => 'Master Data']);
    })->name('hak');

    Route::get('/hak-detail', function (Request $request) {
        return Inertia::render('HakAkses/Detail', ['title' => 'Detail Hak Akses', 'submenu' => 'Pengaturan', 'id' => $request->id]);
    })->name('hak-detail');

    Route::get('/hak-form', function (Request $request) {
        return Inertia::render('HakAkses/Form', ['title' => 'Form Hak Akses', 'submenu' => 'Pengaturan', 'id' => $request->id]);
    })->name('hak-form');

    // SKKAAD
    Route::get('/skkaad', function () {
        return Inertia::render('Keamanan/Main', ['title' => 'Klasifikasi Keamanan', 'submenu' => 'Master Data']);
    })->name('skkaad');

    Route::get('/skkaad-detail', function (Request $request) {
        return Inertia::render('Keamanan/Detail', ['title' => 'Detail Klasifikasi Keamanan', 'submenu' => 'Master Data', 'id' => $request->id]);
    })->name('skkaad-detail');

    Route::get('/skkaad-form', function (Request $request) {
        return Inertia::render('Keamanan/Form', ['title' => 'Form Klasifikasi Keamanan', 'submenu' => 'Master Data', 'id' => $request->id]);
    })->name('skkaad-form');

    // Penyusutan
    Route::get('/penyusutan', function () {
        return Inertia::render('Penyusutan/Main', ['title' => 'Penyusutan Akhir', 'submenu' => 'Master Data']);
    })->name('penyusutan');

    Route::get('/penyusutan-detail', function (Request $request) {
        return Inertia::render('Penyusutan/Detail', ['title' => 'Detail Penyusutan', 'submenu' => 'Master Data', 'id' => $request->id]);
    })->name('penyusutan-detail');

    Route::get('/penyusutan-form', function (Request $request) {
        return Inertia::render('Penyusutan/Form', ['title' => 'Form Penyusutan', 'submenu' => 'Master Data', 'id' => $request->id]);
    })->name('penyusutan-form');


    // Jenis Arsip
    Route::get('/jenis', function () {
        return Inertia::render('Jenisarsip/Main', ['title' => 'Jenis Arsip', 'submenu' => 'Master Data']);
    })->name('jenis');

    Route::get('/jenisarsip-detail', function (Request $request) {
        return Inertia::render('Jenisarsip/Detail', ['title' => 'Detail Jenis Arsip', 'submenu' => 'Master Data', 'id' => $request->id]);
    })->name('jenis-detail');

    Route::get('/jenis-form', function (Request $request) {
        return Inertia::render('Jenisarsip/Form', ['title' => 'Form Jenis Arsip', 'submenu' => 'Master Data', 'id' => $request->id]);
    })->name('jenis-form');
});

require __DIR__ . '/auth.php';
