<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
$rows = DB::select('SELECT id_produk, foto FROM produk LIMIT 10');
foreach ($rows as $r) {
    echo $r->id_produk . " => " . ($r->foto ?? '(null)') . PHP_EOL;
}
