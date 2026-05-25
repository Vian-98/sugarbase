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
use App\Models\Notifikasi;
use Carbon\Carbon;

$report = [];
$timestamp = Carbon::now()->format('Ymd_His');
$outPath = __DIR__ . "/reports/verification_{$timestamp}.txt";
@mkdir(dirname($outPath), 0755, true);

$users = User::where('role','!=','admin')->get();
$produk = Produk::first();
if (!$produk) {
    echo "No product available to create orders.\n";
    exit(1);
}

foreach($users as $user){
    $entry = ['user_id'=>$user->id, 'email'=>$user->email, 'steps'=>[]];
    try{
        // 1) Update profile fields
        $phone = '0812' . rand(1000000,9999999);
        $alamat = 'Auto Test Addr '.substr(md5($user->email),0,6);
        $user->phone = $phone;
        $user->alamat = $alamat;
        $user->save();
        $entry['steps'][] = "profile_updated: phone={$phone} alamat={$alamat}";

        // verify persisted
        $reloaded = User::find($user->id);
        if ($reloaded->phone !== $phone || $reloaded->alamat !== $alamat) {
            $entry['steps'][] = 'profile_verify_failed';
        } else {
            $entry['steps'][] = 'profile_verify_ok';
        }

        // 2) Create order
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
        $entry['steps'][] = "order_created: #{$pesanan->id_pesanan} pembayaran={$p->id_pembayaran}";

        // verify order existence
        $found = Pesanan::where('id_pesanan', $pesanan->id_pesanan)->with('pembayaran','items')->first();
        if (!$found) {
            $entry['steps'][] = 'order_verify_failed';
        } else {
            $entry['steps'][] = 'order_verify_ok';
        }

        // 3) Create notification
        $notif = Notifikasi::create([
            'user_id' => $user->id,
            'judul' => 'Test Notification',
            'pesan' => 'This is an automated test notification for '.$user->email,
            'waktu_kirim' => Carbon::now(),
            'status_baca' => 'belum',
        ]);
        $entry['steps'][] = 'notification_created';

        // verify unread count
        $unread = Notifikasi::where('user_id',$user->id)->where('status_baca','belum')->count();
        $entry['steps'][] = "unread_count={$unread}";

    } catch (\Exception $e) {
        $entry['error'] = $e->getMessage();
    }
    $report[] = $entry;
}

$out = "Verification Report - " . Carbon::now()->toDateTimeString() . "\n\n";
foreach($report as $r){
    $out .= "User {$r['email']} (id={$r['user_id']}):\n";
    if (isset($r['error'])) {
        $out .= "  ERROR: {$r['error']}\n";
        continue;
    }
    foreach($r['steps'] as $s) $out .= "  - {$s}\n";
    $out .= "\n";
}

file_put_contents($outPath, $out);
echo $out;
echo "Report saved to: {$outPath}\n";
