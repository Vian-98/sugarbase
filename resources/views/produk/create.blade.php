@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="page-header">
    <h1>➕ Tambah Produk</h1>
    <p>Tambahkan produk baru ke sistem</p>
</div>

<div class="card">

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- NAMA PRODUK --}}
        <div style="margin-bottom:15px;">
            <label>Nama Produk</label><br>
            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" style="width:100%; padding:8px;">
        </div>

        {{-- HARGA --}}
        <div style="margin-bottom:15px;">
            <label>Harga</label><br>
            <input type="number" name="harga" value="{{ old('harga') }}" style="width:100%; padding:8px;">
        </div>

        {{-- STOK --}}
        <div style="margin-bottom:15px;">
            <label>Stok</label><br>
            <input type="number" name="stok" value="{{ old('stok') }}" style="width:100%; padding:8px;">
        </div>

        {{-- KATEGORI --}}
        <div style="margin-bottom:15px;">
            <label>Kategori</label><br>
            <select name="id_kategori" style="width:100%; padding:8px;">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}"
                        {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DESKRIPSI --}}
        <div style="margin-bottom:15px;">
            <label>Deskripsi</label><br>
            <textarea name="deskripsi_produk" style="width:100%; padding:8px;">{{ old('deskripsi_produk') }}</textarea>
        </div>

        {{-- FOTO --}}
        <div style="margin-bottom:15px;">
            <label>Foto</label><br>
            <input type="file" name="foto">
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('produk.index') }}" style="margin-left:10px;">Kembali</a>
    </form>
</div>
@endsection