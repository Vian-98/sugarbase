<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.view');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::get('/qr', function () { return view('qrcode'); })->name('qr');
