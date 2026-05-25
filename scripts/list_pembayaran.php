<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pembayaran;

$list = Pembayaran::orderBy('id_pembayaran','desc')->take(10)->get(['id_pembayaran','id_pesanan','status_pembayaran','created_at']);
foreach($list as $p){
    echo "id_pembayaran={$p->id_pembayaran} id_pesanan={$p->id_pesanan} status={$p->status_pembayaran} created={$p->created_at}\n";
}
