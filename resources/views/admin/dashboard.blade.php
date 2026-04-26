@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_title')
    <h1>📊 Dashboard Admin</h1>
    <p>Selamat datang di Sugarbase - Admin Panel</p>
@endsection

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        {{-- Total Akun --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #667eea;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">👥</div>
            <h3 style="color: #667eea; font-size: 1.8em; margin: 10px 0;">{{ $totalAkun }}</h3>
            <p style="color: #6b7280;">Total Akun</p>
        </div>
        
        {{-- Total Produk --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #22c55e;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">📦</div>
            <h3 style="color: #22c55e; font-size: 1.8em; margin: 10px 0;">{{ $totalProduk }}</h3>
            <p style="color: #6b7280;">Total Produk</p>
        </div>
        
        {{-- Total Pesanan --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f59e0b;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">🛒</div>
            <h3 style="color: #f59e0b; font-size: 1.8em; margin: 10px 0;">{{ $totalPesanan }}</h3>
            <p style="color: #6b7280;">Total Pesanan</p>
        </div>
        
        {{-- Total Kategori --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #8b5cf6;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">📂</div>
            <h3 style="color: #8b5cf6; font-size: 1.8em; margin: 10px 0;">{{ $totalKategori }}</h3>
            <p style="color: #6b7280;">Total Kategori</p>
        </div>

    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-top: 20px;">
        <h2 style="margin-bottom: 15px;">📈 Quick Actions</h2>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.produk.index') }}" 
               style="background: #667eea; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block;">
                Kelola Produk
            </a>
            <a href="{{ route('admin.kategori.index') }}" 
               style="background: #764ba2; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block;">
                Kelola Kategori
            </a>
            <a href="{{ route('admin.pesanan.index') }}" 
               style="background: #8b5cf6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block;">
                Kelola Pesanan
            </a>
        </div>
    </div>

@endsection
