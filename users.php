<?php
require 'middleware.php';
require 'database.php';


$sql = 'SELECT userId, email, fullName, birthDate, isAdmin FROM users';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();


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
    <title>Users list</title>
</head>
<body>
<?php require 'header.php'; ?>
<main class="px-24 py-10 flex justify-center items-center">
    <table>
        <tr class="*:px-3 *:py-2 *:border bg-blue-100 border-black">
            <th>User ID</th>
            <th>Email</th>
            <th>Full name</th>
            <th>Birth date</th>
            <th>Admin</th>
            <th colspan="3">Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr class="*:px-4 *:py-6 *:border *:text-center">
                <td><?= $user['userId'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['fullName'] ?></td>
                <td><?= $user['birthDate'] ?></td>
                <td>
                    <?= $user['isAdmin'] === 1 ? 'Yes' : 'No' ?>
                </td>
                <td>
                    <a href="#" class="block w-[100px] text-center py-2 text-sm border-2 rounded">
                        <?= $user['isAdmin'] === 1 ? 'Unmake admin' : 'Make admin' ?>
                    </a>
                </td>
                <td>
                    <a href="#" class="text-amber-500 border-amber-500 px-3 py-2 border-2 rounded">
                        <i class="fa fa-pencil"></i>
                    </a>
                </td>
                <td>
                    <a href="#" class="text-red-500 border-red-500 px-3 py-2 border-2 rounded">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</main>
</body>
</html>
