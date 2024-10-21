<?php

require 'middleware.php';
require 'database.php';

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
$isEditRequest = $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'put';
if ($isEditRequest) {
    $id = $_POST['id'];
    $brand = htmlspecialchars($_POST['brand']);
    $model = htmlspecialchars($_POST['model']);
    $year = htmlspecialchars($_POST['year']);
    $volume = (float)htmlspecialchars($_POST['volume']);
    $fuel = htmlspecialchars($_POST['fuel']);
    $price = (int)htmlspecialchars($_POST['price']);
    $description = htmlspecialchars($_POST['description']);

    $sql = 'UPDATE cars SET brand = :brand, model = :model, year = :year, volume = :volume, fuel= :fuel, price = :price, description = :description WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $params = [
        'brand' => $brand,
        'model' => $model,
        'year' => $year,
        'volume' => $volume,
        'fuel' => $fuel,
        'price' => $price,
        'description' => $description,
        'id' => $id
    ];

    $stmt->execute($params);

    header('Location: index.php');
    exit;
}

function deletePhoto($url)
{
    global $carPhotos;
    $carPhotos = array_filter($carPhotos, function ($photo) use ($url) {
        return $photo !== $url;
    });
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type='image/png' href="/public/logo.png">
    <title>Edit car</title>
</head>

<body>
<?php require 'header.php' ?>
<main class="flex items-center justify-center px-4 py-6">
    <form method='post' class="w-[500px] rounded-lg shadow-xl px-4 py-6 border-2 flex flex-col gap-4">
        <p class="text-center text-2xl my-2 font-semibold">Edit car</p>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Brand</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="brand" id="brand" value="<?= $car['brand'] ?>">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Model</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="model" id="model" value="<?= $car['model'] ?>">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Year</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="year" id="year" value="<?= $car['year'] ?>">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Fuel</p>
            <select class="border-2 rounded-md w-2/3" name="fuel" id="fuel">
                <option value="Gasoline" <?php echo $car['fuel'] === 'Gasoline' ? 'selected' : '' ?>>Gasoline</option>
                <option value=" Diesel" <?php echo $car['fuel'] === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                <option value=" Electric" <?php echo $car['fuel'] === 'Electric' ? 'selected' : '' ?>>Electric</option>
                <option value=" Hybrid" <?php echo $car['fuel'] === 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                <option value=" Plug-In Hybrid" <?php echo $car['fuel'] === 'Plug-In Hybrid' ? 'selected' : '' ?>>
                    Plug-In Hybrid
                </option>
            </select>
        </div>
        <div class=" flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Volume (left 0 for electric cars)</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="volume" id="volume"
                   value="<?= $car['volume'] ?>">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Price</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="price" id="price" value="<?= $car['price'] ?>">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Description</p>
            <textarea class="border-2 rounded-md w-2/3 h-16" name="description"
                      id="description"><?= $car['description'] ?></textarea>
        </div>
  


        <input type="hidden" name="_method" value="put">
        <input type="hidden" name="id" value="<?= $id ?>">


        <input type="submit" value="Update"
               class="bg-green-500 rounded-lg text-white py-2 cursor-pointer   font-semibold border-2 border-green-500 hover:bg-white hover:text-green-500">
        <a href="index.php"
           class="bg-red-500 rounded-lg text-white py-2 cursor-pointer text-center font-semibold  border-2 border-red-500 hover:bg-white hover:text-red-500">Cancel</a>


    </form>


</main>
</body>

</html>