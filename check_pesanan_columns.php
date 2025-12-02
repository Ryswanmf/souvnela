<?php
// check_pesanan_columns.php

$host = 'localhost';
$db   = 'souvnela'; // Adjust if needed
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Try to read .env
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

try {
    $pdo = new PDO($dsn, $user, $pass);
    $stmt = $pdo->query("DESCRIBE pesanan");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Kolom pada tabel 'pesanan':\n";
    print_r($columns);
} catch (	PDOException $e) {
    echo "Error: " . $e->getMessage();
}

