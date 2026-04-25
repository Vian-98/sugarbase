@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>📊 Dashboard</h1>
    <p>Selamat datang di Sugarbase - E-Commerce Management System</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="text-align: center; border: 2px solid var(--primary);">
        <div style="font-size: 2.5em; margin-bottom: 10px;">👥</div>
        <h3 style="color: var(--primary); font-size: 1.5em;">{{ $totalAkun }}</h3>
        <p style="color: #6b7280;">Total Akun</p>
    </div>
    
    <div class="card" style="text-align: center; border: 2px solid var(--success);">
        <div style="font-size: 2.5em; margin-bottom: 10px;">📦</div>
        <h3 style="color: var(--success); font-size: 1.5em;">{{ $totalProduk }}</h3>
        <p style="color: #6b7280;">Total Produk</p>
    </div>
    
    <div class="card" style="text-align: center; border: 2px solid var(--warning);">
        <div style="font-size: 2.5em; margin-bottom: 10px;">🛒</div>
        <h3 style="color: var(--warning); font-size: 1.5em;">{{ $totalPesanan }}</h3>
        <p style="color: #6b7280;">Total Pesanan</p>
    </div>
    
    <div class="card" style="text-align: center; border: 2px solid #3b82f6;">
        <div style="font-size: 2.5em; margin-bottom: 10px;">📂</div>
        <h3 style="color: #3b82f6; font-size: 1.5em;">{{ $totalKategori }}</h3>
        <p style="color: #6b7280;">Kategori</p>
    </div>
</div>

<div class="card">
    <h2>ℹ️ Informasi Sistem</h2>
    <ul style="list-style: none; line-height: 2;">
        <li><strong>Framework:</strong> Laravel {{ app()->version() }}</li>
        <li><strong>PHP Version:</strong> {{ phpversion() }}</li>
        <li><strong>Database:</strong> MySQL - sugarbase</li>
        <li><strong>Environment:</strong> {{ config('app.env') }}</li>
        <li><strong>URL:</strong> {{ config('app.url') }}</li>
    </ul>
</div>

<div class="card">
    <h2>🚀 Mulai Develop</h2>
    <p style="margin-bottom: 15px; color: #6b7280;">Navigasi menggunakan sidebar di sebelah kiri untuk mengakses fitur-fitur aplikasi.</p>
    <a href="/produk" class="btn btn-primary">Lihat Produk →</a>
</div>
@endsection
