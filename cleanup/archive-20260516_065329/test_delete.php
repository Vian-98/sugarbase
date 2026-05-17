<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$prod = \App\Models\Produk::find(25);
if ($prod) {
    echo "Product still exists: ID " . $prod->id_produk . " - " . $prod->nama_produk . PHP_EOL;
} else {
    echo "Product deleted successfully" . PHP_EOL;
}

// Also check total product count
$count = \App\Models\Produk::count();
echo "Total products in database: " . $count . PHP_EOL;
