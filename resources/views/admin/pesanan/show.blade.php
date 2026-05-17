@extends('layouts.admin')

@section('breadcrumb', 'Admin › Pesanan › Detail')

@section('content')

<!-- HEADER -->
<div class="container">
    <div class="page-header">
        <h1 class="hero-title">📋 Detail Pesanan #{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</h1>
        <a href="/admin/pesanan" class="btn btn-ghost">← Kembali</a>
    </div>
</div>

<div class="grid-2">

    <!-- MAIN CONTENT -->
    <div>
        <!-- ORDER INFO CARD -->
        <div class="admin-card mb-3">
            <div class="card-header">ℹ️ Informasi Pesanan</div>
            <div class="card-body">
                <div class="grid-2 gap-24 mb-16">
                    <div>
                        <small class="muted d-block mb-2">ID Pesanan</small>
                        <p class="font-700 text-primary m-0">#{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <small class="muted d-block mb-2">Tanggal Pesanan</small>
                        <p class="m-0">{{ $pesanan->tanggal_pesan->format('d M Y · H:i') }}</p>
                    </div>
                </div>
                <div class="grid-2 gap-24">
                    <div>
                        <small class="muted d-block mb-2">Nama Pelanggan</small>
                        <p class="m-0">{{ $pesanan->user->name }}</p>
                        <small class="muted">{{ $pesanan->user->email }}</small>
                    </div>
                    <div>
                        <small class="muted d-block mb-2">Status Pesanan</small>
                        @php
                            $map = [
                                'pending' => ['class' => 'badge-warning', 'emoji' => '⏳'],
                                'diproses' => ['class' => 'badge-info', 'emoji' => '🔄'],
                                'dikirim' => ['class' => 'badge-success', 'emoji' => '🚚'],
                                'selesai' => ['class' => 'badge-success', 'emoji' => '✅'],
                                'dibatalkan' => ['class' => 'badge-danger', 'emoji' => '❌'],
                            ];
                            $st = $pesanan->status_pesanan;
                            $sc = $map[$st] ?? ['class' => 'badge-secondary', 'emoji' => '❓'];
                        @endphp
                        <span class="badge {{ $sc['class'] }}">{{ $sc['emoji'] }} {{ ucfirst($pesanan->status_pesanan) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ITEMS TABLE -->
        <div class="admin-card mb-3">
            <div class="card-header">📦 Item Pesanan</div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Harga</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->items as $item)
                        <tr>
                            <td>
                                <p class="m-0 font-600">{{ $item->produk->nama_produk }}</p>
                                <small class="muted">ID: {{ $item->produk->id_produk }}</small>
                            </td>
                            <td class="text-center font-600">{{ $item->jumlah_pesanan }}x</td>
                            <td class="text-right">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                            <td class="text-right font-700 text-primary">Rp {{ number_format($item->subtotal_pesanan, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TRACKING HISTORY -->
        <div class="admin-card mb-3">
            <div class="card-header">📜 Riwayat Tracking</div>
            <div class="card-body">
                @forelse($pesanan->tracking as $track)
                <div class="timeline-item">
                    <div class="timeline-row">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <p class="m-0 font-600 timeline-status">{{ $track->status }}</p>
                            <small class="muted d-block mb-2">📅 {{ $track->waktu_update->format('d M Y') }} · ⏰ {{ $track->waktu_update->format('H:i') }}</small>
                            <p class="m-0 timeline-desc">{{ $track->keterangan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center muted py-3">Belum ada tracking</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="stack-20">

        <!-- SUMMARY CARD -->
        <div class="admin-card">
            <div class="card-header">💰 Ringkasan</div>
            <div class="card-body">
                <div class="mb-16 border-bottom pb-16">
                    <small class="muted d-block mb-2">Total Harga</small>
                    <h4 class="m-0 font-700 text-primary">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h4>
                </div>
                <div>
                    <small class="muted d-block mb-2">Status Pembayaran</small>
                    @php
                        $bayarColor = [
                            'lunas'    => ['bg' => '#f0fdf4', 'text' => '#16a34a'],
                            'gagal'    => ['bg' => '#fef2f2', 'text' => '#dc2626'],
                            'menunggu' => ['bg' => '#fffbeb', 'text' => '#d97706'],
                        ];
                        $bp = $pesanan->pembayaran->status_pembayaran ?? 'menunggu';
                        $bc = $bayarColor[$bp] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
                    @endphp
                        @php
                            $payClass = match($bp) {
                                'lunas' => 'badge-success',
                                'gagal' => 'badge-danger',
                                'menunggu' => 'badge-warning',
                                default => 'badge-secondary',
                            };
                        @endphp
                        <span class="badge {{ $payClass }}">{{ ucfirst($bp) }}</span>
                    @if($bp !== 'lunas' && $pesanan->pembayaran)
                    <form action="/admin/pembayaran/{{ $pesanan->pembayaran->id_pembayaran }}/konfirmasi" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Konfirmasi pembayaran ini?')">✔ Konfirmasi Pembayaran</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- PAYMENT METHOD CARD -->
        <div class="admin-card">
            <div class="card-header">💳 Metode Pembayaran</div>
            <div class="card-body">
                <p class="mb-3 font-600 meta-text">{{ ucfirst($pesanan->pembayaran->metode_pembayaran ?? '-') }}</p>
                <small class="muted">Nomor Referensi: {{ $pesanan->pembayaran->no_referensi ?? 'N/A' }}</small>
            </div>
        </div>

        <!-- UPDATE STATUS CARD -->
        <div class="admin-card">
            <div class="card-header">🔄 Update Status</div>
            <div class="card-body">
                <form method="POST" action="/admin/pesanan/{{ $pesanan->id_pesanan }}/status">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Status Pesanan</label>
                        <select name="status" class="form-control">
                            @foreach(['pending','diproses','dikirim','selesai','dibatalkan'] as $s)
                            <option value="{{ $s }}" {{ $pesanan->status_pesanan === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">✔ Update Status</button>
                </form>
            </div>
        </div>

        <!-- ADD TRACKING CARD -->
        <div class="admin-card">
            <div class="card-header">➕ Tambah Tracking</div>
            <div class="card-body">
                <form method="POST" action="/admin/pesanan/{{ $pesanan->id_pesanan }}/tracking">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Pesanan Diterima">Pesanan Diterima</option>
                            <option value="Pembayaran Dikonfirmasi">Pembayaran Dikonfirmasi</option>
                            <option value="Sedang Diproses">Sedang Diproses</option>
                            <option value="Dalam Pengiriman">Dalam Pengiriman</option>
                            <option value="Pesanan Selesai">Pesanan Selesai</option>
                            <option value="Pesanan Dibatalkan">Pesanan Dibatalkan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">💾 Simpan Tracking</button>
                </form>
            </div>
        </div>

    </div>

</div>

@push('styles')
<style>
    @media (max-width: 768px) {
        .grid-2 { grid-template-columns: 1fr !important; }
    }
</style>
@endpush

@endsection
