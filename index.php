<?php
session_start();
require 'database.php';

$stmt = $pdo->prepare('SELECT * FROM cars WHERE isFree = 1 ORDER BY id DESC');

$stmt->execute();
$cars = $stmt->fetchAll();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentaCar - Rent your dream car with easy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type='image/png' href="/public/logo.png">

</head>

<body>
<?php require 'header.php' ?>
<div class="bg-[url('https://images.unsplash.com/photo-1493238792000-8113da705763?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] relative h-72 w-full bg-center flex justify-center items-center">
    <h1 class="text-white text-center text-5xl font-semibold absolute top-0 bottom-0 right-0 left-0 backdrop-blur-md flex items-center justify-center">
        Let your dreams come true with <span class="text-blue-500">
                &nbsp; Renta Car
            </span>.</h1>
</div>
<h2 class="text-center py-6 text-3xl font-semibold text-blue-500 uppercase">Available cars </h2>
<p class="text-center">
    <strong> <?= count($cars) ?> </strong> cars found.
</p>
<div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 px-4 py-6 ">
    <?php foreach ($cars as $car) : ?>
        <div class="shadow-xl rounded-lg px-4 py-2  flex gap-4 border-2 border-blue-500">
            <div class="w-1/3 flex items-center justify-center">
                <img src="/public/svgs/<?= str_replace('-', ' ', strtolower($car['brand'])) . '.svg' ?>"
                     alt="<?= $car['brand'] ?>" class="w-16 h-16">
            </div>
            <div class="flex flex-col justify-between ">
                <p class="font-bold text-xl text-blue-500"><?= $car['brand'] . ' ' . $car['model'] . ' ' . $car['year'] ?></p>
                <p>
                    <span class="font-bold">Engine volume:</span> <?= $car['volume'] != 0 ? $car['volume'] . ' l' : '-' ?>
                </p>
                <p><span class="font-bold">Fuel:</span> <?= $car['fuel'] ?></p>
                <p><span class="font-bold">Price per day:</span> $<?= $car['price'] ?></p>

                <a class="mt-6 block w-[200px] text-center bg-blue-500 rounded-lg text-sm text-white px-2 py-2 border-2 border-blue-500 hover:bg-white hover:text-blue-500"
                   href="car.php?id=<?= $car['id'] ?>">Details</a>


            </div>

        </div>
    <?php endforeach ?>
</div>

</body>

</html>