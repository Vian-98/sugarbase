@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
    <h1 style="font-size: 1.8em; color: #1f2937; margin: 0; font-weight: 700;">📦 Pesanan Saya</h1>
    <a href="/katalog" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600;">+ Belanja Lagi</a>
</div>

<!-- FLASH MESSAGES -->
@if(session('success'))
<div style="background: #f0fdf4; border: 1px solid #86efac; color: #16a34a; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
    ✅ {{ session('success') }}
</div>
@endif

<!-- FILTER TAB STATUS -->
@php
$statuses = ['semua' => 'Semua', 'pending' => 'Pending', 'diproses' => 'Diproses', 'dikirim' => 'Dikirim', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
$aktif = request('status', 'semua');
@endphp

<div style="display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap;">
    @foreach($statuses as $key => $label)
    <a href="/pesanan/saya?status={{ $key }}"
        style="padding: 8px 18px; border-radius: 20px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.2s;
               background: {{ $aktif === $key ? 'linear-gradient(135deg, #667eea, #764ba2)' : '#f3f4f6' }};
               color: {{ $aktif === $key ? 'white' : '#6b7280' }};">
        {{ $label }}
        @if($aktif === $key && isset($totalPerStatus[$key]))
            <span style="background: rgba(255,255,255,0.3); padding: 1px 7px; border-radius: 10px; font-size: 0.85em; margin-left: 4px;">{{ $totalPerStatus[$key] }}</span>
        @endif
    </a>
    @endforeach
</div>

<!-- LIST PESANAN -->
@if($pesanan->count() === 0)
<div style="background: white; border-radius: 12px; padding: 80px 40px; text-align: center; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <div style="font-size: 5em; margin-bottom: 20px;">📭</div>
    <h2 style="color: #374151; font-size: 1.3em; margin-bottom: 10px;">Belum ada pesanan</h2>
    <p style="color: #9ca3af; margin-bottom: 24px;">Yuk, mulai belanja dessert favoritmu!</p>
    <a href="/katalog" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600;">
        Belanja Sekarang →
    </a>
</div>
@else

<div style="display: flex; flex-direction: column; gap: 16px;">
    @foreach($pesanan as $item)
    @php
    $statusColors = [
        'pending'    => ['bg' => '#fffbeb', 'text' => '#d97706', 'border' => '#fcd34d', 'emoji' => '⏳'],
        'diproses'   => ['bg' => '#eff6ff', 'text' => '#2563eb', 'border' => '#93c5fd', 'emoji' => '🔄'],
        'dikirim'    => ['bg' => '#f0fdf4', 'text' => '#16a34a', 'border' => '#86efac', 'emoji' => '🚚'],
        'selesai'    => ['bg' => '#f0fdf4', 'text' => '#15803d', 'border' => '#4ade80', 'emoji' => '✅'],
        'dibatalkan' => ['bg' => '#fef2f2', 'text' => '#dc2626', 'border' => '#fca5a5', 'emoji' => '❌'],
    ];
    $sc = $statusColors[$item->status_pesanan] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280', 'border' => '#d1d5db', 'emoji' => '📋'];
    @endphp

    <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; transition: box-shadow 0.2s;"
         onmouseover="this.style.boxShadow='0 4px 20px rgba(102,126,234,0.12)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'">

        <!-- Header Pesanan -->
        <div style="padding: 14px 20px; background: #f9fafb; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <span style="font-weight: 700; color: #374151; font-size: 0.9em;">Pesanan #{{ $item->id_pesanan }}</span>
                <span style="font-size: 0.8em; color: #9ca3af;">{{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d M Y') }}</span>
            </div>
            <span style="padding: 4px 14px; border-radius: 20px; font-size: 0.8em; font-weight: 600;
                          background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; border: 1px solid {{ $sc['border'] }};">
                {{ $sc['emoji'] }} {{ ucfirst($item->status_pesanan) }}
            </span>
        </div>

        <!-- Item Produk -->
        <div style="padding: 16px 20px; border-bottom: 1px solid #f3f4f6;">
            @foreach($item->items->take(3) as $pi)
            <div style="display: flex; align-items: center; gap: 12px; {{ !$loop->last ? 'margin-bottom: 12px;' : '' }}">
                <div style="width: 48px; height: 48px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.6em; flex-shrink: 0; overflow: hidden;">
                    @if(!empty($pi->produk->foto))
                        <img src="{{ asset('storage/' . $pi->produk->foto) }}" alt="{{ $pi->produk->nama_produk ?? 'Produk' }}" style="width:48px; height:48px; object-fit:cover; display:block;">
                    @else
                        <div style="font-size:1.6em;">🍰</div>
                    @endif
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0; font-size: 0.9em; font-weight: 600; color: #111827;">{{ $pi->produk->nama_produk ?? 'Produk' }}</p>
                    <p style="margin: 3px 0 0; font-size: 0.8em; color: #9ca3af;">{{ $pi->jumlah_pesanan }} × Rp {{ number_format($pi->harga_satuan_pesanan, 0, ',', '.') }}</p>
                </div>
                <div style="font-weight: 600; color: #374151; font-size: 0.9em; white-space: nowrap;">
                    Rp {{ number_format($pi->subtotal_pesanan, 0, ',', '.') }}
                </div>
            </div>
            @endforeach

            @if($item->items->count() > 3)
            <p style="margin: 10px 0 0; font-size: 0.8em; color: #9ca3af; font-style: italic;">
                +{{ $item->items->count() - 3 }} produk lainnya
            </p>
            @endif
        </div>

        <!-- Footer Pesanan -->
        <div style="padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                @php $mp = $item->pembayaran->metode_pembayaran ?? '-'; @endphp
                <span style="font-size: 0.8em; color: #9ca3af;">
                    💳 {{ ucfirst($mp) }}
                </span>
                @if($item->pembayaran && $item->pembayaran->status_pembayaran === 'lunas')
                <span style="font-size: 0.8em; color: #16a34a; font-weight: 600;">✔ Lunas</span>
                @elseif($item->status_pesanan === 'pending')
                <a href="/pembayaran/{{ $item->id_pesanan }}" style="font-size: 0.8em; color: #ef4444; font-weight: 600; text-decoration: none;">⚠ Bayar Sekarang</a>
                @endif
            </div>

            <div style="display: flex; align-items: center; gap: 14px;">
                <span style="font-weight: 700; color: #667eea; font-size: 1em;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                <a href="/pesanan/{{ $item->id_pesanan }}"
                    style="padding: 8px 16px; background: #f3f4f6; color: #374151; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600; border: 1px solid #e5e7eb; transition: all 0.2s;"
                    onmouseover="this.style.background='#667eea'; this.style.color='white'"
                    onmouseout="this.style.background='#f3f4f6'; this.style.color='#374151'">
                    Lihat Detail →
                </a>
            </div>
        </div>

    </div>
    @endforeach
</div>

<!-- PAGINATION -->
@if(method_exists($pesanan, 'links'))
<div style="margin-top: 28px; display: flex; justify-content: center;">
    {{ $pesanan->appends(request()->query())->links() }}
</div>
@endif

@endif

@endsection