<?php
require 'middleware.php';
$id = $_GET["id"];

if (!$id) {
    header("location:index.php");
    exit();
} else {
    require 'database.php';

    $sql = 'UPDATE cars SET isFree = 1 WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $params = [
        "id" => $id
    ];
    $stmt->execute($params);

    $sql = 'UPDATE rent SET isEnd = 1 WHERE car_id = :id';
    $stmt = $pdo->prepare($sql);
    $params = [
        "id" => $id
    ];
    $stmt->execute($params);

    header("Location: rented.php");
    exit();
}