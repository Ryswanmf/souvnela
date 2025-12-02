<?php
// check_kode_column.php
$host = 'localhost';
$db   = 'souvnela';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Try to read .env (simplified)
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        if (trim($name) == 'database.default.database') $db = trim($value);
    }
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    // Get full column details
    $stmt = $pdo->query("SHOW COLUMNS FROM pesanan LIKE 'kode'");
    $col = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Detail kolom 'kode':\n";
    print_r($col);
} catch (	PDOException $e) {
    echo "Error: " . $e->getMessage();
}

