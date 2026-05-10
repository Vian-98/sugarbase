@extends('layouts.admin') {{-- Pastikan menggunakan layout admin --}}

@section('title', 'Daftar Produk')

@section('page_title')
    <h1>📦 Manajemen Produk</h1>
    <p>Kelola, edit, dan pantau stok barang Anda di sini.</p>
@endsection

@section('content')
<div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    
    {{-- Header Tabel & Tombol Tambah --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="font-size: 1.25rem; color: #1f2937; margin: 0;">Daftar Produk</h2>
        <a href="{{ route('admin.produk.create') }}" 
           style="background: #22c55e; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s;">
            <span>+</span> Tambah Produk Baru
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #10b981;">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Wrapper untuk Responsive Table --}}
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.75rem;">Info Produk</th>
                    <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.75rem;">Kategori</th>
                    <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.75rem;">Harga</th>
                    <th style="padding: 15px; text-align: left; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.75rem;">Stok</th>
                    <th style="padding: 15px; text-align: center; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.75rem;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($produk as $item)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                    
                    {{-- Info Produk (Foto + Nama) --}}
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 1px solid #e2e8f0;">
                            @else
                                <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 1.2rem;">🖼️</div>
                            @endif
                            <span style="font-weight: 600; color: #1e293b;">{{ $item->nama_produk }}</span>
                        </div>
                    </td>

                    {{-- Kategori --}}
                    <td style="padding: 15px; color: #64748b;">
                        <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 0.85em;">
                            {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                        </span>
                    </td>

                    {{-- Harga --}}
                    <td style="padding: 15px; font-weight: 600; color: #1e293b;">
                        Rp{{ number_format($item->harga, 0, ',', '.') }}
                    </td>

                    {{-- Stok --}}
                    <td style="padding: 15px;">
                        <span style="color: {{ $item->stok <= 5 ? '#ef4444' : '#1e293b' }}; font-weight: {{ $item->stok <= 5 ? 'bold' : 'normal' }};">
                            {{ $item->stok }} <small style="color: #94a3b8;">Unit</small>
                        </span>
                    </td>

                    {{-- Tombol Aksi --}}
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('admin.produk.edit', $item->id_produk) }}" 
                               style="background: #f59e0b; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                                Edit
                            </a>

                            <form action="{{ route('admin.produk.destroy', $item->id_produk) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background: #ef4444; color: white; padding: 6px 12px; border: none; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px; color: #94a3b8;">
                        <div style="font-size: 3rem; margin-bottom: 10px;">📭</div>
                        <p>Belum ada produk yang tersedia.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection