<?php
// check_reviews.php
$host = 'localhost';
$db   = 'souvnela';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

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
    $stmt = $pdo->query("DESCRIBE reviews");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    print_r($columns);
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();
}
