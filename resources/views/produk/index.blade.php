@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="page-header">
    <h1>📦 Produk</h1>
    <p>Kelola semua produk di sistem</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Daftar Produk</h2>
        <a href="{{ route('produk.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    </div>
    @if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
    @endif

    <table style="width:100%; border-collapse: collapse; font-size:14px;">
        <thead>
            <tr style="background:#f9fafb; text-align:left;">
                <th style="padding:12px;">Foto</th>
                <th style="padding:12px;">Nama Produk</th>
                <th style="padding:12px;">Harga</th>
                <th style="padding:12px;">Stok</th>
                <th style="padding:12px;">Kategori</th>
                <th style="padding:12px;">Status</th>
                <th style="padding:12px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($produk as $item)
            <tr style="border-top:1px solid #e5e7eb;">
                <td style="padding:12px;">
                    @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
                    @else
                    -
                    @endif
                </td>

                <td style="padding:12px; font-weight:500;">
                    {{ $item->nama_produk }}
                </td>

                <td style="padding:12px;">
                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                </td>

                <td style="padding:12px;">
                    {{ $item->stok }}
                </td>

                <td style="padding:12px;">
                    {{ $item->kategori->nama_kategori ?? '-' }}
                </td>

                <td style="padding:12px;">
                    <span style="
                    padding:4px 8px;
                    border-radius:6px;
                    background: {{ $item->status_produk == 'aktif' ? '#d1fae5' : '#fee2e2' }};
                    color: {{ $item->status_produk == 'aktif' ? '#065f46' : '#991b1b' }};
                    font-size:12px;
                ">
                        {{ $item->status_produk }}
                    </span>
                </td>

                <td style="display:flex; gap:5px;">
                    <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('produk.destroy', $item->id_produk) }}" method="POST"
                        onsubmit="return confirm('Yakin mau hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:20px;">
                    Belum ada produk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection