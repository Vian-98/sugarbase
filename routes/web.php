<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\SearchController;

// ─── AUTH (guest only) ────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// Logout (harus login dulu)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── ADMIN (harus login + role admin) ────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/produk',    [ProdukController::class,   'index'])->name('produk.index');
    Route::get('/kategori',  [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/pesanan',   [PesananController::class,  'index'])->name('pesanan.index');
    Route::get('/pelanggan', [PelangganController::class,'index'])->name('pelanggan.index');
    Route::get('/pembayaran',[PembayaranController::class,'index'])->name('pembayaran.index');
    Route::get('/qr', function () { return view('qrcode'); })->name('qr');
});

// ─── PELANGGAN (harus login) ──────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
});

// ─── ROOT REDIRECT ────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return redirect(auth()->user()->role === 'admin' ? '/admin/dashboard' : '/beranda');
    }
    return redirect('/login');
});
