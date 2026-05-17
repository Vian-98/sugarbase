@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <h1 class="page-title">✏️ Edit Kategori</h1>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="admin-card">
                    <form method="POST" action="{{ route('admin.kategori.update', $kategori->id_kategori) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                            @error('nama_kategori') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi_kategori" class="form-control" rows="4">{{ old('deskripsi_kategori', $kategori->deskripsi_kategori) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
