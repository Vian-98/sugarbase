@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')

<style>
    /* PAGINATION STYLING */
    .pagination-wrapper {
        text-align: center;
        margin-top: 40px;
    }

    .pagination-info {
        color: var(--text-secondary);
        font-size: 0.9em;
        margin-bottom: 20px;
    }

    .pagination-wrapper ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pagination-wrapper li {
        display: inline-flex;
    }

    .pagination-wrapper a,
    .pagination-wrapper span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--surface-strong);
        color: var(--dark);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9em;
        transition: all 0.2s ease;
    }

    .pagination-wrapper a:hover {
        background: linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%);
        color: white;
        border-color: #789DBC;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(120, 157, 188, 0.3);
    }

    .pagination-wrapper .active span {
        background: linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%);
        color: white;
        border-color: #789DBC;
        box-shadow: 0 4px 12px rgba(120, 157, 188, 0.3);
    }

    .pagination-wrapper .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<div style="margin-bottom: 30px;">
    <h1 style="font-size: 2em; color: var(--dark); margin-bottom: 10px;">🍰 Katalog Produk</h1>
    <p style="color: var(--text-secondary);">Temukan produk favorit Anda</p>
</div>

<div style="display: grid; grid-template-columns: 250px 1fr; gap: 20px; margin-bottom: 30px;">
    
    <!-- FILTER SIDEBAR -->
    <aside style="background: var(--surface-strong); padding: 20px; border-radius: 8px; height: fit-content; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid var(--border);">
        <h3 style="font-size: 1.1em; color: var(--dark); margin-bottom: 15px; font-weight: 600;">🔍 Filter</h3>
        
        <form method="GET" action="/katalog" style="display: flex; flex-direction: column; gap: 15px;">
            
            <!-- Filter Kategori -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px; font-size: 0.9em;">Kategori</label>
                <select name="kategori" style="width: 100%; padding: 8px; border: 1px solid #c4d9ff; border-radius: 6px; background: var(--surface-strong); cursor: pointer;">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Sort -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px; font-size: 0.9em;">Urutan</label>
                <select name="sort" style="width: 100%; padding: 8px; border: 1px solid #c4d9ff; border-radius: 6px; background: var(--surface-strong); cursor: pointer;">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
            </div>
            
            <!-- Search -->
            <div>
                <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px; font-size: 0.9em;">Cari</label>
                <input type="text" name="q" placeholder="Nama produk..." value="{{ request('q') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #c4d9ff; border-radius: 6px; font-size: 0.9em;">
            </div>
            
            <button type="submit" style="background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%); color: white; padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                Terapkan Filter
            </button>
            
            <a href="/katalog" style="text-align: center; padding: 10px; color: #789DBC; text-decoration: none; border: 1px solid #789DBC; border-radius: 6px; font-size: 0.9em; transition: all 0.3s ease;">
                Reset
            </a>
        </form>
    </aside>
    
    <!-- MAIN CONTENT -->
    <div>
        <!-- Active Filters Display -->
        @if(request('q') || request('kategori') || request('sort'))
        <div style="background: rgba(120,157,188,0.15); padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid var(--primary);">
            <strong style="color: var(--dark);">Filter Aktif:</strong>
            @if(request('q'))
                <span style="display: inline-block; background: var(--surface-strong); color: var(--text-secondary); padding: 3px 10px; border-radius: 4px; margin-left: 8px; font-size: 0.9em; border: 1px solid var(--border);">
                    Cari: "{{ request('q') }}"
                </span>
            @endif
            @if(request('kategori'))
                <span style="display: inline-block; background: var(--surface-strong); color: var(--text-secondary); padding: 3px 10px; border-radius: 4px; margin-left: 8px; font-size: 0.9em; border: 1px solid var(--border);">
                    Kategori: {{ $kategori->firstWhere('id_kategori', request('kategori'))->nama_kategori ?? 'N/A' }}
                </span>
            @endif
            @if(request('sort'))
                <span style="display: inline-block; background: var(--surface-strong); color: var(--text-secondary); padding: 3px 10px; border-radius: 4px; margin-left: 8px; font-size: 0.9em; border: 1px solid var(--border);">
                    Urutan: {{ request('sort') == 'terbaru' ? 'Terbaru' : (request('sort') == 'harga_asc' ? 'Harga Terendah' : (request('sort') == 'harga_desc' ? 'Harga Tertinggi' : request('sort'))) }}
                </span>
            @endif
        </div>
        @endif
        
        <!-- Products Grid -->
        @if($produk->count())
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; margin-bottom: 30px;">
            @foreach($produk as $item)
            <div style="background: var(--surface-strong); border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid var(--border); transition: all 0.3s ease; display: flex; flex-direction: column;">
                <!-- Foto -->
                <div style="background: var(--surface-muted); height: 140px; overflow: hidden;">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.5em;">🍰</div>
                    @endif
                </div>
                
                <!-- Info -->
                <div style="padding: 12px; flex: 1; display: flex; flex-direction: column;">
                    <h4 style="margin: 0 0 8px 0; font-size: 0.85em; color: var(--dark); font-weight: 600; line-height: 1.3;">
                        {{ $item->nama_produk }}
                    </h4>
                    
                    <p style="margin: 5px 0; font-size: 0.75em; color: var(--text-secondary);">
                        <span style="background: rgba(120,157,188,0.15); padding: 2px 6px; border-radius: 3px;">{{ $item->kategori->nama_kategori ?? 'N/A' }}</span>
                    </p>
                    
                    <p style="margin: 5px 0; font-size: 0.75em; color: var(--text-secondary);">Stok: {{ $item->stok }}</p>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 8px; border-top: 1px solid var(--border);">
                        <span style="font-size: 0.95em; font-weight: bold; color: #789DBC;">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        <a href="/produk/{{ $item->id_produk }}" style="background: #789DBC; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.75em; font-weight: 600; transition: all 0.3s ease;">
                            Lihat
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan <strong>{{ $produk->firstItem() ?? 0 }}</strong> hingga <strong>{{ $produk->lastItem() ?? 0 }}</strong> dari <strong>{{ $produk->total() }}</strong> produk
            </div>
            {{ $produk->appends(request()->query())->links('pagination.custom') }}
        </div>
        @else
        <div style="text-align: center; padding: 60px 20px; background: var(--surface-muted); border-radius: 8px;">
            <div style="font-size: 3em; margin-bottom: 15px;">😢</div>
            <h3 style="color: var(--dark); margin-bottom: 8px;">Produk Tidak Ditemukan</h3>
            <p style="color: var(--text-secondary); margin-bottom: 20px;">Coba ubah filter atau cari produk lain</p>
            <a href="/katalog" style="display: inline-block; background: #789DBC; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                Reset Filter
            </a>
        </div>
        @endif
    </div>

</div>

@endsection
