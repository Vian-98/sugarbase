@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<!-- HERO BANNER -->
<style>
    .hero-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, var(--bg) 0%, var(--surface-strong) 100%);
        padding: 60px 50px;
        border-radius: 28px;
        margin-bottom: 50px;
        gap: 40px;
        box-shadow: 0 20px 40px rgba(120, 157, 188, 0.06);
        border: 1px solid var(--border-soft);
        position: relative;
        overflow: visible; /* To allow glass card to float out safely if needed */
    }

    /* Abstract background shapes */
    .hero-section::before {
        content: '';
        position: absolute;
        top: -40%; left: -5%;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(201, 233, 210, 0.5) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
    }
    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%; right: -5%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(120, 157, 188, 0.4) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
    }

    .hero-content {
        flex: 1;
        max-width: 580px;
        z-index: 1;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(120, 157, 188, 0.12);
        color: var(--primary);
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.85em;
        font-weight: 700;
        margin-bottom: 24px;
        letter-spacing: 0.5px;
        border: 1px solid rgba(120, 157, 188, 0.25);
    }

    .hero-title {
        font-size: 3.4em;
        font-weight: 800;
        line-height: 1.15;
        color: var(--dark);
        margin-bottom: 20px;
        letter-spacing: -1px;
    }

    .hero-highlight {
        background: linear-gradient(120deg, #789DBC, #5B82A1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-description {
        font-size: 1.15em;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 35px;
        font-weight: 500;
    }

    .hero-actions {
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .btn-hero-primary {
        background: linear-gradient(135deg, #789DBC 0%, #5B82A1 100%);
        color: white !important;
        padding: 16px 32px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.05em;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 20px rgba(120, 157, 188, 0.25);
        display: inline-flex;
        align-items: center;
    }

    .btn-hero-primary:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(120, 157, 188, 0.35);
    }

    .btn-hero-secondary {
        background: var(--surface-strong);
        color: var(--dark) !important;
        padding: 15px 30px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.05em;
        transition: all 0.3s ease;
        border: 2px solid var(--border);
    }

    .btn-hero-secondary:hover {
        background: rgba(120, 157, 188, 0.05);
        border-color: var(--primary);
        color: var(--primary) !important;
    }

    .hero-visual {
        flex: 1;
        display: flex;
        justify-content: flex-end;
        position: relative;
        z-index: 1;
    }

    .hero-image-wrapper {
        position: relative;
        width: 100%;
        max-width: 460px;
        border-radius: 28px;
        background: var(--surface-strong);
        padding: 14px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.06);
        transform: rotate(2deg);
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-image-wrapper:hover {
        transform: rotate(0deg) scale(1.02);
    }

    .hero-img {
        width: 100%;
        height: auto;
        border-radius: 20px;
        display: block;
        object-fit: cover;
        aspect-ratio: 4/3;
    }

    .hero-glass-card {
        position: absolute;
        bottom: -25px;
        left: -35px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        padding: 18px 24px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid rgba(255,255,255,0.8);
        animation: heroFloat 5s ease-in-out infinite;
    }

    /* Dark Mode Overrides for Glass Card */
    html[data-theme='dark'] .hero-glass-card {
        background: rgba(30, 41, 59, 0.85);
        border-color: rgba(255,255,255,0.1);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    html[data-theme='dark'] .glass-icon { background: rgba(255, 255, 255, 0.1); }

    .glass-icon {
        font-size: 1.8em;
        background: var(--highlight);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
    }

    .glass-text strong {
        display: block;
        color: var(--dark);
        font-size: 1.15em;
        font-weight: 800;
        margin-bottom: 3px;
    }

    .glass-text span {
        color: var(--text-secondary);
        font-size: 0.85em;
        font-weight: 600;
    }

    @keyframes heroFloat {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
        100% { transform: translateY(0px); }
    }

    @media (max-width: 1024px) {
        .hero-section {
            flex-direction: column;
            padding: 40px 20px;
            text-align: center;
            overflow: hidden; /* Prevent glass card from expanding width too much on mobile */
        }
        .hero-content { max-width: 100%; }
        .hero-actions { justify-content: center; }
        .hero-visual { justify-content: center; margin-top: 40px; }
        .hero-image-wrapper { transform: rotate(0deg); max-width: 500px; }
        .hero-glass-card {
            left: 50%;
            transform: translateX(-50%);
            bottom: -15px;
            width: max-content;
            animation: none; /* Disable float on mobile to avoid layout shifts */
        }
    }
    @media (max-width: 480px) {
        .hero-title { font-size: 2.5em; }
        .hero-actions { flex-direction: column; width: 100%; }
        .btn-hero-primary, .btn-hero-secondary { width: 100%; justify-content: center; }
    }
</style>

@php
    // Mengambil produk terbaru untuk ditampilkan di Hero Banner
    $heroProduct = $produkTerbaru->first() ?? $produkTerlaris->first();
@endphp

<section class="hero-section">
    <div class="hero-content">
        @if($heroProduct)
            <span class="hero-badge">✨ Varian Terbaru Telah Hadir</span>
            <h1 class="hero-title">Cobain,<br><span class="hero-highlight">{{ $heroProduct->nama_produk }}</span></h1>
            <p class="hero-description">Tambahan terbaru di koleksi dessert premium kami. Dibuat dengan bahan pilihan untuk momen spesialmu hari ini.</p>
            <div class="hero-actions">
                <a href="/produk/{{ $heroProduct->id_produk }}" class="btn-hero-primary">
                    Pesan Sekarang <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="/katalog" class="btn-hero-secondary">
                    Lihat Katalog
                </a>
            </div>
        @else
            <span class="hero-badge">✨ Varian Rasa Baru Telah Hadir</span>
            <h1 class="hero-title">Semua Manis,<br><span class="hero-highlight">Satu Platform</span></h1>
            <p class="hero-description">Nikmati koleksi dessert premium kami dengan kualitas terbaik. Dibuat dengan bahan pilihan untuk momen spesialmu setiap hari.</p>
            <div class="hero-actions">
                <a href="/katalog" class="btn-hero-primary">
                    Belanja Sekarang <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="#kategori" class="btn-hero-secondary">
                    Lihat Kategori
                </a>
            </div>
        @endif
    </div>
    <div class="hero-visual">
        <div class="hero-image-wrapper">
            @if($heroProduct && $heroProduct->foto && file_exists(public_path('storage/' . $heroProduct->foto)))
                <img src="{{ asset('storage/' . $heroProduct->foto) }}" alt="{{ $heroProduct->nama_produk }}" class="hero-img">
            @else
                <img src="{{ asset('storage/produk/red-velvet-slice.jpg') }}" alt="Premium Dessert" class="hero-img">
            @endif
            <div class="hero-glass-card">
                <div class="glass-icon">⭐</div>
                <div class="glass-text">
                    <strong>4.9/5</strong>
                    <span>Rating Pelanggan</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KATEGORI CEPAT -->
@if($kategori->count())
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 1.5em; color: var(--dark); margin-bottom: 20px;">📂 Kategori</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
        @foreach($kategori as $kat)
        <a href="/katalog?kategori={{ $kat->id_kategori }}" 
           style="background: var(--surface-strong); padding: 20px; border-radius: 8px; text-align: center; text-decoration: none; color: var(--primary); border: 1px solid rgba(120,157,188,0.15); transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 10px;">
            <span style="font-size: 2em;">🍰</span>
            <span style="font-weight: 600;">{{ $kat->nama_kategori }}</span>
        </a>
        @endforeach
    </div>
</section>
@endif

<!-- PRODUK TERLARIS -->
@if($produkTerlaris->count())
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 1.5em; color: var(--dark); margin-bottom: 20px;">⭐ Produk Terlaris</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        @foreach($produkTerlaris as $produk)
        <div style="background: var(--surface-strong); border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid var(--border); transition: all 0.3s ease; display: flex; flex-direction: column;">
            <!-- Foto Produk -->
            <div style="background: var(--surface-muted); height: 180px; overflow: hidden;">
                @if($produk->foto)
                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}"
                         style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3em;">🍰</div>
                @endif
            </div>
            
            <!-- Info Produk -->
            <div style="padding: 15px; flex: 1; display: flex; flex-direction: column;">
                <h3 style="margin: 0 0 8px 0; font-size: 0.95em; color: var(--dark); font-weight: 600; line-height: 1.3;">
                    {{ $produk->nama_produk }}
                </h3>
                
                <p style="margin: 5px 0; font-size: 0.85em; color: var(--text-secondary);">
                    <span style="background: rgba(120,157,188,0.15); padding: 3px 8px; border-radius: 4px;">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</span>
                </p>
                
                <p style="margin: 10px 0; font-size: 0.9em; color: var(--text-secondary); flex: 1;">
                    Stok: <strong>{{ $produk->stok }}</strong>
                </p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; border-top: 1px solid var(--border); padding-top: 10px;">
                    <span style="font-size: 1.1em; font-weight: bold; color: var(--primary);">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    <a href="/produk/{{ $produk->id_produk }}" style="background: var(--gradient-brand); color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.3s ease;">
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
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 1.5em; color: var(--dark); margin-bottom: 20px;">🆕 Produk Terbaru</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        @foreach($produkTerbaru as $produk)
        <div style="background: var(--surface-strong); border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid var(--border); transition: all 0.3s ease; display: flex; flex-direction: column;">
            <!-- Foto Produk -->
            <div style="background: var(--surface-muted); height: 180px; overflow: hidden;">
                @if($produk->foto && file_exists(public_path('storage/' . $produk->foto)))
    <img src="{{ asset('storage/' . $produk->foto) }}"
         style="width: 100%; height: 100%; object-fit: cover;">
@else
    <img src="https://placehold.co/300x200/667eea/white?text={{ urlencode($produk->nama_produk) }}"
         style="width: 100%; height: 100%; object-fit: cover;">
@endif
            </div>
            
            <!-- Info Produk -->
            <div style="padding: 15px; flex: 1; display: flex; flex-direction: column;">
                <h3 style="margin: 0 0 8px 0; font-size: 0.95em; color: var(--dark); font-weight: 600; line-height: 1.3;">
                    {{ $produk->nama_produk }}
                </h3>
                
                <p style="margin: 5px 0; font-size: 0.85em; color: var(--text-secondary);">
                    <span style="background: rgba(120,157,188,0.15); padding: 3px 8px; border-radius: 4px;">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</span>
                </p>
                
                <p style="margin: 10px 0; font-size: 0.9em; color: var(--text-secondary); flex: 1;">
                    Stok: <strong>{{ $produk->stok }}</strong>
                </p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; border-top: 1px solid var(--border); padding-top: 10px;">
                    <span style="font-size: 1.1em; font-weight: bold; color: var(--primary);">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    <a href="/produk/{{ $produk->id_produk }}" style="background: var(--gradient-brand); color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.3s ease;">
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
