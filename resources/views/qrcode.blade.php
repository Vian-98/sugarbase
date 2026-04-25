<?php
// Endpoint untuk generate QR code
$url = "http://192.168.2.33:8000";
$qr_api = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - Sugarbase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .qr-box {
            margin: 30px 0;
            padding: 20px;
            background: #f3f4f6;
            border-radius: 10px;
        }
        
        .qr-box img {
            max-width: 300px;
            border-radius: 10px;
        }
        
        .info {
            margin-top: 20px;
            color: #6b7280;
        }
        
        .url {
            font-size: 1.2em;
            font-weight: bold;
            color: #667eea;
            margin: 15px 0;
            font-family: monospace;
        }
        
        .instruction {
            background: #fef3c7;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🍬 Sugarbase QR Code</h1>
        
        <p>Scan QR code di bawah dengan HP untuk akses aplikasi:</p>
        
        <div class="qr-box">
            <img src="<?php echo $qr_api; ?>" alt="QR Code">
        </div>
        
        <div class="url">
            <?php echo $url; ?>
        </div>
        
        <div class="instruction">
            <strong>📱 Cara Akses dari HP:</strong><br>
            1. Scan QR code di atas<br>
            2. Atau ketik langsung: http://192.168.2.33:8000<br>
            3. Pastikan HP connect ke WiFi yang sama
        </div>
        
        <div class="info">
            <p>✓ Server running</p>
            <p>✓ Accessible dari network</p>
            <p>✓ Mobile friendly</p>
        </div>
    </div>
</body>
</html>
