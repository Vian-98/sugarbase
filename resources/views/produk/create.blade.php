@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('page_title')
    <h1>➕ Tambah Produk Baru</h1>
    <p>Masukkan detail produk dengan lengkap untuk mulai berjualan.</p>
@endsection

@section('content')
<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    
    {{-- Alert Error Validasi --}}
    @if ($errors->any())
    <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; border-left: 4px solid #ef4444; margin-bottom: 25px;">
        <p style="font-weight: bold; margin-bottom: 5px;">⚠️ Ada kendala input:</p>
        <ul style="margin: 0; padding-left: 20px; font-size: 0.9em;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama Produk --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" 
                placeholder="Contoh: Gula Pasir Kristal 1kg"
                style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; outline-color: #667eea;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            {{-- Harga --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga') }}" 
                    placeholder="0"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; outline-color: #667eea;">
            </div>

            {{-- Stok --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Stok Awal</label>
                <input type="number" name="stok" value="{{ old('stok') }}" 
                    placeholder="0"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; outline-color: #667eea;">
            </div>
        </div>

        {{-- Kategori --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Kategori</label>
            <select name="id_kategori" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; background: white; outline-color: #667eea; cursor: pointer;">
                <option value="">-- Pilih Kategori Produk --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Deskripsi --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">Deskripsi Lengkap</label>
            <textarea name="deskripsi_produk" placeholder="Tuliskan detail produk, spesifikasi, atau informasi tambahan lainnya..."
                style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; min-height: 120px; box-sizing: border-box; outline-color: #667eea; font-family: inherit;">{{ old('deskripsi_produk') }}</textarea>
        </div>

        {{-- Upload Foto dengan Live Preview --}}
        <div style="margin-bottom: 30px; padding: 25px; border: 2px dashed #e5e7eb; border-radius: 12px; background: #f9fafb; text-align: center;">
            <label style="display: block; font-weight: 600; margin-bottom: 15px; color: #374151;">Foto Produk</label>
            
            {{-- Area Preview --}}
            <div id="preview-container" style="display: none; margin-bottom: 15px;">
                <img id="image-preview" src="#" alt="Preview" 
                     style="width: 160px; height: 160px; object-fit: cover; border-radius: 12px; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <p style="font-size: 0.85em; color: #ef4444; cursor: pointer; margin-top: 8px; font-weight: 600;" onclick="resetPreview()">
                    ✕ Hapus Foto
                </p>
            </div>

            {{-- Placeholder saat belum ada foto --}}
            <div id="placeholder-icon">
                <div style="font-size: 3rem; margin-bottom: 10px;">📸</div>
                <p style="font-size: 0.9em; color: #6b7280; margin-bottom: 15px;">Klik untuk unggah foto produk</p>
            </div>
            
            <input type="file" name="foto" id="foto-input" accept="image/*" 
                style="font-size: 0.9em; color: #6b7280; max-width: 100%;">
            
            <p style="font-size: 0.75em; color: #9ca3af; margin-top: 12px;">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
        </div>

        {{-- Action Buttons --}}
        <div style="display: flex; gap: 12px; border-top: 1px solid #f3f4f6; padding-top: 25px;">
            <button type="submit" 
                style="background: #22c55e; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s; flex: 2;">
                🚀 Simpan Produk Baru
            </button>
            
            <a href="{{ route('admin.produk.index') }}" 
                style="background: white; color: #6b7280; padding: 12px 30px; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; flex: 1;">
                Batal
            </a>
        </div>
    </form>
</div>

{{-- JavaScript untuk Fitur Preview --}}
<script>
    const fotoInput = document.getElementById('foto-input');
    const imagePreview = document.getElementById('image-preview');
    const previewContainer = document.getElementById('preview-container');
    const placeholderIcon = document.getElementById('placeholder-icon');

    // Fungsi saat input file berubah
    fotoInput.onchange = evt => {
        const [file] = fotoInput.files;
        if (file) {
            // Validasi sederhana (opsional: cek tipe file)
            if (file.type.startsWith('image/')) {
                imagePreview.src = URL.createObjectURL(file);
                
                // Animasi sederhana: tampilkan preview, sembunyikan placeholder
                previewContainer.style.display = 'block';
                placeholderIcon.style.display = 'none';
            }
        }
    }

    // Fungsi untuk membatalkan pilihan foto
    function resetPreview() {
        fotoInput.value = ""; // Bersihkan nilai input
        previewContainer.style.display = 'none';
        placeholderIcon.style.display = 'block';
    }
</script>
@endsection