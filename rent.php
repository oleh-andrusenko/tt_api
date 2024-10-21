<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: auth.php');
}


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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = 'INSERT INTO rent  (car_id, startDate, endDate, fullName, days, userId) VALUES (:id, :startDate, :endDate, :fullName,:days, :userId)';
    $stmt = $pdo->prepare($sql);
    $params = [
        'id' => $id,
        'startDate' => $_POST['startDate'],
        'endDate' => $_POST['endDate'],
        'fullName' => $_POST['fullName'],
        'days' => $diff = date_diff(date_create($_POST['startDate']), date_create($_POST['endDate']))->d + 1,
        'userId' => $_SESSION['userId']
    ];
    $stmt->execute($params);
    $sql = 'UPDATE cars SET isFree = 0 WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $params = [
        'id' => $id
    ];
    $stmt->execute($params);


    header('Location: index.php');
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
    <title>Rent a <?= $car['brand'] . ' ' . $car['model'] ?> </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type='image/png' href="/public/logo.png">
    <script src="datePicker.js" defer></script>
</head>
<body>
<?php require 'header.php' ?>
<main class="flex justify-center items-center py-10 ">
    <div class="w-[250px] h-[350px] px-6 py-2 border-l-2 border-t-2 border-b-2 bg-white rounded-l *:py-2 flex flex-col items-center justify-center  border-slate-300 shadow-xl">
        <p class="text-xl font-bold">Info about car</p>
        <p class="text-lg text-blue-500 font-semibold"><?= $car['brand'] . ' ' . $car['model'] . ' ' . $car['year'] ?></p>
        <p><span class="font-semibold">Engine:</span>
            <?= $car['volume'] == 0 ? $car['fuel'] : $car['volume'] . 'l' . $car['fuel'] ?>
        </p>
        <p>
            <span class="font-semibold">Description:</span> <?= !empty($car['description']) ? $car['description'] : 'No description.' ?>
        </p>
        <p>
            <span class="font-semibold">Price per day:</span>
            <span id="pricePerDay"> $<?= $car['price'] ?></span>
        </p>


    </div>
    <form method='post' class="w-[500px] rounded-lg shadow-xl px-4 py-6 border-2 border-slate-400 flex flex-col gap-4">
        <p class="text-center text-2xl my-2 font-semibold text-blue-500 uppercase">Rent car</p>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Start date</p>
            <input class="border-2 rounded-md w-2/3" type="date" min="<?= date('Y-m-d') ?>" name="startDate"
                   id="startDate"
            >
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">End date</p>
            <input class="border-2 rounded-md w-2/3" type="date" min="<?= date('Y-m-d') ?>" name="endDate" id="endDate">
        </div>
        <div class="flex justify-between items-center gap-4">
            <p class="font-semibold w-1/3">Full name</p>
            <input class="border-2 rounded-md w-2/3" type="text" name="fullName" id="fullName"
                   value="<?= $_SESSION['fullName'] ?>"
            >
        </div>


        <div class="flex gap-5 items-center justify-between py-4 px-10 rounded border text-sm">
            <p>Days: <span class="px-4 py-2 bg-blue-500 text-white rounded font-semibold ml-4" id="rentDays">-</span>
            </p>
            <p>Price: <span class="px-4 py-2 bg-blue-500 text-white rounded font-semibold ml-4" id="rentPrice">-</span>
            </p>

        </div>
        <input hidden="hidden" type="number" name="carPrice" id="carPrice" value="<?= $car['price'] ?>">


        <div>
            <input class="w-full text-center bg-blue-500 rounded-lg text-white px-2 py-1 mt-6 border-2 border-blue-500 hover:bg-white hover:text-blue-400 cursor-pointer"
                   type="submit" value="Rent">
        </div>

    </form>
    <div class="w-[250px] h-[350px] px-6 py-2  flex flex-col items-center justify-center  border-r-2 border-t-2 border-b-2  border-slate-300 rounded-r shadow-xl ">
        <h4 class="w-full text-xl  font-bold text-center mb-4"> Rent discounts</h4>
        <p class="text-lg text-blue-500 font-semibold mb-4">Discount conditions:</p>
        <table class="mt-4">
            <tr>
                <td class="pr-6 font-semibold">5+ days</td>
                <td>5% off</td>
            </tr>
            <tr>
                <td class="pr-6 font-semibold">10+ days</td>
                <td>10% off</td>
            </tr>
            <tr>
                <td class="pr-6 font-semibold">21+ days</td>
                <td>25% off</td>
            </tr>
        </table>

    </div>
</main>
</body>
</html>
