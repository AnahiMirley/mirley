<?php
$host = getenv('MYSQL_ADDON_HOST') ?: 'bezlktac0dqtgfodm9sj-mysql.services.clever-cloud.com';
$usuario = getenv('MYSQL_ADDON_USER') ?: 'ufbgxczlgbzc9rui';
$password = getenv('MYSQL_ADDON_PASSWORD') ?: 'XUIDZBMzEsRwI4kIw4cW';
$base_datos = getenv('MYSQL_ADDON_DB') ?: 'bezlktac0dqtgfodm9sj';
$puerto = getenv('MYSQL_ADDON_PORT') ?: 3306;

try {
    $dsn = "mysql:host=$host;port=$puerto;dbname=$base_datos;charset=utf8mb4";
    $pdo = new PDO($dsn, $usuario, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>