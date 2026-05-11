@extends('layouts.app')

@section('title', 'Admin — Manajemen Pesanan')

@section('content')

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="font-size: 1.8em; color: #1f2937; margin: 0 0 4px; font-weight: 700;">📋 Manajemen Pesanan</h1>
        <p style="margin: 0; color: #9ca3af; font-size: 0.9em;">Kelola semua pesanan yang masuk</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="/admin/dashboard" style="padding: 10px 18px; background: #f3f4f6; color: #374151; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600; border: 1px solid #e5e7eb;">← Dashboard</a>
    </div>
</div>

<!-- FLASH MESSAGE -->
@if(session('success'))
<div style="background: #f0fdf4; border: 1px solid #86efac; color: #16a34a; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
    ✅ {{ session('success') }}
</div>
@endif

<!-- STATISTIK REVENUE HARI INI -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px;">
    @php
    $hariIni = \Carbon\Carbon::today();
    $revenueHariIni = $pesanan->where('tanggal_pesan', $hariIni->toDateString())->sum('total_harga');
    $totalPesanan = $pesanan->count();
    $pending = $pesanan->where('status_pesanan', 'pending')->count();
    $selesai = $pesanan->where('status_pesanan', 'selesai')->count();
    @endphp

    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 20px; color: white;">
        <p style="margin: 0 0 6px; font-size: 0.85em; opacity: 0.85;">💰 Revenue Hari Ini</p>
        <p style="margin: 0; font-size: 1.5em; font-weight: 700;">Rp {{ number_format($revenueHariIni, 0, ',', '.') }}</p>
    </div>

    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
        <p style="margin: 0 0 6px; font-size: 0.85em; color: #9ca3af;">📦 Total Pesanan</p>
        <p style="margin: 0; font-size: 1.5em; font-weight: 700; color: #1f2937;">{{ $totalPesanan }}</p>
    </div>

    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
        <p style="margin: 0 0 6px; font-size: 0.85em; color: #9ca3af;">⏳ Pending</p>
        <p style="margin: 0; font-size: 1.5em; font-weight: 700; color: #d97706;">{{ $pending }}</p>
    </div>

    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
        <p style="margin: 0 0 6px; font-size: 0.85em; color: #9ca3af;">✅ Selesai</p>
        <p style="margin: 0; font-size: 1.5em; font-weight: 700; color: #16a34a;">{{ $selesai }}</p>
    </div>
</div>

