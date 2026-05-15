@extends('layouts.admin')

@section('breadcrumb', 'Admin › Manajemen Kategori')

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
    <h1 style="font-size: 1.6em; color: #1f2937; margin: 0; font-weight: 700;">📂 Manajemen Kategori</h1>
    <a href="{{ route('admin.kategori.create') }}" style="padding: 10px 20px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.boxShadow='0 5px 15px rgba(102,126,234,0.3)'" onmouseout="this.style.boxShadow='none'">➕ Tambah Kategori</a>
</div>

<div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
    <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.88em;">
                <thead>
                    <tr style="background: #f9fafb; color: #6b7280; text-transform: uppercase; font-size: 0.8em; letter-spacing: 0.4px;">
                        <th style="padding: 13px 20px; text-align: left; font-weight: 600;">#</th>
                        <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Nama Kategori</th>
                        <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Deskripsi</th>
                        <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Produk</th>
                        <th style="padding: 13px 20px; text-align: center; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $k)
                    <tr style="border-top: 1px solid #e5e7eb; transition: background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                        <td style="padding: 14px 20px; font-weight: 700; color: #667eea;">{{ $loop->iteration }}</td>
                        <td style="padding: 14px 12px;">
                            <p style="margin: 0; font-weight: 600; color: #1f2937;">{{ $k->nama_kategori }}</p>
                        </td>
                        <td style="padding: 14px 12px; color: #374151; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $k->deskripsi_kategori ?? '-' }}
                        </td>
                        <td style="padding: 14px 12px; text-align: center;">
                            <span style="padding: 4px 10px; background: #eff6ff; color: #2563eb; border-radius: 20px; font-size: 0.8em; font-weight: 600;">{{ $k->produk_count ?? 0 }}</span>
                        </td>
                        <td style="padding: 14px 20px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <a href="{{ route('admin.kategori.edit', $k->id_kategori) }}" style="padding: 5px 10px; background: #f59e0b; color: white; border-radius: 6px; text-decoration: none; font-size: 0.8em; font-weight: 600;">✏️ Edit</a>
                                <form method="POST" action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding: 5px 10px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.8em; font-weight: 600;">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
    </div>
</div>

@if ($kategori->hasPages())
<div style="padding: 16px 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end;">
    {{ $kategori->links() }}
</div>
@endif
          </tbody>
            </table>
        </div>
    </div>

    @if ($kategori->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $kategori->links() }}
    </div>
    @endif
</div>
@endsection
