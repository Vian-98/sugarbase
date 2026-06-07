@extends('layouts.admin')

@section('title', 'Kategori')

@section('page_title')
    <div class="container">
        <h1 class="hero-title">Kategori Produk</h1>
        <p class="hero-sub">Kelola pengelompokan produk Anda untuk mempermudah pencarian.</p>
    </div>
@endsection

@section('content')
<div class="container">

    {{-- Alert Sukses --}}
    @if(session('success'))
    <div class="alert alert-success">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Form Tambah Kategori Cepat --}}
    <div class="admin-card mb-5">
        <div class="admin-card-header">
            <h2 class="section-title m-0" style="font-size: 1.1em; color: var(--dark);">➕ Tambah Kategori Baru</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Minuman" required>
                    </div>

                    <div style="flex: 2; min-width: 250px;">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi_kategori" class="form-control" placeholder="Deskripsi singkat...">
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Kategori --}}
    <div class="admin-card">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>NAMA KATEGORI</th>
                        <th>DESKRIPSI</th>
                        <th class="text-center" style="width: 150px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $item)
                    <tr>
                        <td style="color: var(--text-secondary); font-family: monospace;">#{{ str_pad($item->id_kategori, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <span class="badge badge-info" style="font-size: 0.9em; padding: 6px 12px;">
                                {{ $item->nama_kategori }}
                            </span>
                        </td>
                        <td style="color: var(--text-secondary); font-size: 0.9rem;">
                            {{ $item->deskripsi_kategori ?: '-' }}
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" method="POST" 
                                  onsubmit="return confirm('Menghapus kategori akan mempengaruhi produk terkait. Lanjutkan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center" style="padding: 40px; color: var(--text-secondary);">
                            <div style="font-size: 2.5rem; margin-bottom: 10px;">📂</div>
                            <p>Belum ada kategori yang ditambahkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection