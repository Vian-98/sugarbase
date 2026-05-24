@extends('layouts.app')

@section('title', $produk->nama_produk)

@section('content')
<div class="container py-4" style="max-width:800px">

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

<<<<<<< HEAD
    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-5 text-center p-4">
                @if($produk->foto)
                    <img src="{{ asset('storage/'.$produk->foto) }}"
                         class="img-fluid rounded" style="max-height:320px; object-fit:cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                         style="height:280px; font-size:5rem;">🍰</div>
                @endif
=======
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    
    <!-- FOTO PRODUK -->
    <div style="background: #f3f4f6; border-radius: 8px; min-height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        @if($produk->foto)
            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}"
                 style="width: 100%; height: 300px; object-fit: contain;">
        @else
            <div style="font-size: 5em;">🍰</div>
        @endif
    </div>
    
    <!-- INFO PRODUK -->
    <div>
        <div style="margin-bottom: 20px;">
            <span style="background: #e8f9ff; padding: 5px 12px; border-radius: 4px; font-size: 0.85em; color: #667eea; font-weight: 600;">
                {{ $produk->kategori->nama_kategori ?? 'N/A' }}
            </span>
        </div>
        
        <h1 style="font-size: 2em; color: #1f2937; margin: 15px 0;">{{ $produk->nama_produk }}</h1>
        
        <div style="display: flex; align-items: center; gap: 20px; margin: 20px 0; padding: 20px 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
            <div>
                <p style="color: #6b7280; font-size: 0.9em; margin: 0;">Harga</p>
                <h2 style="color: #667eea; font-size: 2.2em; margin: 5px 0;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
>>>>>>> e9344821e6ccdc9ad20f5eea13240736932e2c6c
            </div>
            <div class="col-md-7 p-4">
                <span class="badge bg-danger mb-2">{{ $produk->kategori->nama_kategori ?? 'Uncategorized' }}</span>
                <h2 class="fw-bold">{{ $produk->nama_produk }}</h2>
                <h4 class="text-danger fw-bold">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </h4>
                <p class="text-muted">Stok tersedia: <strong>{{ $produk->stok }}</strong></p>
                <p>{{ $produk->deskripsi_produk }}</p>

                @if($produk->stok > 0)
                <form method="POST" action="/keranjang/tambah">
                    @csrf
                    <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <label class="fw-semibold">Jumlah:</label>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="let i=document.getElementById('qty'); if(i.value>1) i.value--">−</button>
                        <input type="number" id="qty" name="jumlah" value="1"
                               min="1" max="{{ $produk->stok }}"
                               class="form-control text-center" style="width:70px">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="let i=document.getElementById('qty'); if(i.value<{{ $produk->stok }}) i.value++">+</button>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
                        🛒 Tambah ke Keranjang
                    </button>
                </form>
                @else
                    <div class="alert alert-warning">Stok habis</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection