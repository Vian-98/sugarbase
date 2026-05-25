@extends('layouts.admin')

@section('breadcrumb', 'Admin › Manajemen Pesanan')

@section('page_title')
    <div class="container">
        <h1 class="hero-title">📋 Manajemen Pesanan</h1>
    </div>
@endsection

@section('content')
<div class="container">

    <!-- FLASH MESSAGE -->
    @if(session('success'))
    <div class="flash flash-success">✅ {{ session('success') }}</div>
    @endif

    <!-- STATISTIK REVENUE HARI INI -->
    <div class="stat-grid mb-5">
        @php
        $totalPesanan = $pesanan->count();
        $pending = $pesanan->where('status_pesanan', 'pending')->count();
        $selesai = $pesanan->where('status_pesanan', 'selesai')->count();
        @endphp

        <div class="stat-card">
            <p class="stat-card__label">💰 Revenue Hari Ini</p>
            <p class="stat-card__value text-primary">Rp {{ number_format($revenueHariIni, 0, ',', '.') }}</p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">📦 Total Pesanan</p>
            <p class="stat-card__value">{{ $totalPesanan }}</p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">⏳ Pending</p>
            <p class="stat-card__value text-warning">{{ $pending }}</p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">✅ Selesai</p>
            <p class="stat-card__value text-success">{{ $selesai }}</p>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="admin-card mb-4">
        <div class="filter-bar">
            <span class="font-600" style="color: var(--text-secondary); font-size: 0.9em;">Filter:</span>
            @php
            $statuses = ['semua' => 'Semua', 'pending' => 'Pending', 'diproses' => 'Diproses', 'dikirim' => 'Dikirim', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
            $aktif = request('status', 'semua');
            @endphp
            @foreach($statuses as $key => $label)
            <a href="/admin/pesanan?status={{ $key }}" class="filter-chip {{ $aktif === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        <!-- TABEL PESANAN -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th class="text-center">Items</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Pembayaran</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
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
                    <tr>
                        <td class="font-strong text-primary">#{{ $item->id_pesanan }}</td>
                        <td>
                            <p class="m-0 font-600">{{ $item->user->name ?? 'N/A' }}</p>
                            <p class="muted m-0">{{ $item->user->email ?? '' }}</p>
                        </td>
                        <td class="muted">{{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d M Y') }}</td>
                        <td class="text-center font-600">{{ $item->items->count() }} item</td>
                        <td class="text-right font-700">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->pembayaran && $item->pembayaran->status_pembayaran === 'lunas' ? 'badge-success' : 'badge-warning' }}">{{ $bayarColor['label'] }}</span>
                            @if($item->pembayaran && $item->pembayaran->status_pembayaran !== 'lunas')
                            <form action="/admin/pembayaran/{{ $item->pembayaran->id_pembayaran }}/konfirmasi" method="POST" class="d-inline ml-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Konfirmasi pembayaran ini?')">✔ Konfirmasi</button>
                            </form>
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                            $statusClass = match($item->status_pesanan) {
                                'pending' => 'badge-warning',
                                'diproses' => 'badge-info',
                                'dikirim' => 'badge-success',
                                'selesai' => 'badge-success',
                                'dibatalkan' => 'badge-danger',
                                default => 'badge-secondary',
                            };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($item->status_pesanan) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-center">
                                <form action="/admin/pesanan/{{ $item->id_pesanan }}/status" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <select name="status" class="form-control form-control-sm">
                                        @foreach(['pending','diproses','dikirim','selesai','dibatalkan'] as $s)
                                        <option value="{{ $s }}" {{ $item->status_pesanan === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>

                                <a href="/admin/pesanan/{{ $item->id_pesanan }}" class="btn btn-sm btn-ghost">Detail</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center muted p-5">
                            <div class="empty-emoji">📭</div>
                            Tidak ada pesanan ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if(method_exists($pesanan, 'links'))
        <div class="py-3 text-right">
            {{ $pesanan->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
