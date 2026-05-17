<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - SugarBase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', Montserrat, Geneva, Montserrat, sans-serif;
            background: var(--gradient-soft);
            color: var(--dark);
        }

        .navbar {
            background: var(--surface-strong);
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
            color: #789DBC;
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
            color: var(--text-secondary);
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar-right a:hover {
            color: #789DBC;
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
            background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);
        }

        .btn-secondary {
            background: var(--surface-muted);
            color: #789DBC;
            border: 1px solid rgba(120,157,188,0.15);
        }

        .btn-secondary:hover {
            background: #789DBC;
            color: white;
        }

        .btn-disabled {
            background: #d1d5db;
            color: var(--text-secondary);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

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
            border-radius: 8px;
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
            border: 1px solid #c7d2fe;
            color: var(--primary);
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
                text-align: center;
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
            <a href="/guest/katalog">Katalog</a>
            <a href="/login" class="btn btn-primary" style="padding: 8px 16px;">Masuk</a>
            <a href="/register" class="btn btn-secondary" style="padding: 8px 16px;">Daftar</a>
        </div>
    </nav>

    <div class="container">

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
                        <a href="/login" class="btn btn-primary" style="padding: 12px 30px; width: 100%; text-align: center;">
                            🛒 Masuk untuk Membeli
                        </a>
                        <a href="/register" class="btn btn-secondary" style="padding: 12px 30px; width: 100%; text-align: center;">
                            📝 Daftar Akun Baru
                        </a>
                        <a href="/guest/katalog" class="btn" style="padding: 12px 30px; width: 100%; text-align: center; background: var(--surface-muted); color: var(--text-secondary); border: 1px solid var(--border);">
                            ← Kembali ke Katalog
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <h3>🍰 SugarBase</h3>
        <p style="margin-top: 10px; opacity: 0.8;">Toko Dessert Premium dengan Berbagai Pilihan Produk Terbaik</p>
        <p style="margin-top: 20px; opacity: 0.6; font-size: 0.9em;">© 2026 SugarBase. All rights reserved.</p>
    </footer>

</body>
</html>
