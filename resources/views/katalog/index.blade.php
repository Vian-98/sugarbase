@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')

<div style="margin-bottom: 30px;">
    <h1 style="font-size: 2em; color: #1f2937; margin-bottom: 10px;">🍰 Katalog Produk</h1>
    <p style="color: #6b7280;">Temukan produk favorit Anda</p>
</div>

<div style="display: grid; grid-template-columns: 250px 1fr; gap: 20px; margin-bottom: 30px;">
    
    <!-- FILTER SIDEBAR -->
    <aside style="background: white; padding: 20px; border-radius: 8px; height: fit-content; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
        <h3 style="font-size: 1.1em; color: #1f2937; margin-bottom: 15px; font-weight: 600;">🔍 Filter</h3>
        
        <form method="GET" action="/katalog" style="display: flex; flex-direction: column; gap: 15px;">
            
            <!-- Filter Kategori -->
            <div>
                <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 8px; font-size: 0.9em;">Kategori</label>
                <select name="kategori" style="width: 100%; padding: 8px; border: 1px solid #c4d9ff; border-radius: 6px; background: white; cursor: pointer;">
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
                <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 8px; font-size: 0.9em;">Urutan</label>
                <select name="sort" style="width: 100%; padding: 8px; border: 1px solid #c4d9ff; border-radius: 6px; background: white; cursor: pointer;">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
            </div>
            
            <!-- Search -->
            <div>
                <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 8px; font-size: 0.9em;">Cari</label>
                <input type="text" name="q" placeholder="Nama produk..." value="{{ request('q') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #c4d9ff; border-radius: 6px; font-size: 0.9em;">
            </div>
            
            <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                Terapkan Filter
            </button>
            
            <a href="/katalog" style="text-align: center; padding: 10px; color: #667eea; text-decoration: none; border: 1px solid #667eea; border-radius: 6px; font-size: 0.9em; transition: all 0.3s ease;">
                Reset
            </a>
        </form>
    </aside>
    
    <!-- MAIN CONTENT -->
    <div>
        <!-- Active Filters Display -->
        @if(request('q') || request('kategori') || request('sort'))
        <div style="background: #e8f9ff; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #667eea;">
            <strong>Filter Aktif:</strong>
            @if(request('q'))
                <span style="display: inline-block; background: white; padding: 3px 10px; border-radius: 4px; margin-left: 8px; font-size: 0.9em;">
                    Cari: "{{ request('q') }}"
                </span>
            @endif
            @if(request('kategori'))
                <span style="display: inline-block; background: white; padding: 3px 10px; border-radius: 4px; margin-left: 8px; font-size: 0.9em;">
                    Kategori: {{ $kategori->find(request('kategori'))->nama_kategori ?? 'N/A' }}
                </span>
            @endif
        </div>
        @endif
        
        <!-- Products Grid -->
        @if($produk->count())
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; margin-bottom: 30px;">
            @foreach($produk as $item)
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; transition: all 0.3s ease; display: flex; flex-direction: column;">
                <!-- Foto -->
                <div style="background: #f3f4f6; height: 140px; display: flex; align-items: center; justify-content: center; font-size: 2.5em;">
                    {{ $item->foto ?? '🍰' }}
                </div>
                
                <!-- Info -->
                <div style="padding: 12px; flex: 1; display: flex; flex-direction: column;">
                    <h4 style="margin: 0 0 8px 0; font-size: 0.85em; color: #1f2937; font-weight: 600; line-height: 1.3;">
                        {{ $item->nama_produk }}
                    </h4>
                    
                    <p style="margin: 5px 0; font-size: 0.75em; color: #6b7280;">
                        <span style="background: #e8f9ff; padding: 2px 6px; border-radius: 3px;">{{ $item->kategori->nama_kategori ?? 'N/A' }}</span>
                    </p>
                    
                    <p style="margin: 5px 0; font-size: 0.75em; color: #6b7280;">Stok: {{ $item->stok }}</p>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 8px; border-top: 1px solid #e5e7eb;">
                        <span style="font-size: 0.95em; font-weight: bold; color: #667eea;">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        <a href="/produk/{{ $item->id_produk }}" style="background: #667eea; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.75em; font-weight: 600; transition: all 0.3s ease;">
                            Lihat
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
            {{ $produk->links('pagination::bootstrap-4') }}
        </div>
        @else
        <div style="text-align: center; padding: 60px 20px; background: #f3f4f6; border-radius: 8px;">
            <div style="font-size: 3em; margin-bottom: 15px;">😢</div>
            <h3 style="color: #1f2937; margin-bottom: 8px;">Produk Tidak Ditemukan</h3>
            <p style="color: #6b7280; margin-bottom: 20px;">Coba ubah filter atau cari produk lain</p>
            <a href="/katalog" style="display: inline-block; background: #667eea; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                Reset Filter
            </a>
        </div>
        @endif
    </div>

</div>

@endsection
