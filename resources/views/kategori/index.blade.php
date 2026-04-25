@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="page-header">
    <h1>📂 Kategori</h1>
    <p>Kelola kategori produk</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Daftar Kategori</h2>
        <a href="#" class="btn btn-primary">+ Tambah Kategori</a>
    </div>
    <p style="color: #6b7280;">Data kategori akan ditampilkan di sini. Silakan lengkapi fitur ini bersama tim Anda.</p>
</div>
@endsection
