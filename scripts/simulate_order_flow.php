<?php
// scripts/simulate_order_flow.php
// Simulate: register user -> create order -> create pembayaran -> admin verify

$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) { echo ".env not found\n"; exit(1); }
$env = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$config = [];
foreach ($env as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (!str_contains($line, '=')) continue;
    list($k, $v) = explode('=', $line, 2);
    $config[trim($k)] = trim($v);
}
$host = $config['DB_HOST'] ?? '127.0.0.1';
$port = $config['DB_PORT'] ?? '3306';
$db   = $config['DB_DATABASE'] ?? '';
$user = $config['DB_USERNAME'] ?? '';
$pass = $config['DB_PASSWORD'] ?? '';
$dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
try { $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]); }
catch (Exception $e) { echo "DB connection failed: " . $e->getMessage() . "\n"; exit(2); }

echo "Connected to DB {$db}\n";

// 1) Register new user
$email = 'simuser+' . time() . '@example.test';
$name = 'Sim User ' . date('His');
$password = password_hash('Secret123!', PASSWORD_BCRYPT);
$role = 'pelanggan';
$now = date('Y-m-d H:i:s');
$sth = $pdo->prepare('INSERT INTO users (name,email,password,role,created_at,updated_at) VALUES (:name,:email,:password,:role,:now,:now)');
$sth->execute([':name'=>$name, ':email'=>$email, ':password'=>$password, ':role'=>$role, ':now'=>$now]);
$userId = $pdo->lastInsertId();
echo "Created user id={$userId}, email={$email}\n";

// 2) Pick a product with stock
$sth = $pdo->query('SELECT id_produk, nama_produk, harga, stok FROM produk WHERE stok > 0 LIMIT 1');
$prod = $sth->fetch(PDO::FETCH_ASSOC);
if (!$prod) { echo "No product with stock available.\n"; exit(0); }
$produkId = $prod['id_produk'];
$harga = (int)$prod['harga'];
$nama = $prod['nama_produk'];
$stok = (int)$prod['stok'];
echo "Using product id={$produkId} name={$nama} stok={$stok} harga={$harga}\n";

// 3) Create pesanan and pesanan_item (simulate checkout)
$qty = min(2, max(1, (int)($stok > 0 ? 1 : 0)));
$subtotal = $harga * $qty;
$total = $subtotal; // no shipping
$sth = $pdo->prepare('INSERT INTO pesanan (user_id,tanggal_pesan,total_harga,status_pesanan) VALUES (:uid,:tgl,:total,:status)');
$sth->execute([':uid'=>$userId, ':tgl'=>$now, ':total'=>$total, ':status'=>'pending']);
$pesananId = $pdo->lastInsertId();
echo "Created pesanan id={$pesananId} total={$total}\n";

$sth = $pdo->prepare('INSERT INTO pesanan_item (id_pesanan,id_produk,jumlah_pesanan,harga_satuan_pesanan,subtotal_pesanan) VALUES (:pid,:prid,:qty,:harga,:sub)');
$sth->execute([':pid'=>$pesananId, ':prid'=>$produkId, ':qty'=>$qty, ':harga'=>$harga, ':sub'=>$subtotal]);
echo "Added pesanan_item: produk={$produkId} qty={$qty} subtotal={$subtotal}\n";

// decrement stock
$sth = $pdo->prepare('UPDATE produk SET stok = stok - :q WHERE id_produk = :pid');
$sth->execute([':q'=>$qty, ':pid'=>$produkId]);
echo "Decremented product stock by {$qty}\n";

$metode = 'ewallet';
$sth = $pdo->prepare('INSERT INTO pembayaran (id_pesanan,metode_pembayaran,status_pembayaran,tanggal_bayar,jumlah_bayar,created_at,updated_at) VALUES (:pid,:metode,:status,:tgl,:jumlah,:now,:now)');
// use allowed enum value 'menunggu' and set tanggal_bayar to now per schema
$sth->execute([':pid'=>$pesananId, ':metode'=>$metode, ':status'=>'menunggu', ':tgl'=>$now, ':jumlah'=>$total, ':now'=>$now]);
$pembayaranId = $pdo->lastInsertId();
echo "Created pembayaran id={$pembayaranId} status=pending amount={$total}\n";

