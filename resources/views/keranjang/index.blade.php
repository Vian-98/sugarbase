@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">🛒 Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(!$keranjang || $keranjang->items->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:5rem">🛒</div>
            <h4 class="mt-3 text-muted">Keranjang kamu masih kosong</h4>
            <a href="/katalog" class="btn btn-danger mt-3 px-4">Belanja Sekarang</a>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>Nama Produk</th>
                            <th>Harga Satuan</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keranjang->items as $item)
                        <tr>
                            <td width="80">
                                @if($item->produk->foto)
                                    <img src="{{ asset('storage/'.$item->produk->foto) }}"
                                         width="60" height="60"
                                         class="rounded" style="object-fit:cover">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center
                                                justify-content-center" style="width:60px;height:60px;font-size:1.8rem">
                                        🍰
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $item->produk->nama_produk }}</td>
                            <td>Rp {{ number_format($item->harga_satuan_keranjang, 0, ',', '.') }}</td>
                            <td width="180">
                                <form method="POST" action="/keranjang/update/{{ $item->id }}">
                                    @csrf
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="let i=this.nextElementSibling; if(i.value>1){i.value--;i.closest('form').submit()}">−</button>
                                        <input type="number" name="jumlah"
                                               value="{{ $item->jumlah_keranjang }}"
                                               min="1" max="{{ $item->produk->stok }}"
                                               class="form-control form-control-sm text-center"
                                               style="width:55px"
                                               onchange="this.closest('form').submit()">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="let i=this.previousElementSibling; if(i.value<{{ $item->produk->stok }}){i.value++;i.closest('form').submit()}">+</button>
                                    </div>
                                </form>
                            </td>
                            <td class="text-end fw-semibold">
                                Rp {{ number_format($item->subtotal_keranjang, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <form method="POST" action="/keranjang/hapus/{{ $item->id }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Hapus item ini?')">🗑</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center py-3">
                <div>
                    <span class="text-muted">Total Belanja:</span>
                    <span class="fs-4 fw-bold text-danger ms-2">
                        Rp {{ number_format($keranjang->items->sum('subtotal_keranjang'), 0, ',', '.') }}
                    </span>
                </div>
                <a href="/checkout" class="btn btn-danger btn-lg px-4">
                    Lanjut ke Pembayaran →
                </a>
            </div>
        </div>
    @endif
</div>
@endsection