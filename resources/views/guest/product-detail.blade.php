@extends('layouts.guest')

@section('title', $produk->nama_produk . ' - SugarBase')

@section('styles')
<style>
    .breadcrumb {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        align-items: center;
    }

    .breadcrumb a {
        color: #789DBC;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .product-detail {
        background: var(--surface-strong);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid var(--border);
    }

    .product-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
    }

    .product-image {
        background: var(--surface-muted);
        border-radius: 12px;
        height: 400px;
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
        font-size: 8em;
    }

    .product-details-section h1 {
        font-size: 2em;
        color: var(--dark);
        margin-bottom: 15px;
    }

    .product-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
    }

    .meta-label {
        font-size: 0.85em;
        color: var(--text-secondary);
        font-weight: 600;
    }

    .meta-value {
        font-size: 1.1em;
        color: var(--dark);
        font-weight: 600;
    }

    .price-section {
        background: var(--gradient-soft);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid rgba(120,157,188,0.15);
    }

    .price-label {
        font-size: 0.9em;
        color: var(--text-secondary);
        margin-bottom: 5px;
    }

    .price-value {
        font-size: 2.2em;
        font-weight: bold;
        color: #789DBC;
    }

    .description-section {
        margin-bottom: 30px;
    }

    .description-section h3 {
        font-size: 1.2em;
        color: var(--dark);
        margin-bottom: 15px;
    }

    .description-section p {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .action-section {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        padding-top: 25px;
        border-top: 1px solid var(--border);
    }

    .login-prompt {
        background: rgba(120,157,188,0.15);
        border: 1px solid var(--border);
        color: var(--text-secondary);
        padding: 15px 20px;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
        margin-bottom: 30px;
    }

    .stock-status {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.9em;
        font-weight: 600;
    }

    .stock-available {
        background: rgba(126,187,152,0.15);
        color: var(--success);
    }

    .stock-limited {
        background: rgba(231,200,158,0.15);
        color: var(--warning);
    }

    .stock-unavailable {
        background: rgba(217,137,153,0.15);
        color: var(--danger);
    }

    .btn-custom-primary {
        background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%);
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-block;
        text-align: center;
    }

    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);
        color: white;
    }

    .btn-custom-secondary {
        background: var(--surface-muted);
        color: var(--dark);
        border: 1px solid var(--border);
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
    }

    .btn-custom-secondary:hover {
        background: var(--primary);
        color: white;
    }

    .btn-back {
        background: var(--surface-muted);
        color: var(--text-secondary);
        border: 1px solid var(--border);
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
    }

    .btn-back:hover {
        background: var(--border);
        color: var(--dark);
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .product-image {
            height: 300px;
        }

        .product-details-section h1 {
            font-size: 1.5em;
        }

        .price-value {
            font-size: 1.8em;
        }

        .action-section {
            flex-direction: column;
        }

        .action-section a {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

<!-- BREADCRUMB -->
<div class="breadcrumb">
    <a href="/">Beranda</a>
    <span>›</span>
    <a href="/guest/katalog">Katalog</a>
    <span>›</span>
    <span style="color: var(--text-secondary);">{{ $produk->nama_produk }}</span>
</div>

<!-- LOGIN PROMPT -->
<div class="login-prompt">
    👋 Anda dapat melihat detail produk ini, namun untuk membeli silakan <a href="/login" style="color: var(--primary); font-weight: bold; text-decoration: underline;">masuk</a> terlebih dahulu.
</div>

<!-- PRODUCT DETAIL -->
<div class="product-detail">
    <div class="product-grid">
        
        <!-- PRODUCT IMAGE -->
        <div class="product-image">
            @if($produk->foto)
                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}">
            @else
                <div class="product-image-emoji">🍰</div>
            @endif
        </div>

        <!-- PRODUCT DETAILS -->
        <div class="product-details-section">
            <h1>{{ $produk->nama_produk }}</h1>

            <!-- META INFO -->
            <div class="product-meta">
                <div class="meta-item">
                    <span class="meta-label">📂 Kategori</span>
                    <span class="meta-value">{{ $produk->kategori->nama_kategori ?? 'Uncategorized' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">📦 Stok Tersedia</span>
                    @if($produk->stok > 20)
                        <span class="meta-value stock-status stock-available">✓ Stok Banyak ({{ $produk->stok }})</span>
                    @elseif($produk->stok > 0)
                        <span class="meta-value stock-status stock-limited">⚠ Stok Terbatas ({{ $produk->stok }})</span>
                    @else
                        <span class="meta-value stock-status stock-unavailable">✗ Stok Habis</span>
                    @endif
                </div>
            </div>

            <!-- PRICE SECTION -->
            <div class="price-section">
                <div class="price-label">Harga</div>
                <div class="price-value">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
            </div>

            <!-- DESCRIPTION -->
            @if($produk->deskripsi_produk)
            <div class="description-section">
                <h3>📝 Deskripsi Produk</h3>
                <p>{{ $produk->deskripsi_produk }}</p>
            </div>
            @endif

            <!-- ACTIONS -->
            <div class="action-section">
                <a href="/login" class="btn-custom-primary" style="width: 100%;">
                    🛒 Masuk untuk Membeli
                </a>
                <a href="/register" class="btn-custom-secondary" style="width: 100%;">
                    📝 Daftar Akun Baru
                </a>
                <a href="/guest/katalog" class="btn-back" style="width: 100%;">
                    ← Kembali ke Katalog
                </a>
            </div>

        </div>

    </div>
</div>

@endsection
