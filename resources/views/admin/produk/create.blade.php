@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold">➕ Tambah Produk</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" 
                                   value="{{ old('nama_produk') }}" required>
                            @error('nama_produk') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $k)
                                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('id_kategori') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Harga (Rp)</label>
                                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                           value="{{ old('harga') }}" min="0" step="0.01" required>
                                    @error('harga') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Stok</label>
                                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" 
                                           value="{{ old('stok') }}" min="0" required>
                                    @error('stok') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Produk</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*" required>
                            <small class="text-muted">JPG, PNG (Max 2MB)</small>
                            @error('foto') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi_produk" class="form-control" rows="3">{{ old('deskripsi_produk') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">💾 Simpan</button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
