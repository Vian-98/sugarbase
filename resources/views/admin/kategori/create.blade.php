@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">➕ Tambah Kategori</h2>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.kategori.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   value="{{ old('nama_kategori') }}" required>
                            @error('nama_kategori') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi_kategori" class="form-control" rows="4">{{ old('deskripsi_kategori') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">💾 Simpan</button>
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
