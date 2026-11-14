<?php

$driver = getenv('DB_DRIVER') ?: 'mysql';          
$host   = getenv('DB_HOST')   ?: 'localhost';
$port   = getenv('DB_PORT')   ?: ($driver === 'pgsql' ? '5432' : '3306');
$dbname = getenv('DB_NAME')   ?: 'biblio_express';
$user   = getenv('DB_USER')   ?: ($driver === 'pgsql' ? 'postgres' : 'root');
$pass   = getenv('DB_PASS')   ?: 'admin';

$dsn = ($driver === 'pgsql')
    ? "pgsql:host=$host;port=$port;dbname=$dbname"
    : "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    error_log('Error de conexión: ' . $e->getMessage());
    http_response_code(500);
    exit('Error: ' . $e->getMessage());
}