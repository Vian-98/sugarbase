@extends('layouts.app')

@section('title', $produk->nama_produk)

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 20px;">

    <div style="margin-bottom: 20px;">
        <a href="/beranda" style="color: var(--primary); text-decoration: none; font-weight: 500;">Beranda</a>
        <span style="color: var(--text-secondary); margin: 0 5px;"> / </span>
        <a href="/katalog" style="color: var(--primary); text-decoration: none; font-weight: 500;">Katalog</a>
        <span style="color: var(--text-secondary); margin: 0 5px;"> / </span>
        <span style="color: var(--dark); font-weight: 600;">{{ $produk->nama_produk }}</span>
    </div>

    @if(session('error'))
        <div style="background: rgba(217,137,153,0.15); color: var(--danger); padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--danger);">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div style="background: var(--surface-strong); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; display: grid; grid-template-columns: 1fr 1fr; border: 1px solid var(--border);">

        <div style="background: var(--surface-muted); min-height: 400px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 20px;">
            @if($produk->foto)
                <img src="{{ asset('storage/'.$produk->foto) }}"
                     alt="{{ $produk->nama_produk }}"
                     style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
            @else
                <img src="https://placehold.co/400x400/667eea/white?text=🍰"
                     alt="No Image"
                     style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
            @endif
        </div>

        <div style="padding: 40px;">
            <span style="background: rgba(120,157,188,0.15); color: var(--primary); padding: 6px 14px; border-radius: 20px; font-size: 0.85em; font-weight: 700;">
                {{ $produk->kategori->nama_kategori ?? 'Uncategorized' }}
            </span>

            <h1 style="font-size: 2.2em; color: var(--dark); margin: 16px 0 12px; font-weight: 800; line-height: 1.2;">
                {{ $produk->nama_produk }}
            </h1>

            <div style="font-size: 1.8em; font-weight: 800; color: var(--primary); margin-bottom: 16px;">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </div>

            <div style="color: var(--text-secondary); font-size: 0.95em; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-block; width: 10px; height: 10px; background: {{ $produk->stok > 0 ? 'var(--success)' : 'var(--danger)' }}; border-radius: 50%;"></span>
                Stok tersedia: <strong style="color: var(--dark);">{{ $produk->stok }}</strong>
            </div>

            <p style="color: var(--text-secondary); line-height: 1.7; margin-bottom: 30px; font-size: 1em;">
                {{ $produk->deskripsi_produk ?: 'Belum ada deskripsi untuk produk ini.' }}
            </p>

            @if($produk->stok > 0)
            <form method="POST" action="/keranjang/tambah">
                @csrf
                <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">

                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                    <label style="font-weight: 600; color: var(--dark); font-size: 1.1em;">Jumlah:</label>
                    <div style="display: flex; align-items: center; border: 1px solid var(--border); border-radius: 10px; overflow: hidden; background: var(--surface);">
                        <button type="button"
                            style="background: var(--surface-muted); color: var(--dark); border: none; padding: 10px 16px; font-size: 1.2em; cursor: pointer; transition: background 0.2s;"
                            onclick="let i=document.getElementById('qty'); if(i.value>1) i.value--">−</button>
                        <input type="number" id="qty" name="jumlah" value="1"
                               min="1" max="{{ $produk->stok }}"
                               style="width: 60px; border: none; background: transparent; color: var(--dark); text-align: center; font-size: 1.1em; padding: 10px 0; outline: none; font-weight: bold;">
                        <button type="button"
                            style="background: var(--surface-muted); color: var(--dark); border: none; padding: 10px 16px; font-size: 1.2em; cursor: pointer; transition: background 0.2s;"
                            onclick="let i=document.getElementById('qty'); if(parseInt(i.value)<{{ $produk->stok }}) i.value=parseInt(i.value)+1">+</button>
                    </div>
                </div>

                <button type="submit"
                    style="width: 100%; background: var(--gradient-brand); color: white; border: none; padding: 16px; border-radius: 12px; font-size: 1.1em; font-weight: 700; cursor: pointer; box-shadow: 0 8px 20px rgba(120,157,188,0.3); transition: all 0.3s ease;">
                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i> Tambah ke Keranjang
                </button>
            </form>
            @else
                <div style="background: rgba(231, 200, 158, 0.15); color: var(--warning); border: 1px solid var(--warning); padding: 16px; border-radius: 12px; text-align: center; font-weight: 700; font-size: 1.1em;">
                    ⚠️ Stok Habis
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Styling interaktif tombol */
    form button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(120,157,188,0.4);
    }
    
    @media (max-width: 768px) {
        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
        div[style*="padding: 40px;"] {
            padding: 24px !important;
        }
    }
</style>
@endsection