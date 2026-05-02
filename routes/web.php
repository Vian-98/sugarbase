<?php

use Illuminate\Support\Facades\Route;
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