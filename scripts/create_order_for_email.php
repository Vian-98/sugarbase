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

$email = $argv[1] ?? null;
if (!$email) {
    echo "Usage: php scripts/create_order_for_email.php email@example.test\n";
    exit(1);
}

$user = User::where('email', $email)->first();
if (!$user) {
    echo "User with email {$email} not found\n";
    exit(1);
}

$produk = Produk::first();
if (!$produk) {
    echo "No product available\n";
    exit(1);
}

$qty = 1;
$subtotal = $produk->harga * $qty;

$pesanan = Pesanan::create([
    'user_id' => $user->id,
    'tanggal_pesan' => Carbon::now(),
    'total_harga' => $subtotal,
    'status_pesanan' => 'pending',
]);

PesananItem::create([
    'id_pesanan' => $pesanan->id_pesanan,
    'id_produk' => $produk->id_produk,
    'jumlah_pesanan' => $qty,
    'harga_satuan_pesanan' => $produk->harga,
    'subtotal_pesanan' => $subtotal,
]);

$p = Pembayaran::create([
    'id_pesanan' => $pesanan->id_pesanan,
    'metode_pembayaran' => 'transfer',
    'status_pembayaran' => 'menunggu',
    'tanggal_bayar' => Carbon::now(),
    'jumlah_bayar' => $subtotal,
]);

echo "Created order #{$pesanan->id_pesanan} for {$user->email} (pembayaran id_pembayaran={$p->id_pembayaran})\n";
echo "Payment page: /pembayaran/{$pesanan->id_pesanan}\n";
