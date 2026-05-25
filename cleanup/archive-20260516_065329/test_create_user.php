<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$user = User::create([
    'name' => 'Test User',
    'email' => 'test@test.com',
    'password' => 'password123',
    'role' => 'pelanggan'
]);

echo "User created: " . $user->email . "\n";
