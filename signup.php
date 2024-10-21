<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['do_signup'])) {
    print_r($_POST);

    $email = $_POST['login'];
    $password = $_POST['password'];
    $fullName = $_POST['fullName'];
    $birthDate = $_POST['birthDate'];

    require 'database.php';

    $sql = 'INSERT INTO users (email, hashedPassword, fullName, birthDate) VALUES(:email, :hashedPassword, :fullName, :birthDate)';
    $stmt = $pdo->prepare($sql);
    $params = [
        'email' => $email,
        'hashedPassword' => hash('sha256', $password),
        'fullName' => $fullName,
        'birthDate' => $birthDate

    ];
    $stmt->execute($params);
    header('Location: auth.php');
    exit;

}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type='image/png' href="/public/logo.png">
</head>
<body>
<?php require('header.php'); ?>

<main class="px-24 py-10 flex justify-center items-center">
    <form method="POST" class="px-8 py-10 rounded border-2 border-slate-300 w-[500px] flex flex-col gap-4" action="">
        <h2 class="text-3xl font-semibold text-blue-500 my-4 text-center">Nice to meet you!</h2>
        <div class="flex items-center gap-2">
            <p class="font-bold w-1/4">Email: </p>
            <input class="w-3/4 rounded-sm border" type="email" name="login" id="login">
        </div>
        <div class="flex items-center gap-2">
            <p class="font-bold w-1/4">Full name: </p>
            <input class="w-3/4 rounded-sm border" type="text" name="fullName" id="fullName">
        </div>
        <div class="flex items-center gap-2">
            <p class="font-bold w-1/4">Date of birth: </p>
            <input class="w-3/4 rounded-sm border" type="date" name="birthDate" id="birthDate">
        </div>
        <div class="flex items-center gap-2">
            <p class="font-bold w-1/4">Password:</p>
            <input class="w-3/4 rounded-sm border" type="password" name="password" id="password">
        </div>
        <div class="flex items-center gap-2">
            <p class="font-bold w-1/4">Confirm password:</p>
            <input class="w-3/4 rounded-sm border" type="password" name="password_confirm" id="password_confirm">
        </div>

        <input class="rounded bg-blue-500 text-white rounded py-2 mt-4 cursor-pointer" type="submit" value="Sign up"
               name="do_signup">
        <p>
            Already have an account? <a class="ml-2 text-blue-400 font-semibold underline" href="auth.php">Sign in</a>
        </p>
    </form>

</main>
</body>
</html>