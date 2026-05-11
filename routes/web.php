<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah']);
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update']);
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus']);
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'proses']);
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::get('/pesanan/saya', [PesananController::class, 'milikSaya'])->name('pesanan.saya');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/pesanan', [App\Http\Controllers\Admin\PesananController::class, 'index']);
    Route::post('/pesanan/{id}/status', [App\Http\Controllers\Admin\PesananController::class, 'updateStatus']);
    Route::post('/pembayaran/{id}/konfirmasi', [App\Http\Controllers\Admin\PembayaranController::class, 'konfirmasi']);
});

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
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('/kategori',  [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/pesanan', [App\Http\Controllers\Admin\PesananController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan/{id}/status', [App\Http\Controllers\Admin\PesananController::class, 'updateStatus'])->name('pesanan.status');
    Route::get('/pelanggan', [PelangganController::class,'index'])->name('pelanggan.index');
    Route::get('/pembayaran', [App\Http\Controllers\Admin\PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{id}/konfirmasi', [App\Http\Controllers\Admin\PembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
    Route::get('/qr', function () { return view('qrcode'); })->name('qr');
});

// ─── PELANGGAN (harus login) ──────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::patch('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::patch('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.readAll');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah']);
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update']);
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus']);

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'proses']);
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::get('/pesanan/saya', [PesananController::class, 'milikSaya'])->name('pesanan.saya');
});

// ─── ROOT REDIRECT ────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return redirect(auth()->user()->role === 'admin' ? '/admin/dashboard' : '/beranda');
    }
    return redirect('/login');
});
