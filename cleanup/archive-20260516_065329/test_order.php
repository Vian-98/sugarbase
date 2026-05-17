<?php
define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create new orders for today
$today = \Carbon\Carbon::today();

$pesanan1 = new \App\Models\Pesanan();
$pesanan1->user_id = 2;
$pesanan1->tanggal_pesan = $today;
$pesanan1->total_harga = 500000;
$pesanan1->status_pesanan = 'selesai';
$pesanan1->save();

echo "Order 1 created: ID " . $pesanan1->id_pesanan . " - Rp " . number_format($pesanan1->total_harga) . "\n";

$pesanan2 = new \App\Models\Pesanan();
$pesanan2->user_id = 3;
$pesanan2->tanggal_pesan = $today;
$pesanan2->total_harga = 325000;
$pesanan2->status_pesanan = 'selesai';
$pesanan2->save();

echo "Order 2 created: ID " . $pesanan2->id_pesanan . " - Rp " . number_format($pesanan2->total_harga) . "\n";

$revenueToday = \App\Models\Pesanan::whereDate('tanggal_pesan', $today)
    ->where('status_pesanan', '!=', 'dibatalkan')
    ->sum('total_harga');

echo "Total revenue today: Rp " . number_format($revenueToday) . "\n";
?>
