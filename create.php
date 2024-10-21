<?php
require 'middleware.php';
require 'database.php';
$photos = [];
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    if (isset($_FILES['files'])) {
        $folder = "uploads/";
        $names = $_FILES['files']['name'];
        $tmp_names = $_FILES['files']['tmp_name'];
        $upload_data = array_combine($tmp_names, $names);
        /*    highlight_string("<?php " . var_export($upload_data, true) . ";?>");*/

        $carId = uniqid();
        foreach ($upload_data as $temp_folder => $file) {
            $file = $carId . '-' . str_replace(' ', '_', $file);
            $photos[] = $file;
            move_uploaded_file($temp_folder, $folder . $file);
        }
    }


    $brand = htmlspecialchars($_POST['brand']);
    $model = htmlspecialchars($_POST['model']);
    $year = htmlspecialchars($_POST['year']);
    $volume = (float)htmlspecialchars($_POST['volume']);
    $fuel = htmlspecialchars($_POST['fuel']);
    $price = (int)htmlspecialchars($_POST['price']);
    $description = htmlspecialchars($_POST['description']);

    $sql = 'INSERT INTO cars (brand, model, year, volume, fuel, price, description, photos) VALUES (:brand, :model, :year, :volume, :fuel, :price, :description, :photos)';

    $stmt = $pdo->prepare($sql);
    $params = [
        'brand' => $brand,
        'model' => $model,
        'year' => $year,
        'volume' => $volume,
        'fuel' => $fuel,
        'price' => $price,
        'description' => $description,
        'photos' => implode(';', $photos)
    ];

    $stmt->execute($params);
    header('Location: index.php');
    exit;
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
    <title>Create new car</title>
</head>

<body>
<?php require 'header.php' ?>
<main class="flex items-center justify-center px-4 py-6">
    <form action="create.php" method='post' enctype="multipart/form-data"
          class="w-[500px] rounded-lg shadow-xl px-4 py-6 border-2 flex flex-col gap-4">
        <p class="text-center text-2xl my-2 font-semibold">Create new car</p>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Brand</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="brand" id="brand">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Model</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="model" id="model">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Year</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="year" id="year">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Fuel</p>
            <select class="border-2 rounded-md w-2/3" name="fuel" id="fuel">
                <option value="Gasoline">Gasoline</option>
                <option value="Diesel">Diesel</option>
                <option value="Electric">Electric</option>
                <option value="Hybrid">Hybrid</option>
                <option value="Plug-In Hybrid">Plug-In Hybrid</option>
            </select>
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Volume (left 0 for electric cars)</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="volume" id="volume">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Price</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="price" id="price">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Description</p>
            <textarea class="border-2 rounded-md w-2/3 h-16" name="description" id="description"></textarea>
        </div>
        <div class="flex gap-4">
            <p> Car photos:</p>
            <input class="w-1/2" type="file" multiple="multiple" name="files[]" id="id_upload"/>

        </div>
        <input type="submit" value="Create"
               class="bg-green-500 rounded-lg text-white py-2 cursor-pointer   font-semibold border-2 border-green-500 hover:bg-white hover:text-green-500">
        <a href="index.php"
           class="bg-red-500 rounded-lg text-white py-2 cursor-pointer text-center font-semibold  border-2 border-red-500 hover:bg-white hover:text-red-500">Cancel</a>
    </form>


</main>
</body>

</html>