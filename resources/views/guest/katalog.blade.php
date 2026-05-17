<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - SugarBase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9fafb;
            color: #1f2937;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #667eea;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .navbar-right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .navbar-right a {
            text-decoration: none;
            color: #6b7280;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar-right a:hover {
            color: #667eea;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-title {
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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
            color: #6b7280;
        }

        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.9em;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
        }

        .product-image {
            background: #f3f4f6;
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
            color: #1f2937;
            font-weight: 600;
            line-height: 1.3;
        }

        .product-category {
            margin: 5px 0;
            font-size: 0.85em;
            color: #6b7280;
        }

        .product-category span {
            background: #e8f9ff;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .product-stock {
            margin: 10px 0;
            font-size: 0.9em;
            color: #6b7280;
            flex: 1;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .product-price {
            font-size: 1.1em;
            font-weight: bold;
            color: #667eea;
        }

        .login-prompt {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            color: #3730a3;
            padding: 12px 16px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .pagination a,
        .pagination span {
            padding: 10px 15px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            text-decoration: none;
            color: #667eea;
            font-weight: 600;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .empty-state-emoji {
            font-size: 4em;
            margin-bottom: 20px;
        }

        .empty-state h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #1f2937;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 20px;
        }

        .footer {
            background: #1f2937;
            color: white;
            padding: 40px 20px;
            text-align: center;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 1rem;
            }

            .filters-row {
                flex-direction: column;
                align-items: stretch;
            }

            .grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            🍰 SugarBase
        </a>
        <div class="navbar-right">
            <a href="/">Beranda</a>
            <a href="/guest/katalog" style="color: #667eea; font-weight: 600;">Katalog</a>
            <a href="/login" class="btn btn-primary" style="padding: 8px 16px;">Masuk</a>
            <a href="/register" class="btn btn-secondary" style="padding: 8px 16px;">Daftar</a>
        </div>
    </nav>

    <div class="container">

        <!-- LOGIN PROMPT -->
        <div class="login-prompt">
            👋 Anda dapat melihat produk kami, namun untuk membeli silakan <a href="/login" style="color: #3730a3; font-weight: bold; text-decoration: underline;">masuk</a> terlebih dahulu.
        </div>

        <!-- PAGE TITLE -->
        <div class="page-title">
            <h1>📦 Katalog Produk</h1>
            <p style="color: #6b7280;">Temukan dessert favorit Anda dari koleksi lengkap kami</p>
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
                        <button type="submit" class="btn btn-primary" style="margin-top: 27px;">Cari</button>
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
                            <a href="/guest/produk/{{ $item->id_produk }}" class="btn btn-primary" style="padding: 8px 12px; font-size: 0.85em;">
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
                <a href="/guest/katalog" class="btn btn-primary">Lihat Semua Produk</a>
            </div>
        @endif

    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <h3>🍰 SugarBase</h3>
        <p style="margin-top: 10px; opacity: 0.8;">Toko Dessert Premium dengan Berbagai Pilihan Produk Terbaik</p>
        <p style="margin-top: 20px; opacity: 0.6; font-size: 0.9em;">© 2026 SugarBase. All rights reserved.</p>
    </footer>

</body>
</html>
