@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width:800px">

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-5 text-center p-4">
                @if($produk->foto)
                    <img src="{{ asset('storage/'.$produk->foto) }}"
                         class="img-fluid rounded" style="max-height:320px; object-fit:cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                         style="height:280px; font-size:5rem;">🍰</div>
                @endif
            </div>
            <div class="col-md-7 p-4">
                <span class="badge bg-pink text-white mb-2"
                      style="background:#e91e8c">{{ $produk->kategori->nama_kategori ?? 'Uncategorized' }}</span>
                <h2 class="fw-bold">{{ $produk->nama_produk }}</h2>
                <h4 class="text-danger fw-bold">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </h4>
                <p class="text-muted">Stok tersedia: <strong>{{ $produk->stok }}</strong></p>
                <p>{{ $produk->deskripsi }}</p>

                @if($produk->stok > 0)
                <form method="POST" action="/keranjang/tambah">
                    @csrf
                    <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <label class="fw-semibold">Jumlah:</label>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="let i=document.getElementById('qty'); if(i.value>1) i.value--">−</button>
                        <input type="number" id="qty" name="jumlah" value="1"
                               min="1" max="{{ $produk->stok }}"
                               class="form-control text-center" style="width:70px">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="let i=document.getElementById('qty'); if(i.value<{{ $produk->stok }}) i.value++">+</button>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
                        🛒 Tambah ke Keranjang
                    </button>
                </form>
                @else
                    <div class="alert alert-warning">Stok habis</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', $produk->nama_produk)

@section('content')

<div style="margin-bottom: 30px;">
    <a href="/katalog" style="color: #667eea; text-decoration: none; font-size: 0.9em;">← Kembali ke Katalog</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    
    <!-- FOTO PRODUK -->
    <div style="display: flex; align-items: center; justify-content: center; background: #f3f4f6; border-radius: 8px; min-height: 300px; font-size: 5em;">
        {{ $produk->foto ?? '🍰' }}
    </div>
    
    <!-- INFO PRODUK -->
    <div>
        <div style="margin-bottom: 20px;">
            <span style="background: #e8f9ff; padding: 5px 12px; border-radius: 4px; font-size: 0.85em; color: #667eea; font-weight: 600;">
                {{ $produk->kategori->nama_kategori ?? 'N/A' }}
            </span>
        </div>
        
        <h1 style="font-size: 2em; color: #1f2937; margin: 15px 0;">{{ $produk->nama_produk }}</h1>
        
        <div style="display: flex; align-items: center; gap: 20px; margin: 20px 0; padding: 20px 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
            <div>
                <p style="color: #6b7280; font-size: 0.9em; margin: 0;">Harga</p>
                <h2 style="color: #667eea; font-size: 2.2em; margin: 5px 0;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
            </div>
            <div>
                <p style="color: #6b7280; font-size: 0.9em; margin: 0;">Stok Tersedia</p>
                <h2 style="color: {{ $produk->stok > 0 ? '#22c55e' : '#ef4444' }}; font-size: 2.2em; margin: 5px 0;">{{ $produk->stok }}</h2>
            </div>
        </div>
        
        <div style="margin-bottom: 25px;">
            <h3 style="color: #1f2937; margin-bottom: 10px;">Deskripsi</h3>
            <p style="color: #6b7280; line-height: 1.6; white-space: pre-wrap;">{{ $produk->deskripsi_produk ?? 'Tidak ada deskripsi' }}</p>
        </div>
        
        <!-- Tambah ke Keranjang -->
        @if($produk->stok > 0)
        <form method="POST" action="/keranjang/tambah" style="margin-top: 30px;">
            @csrf
            <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
            
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                <label style="font-weight: 600; color: #1f2937;">Jumlah:</label>
                <div style="display: flex; align-items: center; border: 1px solid #e5e7eb; border-radius: 6px; width: fit-content;">
                    <button type="button" onclick="decreaseQty()" style="background: none; border: none; padding: 8px 12px; cursor: pointer; color: #667eea; font-weight: 600;">−</button>
                    <input type="number" name="jumlah" id="qty" value="1" min="1" max="{{ $produk->stok }}" 
                           style="width: 50px; text-align: center; border: none; font-weight: 600;">
                    <button type="button" onclick="increaseQty({{ $produk->stok }})" style="background: none; border: none; padding: 8px 12px; cursor: pointer; color: #667eea; font-weight: 600;">+</button>
                </div>
            </div>
            
            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 14px; border: none; border-radius: 6px; font-size: 1em; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                🛒 Tambah ke Keranjang
            </button>
        </form>
        @else
        <div style="background: #fef2f2; border: 1px solid #fca5a5; padding: 15px; border-radius: 6px; color: #991b1b; text-align: center; font-weight: 600;">
            Stok Habis - Produk tidak tersedia
        </div>
        @endif
        
        <!-- Info Tambahan -->
        <div style="margin-top: 30px; padding: 20px; background: #fbfbfb; border-radius: 6px; border-left: 4px solid #c4d9ff;">
            <p style="color: #6b7280; font-size: 0.9em; margin: 0;">
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
