@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="page-header">
    <h1>📦 Produk</h1>
    <p>Kelola semua produk di sistem</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Daftar Produk</h2>
        <a href="#" class="btn btn-primary">+ Tambah Produk</a>
    </div>
    <p style="color: #6b7280;">Data produk akan ditampilkan di sini. Silakan lengkapi fitur ini bersama tim Anda.</p>
</div>
@endsection
