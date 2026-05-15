@extends('layouts.admin')

@section('breadcrumb', 'Admin › Manajemen Pelanggan')

@section('content')

<!-- HEADER -->
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <h1 style="font-size: 1.6em; color: #1f2937; margin: 0; font-weight: 700;">👥 Manajemen Pelanggan</h1>
    <div style="display: flex; gap: 8px;">
        <input type="search" placeholder="Cari pelanggan..." style="padding: 10px 16px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.9em; width: 200px;">
    </div>
</div>

<div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
    <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.88em;">
                <thead>
                    <tr style="background: #f9fafb; color: #6b7280; text-transform: uppercase; font-size: 0.8em; letter-spacing: 0.4px;">
                        <th style="padding: 13px 20px; text-align: left; font-weight: 600;">#</th>
                        <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Nama</th>
                        <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Email</th>
                        <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Telepon</th>
                        <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Pesanan</th>
                        <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Status</th>
                        <th style="padding: 13px 20px; text-align: center; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $p)
                    <tr style="border-top: 1px solid #e5e7eb; transition: background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                        <td style="padding: 14px 20px; font-weight: 700; color: #667eea;">{{ $loop->iteration }}</td>
                        <td style="padding: 14px 12px;">
                            <p style="margin: 0; font-weight: 600; color: #1f2937;">{{ $p->name }}</p>
                            <small style="color: #9ca3af;">ID: {{ $p->id }}</small>
                        </td>
                        <td style="padding: 14px 12px; color: #374151;">
                            <a href="mailto:{{ $p->email }}" style="color: #2563eb; text-decoration: none;">{{ $p->email }}</a>
                        </td>
                        <td style="padding: 14px 12px; color: #374151;">{{ $p->no_telepon ?? '-' }}</td>
                        <td style="padding: 14px 12px; text-align: center;">
                            @php
                                $pesananCount = $p->pesanan()->count() ?? 0;
                            @endphp
                            <span style="padding: 4px 10px; background: #eff6ff; color: #2563eb; border-radius: 20px; font-size: 0.8em; font-weight: 600;">{{ $pesananCount }}</span>
                        </td>
                        <td style="padding: 14px 12px; text-align: center;">
                            <span style="padding: 4px 10px; background: #f0fdf4; color: #16a34a; border-radius: 20px; font-size: 0.8em; font-weight: 600;">Aktif</span>
                        </td>
                        <td style="padding: 14px 20px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <a href="{{ route('admin.pelanggan.show', $p->id) }}" style="padding: 5px 10px; background: #3b82f6; color: white; border-radius: 6px; text-decoration: none; font-size: 0.8em; font-weight: 600;">👁️ Lihat</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 60px 20px; text-align: center; color: #9ca3af;">
                            <div style="font-size: 3em; margin-bottom: 12px;">👤</div>
                            Tidak ada pelanggan ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
    </div>
</div>

@if ($pelanggan->hasPages())
<div style="padding: 16px 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end;">
    {{ $pelanggan->links() }}
</div>
@endif

@endsection
