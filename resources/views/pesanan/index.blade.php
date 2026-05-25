@extends('layouts.app')

@section('title', 'Pesanan')

@section('content')
<div class="page-header">
    <h1>🛒 Pesanan</h1>
    <p>Kelola semua pesanan pelanggan</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Daftar Pesanan</h2>
        <a href="#" class="btn btn-primary">+ Pesanan Baru</a>
    </div>
    <p style="color: var(--text-secondary);">Data pesanan akan ditampilkan di sini. Silakan lengkapi fitur ini bersama tim Anda.</p>
</div>
@endsection
