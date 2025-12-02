<?php
// check_db.php

// Database configuration (adjust based on your .env or assumption)
$host = 'localhost';
$db   = 'souvnela'; // Assumption based on project name, will try standard
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Try to read .env for real credentials
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if ($name == 'database.default.database') $db = $value;
        if ($name == 'database.default.username') $user = $value;
        if ($name == 'database.default.password') $pass = $value;
    }
}

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Check count
    $stmt = $pdo->query("SELECT COUNT(*) FROM produk WHERE is_unggulan = 1");
    $count = $stmt->fetchColumn();
    
    echo "Total Produk Unggulan saat ini: " . $count . "\n";
    
    if ($count == 0) {
        echo "Memperbaiki: Mengatur 6 produk terbaru menjadi unggulan...\n";
        $stmt = $pdo->query("UPDATE produk SET is_unggulan = 1 ORDER BY id DESC LIMIT 6");
        echo "Berhasil diupdate.\n";
    }

} catch (	PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}

