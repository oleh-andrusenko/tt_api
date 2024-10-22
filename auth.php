<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['do_signin'])) {


    $email = $_POST['login'];
    $password = $_POST['password'];


    require 'database.php';

    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $params = [
        'email' => $email
    ];
    $stmt->execute($params);
    $user = $stmt->fetch();

    if (hash_equals($user['hashedPassword'], hash('sha256', $password))) {

        $_SESSION['email'] = $user['email'];
        $_SESSION['fullName'] = $user['fullName'];
        $_SESSION['isAdmin'] = $user['isAdmin'];
        $_SESSION['userId'] = $user['userId'];
        header('Location: index.php');
        exit();
    } else echo 'PASSWORD WRONG';



//    exit;

}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auth page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type='image/png' href="/public/logo.png">
</head>
<body>
<?php require('header.php'); ?>

<main class="px-24 py-10 flex justify-center items-center">
    <form class="px-8 py-10 rounded border-2 border-slate-300 w-[500px] flex flex-col gap-4" action="" method="POST">
        <h2 class="text-3xl font-semibold text-blue-500 my-4 text-center">Welcome back to RentaCar</h2>
        <div class="flex items-center gap-2">
            <p class="font-bold w-1/4">Login: </p>
            <input class="w-3/4 rounded-sm border" type="text" name="login" id="login">
        </div>
        <div class="flex items-center gap-2">
            <p class="font-bold w-1/4">Password:</p>
            <input class="w-3/4 rounded-sm border" type="password" name="password" id="password">
        </div>
        <input class="rounded bg-blue-500 text-white rounded py-2 mt-4 cursor-pointer" type="submit" value="Login"
               name="do_signin">
        <p>
            Doesn`t have an account yet? <a class="ml-2 text-blue-400 font-semibold underline" href="signup.php">Register
                now</a>
        </p>

    </form>

</main>
</body>
</html>