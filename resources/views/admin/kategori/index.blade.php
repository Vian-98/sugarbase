@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('page_title')
    <div class="container">
        <h1 class="hero-title">Manajemen Kategori</h1>
        <p class="hero-sub">Kelola kategori produk</p>
    </div>
@endsection

@section('content')

<!-- PAGE HEADER -->
    <div class="page-header">
    <h1 class="page-title"></h1>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>Tambah Kategori
    </a>
</div>

<!-- ALERTS -->
@if ($message = Session::get('success'))
<div class="flash flash-success"><i class="fas fa-check-circle mr-2"></i>{{ $message }}</div>
@endif

@if ($message = Session::get('error'))
<div class="flash flash-danger"><i class="fas fa-times-circle mr-2"></i>{{ $message }}</div>
@endif

<!-- CATEGORIES TABLE CARD -->
    <div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="col-50">#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="col-100 text-center">Produk</th>
                        <th class="col-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $k)
                    <tr>
                        <td class="font-700 text-primary">{{ $loop->iteration }}</td>
                        <td class="font-600 text-dark">{{ $k->nama_kategori }}</td>
                        <td class="truncate">{{ $k->deskripsi_kategori ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ $k->produk_count ?? 0 }}</span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('admin.kategori.edit', $k->id_kategori) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                        <td colspan="5" class="empty-cell">
                            <i class="fas fa-inbox empty-icon"></i>
                            <p class="mb-0 mt-1 font-600">Tidak ada kategori</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PAGINATION -->
@if ($kategori->hasPages())
<div class="text-center mt-5">
    {{ $kategori->links() }}
</div>
@endif

@endsection
