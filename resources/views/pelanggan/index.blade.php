@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')
<div class="page-header">
    <h1>👥 Pelanggan</h1>
    <p>Kelola data pelanggan</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Daftar Pelanggan</h2>
        <a href="#" class="btn btn-primary">+ Tambah Pelanggan</a>
    </div>
    <p style="color: #6b7280;">Data pelanggan akan ditampilkan di sini. Silakan lengkapi fitur ini bersama tim Anda.</p>
</div>
@endsection