// create notification for user: pesanan dibuat
$sth = $pdo->prepare('INSERT INTO notifikasi (user_id,judul,pesan,waktu_kirim,status_baca,created_at,updated_at) VALUES (:uid,:judul,:pesan,:waktu,:status,:now,:now)');
$sth->execute([':uid'=>$userId, ':judul'=>'Pesanan Berhasil Dibuat', ':pesan'=>"Pesanan #{$pesananId} berhasil dibuat.", ':waktu'=>$now, ':status'=>'belum', ':now'=>$now]);
echo "Notifikasi sent to user {$userId}\n";

// 5) Simulate user performs payment (we already set tanggal_bayar); optionally leave status as 'menunggu'
sleep(1);
$payTgl = date('Y-m-d H:i:s');
$sth = $pdo->prepare('UPDATE pembayaran SET status_pembayaran = :status, tanggal_bayar = :tgl WHERE id_pembayaran = :id');
$sth->execute([':status'=>'menunggu', ':tgl'=>$payTgl, ':id'=>$pembayaranId]);
echo "User performed payment: pembayaran id={$pembayaranId} status=menunggu\n";

// notify admin
$sth = $pdo->prepare('INSERT INTO notifikasi (user_id,judul,pesan,waktu_kirim,status_baca,created_at,updated_at) VALUES (:uid,:judul,:pesan,:waktu,:status,:now,:now)');
// Assuming admin user id = 1 (common), check existence
$adminId = 1;
$check = $pdo->prepare('SELECT id FROM users WHERE id = :id'); $check->execute([':id'=>$adminId]);
if (!$check->fetchColumn()) {
    // pick any admin by role
    $r = $pdo->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1")->fetch(PDO::FETCH_COLUMN);
    if ($r) $adminId = $r;
}
$sth->execute([':uid'=>$adminId, ':judul'=>'Pembayaran Baru', ':pesan'=>"Pembayaran untuk Pesanan #{$pesananId} menunggu verifikasi.", ':waktu'=>$payTgl, ':status'=>'belum', ':now'=>$now]);
echo "Notifikasi sent to admin {$adminId}\n";

// 6) Admin verifies payment -> set pembayaran.status_pembayaran = 'lunas' and pesanan.status_pesanan = 'diproses'
$sth = $pdo->prepare('UPDATE pembayaran SET status_pembayaran = :status WHERE id_pembayaran = :id');
$sth->execute([':status'=>'lunas', ':id'=>$pembayaranId]);
$sth = $pdo->prepare('UPDATE pesanan SET status_pesanan = :s WHERE id_pesanan = :id');
$sth->execute([':s'=>'diproses', ':id'=>$pesananId]);
echo "Admin verified pembayaran id={$pembayaranId} and pesanan id={$pesananId} set to diproses\n";

// notify user about confirmation
$sth = $pdo->prepare('INSERT INTO notifikasi (user_id,judul,pesan,waktu_kirim,status_baca,created_at,updated_at) VALUES (:uid,:judul,:pesan,:waktu,:status,:now,:now)');
$now2 = date('Y-m-d H:i:s');
$sth->execute([':uid'=>$userId, ':judul'=>'Pembayaran Dikonfirmasi', ':pesan'=>"Pembayaran pesanan #{$pesananId} telah dikonfirmasi.", ':waktu'=>$now2, ':status'=>'belum', ':now'=>$now2]);
echo "Notifikasi konfirmasi dikirim ke user {$userId}\n";

// final state check
$sth = $pdo->prepare('SELECT status_pesanan FROM pesanan WHERE id_pesanan = :id'); $sth->execute([':id'=>$pesananId]);
$ps = $sth->fetchColumn();
echo "Final pesanan status: {$ps}\n";

echo "Simulation complete.\n";
