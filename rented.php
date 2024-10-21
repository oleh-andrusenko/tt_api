<?php
require 'middleware.php';

require 'database.php';


$stmt = $pdo->prepare('select 
users.userId, users.email, users.fullName, users.birthDate, rent.car_id,   
  cars.brand, cars.model, cars.year, cars.volume, cars.fuel, cars.price,  rent.startDate, rent.endDate, rent.days
from ((rent 
inner join cars on rent.car_id = cars.id)
inner join users on rent.userId = users.userId)
where rent.isEnd = 0');
$stmt->execute();
$rentedCars = $stmt->fetchAll();
$car = $rentedCars[0] ?? null;
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rented cars list</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type='image/png' href="/public/logo.png">
</head>
<body>
<?php require 'header.php' ?>

<main class="flex justify-center items-center flex-col gap-4 py-10">
    <h1 class="text-3xl font-bold text-blue-500 mb-4">Rented cars list</h1>
    <?php if (count($rentedCars) > 0) : ?>
        <table>
            <tr class="*:px-3 *:py-2 *:border bg-blue-100 border-black">

                <th>User ID</th>
                <th>User email</th>
                <th>User full name</th>
                <th>User birth date</th>
                <th>Car ID</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Engine</th>
                <th>Fuel</th>
                <th>Price per day</th>
                <th>Rent start</th>
                <th>Rent end</th>
                <th>Rent days</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($rentedCars as $rentedCar) : ?>
                <tr class="py-2 border">
                    <?php foreach ($rentedCar as $key => $value): ?>
                        <td class="p-2 border text-center"><?= $value ?></td>
                    <?php endforeach; ?>
                    <td class="text-center py-4 px-3">
                        <a class="px-3 py-2 border-2 text-center rounded"
                           href="free.php?id=<?= $rentedCar['car_id'] ?>">End rent</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php else : ?>
        <p>
            No rented cars yet.
        </p>
    <?php endif ?>


</main>

</body>
</html>
