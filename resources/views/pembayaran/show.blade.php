@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width:600px">
    <h2 class="fw-bold mb-4">💳 Halaman Pembayaran</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm text-center">
        <div class="card-body py-5">
            <p class="text-muted mb-1">Order ID</p>
            <h5 class="fw-bold">#{{ $pembayaran->id_pesanan }}</h5>
            <hr>
            <h4 class="text-danger fw-bold mb-4">
                Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
            </h4>

            @if($pembayaran->metode_pembayaran === 'transfer')
                <div style="font-size:3rem">🏦</div>
                <h5 class="mt-2 fw-bold">Transfer Bank</h5>
                <div class="alert alert-info text-start mt-3">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted">Bank</td><td><strong>BCA</strong></td></tr>
                        <tr><td class="text-muted">No. Rekening</td><td><strong>1234567890</strong></td></tr>
                        <tr><td class="text-muted">Atas Nama</td><td><strong>SugarBase</strong></td></tr>
                        <tr><td class="text-muted">Jumlah</td>
                            <td><strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                </div>
                <p class="text-muted small">Pastikan jumlah transfer tepat sesuai nominal di atas</p>
                <form method="POST" action="/pembayaran/{{ $pembayaran->id_pembayaran }}/konfirmasi">
                    @csrf
                    <button class="btn btn-success px-5 py-2 fw-bold">
                        ✅ Saya Sudah Transfer
                    </button>
                </form>

            @elseif($pembayaran->metode_pembayaran === 'cod')
                <div style="font-size:3rem">🚚</div>
                <h5 class="mt-2 fw-bold">COD — Bayar Saat Barang Tiba</h5>
                <div class="alert alert-warning mt-3">
                    Pesanan kamu sedang diproses.<br>
                    Siapkan uang tunai <strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong>
                    saat kurir tiba.
                </div>
                <a href="/pesanan/saya" class="btn btn-primary px-5 py-2 fw-bold">
                    OK, Mengerti
                </a>

            @else
                <div style="font-size:3rem">📱</div>
                <h5 class="mt-2 fw-bold">E-Wallet</h5>
                <div class="alert alert-info text-start mt-3">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted">Platform</td><td><strong>GoPay / OVO / Dana</strong></td></tr>
                        <tr><td class="text-muted">Nomor</td><td><strong>081234567890</strong></td></tr>
                        <tr><td class="text-muted">Jumlah</td>
                            <td><strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                </div>
                <form method="POST" action="/pembayaran/{{ $pembayaran->id_pembayaran }}/konfirmasi">
                    @csrf
                    <button class="btn btn-success px-5 py-2 fw-bold">
                        ✅ Konfirmasi Pembayaran
                    </button>
                </form>
            @endif
        </div>
    </div>
    <a href="/pesanan/saya" class="btn btn-outline-secondary w-100 mt-3">
        Lihat Riwayat Pesanan
    </a>
</div>
@endsection