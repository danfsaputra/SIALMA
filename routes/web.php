<?php

use App\Http\Controllers\API\AlihmediaController;
use App\Http\Controllers\API\BeritaacaraController;
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

    Route::get('/alihmedia', function () {
        return Inertia::render('Alihmedia/Main', ['title' => 'Data Alih Media', 'submenu' => 'Alih Media']);
    })->name('alihmedia');

    Route::get('/klasifikasi', function () {
        return Inertia::render('Klasifikasi/Main', ['title' => 'Data Klasifikasi', 'submenu' => 'Master Data']);
    })->name('klasifikasi');

    Route::get('/klasifikasi-detail', function (Request $request) {
        return Inertia::render('Klasifikasi/Detail', ['title' => 'Detail Klasifikasi', 'submenu' => 'Master Data', 'nm_klasifikasi' => $request->nm_klasifikasi]);
    })->name('klasifikasi-detail');

    Route::post('/alihmedia/{id}', [AlihmediaController::class, 'store'])->name('store');

    Route::get('/alihmedia-form', function (Request $request) {
        return Inertia::render('Alihmedia/Form', ['title' => 'Entry Data Alih Media', 'submenu' => 'Alih Media', 'id' => $request->id]);
    })->name('alihmedia-form');

    Route::get('/alihmedia-detail', function (Request $request) {
        return Inertia::render('Alihmedia/Detail', ['title' => 'Data Alih Media', 'submenu' => 'Alih Media', 'id' => $request->id]);
    })->name('alihmedia-detail');

    Route::get('/pdf/preview/{id}', [AlihmediaController::class, 'getPdf']);

    Route::get('/validasidata', function () {
        return Inertia::render('Validasi/Main', ['title' => 'Validasi Data Alih Media', 'submenu' => 'Validasi Alih Media']);
    })->name('validasi');

    Route::get('/validasi-detail', function (Request $request) {
        return Inertia::render('Validasi/Detail', ['title' => 'Validasi Data Alih Media', 'submenu' => 'Alih Media', 'id' => $request->id]);
    })->name('validasi-detail');

    Route::get('/validasi-form', function (Request $request) {
        return Inertia::render('Validasi/Form', ['title' => 'Form Validasi Data Alih Media', 'submenu' => 'Alih Media', 'id' => $request->id]);
    })->name('validasi-form');

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

    Route::post('/berita/{id}', [BeritaAcaraController::class, 'store'])->name('store');

    Route::get('/berita-form', function (Request $request) {
        return Inertia::render('BeritaAcara/Form', ['title' => 'Form Berita Acara', 'submenu' => 'Berita Acara', 'id' => $request->id]);
    })->name('berita-form');

    Route::get('/berita-detail', function (Request $request) {
        return Inertia::render('BeritaAcara/Detail', ['title' => 'Detail Berita Acara', 'submenu' => 'Berita Acara', 'id' => $request->id]);
    })->name('berita-detail');

    // Daftar Arsip
    Route::get('/daftararsip', function () {
        return Inertia::render('Daftararsip/Main', ['title' => 'Daftar Arsip', 'submenu' => 'Daftar Arsip']);
    })->name('daftararsip');

    Route::get('/daftararsip-detail', function (Request $request) {
        return Inertia::render('Daftararsip/Detail', ['title' => 'Detail Arsip', 'submenu' => 'Daftar Arsip', 'id' => $request->id]);
    })->name('daftararsip-detail');

});

require __DIR__ . '/auth.php';
