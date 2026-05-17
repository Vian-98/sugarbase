<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SugarBase - Toko Dessert Premium</title>
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
            font-size: 16px;
            line-height: 1.6;
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
            color: var(--dark);
            font-weight: 600;
            transition: color 0.2s ease;
            padding: 6px 8px;
            border-radius: 8px;
        }

        /* Force primary buttons in navbar to have white text */
        .navbar-right a.btn-primary {
            color: #ffffff !important;
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
            background: transparent;
            color: #789DBC;
            border: none;
            box-shadow: none;
            padding: 6px 10px;
        }

        .btn-secondary:hover {
            background: rgba(102,126,234,0.06);
            color: #789DBC;
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
            border-radius: 8px;
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

        .guest-badge {
            background: rgba(231,200,158,0.15);
            border: 1px solid #fcd34d;
            color: var(--warning);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .login-prompt {
            background: rgba(231,200,158,0.15);
            border: 1px solid #fbe3c9;
            color: var(--warning);
            padding: 12px 16px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            box-shadow: 0 6px 18px rgba(250,204,21,0.05);
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

            .hero h1 {
                font-size: 1.8em;
            }

            .grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
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
            <a href="/" style="color: #789DBC; font-weight: 600;">Beranda</a>
            <a href="/guest/katalog">Katalog</a>
            <a href="/login" class="btn btn-primary" style="padding: 8px 16px;">Masuk</a>
            <a href="/register" class="btn btn-secondary" style="padding: 8px 16px;">Daftar</a>
        </div>
    </nav>

    <div class="container">

        <!-- GUEST INFO -->
        <div class="login-prompt">
            👋 Halo Guest! Anda dapat melihat produk kami, namun untuk membeli silakan <a href="/login" style="color: var(--primary); font-weight: bold; text-decoration: underline;">masuk atau daftar</a> terlebih dahulu.
        </div>

        <!-- HERO BANNER -->
        <section class="hero">
            <h1>🍰 Semua Manis, Satu Platform</h1>
            <p>Nikmati koleksi dessert premium kami dengan kualitas terbaik</p>
            <a href="/guest/katalog" class="btn btn-primary">Jelajahi Produk →</a>
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
                            <a href="/guest/produk/{{ $produk->id_produk }}" class="btn btn-primary" style="padding: 8px 12px; font-size: 0.85em;">
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
                            <a href="/guest/produk/{{ $produk->id_produk }}" class="btn btn-primary" style="padding: 8px 12px; font-size: 0.85em;">
                                Lihat
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
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
