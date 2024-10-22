<?php
session_start();
require('database.php');

$id = $_GET['id'];
if (!$id) {
    header('Location: index.php');
    exit;
}

$sql = "SELECT userId, email, fullName, birthDate, isAdmin FROM users WHERE userId = :id";
$stmt = $pdo->prepare($sql);
$params = [
        'id' => $id
];
$stmt->execute($params);
$user = $stmt->fetch();

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type='image/png' href="/public/logo.png">
    <title>Profile</title>
</head>
<body>
<?php require 'header.php'; ?>

<main class="px-24 py-10 flex items-center justify-center">
    <div class="w-[500px] px-6 py-8 border-slate-300 border-2 rounded">
        <h2 class="text-3xl font-semibold text-center text-blue-500 mb-8">Your profile info</h2>
        <?php foreach($user as $key=>$value): ?>

            <div class="flex items-center justify-between gap-8 border-b">
                <p class="font-semibold py-2 uppercase"><?=$key?></p>
                <p><?=$value?></p>
            </div>
        <?php endforeach;?>
        <form action="deleteUser.php" method="post" class="mt-10">
            <input type="hidden" name="userId" value="<?=$user['userId']?>">
            <input class="w-full bg-red-500 text-white font-semibold px-2 py-1 text-center rounded border-2 border-red-600 cursor-pointer" type="submit" value="Delete account">
        </form>
    </div>
</main>


</body>
</html>
