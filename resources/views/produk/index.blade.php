@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('page_title')
    <div class="container d-flex" style="justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 class="hero-title">📦 Manajemen Produk</h1>
            <p class="hero-sub">Kelola, edit, dan pantau stok barang Anda di sini.</p>
        </div>
        <div style="padding-bottom: 15px;">
            <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                + Tambah Produk Baru
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="container">

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="alert alert-success mb-4">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Daftar Produk --}}
    <div class="admin-card">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="min-width: 250px;">INFO PRODUK</th>
                        <th>KATEGORI</th>
                        <th>HARGA</th>
                        <th class="text-center">STOK</th>
                        <th class="text-center" style="width: 180px;">AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($produk as $item)
                    <tr>
                        {{-- Info Produk (Foto + Nama) --}}
                        <td>
                            <div class="d-flex" style="gap: 15px; align-items: center;">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border);">
                                @else
                                    <div style="width: 50px; height: 50px; background: var(--surface-muted); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 1.2rem;">🖼️</div>
                                @endif
                                <span class="font-600" style="color: var(--dark); font-size: 0.95em;">{{ $item->nama_produk }}</span>
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td>
                            <span class="badge badge-info" style="font-size: 0.85em;">
                                {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                            </span>
                        </td>

                        {{-- Harga --}}
                        <td class="font-600" style="color: var(--primary);">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>

                        {{-- Stok --}}
                        <td class="text-center">
                            @if($item->stok <= 5)
                                <span class="badge badge-danger">{{ $item->stok }} Unit</span>
                            @else
                                <span class="font-600">{{ $item->stok }} <small class="muted">Unit</small></span>
                            @endif
                        </td>

                        {{-- Tombol Aksi --}}
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-center">
                                <a href="{{ route('admin.produk.edit', $item->id_produk) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.produk.destroy', $item->id_produk) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center muted p-5">
                            <div class="empty-emoji" style="font-size: 3rem; margin-bottom: 10px;">📭</div>
                            <p>Belum ada produk yang tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection