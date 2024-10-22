<?php
session_start();
global $pdo;
require('database.php');

$id = $_GET['id'];
if (!$id) {
    header('Location: index.php');
    exit;
}


$sql = 'SELECT * FROM cars WHERE id = :id';
$stmt = $pdo->prepare($sql);
$params = [
    'id' => $id
];
$stmt->execute($params);
$car = $stmt->fetch();
$carPhotos = !empty($car['photos']) ? explode(';', $car['photos']) : [];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type='image/png' href="/public/logo.png">
    <title>
        <?= $car['brand'] . ' ' . $car['model'] . ' ' . $car['year'] ?>
    </title>

    <style>
        #slider {
            display: flex;
            gap: 8px;
        }
        .slide{
            display: none;
        }
        #slider img{
            width: 500px;
            height: 320px;
        }
    </style>
    <script src="slider.js" defer></script>
</head>

<body>
<?php require 'header.php' ?>
<main class="py-6 px-36">
    <div class="shadow-xl rounded-lg px-4 py-6   border-2 border-blue-500">
        <div class="flex justify-between items-center px-10">
            <div class="flex gap-4 items-end">
                <p class="flex  items-center gap-4 font-bold text-4xl text-blue-500">
                    <img src="/public/svgs/<?= str_replace('-', ' ', strtolower($car['brand'])) . '.svg' ?>"
                         alt="<?= $car['brand'] ?>"
                         class="w-24 h-24">
                    <span class="truncate ...">
                        <?= $car['brand'] . '<br>' . $car['model'] . ' ' . $car['year'] ?>
                    </span>
                </p>
                <div class="p-4 rounded border flex items-center gap-2">
                    <p class="font-bold">
                        <img src="public/icons/engine.svg" class="w-12 h-12" alt="Engine icon">
                    </p>
                    <p class="text-3xl font-semibold">
                        <?= $car['volume'] != 0 ? $car['volume'] . ' l' : '-' ?>
                    </p>
                </div>
                <div class="p-4 rounded border flex items-center gap-2">
                    <p class="font-bold">
                        <img src="public/icons/fuel.svg" class="w-12 h-12" alt="Fuel icon">
                    </p>
                    <p class="text-3xl font-semibold">
                        <?= $car['fuel'] ?>
                    </p>
                </div>
                <div class="p-4 rounded border  flex items-center gap-2">
                    <p class="font-bold">
                        <img src="public/icons/price.svg" class="w-12 h-12" alt="Price icon">
                    </p>
                    <p class="text-3xl font-semibold">
                        $<?= $car['price'] ?>
                    </p>
                </div>

            </div>
            <div>
                <div class="flex flex-col items-center justify-center gap-2">
                    <a class="w-[150px] text-center bg-blue-500 rounded-lg text-white px-2 py-1 border-2 border-blue-500 hover:bg-white hover:text-blue-500 cursor-pointer"
                       href="rent.php?id=<?= $car['id'] ?>">
                        Rent</a>
                    <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 1): ?>
                        <a class="w-[150px] text-center bg-amber-500 rounded-lg text-white px-2 py-1  border-2 border-amber-500 hover:bg-white hover:text-amber-500 cursor-pointer"
                           href="edit.php?id=<?= $car['id'] ?>">
                            Edit</a>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="submit"
                                   class=" w-[150px] text-center bg-red-500 rounded-lg text-white px-2 py-1 border-2 border-red-500 hover:bg-white hover:text-red-400 cursor-pointer"
                                   value="Delete">
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div>
            <div id="slider">
                <?php foreach ($carPhotos as $carPhoto): ?>
                        <img src="/uploads/<?= $carPhoto ?>" alt="Car photo">
                <?php endforeach; ?>

            </div>

        </div>
    </div>
</main>
</body>

</html>