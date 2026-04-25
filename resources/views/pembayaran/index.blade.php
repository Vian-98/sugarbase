@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="page-header">
    <h1>💳 Pembayaran</h1>
    <p>Kelola transaksi pembayaran</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Daftar Pembayaran</h2>
        <a href="#" class="btn btn-primary">+ Pembayaran Baru</a>
    </div>
    <p style="color: #6b7280;">Data pembayaran akan ditampilkan di sini. Silakan lengkapi fitur ini bersama tim Anda.</p>
</div>
@endsection
