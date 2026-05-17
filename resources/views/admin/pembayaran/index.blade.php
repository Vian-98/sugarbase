@extends('layouts.admin')

@section('breadcrumb', 'Admin › Manajemen Pembayaran')

@section('content')

<div class="page-header">
    <h1 class="page-title">💳 Manajemen Pembayaran</h1>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Metode</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-center">Aksi</th>
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
                <tr>
                    <td class="font-strong text-primary">#{{ $p->id_pesanan }}</td>
                    <td>
                        <p class="m-0 font-600">{{ $p->pesanan->user->name ?? '-' }}</p>
                        <p class="muted m-0">{{ $p->pesanan->user->email ?? '' }}</p>
                    </td>
                    <td>{{ ucfirst($p->metode_pembayaran ?? '-') }}</td>
                    @php
                        $statusClass = match($p->status_pembayaran ?? 'menunggu') {
                            'lunas' => 'badge-success',
                            'gagal' => 'badge-danger',
                            'menunggu' => 'badge-warning',
                            default => 'badge-secondary',
                        };
                    @endphp
                    <td class="text-center"><span class="badge {{ $statusClass }}">{{ ucfirst($p->status_pembayaran ?? 'menunggu') }}</span></td>
                    <td class="text-right font-700">Rp {{ number_format($p->pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($p->status_pembayaran !== 'lunas')
                        <form action="/admin/pembayaran/{{ $p->id_pembayaran }}/konfirmasi" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Konfirmasi pembayaran ini?')">✔ Konfirmasi</button>
                        </form>
                        @else
                        <span class="muted">✓ Lunas</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center muted p-5">
                        <div class="empty-emoji">📭</div>
                        Tidak ada pembayaran ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
