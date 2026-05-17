@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')

<section>
    <div style="display:flex;flex-direction:column;gap:18px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <h1 style="font-size:1.4em;margin:0;">Riwayat Pesanan</h1>
            <a href="/katalog" style="background:var(--primary);color:white;padding:10px 14px;border-radius:8px;text-decoration:none;">🛒 Mulai Belanja</a>
        </div>

        @if($pesanan->isEmpty())
            <div style="background:white;padding:20px;border-radius:12px;border:1px solid var(--border);">
                <p style="margin:0;color:#6b7280;">Belum ada pesanan. Coba jelajahi katalog dan pesan produk favoritmu.</p>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach($pesanan as $p)
                <div style="background:white;padding:14px;border-radius:12px;border:1px solid var(--border);box-shadow:0 8px 20px rgba(102,126,234,0.04);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                        <div>
                            <div style="font-weight:700">Pesanan #{{ $p->id_pesanan }}</div>
                            <div style="color:#6b7280;font-size:0.9em">{{ optional($p->tanggal_pesan)->format('d M Y H:i') }}</div>
                        </div>
                        <div style="text-align:right">
                            <div style="font-weight:800;color:var(--primary)">{{ number_format($p->total_harga,0,',','.') }}</div>
                            <div style="font-size:0.9em;color:#6b7280">{{ ucfirst($p->status_pesanan) }}</div>
                        </div>
                    </div>

                    <div style="border-top:1px dashed var(--border);padding-top:12px;display:flex;flex-direction:column;gap:10px;">
                        @foreach($p->items as $it)
                        <div style="display:flex;gap:12px;align-items:center;">
                            @if(!empty($it->produk->foto))
                                <img src="{{ asset('storage/' . $it->produk->foto) }}" alt="{{ $it->produk->nama_produk ?? 'Produk' }}" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
                            @else
                                <div style="width:64px;height:64px;border-radius:8px;background:var(--light);display:flex;align-items:center;justify-content:center;">🍰</div>
                            @endif
                            <div style="flex:1;">
                                <div style="font-weight:700">{{ $it->produk->nama_produk ?? 'Produk terhapus' }}</div>
                                <div style="color:#6b7280;font-size:0.95em">{{ $it->jumlah_pesanan }} × {{ number_format($it->harga_satuan_pesanan,0,',','.') }} = <strong>{{ number_format($it->subtotal_pesanan ?? ($it->jumlah_pesanan * $it->harga_satuan_pesanan),0,',','.') }}</strong></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
