<?php
$host     = getenv('DB_HOST');
$db_name  = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$port     = getenv('DB_PORT');

try {
    // Cambiato da mysql: a pgsql:
    $dsn = "pgsql:host=$host;port=$port;dbname=$db_name";
    $conn = new PDO($dsn, $username, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch(PDOException $e) {
    echo json_encode(["message" => "Connection error: ".$e->getMessage()]);
    exit;
}
?>