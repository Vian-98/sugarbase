@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width:700px">
    <h2 class="fw-bold mb-4">📋 Konfirmasi Pesanan</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold bg-light">Ringkasan Pesanan</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keranjang->items as $item)
                    <tr>
                        <td>{{ $item->produk->nama_produk }}</td>
                        <td class="text-center">{{ $item->jumlah_keranjang }}</td>
                        <td class="text-end">Rp {{ number_format($item->subtotal_keranjang, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="2">Total</th>
                        <th class="text-end text-danger">
                            Rp {{ number_format($keranjang->items->sum('subtotal_keranjang'), 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <form method="POST" action="/checkout">
        @csrf
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold bg-light">Pilih Metode Pembayaran</div>
            <div class="card-body">
                <div class="form-check p-3 mb-2 border rounded">
                    <input class="form-check-input" type="radio" name="metode"
                           value="transfer" id="transfer" required>
                    <label class="form-check-label ms-2" for="transfer">
                        🏦 <strong>Transfer Bank</strong>
                        <small class="text-muted d-block">Transfer ke rekening BCA/BNI/Mandiri</small>
                    </label>
                </div>
                <div class="form-check p-3 mb-2 border rounded">
                    <input class="form-check-input" type="radio" name="metode"
                           value="cod" id="cod">
                    <label class="form-check-label ms-2" for="cod">
                        🚚 <strong>COD (Bayar di Tempat)</strong>
                        <small class="text-muted d-block">Bayar tunai saat barang tiba</small>
                    </label>
                </div>
                <div class="form-check p-3 border rounded">
                    <input class="form-check-input" type="radio" name="metode"
                           value="ewallet" id="ewallet">
                    <label class="form-check-label ms-2" for="ewallet">
                        📱 <strong>E-Wallet</strong>
                        <small class="text-muted d-block">GoPay, OVO, Dana</small>
                    </label>
                </div>
                @error('metode')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-danger w-100 btn-lg fw-bold">
            ✅ Buat Pesanan
        </button>
    </form>
</div>
@endsection