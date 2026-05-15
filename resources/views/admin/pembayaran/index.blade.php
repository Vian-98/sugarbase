@extends('layouts.admin')

@section('breadcrumb', 'Admin › Manajemen Pembayaran')

@section('content')

<div style="margin-bottom: 24px;">
    <h1 style="font-size: 1.6em; color: #1f2937; margin: 0; font-weight: 700;">💳 Manajemen Pembayaran</h1>
</div>

<div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.88em;">
            <thead>
                <tr style="background: #f9fafb; color: #6b7280; text-transform: uppercase; font-size: 0.8em; letter-spacing: 0.4px;">
                    <th style="padding: 13px 20px; text-align: left; font-weight: 600;">ID Pesanan</th>
                    <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Nama Pelanggan</th>
                    <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Metode</th>
                    <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Status</th>
                    <th style="padding: 13px 12px; text-align: right; font-weight: 600;">Jumlah</th>
                    <th style="padding: 13px 20px; text-align: center; font-weight: 600;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaran as $p)
                @php
                    $statusColors = [
                        'lunas'    => ['bg' => '#f0fdf4', 'text' => '#16a34a'],
                        'gagal'    => ['bg' => '#fef2f2', 'text' => '#dc2626'],
                        'menunggu' => ['bg' => '#fffbeb', 'text' => '#d97706'],
                    ];
                    $sc = $statusColors[$p->status_pembayaran ?? 'menunggu'] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
                @endphp
                <tr style="border-top: 1px solid #e5e7eb; transition: background 0.15s;"
                    onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                    
                    <td style="padding: 14px 20px; font-weight: 700; color: #667eea;">#{{ $p->id_pesanan }}</td>
                    
                    <td style="padding: 14px 12px;">
                        <p style="margin: 0; font-weight: 600; color: #111827;">{{ $p->pesanan->user->name ?? '-' }}</p>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: #9ca3af;">{{ $p->pesanan->user->email ?? '' }}</p>
                    </td>
                    
                    <td style="padding: 14px 12px; color: #374151;">
                        {{ ucfirst($p->metode_pembayaran ?? '-') }}
                    </td>
                    
                    <td style="padding: 14px 12px; text-align: center;">
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8em; font-weight: 600;
                                     background: {{ $sc['bg'] }}; color: {{ $sc['text'] }};">
                            {{ ucfirst($p->status_pembayaran ?? 'menunggu') }}
                        </span>
                    </td>
                    
                    <td style="padding: 14px 12px; text-align: right; font-weight: 700; color: #1f2937; white-space: nowrap;">
                        Rp {{ number_format($p->pesanan->total_harga ?? 0, 0, ',', '.') }}
                    </td>
                    
                    <td style="padding: 14px 20px; text-align: center;">
                        @if($p->status_pembayaran !== 'lunas')
                        <form action="/admin/pembayaran/{{ $p->id_pembayaran }}/konfirmasi" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini?')"
                                style="padding: 5px 12px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.8em; font-weight: 600; transition: all 0.2s;"
                                onmouseover="this.style.background='#764ba2'" onmouseout="this.style.background='#667eea'">
                                ✔ Konfirmasi
                            </button>
                        </form>
                        @else
                        <span style="color: #9ca3af; font-size: 0.8em;">✓ Lunas</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 60px 20px; text-align: center; color: #9ca3af;">
                        <div style="font-size: 3em; margin-bottom: 12px;">📭</div>
                        Tidak ada pembayaran ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
