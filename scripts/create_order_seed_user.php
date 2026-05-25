<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Pembayaran;
use Carbon\Carbon;

// find a seeded non-admin user
$user = User::where('role','!=','admin')->first();
if (!$user) {
    echo "No seeded non-admin user found\n";
    exit(1);
}

// choose a product (id 1 fallback)
$produk = Produk::first() ?? Produk::find(1);
if (!$produk) {
    echo "No product found\n";
    exit(1);
}

$qty = 1;
$subtotal = $produk->harga * $qty;

// create pesanan
$pesanan = Pesanan::create([
    'user_id' => $user->id,
    'tanggal_pesan' => Carbon::now(),
    'total_harga' => $subtotal,
    'status_pesanan' => 'pending',
]);

// create item
PesananItem::create([
    'id_pesanan' => $pesanan->id_pesanan,
    'id_produk' => $produk->id_produk,
    'jumlah_pesanan' => $qty,
    'harga_satuan_pesanan' => $produk->harga,
    'subtotal_pesanan' => $subtotal,
]);

// create pembayaran (tanggal_bayar required by schema; set to now())
$p = Pembayaran::create([
    'id_pesanan' => $pesanan->id_pesanan,
    'metode_pembayaran' => 'transfer',
    'status_pembayaran' => 'menunggu',
    'tanggal_bayar' => Carbon::now(),
    'jumlah_bayar' => $subtotal,
]);

echo "Created order #{$pesanan->id_pesanan} for user {$user->email} (product {$produk->nama_produk})\n";
echo "Pembayaran id_pembayaran={$p->id_pembayaran} status={$p->status_pembayaran}\n";
echo "Payment page: /pembayaran/{$pesanan->id_pesanan}\n";