<!-- FILTER & SEARCH -->
<div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <span style="font-weight: 600; color: #374151; font-size: 0.9em;">Filter:</span>
        @php
        $statuses = ['semua' => 'Semua', 'pending' => 'Pending', 'diproses' => 'Diproses', 'dikirim' => 'Dikirim', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
        $aktif = request('status', 'semua');
        @endphp
        @foreach($statuses as $key => $label)
        <a href="/admin/pesanan?status={{ $key }}"
            style="padding: 6px 14px; border-radius: 20px; text-decoration: none; font-size: 0.82em; font-weight: 600; transition: all 0.2s;
                   background: {{ $aktif === $key ? 'linear-gradient(135deg, #667eea, #764ba2)' : '#f3f4f6' }};
                   color: {{ $aktif === $key ? 'white' : '#6b7280' }};">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <!-- TABEL PESANAN -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.88em;">
            <thead>
                <tr style="background: #f9fafb; color: #6b7280; text-transform: uppercase; font-size: 0.8em; letter-spacing: 0.4px;">
                    <th style="padding: 13px 20px; text-align: left; font-weight: 600;">ID</th>
                    <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Pelanggan</th>
                    <th style="padding: 13px 12px; text-align: left; font-weight: 600;">Tanggal</th>
                    <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Items</th>
                    <th style="padding: 13px 12px; text-align: right; font-weight: 600;">Total</th>
                    <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Pembayaran</th>
                    <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Status</th>
                    <th style="padding: 13px 20px; text-align: center; font-weight: 600;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan as $item)
                @php
                $statusColors = [
                    'pending'    => ['bg' => '#fffbeb', 'text' => '#d97706'],
                    'diproses'   => ['bg' => '#eff6ff', 'text' => '#2563eb'],
                    'dikirim'    => ['bg' => '#f0fdf4', 'text' => '#16a34a'],
                    'selesai'    => ['bg' => '#f0fdf4', 'text' => '#15803d'],
                    'dibatalkan' => ['bg' => '#fef2f2', 'text' => '#dc2626'],
                ];
                $sc = $statusColors[$item->status_pesanan] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
                $bayarColor = $item->pembayaran && $item->pembayaran->status_pembayaran === 'lunas'
                    ? ['bg' => '#f0fdf4', 'text' => '#16a34a', 'label' => 'Lunas']
                    : ['bg' => '#fffbeb', 'text' => '#d97706', 'label' => 'Menunggu'];
                @endphp
                <tr style="border-top: 1px solid #e5e7eb; transition: background 0.15s;"
                    onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">

                    <td style="padding: 14px 20px; font-weight: 700; color: #667eea;">#{{ $item->id_pesanan }}</td>

                    <td style="padding: 14px 12px;">
                        <p style="margin: 0; font-weight: 600; color: #111827;">{{ $item->user->name ?? 'N/A' }}</p>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: #9ca3af;">{{ $item->user->email ?? '' }}</p>
                    </td>

                    <td style="padding: 14px 12px; color: #6b7280;">
                        {{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d M Y') }}
                    </td>

                    <td style="padding: 14px 12px; text-align: center; color: #374151; font-weight: 600;">
                        {{ $item->items->count() }} item
                    </td>

                    <td style="padding: 14px 12px; text-align: right; font-weight: 700; color: #1f2937; white-space: nowrap;">
                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                    </td>

                    <td style="padding: 14px 12px; text-align: center;">
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.8em; font-weight: 600;
                                     background: {{ $bayarColor['bg'] }}; color: {{ $bayarColor['text'] }};">
                            {{ $bayarColor['label'] }}
                        </span>
                        @if($item->pembayaran && $item->pembayaran->status_pembayaran !== 'lunas')
                        <form action="/admin/pembayaran/{{ $item->pembayaran->id_pembayaran }}/konfirmasi" method="POST" style="display: inline; margin-left: 6px;">
                            @csrf
                            <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini?')"
                                style="padding: 3px 8px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.75em; font-weight: 600;">
                                ✔ Konfirmasi
                            </button>
                        </form>
                        @endif
                    </td>

                    <td style="padding: 14px 12px; text-align: center;">
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8em; font-weight: 600;
                                     background: {{ $sc['bg'] }}; color: {{ $sc['text'] }};">
                            {{ ucfirst($item->status_pesanan) }}
                        </span>
                    </td>

                    <td style="padding: 14px 20px; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: wrap;">
                            <!-- Update Status -->
                            <form action="/admin/pesanan/{{ $item->id_pesanan }}/status" method="POST" style="display: flex; gap: 4px;">
                                @csrf
                                <select name="status"
                                    style="padding: 5px 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.8em; background: white; color: #374151; cursor: pointer;">
                                    @foreach(['pending','diproses','dikirim','selesai','dibatalkan'] as $s)
                                    <option value="{{ $s }}" {{ $item->status_pesanan === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    style="padding: 5px 10px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.8em; font-weight: 600;">
                                    Update
                                </button>
                            </form>

                            <!-- Detail -->
                            <a href="/pesanan/{{ $item->id_pesanan }}"
                                style="padding: 5px 10px; background: #f3f4f6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 0.8em; font-weight: 600; border: 1px solid #e5e7eb;">
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 60px; text-align: center; color: #9ca3af;">
                        <div style="font-size: 3em; margin-bottom: 12px;">📭</div>
                        Tidak ada pesanan ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if(method_exists($pesanan, 'links'))
    <div style="padding: 16px 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end;">
        {{ $pesanan->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
