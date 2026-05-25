@extends('layouts.guest')

@section('title', 'Beranda - SugarBase')

@section('styles')
<style>
    .hero {
        background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%);
        color: white;
        padding: 64px 40px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 40px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.25);
    }

    .hero h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    .hero p {
        font-size: 1.1em;
        opacity: 0.95;
        margin-bottom: 20px;
    }

    .section {
        margin-bottom: 40px;
    }

    .section h2 {
        font-size: 1.5em;
        color: var(--dark);
        margin-bottom: 20px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .kategori-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }

    .kategori-card {
        background: var(--surface-strong);
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        color: #789DBC;
        border: 1px solid rgba(120,157,188,0.15);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .kategori-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(120, 157, 188, 0.15);
        border-color: #789DBC;
    }

    .kategori-card span:first-child {
        font-size: 2em;
    }

    .kategori-card span:last-child {
        font-weight: 600;
    }

    .product-card {
        background: var(--surface-strong);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(120, 157, 188, 0.15);
    }

    .product-image {
        background: var(--surface-muted);
        height: 180px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-image-emoji {
        font-size: 3em;
    }

    .product-info {
        padding: 15px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        margin: 0 0 8px 0;
        font-size: 0.95em;
        color: var(--dark);
        font-weight: 600;
        line-height: 1.3;
    }

    .product-category {
        margin: 5px 0;
        font-size: 0.85em;
        color: var(--text-secondary);
    }

    .product-category span {
        background: rgba(120,157,188,0.15);
        padding: 3px 8px;
        border-radius: 4px;
    }

    .product-stock {
        margin: 10px 0;
        font-size: 0.9em;
        color: var(--text-secondary);
        flex: 1;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        border-top: 1px solid var(--border);
        padding-top: 10px;
    }

    .product-price {
        font-size: 1.1em;
        font-weight: bold;
        color: #789DBC;
    }

    .login-prompt {
        background: rgba(120,157,188,0.15);
        border: 1px solid var(--border);
        color: var(--text-secondary);
        padding: 12px 16px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .btn-custom-primary {
        background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-block;
    }

    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);
        color: white;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 1.8em;
        }

        .grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
    }
</style>
@endsection

@section('content')

<!-- GUEST INFO -->
<div class="login-prompt">
    👋 Halo Guest! Anda dapat melihat produk kami, namun untuk membeli silakan <a href="/login" style="color: var(--primary); font-weight: bold; text-decoration: underline;">masuk atau daftar</a> terlebih dahulu.
</div>

<!-- HERO BANNER -->
<section class="hero">
    <h1>🍰 Semua Manis, Satu Platform</h1>
    <p>Nikmati koleksi dessert premium kami dengan kualitas terbaik</p>
    <a href="/guest/katalog" class="btn-custom-primary">Jelajahi Produk →</a>
</section>

<!-- KATEGORI CEPAT -->
@if($kategori->count())
<section class="section">
    <h2>📂 Kategori</h2>
    <div class="kategori-grid">
        @foreach($kategori as $kat)
        <a href="/guest/katalog?kategori={{ $kat->id_kategori }}" class="kategori-card">
            <span>🍰</span>
            <span>{{ $kat->nama_kategori }}</span>
        </a>
        @endforeach
    </div>
</section>
@endif

<!-- PRODUK TERLARIS -->
@if($produkTerlaris->count())
<section class="section">
    <h2>⭐ Produk Terlaris</h2>
    <div class="grid">
        @foreach($produkTerlaris as $produk)
        <div class="product-card">
            <div class="product-image">
                @if($produk->foto)
                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}">
                @else
                    <div class="product-image-emoji">🍰</div>
                @endif
            </div>
            
            <div class="product-info">
                <h3 class="product-name">{{ $produk->nama_produk }}</h3>
                
                <p class="product-category">
                    <span>{{ $produk->kategori->nama_kategori ?? 'N/A' }}</span>
                </p>
                
                <p class="product-stock">
                    Stok: <strong>{{ $produk->stok }}</strong>
                </p>
                
                <div class="product-footer">
                    <span class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    <a href="/guest/produk/{{ $produk->id_produk }}" class="btn-custom-primary" style="padding: 6px 12px; font-size: 0.85em;">
                        Lihat
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- PRODUK TERBARU -->
@if($produkTerbaru->count())
<section class="section">
    <h2>🆕 Produk Terbaru</h2>
    <div class="grid">
        @foreach($produkTerbaru as $produk)
        <div class="product-card">
            <div class="product-image">
                @if($produk->foto)
                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}">
                @else
                    <div class="product-image-emoji">🍰</div>
                @endif
            </div>
            
            <div class="product-info">
                <h3 class="product-name">{{ $produk->nama_produk }}</h3>
                
                <p class="product-category">
                    <span>{{ $produk->kategori->nama_kategori ?? 'N/A' }}</span>
                </p>
                
                <p class="product-stock">
                    Stok: <strong>{{ $produk->stok }}</strong>
                </p>
                
                <div class="product-footer">
                    <span class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    <a href="/guest/produk/{{ $produk->id_produk }}" class="btn-custom-primary" style="padding: 6px 12px; font-size: 0.85em;">
                        Lihat
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection
