<?php
// scripts/verify_riwayat_notif.php
// Quick DB check: verifies pesanan items+produk for a sample user and per-user notifications.

$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    echo ".env not found\n";
    exit(1);
}
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

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo "DB connection failed: " . $e->getMessage() . "\n";
    exit(2);
}

echo "Connected to DB {$db} at {$host}:{$port}\n";

// pick a sample user
$stmt = $pdo->query('SELECT id FROM users ORDER BY id LIMIT 2');
$users = $stmt->fetchAll(PDO::FETCH_COLUMN);
if (empty($users)) {
    echo "No users found in users table.\n";
    exit(0);
}
$u1 = $users[0];
$u2 = $users[1] ?? null;

echo "Sample user id: {$u1}" . ($u2 ? ", another user id: {$u2}" : "") . "\n";

// overall counts
$stmt = $pdo->query('SELECT COUNT(*) FROM pesanan');
$totalPesanan = $stmt->fetchColumn();
$stmt = $pdo->query('SELECT COUNT(*) FROM pesanan_item');
$totalItems = $stmt->fetchColumn();
echo "Total pesanan in DB: {$totalPesanan}, total pesanan_item: {$totalItems}\n";

// fetch pesanan for user
$sql = "SELECT p.* FROM pesanan p WHERE p.user_id = :uid ORDER BY p.tanggal_pesan DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':uid'=>$u1]);
$pesanan = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Pesanan count for user {$u1}: " . count($pesanan) . "\n";
if (count($pesanan) > 0) {
    // fetch items for the latest pesanan
    $pid = $pesanan[0]['id_pesanan'];
    echo "Latest pesanan id: {$pid}\n";
    $sql = "SELECT pi.*, pr.nama_produk, pr.foto FROM pesanan_item pi LEFT JOIN produk pr ON pi.id_produk = pr.id_produk WHERE pi.id_pesanan = :pid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':pid'=>$pid]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Items count in latest pesanan: " . count($items) . "\n";
    foreach ($items as $it) {
        echo " - produk id: ".($it['id_produk'] ?? 'NULL') . ", nama: " . ($it['nama_produk'] ?? '[deleted]') . ", foto: " . ($it['foto'] ?? 'NULL') . ", jumlah: " . ($it['jumlah_pesanan'] ?? '?') . "\n";
    }
} else {
    echo "No pesanan for this user.\n";
}

// check notifikasi scope
$stmt = $pdo->prepare('SELECT COUNT(*) FROM notifikasi WHERE user_id = :uid');
$stmt->execute([':uid'=>$u1]);
$cnt1 = $stmt->fetchColumn();
echo "Notifikasi count for user {$u1}: {$cnt1}\n";

if ($u2) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM notifikasi WHERE user_id = :uid');
    $stmt->execute([':uid'=>$u2]);
    $cnt2 = $stmt->fetchColumn();
    echo "Notifikasi count for user {$u2}: {$cnt2}\n";
    if ($cnt1 == 0 && $cnt2 > 0) {
        echo "Note: first user has no notifications but another user does.\n";
    }
}

// show unread notifications for user
$stmt = $pdo->prepare("SELECT id_notifikasi, judul, pesan, status_baca, waktu_kirim FROM notifikasi WHERE user_id = :uid ORDER BY waktu_kirim DESC LIMIT 10");
$stmt->execute([':uid'=>$u1]);
$notifs = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($notifs)) {
    echo "No notification rows to show for user {$u1}.\n";
} else {
    echo "Latest notifications for user {$u1}:\n";
    foreach ($notifs as $n) {
        echo " - [{$n['status_baca']}] {$n['judul']} @ {$n['waktu_kirim']}\n";
    }
}

// show sample pesanan_item rows and their pesanan owner
$stmt = $pdo->query('SELECT pi.id_pesanan, pi.id_produk, pi.jumlah_pesanan, pr.nama_produk, p.user_id FROM pesanan_item pi LEFT JOIN produk pr ON pi.id_produk = pr.id_produk LEFT JOIN pesanan p ON pi.id_pesanan = p.id_pesanan LIMIT 10');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "\nSample pesanan_item rows (up to 10):\n";
if (empty($rows)) {
    echo " - none\n";
} else {
    foreach ($rows as $r) {
        echo " - id_pesanan: {$r['id_pesanan']}, user_id: " . ($r['user_id'] ?? 'NULL') . ", id_produk: " . ($r['id_produk'] ?? 'NULL') . ", nama: " . ($r['nama_produk'] ?? '[deleted]') . ", jumlah: " . ($r['jumlah_pesanan'] ?? '?') . "\n";
    }
}

// if we found any sample rows, inspect notifications for the owner user
if (!empty($rows)) {
    $owner = $rows[0]['user_id'];
    if ($owner) {
        // print owner user info
        $stmt = $pdo->prepare('SELECT id, name, email FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([':id'=>$owner]);
        $uinfo = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($uinfo) {
            echo "\nOwner user info: id={$uinfo['id']}, name={$uinfo['name']}, email={$uinfo['email']}\n";
        }

        $stmt = $pdo->prepare('SELECT id_notifikasi, judul, status_baca, waktu_kirim FROM notifikasi WHERE user_id = :uid ORDER BY waktu_kirim DESC LIMIT 10');
        $stmt->execute([':uid'=>$owner]);
        $n = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "\nNotifications for owner user {$owner}: " . count($n) . "\n";
        foreach ($n as $row) {
            echo " - [{$row['status_baca']}] {$row['judul']} @ {$row['waktu_kirim']} (id: {$row['id_notifikasi']})\n";
        }
    }
}

exit(0);
