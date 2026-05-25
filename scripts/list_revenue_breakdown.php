<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pesanan;
use App\Models\User;
use Carbon\Carbon;

echo "Revenue breakdown\n";

$today = Carbon::today();
echo "\n-- Revenue Today (".$today->toDateString().") --\n";
$todayOrders = Pesanan::whereDate('tanggal_pesan', $today)
    ->where('status_pesanan', '!=', 'dibatalkan')
    ->with('user')
    ->get();
$sumToday = $todayOrders->sum('total_harga');
echo "Total Today: Rp " . number_format($sumToday,0,',','.') . "\n";
foreach($todayOrders as $o){
    $user = $o->user ? $o->user->email : 'guest';
    echo "#{$o->id_pesanan} | {$o->tanggal_pesan} | {$user} | Rp " . number_format($o->total_harga,0,',','.') . " | {$o->status_pesanan}\n";
}

echo "\n-- All Revenue (status != dibatalkan) --\n";
$orders = Pesanan::where('status_pesanan','!=','dibatalkan')->with('user')->orderBy('tanggal_pesan','desc')->get();
$sumAll = $orders->sum('total_harga');
echo "Total Revenue: Rp " . number_format($sumAll,0,',','.') . "\n";
foreach($orders as $o){
    $user = $o->user ? $o->user->email : 'guest';
    echo "#{$o->id_pesanan} | {$o->tanggal_pesan} | {$user} | Rp " . number_format($o->total_harga,0,',','.') . " | {$o->status_pesanan}\n";
}
