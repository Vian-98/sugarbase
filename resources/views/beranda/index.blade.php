@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<!-- HERO BANNER -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 20px; border-radius: 12px; margin-bottom: 40px; text-align: center;">
    <h1 style="font-size: 2.5em; margin-bottom: 10px;">🍰 Semua Manis, Satu Platform</h1>
    <p style="font-size: 1.1em; margin-bottom: 20px; opacity: 0.95;">Nikmati koleksi dessert premium kami dengan kualitas terbaik</p>
    <a href="/katalog" style="display: inline-block; background: white; color: #667eea; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: all 0.3s ease; margin-top: 10px;">
        Belanja Sekarang →
    </a>
</section>

<!-- KATEGORI CEPAT -->
@if($kategori->count())
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 1.5em; color: #1f2937; margin-bottom: 20px;">📂 Kategori</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
        @foreach($kategori as $kat)
        <a href="/katalog?kategori={{ $kat->id_kategori }}" 
           style="background: white; padding: 20px; border-radius: 8px; text-align: center; text-decoration: none; color: #667eea; border: 2px solid #c4d9ff; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 10px;">
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
    <h2 style="font-size: 1.5em; color: #1f2937; margin-bottom: 20px;">⭐ Produk Terlaris</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        @foreach($produkTerlaris as $produk)
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; transition: all 0.3s ease; display: flex; flex-direction: column;">
            <!-- Foto Produk -->
            <div style="background: #f3f4f6; height: 180px; display: flex; align-items: center; justify-content: center; font-size: 3em;">
                {{ $produk->foto ?? '🍰' }}
            </div>
            
            <!-- Info Produk -->
            <div style="padding: 15px; flex: 1; display: flex; flex-direction: column;">
                <h3 style="margin: 0 0 8px 0; font-size: 0.95em; color: #1f2937; font-weight: 600; line-height: 1.3;">
                    {{ $produk->nama_produk }}
                </h3>
                
                <p style="margin: 5px 0; font-size: 0.85em; color: #6b7280;">
                    <span style="background: #e8f9ff; padding: 3px 8px; border-radius: 4px;">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</span>
                </p>
                
                <p style="margin: 10px 0; font-size: 0.9em; color: #6b7280; flex: 1;">
                    Stok: <strong>{{ $produk->stok }}</strong>
                </p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; border-top: 1px solid #e5e7eb; padding-top: 10px;">
                    <span style="font-size: 1.1em; font-weight: bold; color: #667eea;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    <a href="/produk/{{ $produk->id_produk }}" style="background: #667eea; color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.3s ease;">
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
    <h2 style="font-size: 1.5em; color: #1f2937; margin-bottom: 20px;">🆕 Produk Terbaru</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        @foreach($produkTerbaru as $produk)
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; transition: all 0.3s ease; display: flex; flex-direction: column;">
            <!-- Foto Produk -->
            <div style="background: #f3f4f6; height: 180px; display: flex; align-items: center; justify-content: center; font-size: 3em;">
                {{ $produk->foto ?? '🍰' }}
            </div>
            
            <!-- Info Produk -->
            <div style="padding: 15px; flex: 1; display: flex; flex-direction: column;">
                <h3 style="margin: 0 0 8px 0; font-size: 0.95em; color: #1f2937; font-weight: 600; line-height: 1.3;">
                    {{ $produk->nama_produk }}
                </h3>
                
                <p style="margin: 5px 0; font-size: 0.85em; color: #6b7280;">
                    <span style="background: #e8f9ff; padding: 3px 8px; border-radius: 4px;">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</span>
                </p>
                
                <p style="margin: 10px 0; font-size: 0.9em; color: #6b7280; flex: 1;">
                    Stok: <strong>{{ $produk->stok }}</strong>
                </p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; border-top: 1px solid #e5e7eb; padding-top: 10px;">
                    <span style="font-size: 1.1em; font-weight: bold; color: #667eea;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    <a href="/produk/{{ $produk->id_produk }}" style="background: #667eea; color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.3s ease;">
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
