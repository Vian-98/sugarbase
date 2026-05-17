<?php
require __DIR__ . '/../vendor/autoload.php';
// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pembayaran;

$id = $argv[1] ?? 0;
if (!$id) {
    echo "Usage: php scripts/confirm_payment.php {pembayaran_id}\n";
    exit(1);
}

$p = Pembayaran::find($id);
if (!$p) {
    echo "Pembayaran $id not found\n";
    exit(1);
}

$p->status_pembayaran = 'lunas';
$p->tanggal_bayar = now();
$p->save();

// update pesanan status (use correct column name)
if ($p->pesanan) {
    $p->pesanan->status_pesanan = 'diproses';
    $p->pesanan->save();
}

echo "Pembayaran {$id} marked as lunas and pesanan updated.\n";
