@extends('layouts.admin') {{-- Menggunakan layout admin agar seragam --}}

@section('title', 'Kategori')

@section('page_title')
    <h1>📂 Kategori Produk</h1>
    <p>Kelola pengelompokan produk Anda untuk mempermudah pencarian.</p>
@endsection

@section('content')
<div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    
    {{-- Form Tambah Kategori Cepat --}}
    <div style="margin-bottom: 30px; padding: 20px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
        <h2 style="font-size: 1rem; color: #475569; margin-bottom: 15px; font-weight: 600;">➕ Tambah Kategori Baru</h2>
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <input type="text" name="nama_kategori" placeholder="Nama kategori (e.g. Minuman)"
                        style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; outline-color: #8b5cf6;" required>
                </div>

                <div style="flex: 2; min-width: 250px;">
                    <input type="text" name="deskripsi_kategori" placeholder="Deskripsi singkat kategori..."
                        style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; outline-color: #8b5cf6;">
                </div>

                <button type="submit" 
                    style="background: #8b5cf6; color: white; padding: 12px 25px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s;">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
    <div style="background: rgba(201,233,210,0.45); color: #3A7A5A; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #7EBB98;">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Daftar Kategori --}}
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="background: #f1f5f9; text-align: left;">
                    <th style="padding: 15px; color: #64748b; font-weight: 600; font-size: 0.85rem; border-radius: 8px 0 0 8px;">ID</th>
                    <th style="padding: 15px; color: #64748b; font-weight: 600; font-size: 0.85rem;">NAMA KATEGORI</th>
                    <th style="padding: 15px; color: #64748b; font-weight: 600; font-size: 0.85rem;">DESKRIPSI</th>
                    <th style="padding: 15px; color: #64748b; font-weight: 600; font-size: 0.85rem; text-align: center; border-radius: 0 8px 8px 0;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $item)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 15px; color: #94a3b8; font-family: monospace;">#{{ $item->id_kategori }}</td>
                    <td style="padding: 15px;">
                        <span style="font-weight: 600; color: #1e293b; background: #ede9fe; color: #5b21b6; padding: 4px 12px; border-radius: 6px;">
                            {{ $item->nama_kategori }}
                        </span>
                    </td>
                    <td style="padding: 15px; color: #64748b; font-size: 0.9rem;">
                        {{ $item->deskripsi_kategori ?: '-' }}
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <form action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" method="POST" 
                              onsubmit="return confirm('Menghapus kategori akan mempengaruhi produk terkait. Lanjutkan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.9rem; font-weight: 600;">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px;">📂</div>
                        <p>Belum ada kategori yang ditambahkan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection