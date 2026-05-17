@extends('layouts.guest')

@section('title', 'Katalog - SugarBase')

@section('styles')
<style>
    .page-title {
        margin-bottom: 30px;
    }

    .page-title h1 {
        font-size: 2em;
        margin-bottom: 10px;
    }

    .filters {
        background: var(--surface-strong);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid var(--border);
    }

    .filters-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-weight: 600;
        font-size: 0.9em;
        color: var(--text-secondary);
    }

    .filter-group select,
    .filter-group input {
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.9em;
        background: var(--surface);
        color: var(--dark);
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
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
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--surface-strong);
        border-radius: 12px;
        border: 1px solid var(--border);
    }

    .empty-state-emoji {
        font-size: 4em;
        margin-bottom: 20px;
    }

    .empty-state h2 {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 20px;
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
        .filters-row {
            flex-direction: column;
            align-items: stretch;
        }

        .grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>
@endsection

@section('content')

<!-- LOGIN PROMPT -->
<div class="login-prompt">
    👋 Anda dapat melihat produk kami, namun untuk membeli silakan <a href="/login" style="color: var(--primary); font-weight: bold; text-decoration: underline;">masuk</a> terlebih dahulu.
</div>

<!-- PAGE TITLE -->
<div class="page-title">
    <h1>📦 Katalog Produk</h1>
    <p style="color: var(--text-secondary);">Temukan dessert favorit Anda dari koleksi lengkap kami</p>
</div>

<!-- FILTERS -->
<div class="filters">
    <form method="GET" action="/guest/katalog">
        <div class="filters-row">
            <div class="filter-group" style="flex: 1;">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="filter-group" style="flex: 2;">
                <label for="search">Cari Produk</label>
                <input type="text" name="search" id="search" placeholder="Cari produk..." value="{{ request('search') }}">
            </div>
            
            <div class="filter-group" style="justify-content: flex-end;">
                <button type="submit" class="btn-custom-primary" style="margin-top: 24px;">Cari</button>
            </div>
        </div>
    </form>
</div>

<!-- PRODUCTS GRID -->
@if($produk->count() > 0)
    <div class="grid">
        @foreach($produk as $item)
        <div class="product-card">
            <div class="product-image">
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}">
                @else
                    <div class="product-image-emoji">🍰</div>
                @endif
            </div>
            
            <div class="product-info">
                <h3 class="product-name">{{ $item->nama_produk }}</h3>
                
                <p class="product-category">
                    <span>{{ $item->kategori->nama_kategori ?? 'N/A' }}</span>
                </p>
                
                <p class="product-stock">
                    Stok: <strong>{{ $item->stok }}</strong>
                </p>
                
                <div class="product-footer">
                    <span class="product-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                    <a href="/guest/produk/{{ $item->id_produk }}" class="btn-custom-primary" style="padding: 6px 12px; font-size: 0.85em;">
                        Lihat
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- PAGINATION -->
    @if(method_exists($produk, 'links'))
    <div class="pagination">
        {{ $produk->appends(request()->query())->links() }}
    </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-state-emoji">📭</div>
        <h2>Tidak Ada Produk</h2>
        <p>Produk yang Anda cari tidak tersedia. Silakan coba filter lain.</p>
        <a href="/guest/katalog" class="btn-custom-primary">Lihat Semua Produk</a>
    </div>
@endif

@endsection
