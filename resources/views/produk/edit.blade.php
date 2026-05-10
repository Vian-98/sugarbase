@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('page_title')
    <h1>✏️ Edit Produk</h1>
    <p>Perbarui informasi detail produk <strong>{{ $produk->nama_produk }}</strong></p>
@endsection

@section('content')
<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    
    {{-- Alert Error --}}
    @if ($errors->any())
    <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; border-left: 4px solid #ef4444; margin-bottom: 25px;">
        <p style="font-weight: bold; margin-bottom: 5px;">Terjadi kesalahan:</p>
        <ul style="margin: 0; padding-left: 20px; font-size: 0.9em;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            {{-- Nama Produk --}}
            <div style="grid-column: span 2; margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" 
                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; outline-color: #667eea;">
            </div>

            {{-- Harga --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" 
                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; outline-color: #667eea;">
            </div>

            {{-- Stok --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Stok Unit</label>
                <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" 
                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; outline-color: #667eea;">
            </div>
        </div>

        {{-- Kategori --}}
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Kategori</label>
            <select name="id_kategori" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; background: white; outline-color: #667eea;">
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}" {{ old('id_kategori', $produk->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Deskripsi --}}
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Deskripsi Produk</label>
            <textarea name="deskripsi_produk" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; min-height: 120px; box-sizing: border-box; outline-color: #667eea; font-family: inherit;">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
        </div>

        {{-- Upload Foto dengan Preview --}}
        <div style="margin-bottom: 30px; padding: 20px; border: 2px dashed #d1d5db; border-radius: 12px; background: #f9fafb; text-align: center;">
            <label style="display: block; font-weight: 600; margin-bottom: 15px; color: #374151;">Foto Produk</label>
            
            <div style="display: flex; justify-content: center; gap: 20px; align-items: center; margin-bottom: 15px;">
                {{-- Foto Lama --}}
                <div id="old-photo-container">
                    <p style="font-size: 0.75em; color: #6b7280; margin-bottom: 5px;">Foto Saat Ini</p>
                    @if($produk->foto)
                        <img src="{{ asset('storage/' . $produk->foto) }}" 
                            style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    @else
                        <div style="width: 120px; height: 120px; background: #e5e7eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #9ca3af;">No Photo</div>
                    @endif
                </div>

                {{-- Panah Indikator (Hanya muncul saat preview ada) --}}
                <div id="arrow-indicator" style="display: none; font-size: 1.5rem; color: #667eea;">➡️</div>

                {{-- Preview Foto Baru --}}
                <div id="preview-container" style="display: none;">
                    <p style="font-size: 0.75em; color: #6b7280; margin-bottom: 5px;">Preview Baru</p>
                    <img id="image-preview" src="#" alt="Preview Baru" 
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 3px solid #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);">
                </div>
            </div>
            
            <input type="file" name="foto" id="foto-input" accept="image/*" style="font-size: 0.9em; color: #6b7280;">
            <p style="font-size: 0.8em; color: #9ca3af; margin-top: 10px;">Klik untuk mengganti foto. Format: JPG, PNG, WEBP (Maks 2MB).</p>
            
            <button type="button" id="reset-button" onclick="resetPreview()" style="display: none; margin: 10px auto 0; background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.85em; font-weight: 600;">
                ✕ Batalkan Perubahan Foto
            </button>
        </div>

        {{-- Action Buttons --}}
        <div style="display: flex; gap: 12px; border-top: 1px solid #f3f4f6; padding-top: 20px;">
            <button type="submit" 
                style="background: #667eea; color: white; padding: 12px 25px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s; flex: 1;">
                💾 Simpan Perubahan
            </button>
            
            <a href="{{ route('admin.produk.index') }}" 
                style="background: white; color: #374151; padding: 12px 25px; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center;">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    const fotoInput = document.getElementById('foto-input');
    const imagePreview = document.getElementById('image-preview');
    const previewContainer = document.getElementById('preview-container');
    const arrowIndicator = document.getElementById('arrow-indicator');
    const resetButton = document.getElementById('reset-button');

    fotoInput.onchange = evt => {
        const [file] = fotoInput.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            previewContainer.style.display = 'block';
            arrowIndicator.style.display = 'block';
            resetButton.style.display = 'block';
        }
    }

    function resetPreview() {
        fotoInput.value = ""; // Reset file input
        previewContainer.style.display = 'none';
        arrowIndicator.style.display = 'none';
        resetButton.style.display = 'none';
    }
</script>
@endsection