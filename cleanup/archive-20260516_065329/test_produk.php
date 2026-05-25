<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test creating a product
$produk = new \App\Models\Produk();
$produk->nama_produk = 'Test Donut Coklat Premium';
$produk->harga = 35000;
$produk->stok = 50;
$produk->id_kategori = 1; // Kue & Pastry
$produk->status_produk = 'aktif';
$produk->deskripsi_produk = 'Donut lezat dengan coklat premium dan topping rainbow sprinkles yang warna-warni. Empuk, lembut, dan nikmat dinikmati kapan saja!';
$produk->user_id = 1; // admin user
$produk->foto = null; // No photo
$produk->save();

echo "Product created successfully!" . PHP_EOL;
echo "ID: " . $produk->id_produk . PHP_EOL;
echo "Name: " . $produk->nama_produk . PHP_EOL;
echo "Price: Rp " . number_format($produk->harga, 0, ',', '.') . PHP_EOL;
echo "Category ID: " . $produk->id_kategori . PHP_EOL;

// Verify it exists
$check = \App\Models\Produk::find($produk->id_produk);
echo "\nVerification: " . ($check ? "Product exists in database" : "Product NOT found") . PHP_EOL;
