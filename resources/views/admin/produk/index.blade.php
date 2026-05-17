@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('page_title')
    <h1 class="hero-title">Manajemen Produk</h1>
    <p class="hero-sub">Kelola semua produk di toko Anda</p>
@endsection

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <h1 class="page-title"></h1>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>Tambah Produk
    </a>
</div>

<!-- ALERTS -->
@if ($message = Session::get('success'))
<div class="flash flash-success"><i class="fas fa-check-circle mr-2"></i>{{ $message }}</div>
@endif

@if ($message = Session::get('error'))
<div class="flash flash-danger"><i class="fas fa-times-circle mr-2"></i>{{ $message }}</div>
@endif

<!-- PRODUCTS TABLE CARD -->
<div class="admin-card">
    <div class="admin-card-body p-0">
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="col-50">#</th>
                        <th class="col-80">Foto</th>
                        <th>Nama Produk</th>
                        <th class="col-120">Kategori</th>
                        <th class="col-120 text-right">Harga</th>
                        <th class="col-80 text-center">Stok</th>
                        <th class="col-100 text-center">Status</th>
                        <th class="col-120 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $p)
                    <tr>
                        <td class="font-700 text-primary">{{ $loop->iteration }}</td>
                        <td>
                            @if($p->foto)
                            <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto" class="admin-table-img">
                            @else
                            <span class="badge badge-secondary">No Image</span>
                            @endif
                        </td>
                        <td>
                            <div class="font-600 text-dark">{{ $p->nama_produk }}</div>
                            <small class="muted">ID: {{ $p->id_produk }}</small>
                        </td>
                        <td class="muted">{{ $p->kategori->nama_kategori ?? '-' }}</td>
                        <td class="text-right font-700 text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($p->stok > 0)
                            <span class="badge badge-success">{{ $p->stok }}</span>
                            @else
                            <span class="badge badge-danger">Habis</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($p->status_produk === 'aktif')
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('admin.produk.edit', $p->id_produk) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.produk.destroy', $p->id_produk) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-cell">
                            <i class="fas fa-inbox empty-icon"></i>
                            <p class="mb-0 mt-1 font-600">Tidak ada produk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PAGINATION -->
@if ($produk->hasPages())
<div style="display: flex; justify-content: center; margin-top: 24px;">
    {{ $produk->links() }}
</div>
@endif

@endsection
