<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\UserController;

// **Halaman Utama (Berita Lokal + API)**
Route::get('/', [BeritaController::class, 'index'])->name('home');

// **Fitur Pencarian Berita**
Route::get('/search', [BeritaController::class, 'search'])->name('berita.search');

// **Login & Register**
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// **Halaman Detail Berita Nasional & Internasional**
Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/berita-internasional/{id}', [BeritaController::class, 'showInternationalNews'])->name('berita.international.show');

// **Halaman Kategori Berita**
Route::get('/kategori/{kategori}', [BeritaController::class, 'kategori'])->name('berita.kategori');

// **Dashboard User (Setelah Login)**
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [BeritaController::class, 'dashboard'])->name('dashboard');
});

// **Dashboard Admin & CRUD Berita**
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [BeritaController::class, 'adminIndex'])->name('admin.dashboard');

    // **CRUD Berita**
    Route::resource('/admin/berita', BeritaController::class)->parameters([
        'berita' => 'berita'
    ])->names([
        'index'   => 'admin.berita.index',
        'create'  => 'admin.berita.create',
        'store'   => 'admin.berita.store',
        'show'    => 'admin.berita.show',
        'edit'    => 'admin.berita.edit',
        'update'  => 'admin.berita.update',
        'destroy' => 'admin.berita.destroy',
    ]);

    // **CRUD Kategori oleh Admin**
    Route::resource('/admin/kategori', KategoriController::class);

    // **Manajemen Pengguna oleh Admin**
    Route::resource('/admin/users', UserController::class);
});

// **Fitur Komentar di Berita**
Route::post('/berita/{berita}/komentar', [KomentarController::class, 'store'])->name('berita.komentar');