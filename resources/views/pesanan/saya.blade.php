@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">📦 Riwayat Pesanan Saya</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Tab --}}
    <ul class="nav nav-tabs mb-4">
        @foreach(['Semua','pending','diproses','dikirim','selesai','dibatalkan'] as $tab)
        <li class="nav-item">
            <a class="nav-link {{ request('status', 'Semua') === $tab ? 'active fw-bold' : '' }}"
               href="?status={{ $tab }}">
                {{ ucfirst($tab) }}
            </a>
        </li>
        @endforeach
    </ul>

    @forelse($pesanan as $p)
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Pesanan</span>
                    <h6 class="fw-bold mb-1">#{{ $p->id_pesanan }}</h6>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y') }}</small>
                </div>
                <div class="text-center">
                    @php
                        $warna = match($p->status_pesanan) {
                            'pending'     => 'warning',
                            'diproses'    => 'info',
                            'dikirim'     => 'primary',
                            'selesai'     => 'success',
                            'dibatalkan'  => 'danger',
                            default       => 'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $warna }} px-3 py-2">
                        {{ ucfirst($p->status_pesanan) }}
                    </span>
                </div>
                <div class="text-end">
                    <span class="text-muted small">Total</span>
                    <h6 class="fw-bold text-danger mb-1">
                        Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                    </h6>
                    <a href="/pesanan/{{ $p->id_pesanan }}" class="btn btn-outline-primary btn-sm">
                        Detail →
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <div style="font-size:4rem">📭</div>
        <h5 class="text-muted mt-3">Belum ada pesanan</h5>
        <a href="/katalog" class="btn btn-danger mt-2">Mulai Belanja</a>
    </div>
    @endforelse
</div>
@endsection