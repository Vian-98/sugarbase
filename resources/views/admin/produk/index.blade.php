@extends('layouts.admin')

@section('breadcrumb', 'Admin › Manajemen Produk')

@section('content')

<!-- FLASH MESSAGE -->
@if ($message = Session::get('success'))
<div style="background: #f0fdf4; border: 1px solid #86efac; color: #16a34a; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
    ✅ {{ $message }}
</div>
@endif

@if ($message = Session::get('error'))
<div style="background: #fef2f2; border: 1px solid #fca5a5; color: #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
    ❌ {{ $message }}
</div>
@endif

<!-- HEADER -->
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <h1 style="font-size: 1.6em; color: #1f2937; margin: 0; font-weight: 700;">📦 Manajemen Produk</h1>
    <a href="{{ route('admin.produk.create') }}" style="padding: 10px 20px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.boxShadow='0 5px 15px rgba(102,126,234,0.3)'" onmouseout="this.style.boxShadow='none'">➕ Tambah Produk</a>
</div>

<div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
    <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.88em;">
                <thead>
                    <tr style="background: #f9fafb; color: #6b7280; text-transform: uppercase; font-size: 0.8em; letter-spacing: 0.4px;">
                        <th style="padding: 13px 20px; text-align: left; font-weight: 600;">#</th>
                        <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Foto</th>
                        <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Nama Produk</th>
                        <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Kategori</th>
                        <th style="padding: 13px 12px; text-align: right; font-weight: 600;">Harga</th>
                        <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Stok</th>
                        <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Status</th>
                        <th style="padding: 13px 20px; text-align: center; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $p)
                    <tr style="border-top: 1px solid #e5e7eb; transition: background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                        <td style="padding: 14px 20px; font-weight: 700; color: #667eea;">{{ $loop->iteration }}</td>
                        <td style="padding: 14px 12px;">
                            @if($p->foto)
                            <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto" style="max-width: 60px; border-radius: 6px;">
                            @else
                            <span style="padding: 4px 8px; background: #f3f4f6; color: #6b7280; border-radius: 4px; font-size: 0.75em;">No Image</span>
                            @endif
                        </td>
                        <td style="padding: 14px 12px;">
                            <p style="margin: 0; font-weight: 600; color: #1f2937;">{{ $p->nama_produk }}</p>
                            <small style="color: #9ca3af;">ID: {{ $p->id_produk }}</small>
                        </td>
                        <td style="padding: 14px 12px; color: #374151;">{{ $p->kategori->nama_kategori ?? '-' }}</td>
                        <td style="padding: 14px 12px; text-align: right; font-weight: 700; color: #1f2937;">
                            Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </td>
                        <td style="padding: 14px 12px; text-align: center;">
                            @if($p->stok > 0)
                            <span style="padding: 4px 10px; background: #f0fdf4; color: #16a34a; border-radius: 20px; font-size: 0.8em; font-weight: 600;">{{ $p->stok }}</span>
                            @else
                            <span style="padding: 4px 10px; background: #fef2f2; color: #dc2626; border-radius: 20px; font-size: 0.8em; font-weight: 600;">Habis</span>
                            @endif
                        </td>
                        <td style="padding: 14px 12px; text-align: center;">
                            @if($p->status_produk === 'aktif')
                            <span style="padding: 4px 10px; background: #f0fdf4; color: #16a34a; border-radius: 20px; font-size: 0.8em; font-weight: 600;">Aktif</span>
                            @else
                            <span style="padding: 4px 10px; background: #f3f4f6; color: #6b7280; border-radius: 20px; font-size: 0.8em; font-weight: 600;">Nonaktif</span>
                            @endif
                        </td>
                        <td style="padding: 14px 20px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <a href="{{ route('admin.produk.edit', $p->id_produk) }}" style="padding: 5px 10px; background: #f59e0b; color: white; border-radius: 6px; text-decoration: none; font-size: 0.8em; font-weight: 600;">✏️ Edit</a>
                                <form method="POST" action="{{ route('admin.produk.destroy', $p->id_produk) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding: 5px 10px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.8em; font-weight: 600;">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
    </div>
</div>

@if ($produk->hasPages())
<div style="padding: 16px 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end;">
    {{ $produk->links() }}
</div>
@endif
      </table>
        </div>
    </div>

    @if ($produk->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $produk->links() }}
    </div>
    @endif
</div>
@endsection
