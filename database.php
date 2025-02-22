<?php


$host = 'localhost';
$port = 3306;
$dbName = 'cars';
$username = 'root';
$password = 'root';


$dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8";


try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
