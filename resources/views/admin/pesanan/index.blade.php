@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">📋 Manajemen Pesanan</h2>

    {{-- Revenue Hari Ini --}}
    <div class="card bg-danger text-white mb-4" style="max-width:300px">
        <div class="card-body">
            <p class="mb-1 small opacity-75">Revenue Hari Ini</p>
            <h4 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
        </div>
    </div>

    {{-- Filter --}}
    <ul class="nav nav-tabs mb-4">
        @foreach(['Semua','pending','diproses','dikirim','selesai','dibatalkan'] as $tab)
        <li class="nav-item">
            <a class="nav-link {{ request('status', 'Semua') === $tab ? 'active fw-bold' : '' }}"
               href="?status={{ $tab }}">{{ ucfirst($tab) }}</a>
        </li>
        @endforeach
    </ul>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status Bayar</th>
                        <th>Status Pesanan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                    <tr>
                        <td><strong>#{{ $p->id_pesanan }}</strong></td>
                        <td>{{ $p->user->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y') }}</td>
                        <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($p->pembayaran->metode_pembayaran ?? '-') }}</td>
                        <td>
                            @php $sp = $p->pembayaran->status_pembayaran ?? 'menunggu' @endphp
                            <span class="badge bg-{{ $sp === 'lunas' ? 'success' : ($sp === 'gagal' ? 'danger' : 'warning') }}">
                                {{ ucfirst($sp) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $warna = match($p->status_pesanan) {
                                    'pending'    => 'warning',
                                    'diproses'   => 'info',
                                    'dikirim'    => 'primary',
                                    'selesai'    => 'success',
                                    'dibatalkan' => 'danger',
                                    default      => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $warna }}">{{ ucfirst($p->status_pesanan) }}</span>
                        </td>
                        <td class="text-center">
                            <form method="POST" action="/admin/pesanan/{{ $p->id_pesanan }}/status"
                                  class="d-flex gap-1 justify-content-center">
                                @csrf
                                <select name="status" class="form-select form-select-sm" style="width:130px">
                                    @foreach(['pending','diproses','dikirim','selesai','dibatalkan'] as $s)
                                    <option value="{{ $s }}" {{ $p->status_pesanan === $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection