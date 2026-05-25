<?php

// Bootstrap Laravel application
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

// Create a kernel and bootstrap
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Import classes
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

echo "=== Testing Dashboard Revenue Calculation ===\n\n";

// Test 1: Get today's date
$today = Carbon::today();
echo "Today: " . $today->format('Y-m-d') . "\n";

// Test 2: Direct database query
$revenueDbQuery = DB::table('pesanan')
    ->whereDate('tanggal_pesan', $today)
    ->where('status_pesanan', '!=', 'dibatalkan')
    ->sum('total_harga');
echo "DB Query Revenue Today: Rp " . number_format($revenueDbQuery, 0, ',', '.') . "\n";

// Test 3: Using Eloquent
$revenueEloquent = Pesanan::whereDate('tanggal_pesan', $today)
    ->where('status_pesanan', '!=', 'dibatalkan')
    ->sum('total_harga');
echo "Eloquent Revenue Today: Rp " . number_format($revenueEloquent, 0, ',', '.') . "\n";

// Test 4: Check all today's orders
$todaysOrders = Pesanan::whereDate('tanggal_pesan', $today)->get();
echo "\nOrders placed on " . $today->format('Y-m-d') . ":\n";
foreach ($todaysOrders as $order) {
    echo "  - Order #" . str_pad($order->id_pesanan, 5, '0', STR_PAD_LEFT) 
        . " | Total: Rp " . number_format($order->total_harga, 0, ',', '.') 
        . " | Status: " . $order->status_pesanan . "\n";
}

// Test 5: Test the controller method
echo "\n=== Testing DashboardController ===\n";
$controller = new \App\Http\Controllers\DashboardController();

// Use reflection to call the index method and capture the view data
$reflection = new ReflectionClass($controller);
$method = $reflection->getMethod('index');
$method->setAccessible(true);

// Mock request
$fakeRequest = new \Illuminate\Http\Request();

// The index method returns a view, so we need to check what data is passed
// Let's manually calculate what should be passed
$today = Carbon::today();
$revenueToday = Pesanan::whereDate('tanggal_pesan', $today)
    ->where('status_pesanan', '!=', 'dibatalkan')
    ->sum('total_harga');

$totalRevenue = Pesanan::where('status_pesanan', '!=', 'dibatalkan')
    ->sum('total_harga');

echo "Revenue Today (from calculation): Rp " . number_format($revenueToday, 0, ',', '.') . "\n";
echo "Total Revenue (from calculation): Rp " . number_format($totalRevenue, 0, ',', '.') . "\n";

// Test 6: Check view file
$adminDashboardPath = __DIR__ . '/resources/views/admin/dashboard.blade.php';
if (file_exists($adminDashboardPath)) {
    $content = file_get_contents($adminDashboardPath);
    if (strpos($content, '$revenueToday') !== false) {
        echo "\n✓ Admin dashboard view contains \$revenueToday variable\n";
    } else {
        echo "\n✗ Admin dashboard view MISSING \$revenueToday variable\n";
    }
}

echo "\n=== Test Complete ===\n";
