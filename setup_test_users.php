<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admin = \App\Models\User::where('role', 'admin')->first();
if(!$admin){ 
    $admin = \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@sugarbase.com', 'password' => bcrypt('password'), 'role' => 'admin', 'phone' => '08123456789', 'alamat' => 'Kantor Admin']); 
} else { 
    $admin->password = bcrypt('password'); 
    $admin->save(); 
}
echo 'Admin: ' . $admin->email . PHP_EOL;

$customer = \App\Models\User::where('role', '!=', 'admin')->first();
if(!$customer){ 
    $customer = \App\Models\User::create(['name' => 'Pelanggan', 'email' => 'pelanggan@sugarbase.com', 'password' => bcrypt('password'), 'role' => 'pelanggan', 'phone' => '08123456780', 'alamat' => 'Rumah Pelanggan']); 
} else { 
    $customer->password = bcrypt('password'); 
    $customer->save(); 
}
echo 'Customer: ' . $customer->email . PHP_EOL;
