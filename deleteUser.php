<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    require 'database.php';

    $stmt = $pdo->prepare('DELETE FROM users WHERE userId = :id');
    $stmt->execute([
        'id' => $userId
    ]);
    header('Location: index.php');
    $_SESSION = [];
    die();

}