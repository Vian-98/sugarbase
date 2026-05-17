@extends('layouts.app')


@section('title', $produk->nama_produk)

@section('content')

<div style="margin-bottom: 30px;">
    <a href="/katalog" style="color: #789DBC; text-decoration: none; font-size: 0.9em;">← Kembali ke Katalog</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; background: var(--surface-strong); padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    
    <!-- FOTO PRODUK -->
    <div style="background: var(--surface-muted); border-radius: 8px; min-height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        @if($produk->foto)
            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}"
                 style="width: 100%; height: 300px; object-fit: contain;">
        @else
            <div style="font-size: 5em;">🍰</div>
        @endif
    </div>
    
    <!-- INFO PRODUK -->
    <div>
        <div style="margin-bottom: 20px;">
            <span style="background: rgba(120,157,188,0.15); padding: 5px 12px; border-radius: 4px; font-size: 0.85em; color: #789DBC; font-weight: 600;">
                {{ $produk->kategori->nama_kategori ?? 'N/A' }}
            </span>
        </div>
        
        <h1 style="font-size: 2em; color: var(--dark); margin: 15px 0;">{{ $produk->nama_produk }}</h1>
        
        <div style="display: flex; align-items: center; gap: 20px; margin: 20px 0; padding: 20px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
            <div>
                <p style="color: var(--text-secondary); font-size: 0.9em; margin: 0;">Harga</p>
                <h2 style="color: #789DBC; font-size: 2.2em; margin: 5px 0;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
            </div>
            <div>
                <p style="color: var(--text-secondary); font-size: 0.9em; margin: 0;">Stok Tersedia</p>
                <h2 style="color: {{ $produk->stok > 0 ? '#7EBB98' : '#ef4444' }}; font-size: 2.2em; margin: 5px 0;">{{ $produk->stok }}</h2>
            </div>
        </div>
        
        <div style="margin-bottom: 25px;">
            <h3 style="color: var(--dark); margin-bottom: 10px;">Deskripsi</h3>
            <p style="color: var(--text-secondary); line-height: 1.6; white-space: pre-wrap;">{{ $produk->deskripsi_produk ?? 'Tidak ada deskripsi' }}</p>
        </div>
        
        <!-- Tambah ke Keranjang -->
        @if($produk->stok > 0)
        <form method="POST" action="/keranjang/tambah" style="margin-top: 30px;">
            @csrf
            <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
            
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                <label style="font-weight: 600; color: var(--dark);">Jumlah:</label>
                <div style="display: flex; align-items: center; border: 1px solid var(--border); border-radius: 6px; width: fit-content;">
                    <button type="button" onclick="decreaseQty()" style="background: none; border: none; padding: 8px 12px; cursor: pointer; color: #789DBC; font-weight: 600;">−</button>
                    <input type="number" name="jumlah" id="qty" value="1" min="1" max="{{ $produk->stok }}" 
                           style="width: 50px; text-align: center; border: none; font-weight: 600;">
                    <button type="button" onclick="increaseQty({{ $produk->stok }})" style="background: none; border: none; padding: 8px 12px; cursor: pointer; color: #789DBC; font-weight: 600;">+</button>
                </div>
            </div>
            
            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%); color: white; padding: 14px; border: none; border-radius: 6px; font-size: 1em; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                🛒 Tambah ke Keranjang
            </button>
        </form>
        @else
        <div style="background: rgba(217,137,153,0.15); border: 1px solid #fca5a5; padding: 15px; border-radius: 6px; color: var(--danger); text-align: center; font-weight: 600;">
            Stok Habis - Produk tidak tersedia
        </div>
        @endif
        
        <!-- Info Tambahan -->
        <div style="margin-top: 30px; padding: 20px; background: var(--surface-muted); border-radius: 6px; border-left: 4px solid #c4d9ff;">
            <p style="color: var(--text-secondary); font-size: 0.9em; margin: 0;">
                ✓ Kualitas terjamin<br>
                ✓ Pengemasan aman<br>
                ✓ Pengiriman cepat
            </p>
        </div>
    </div>

</div>

<script>
function decreaseQty() {
    const input = document.getElementById('qty');
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function increaseQty(maxStock) {
    const input = document.getElementById('qty');
    if (input.value < maxStock) {
        input.value = parseInt(input.value) + 1;
    }
}
</script>

@endsection
