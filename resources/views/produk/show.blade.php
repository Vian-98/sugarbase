@extends('layouts.app')

@section('title', $produk->nama_produk)

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 20px;">

    {{-- Breadcrumb --}}
    <div style="margin-bottom: 20px;">
        <a href="/beranda" style="color: #667eea; text-decoration: none;">Beranda</a>
        <span style="color: #6b7280;"> / </span>
        <a href="/katalog" style="color: #667eea; text-decoration: none;">Katalog</a>
        <span style="color: #6b7280;"> / </span>
        <span style="color: #1f2937;">{{ $produk->nama_produk }}</span>
    </div>

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- Card Produk --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; display: grid; grid-template-columns: 1fr 1fr; gap: 0;">

        {{-- Foto --}}
        <div style="background: #f3f4f6; min-height: 350px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            @if($produk->foto)
                <img src="{{ asset('storage/'.$produk->foto) }}"
                     alt="{{ $produk->nama_produk }}"
                     style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <div style="font-size: 5rem; text-align: center;">🍰</div>
            @endif
        </div>

        {{-- Info Produk --}}
        <div style="padding: 35px;">

            {{-- Badge Kategori --}}
            <span style="background: #e8f9ff; color: #667eea; padding: 4px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 600;">
                {{ $produk->kategori->nama_kategori ?? 'Uncategorized' }}
            </span>

            <h1 style="font-size: 1.8em; color: #1f2937; margin: 12px 0 8px; font-weight: 700;">
                {{ $produk->nama_produk }}
            </h1>

            <div style="font-size: 1.6em; font-weight: bold; color: #667eea; margin-bottom: 12px;">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </div>

            <div style="color: #6b7280; font-size: 0.9em; margin-bottom: 12px;">
                Stok tersedia: <strong style="color: #1f2937;">{{ $produk->stok }}</strong>
            </div>

            <p style="color: #4b5563; line-height: 1.6; margin-bottom: 24px; font-size: 0.95em;">
                {{ $produk->deskripsi_produk }}
            </p>

            @if($produk->stok > 0)
            <form method="POST" action="/keranjang/tambah">
                @csrf
                <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">

                {{-- Input Qty --}}
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                    <label style="font-weight: 600; color: #1f2937;">Jumlah:</label>
                    <div style="display: flex; align-items: center; border: 2px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                        <button type="button"
                            style="background: #f3f4f6; border: none; padding: 8px 14px; font-size: 1.1em; cursor: pointer; color: #374151;"
                            onclick="let i=document.getElementById('qty'); if(i.value>1) i.value--">−</button>
                        <input type="number" id="qty" name="jumlah" value="1"
                               min="1" max="{{ $produk->stok }}"
                               style="width: 60px; border: none; text-align: center; font-size: 1em; padding: 8px 0; outline: none;">
                        <button type="button"
                            style="background: #f3f4f6; border: none; padding: 8px 14px; font-size: 1.1em; cursor: pointer; color: #374151;"
                            onclick="let i=document.getElementById('qty'); if(parseInt(i.value)<{{ $produk->stok }}) i.value=parseInt(i.value)+1">+</button>
                    </div>
                </div>

                <button type="submit"
                    style="width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px; border-radius: 8px; font-size: 1em; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    🛒 Tambah ke Keranjang
                </button>
            </form>
            @else
                <div style="background: #fef3c7; color: #92400e; padding: 12px 16px; border-radius: 8px; text-align: center; font-weight: 600;">
                    ⚠️ Stok Habis
                </div>
            @endif

        </div>
    </div>
</div>
@endsection