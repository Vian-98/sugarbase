@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="page-header">
    <h1>📂 Kategori</h1>
    <p>Kelola kategori produk</p>
</div>

<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Daftar Kategori</h2>
    </div>

    <form action="{{ route('kategori.store') }}" method="POST" style="margin-bottom:20px;">
        @csrf

        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <input type="text" name="nama_kategori" placeholder="Nama kategori"
                style="padding:10px; border:1px solid #ddd; border-radius:8px; flex:1;" required>

            <input type="text" name="deskripsi_kategori" placeholder="Deskripsi"
                style="padding:10px; border:1px solid #ddd; border-radius:8px; flex:1;">

            <button type="submit" class="btn btn-primary">
                + Tambah Kategori
            </button>
        </div>
    </form>

    <table width="100%" cellpadding="10" style="border-collapse:collapse;">
        <tr style="background:#f9fafb; text-align:left;">
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
        </tr>

        @forelse($kategori as $item)
        <tr style="border-top:1px solid #eee;">
            <td>{{ $item->id_kategori }}</td>
            <td>{{ $item->nama_kategori }}</td>
            <td>{{ $item->deskripsi_kategori }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" style="color:#6b7280;">
                Belum ada data kategori
            </td>
        </tr>
        @endforelse

    </table>

</div>
@endsection