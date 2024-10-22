<?php
session_start();

if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 0) {
    header('Location: index.php');
    die();
}
