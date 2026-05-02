@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="page-header">
    <h1>✏️ Edit Produk</h1>
</div>

<div class="card">

    @if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card" style="max-width:600px;">

        @if ($errors->any())
        <div style="background:#fee2e2; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div style="margin-bottom:15px;">
                <label style="font-weight:600;">Nama Produk</label>
                <input type="text" name="nama_produk"
                    value="{{ $produk->nama_produk }}"
                    style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
            </div>

            {{-- Harga --}}
            <div style="margin-bottom:15px;">
                <label style="font-weight:600;">Harga</label>
                <input type="number" name="harga"
                    value="{{ $produk->harga }}"
                    style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
            </div>

            {{-- Stok --}}
            <div style="margin-bottom:15px;">
                <label style="font-weight:600;">Stok</label>
                <input type="number" name="stok"
                    value="{{ $produk->stok }}"
                    style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
            </div>

            {{-- Kategori --}}
            <div style="margin-bottom:15px;">
                <label style="font-weight:600;">Kategori</label>
                <select name="id_kategori"
                    style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                    @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}"
                        {{ $produk->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Deskripsi --}}
            <div style="margin-bottom:15px;">
                <label style="font-weight:600;">Deskripsi</label>
                <textarea name="deskripsi_produk"
                    style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px; min-height:80px;">{{ $produk->deskripsi_produk }}</textarea>
            </div>

            {{-- Foto --}}
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;">Foto</label><br>

                @if($produk->foto)
                <img src="{{ asset('storage/' . $produk->foto) }}"
                    style="width:80px; height:80px; object-fit:cover; border-radius:8px; margin-bottom:10px;">
                @endif

                <input type="file" name="foto">
            </div>

            {{-- BUTTON --}}
            <div style="display:flex; gap:10px;">
                <button type="submit"
                    style="background:#2563eb; color:white; padding:10px 15px; border:none; border-radius:8px; cursor:pointer;">
                    Update
                </button>

                <a href="{{ route('produk.index') }}"
                    style="padding:10px 15px; border:1px solid #d1d5db; border-radius:8px;">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection