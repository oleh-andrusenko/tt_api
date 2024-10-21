<?php


$diff = date_diff(date_create($_POST['endDate']), date_create($_POST['startDate']))->d + 1;
$price = $diff * $_POST['carPrice'];

switch ($diff) {
    case $diff >= 5 && $diff < 10:
        $discount = $price * 0.05;
        break;
    case $diff >= 10 && $diff < 21:
        $discount = $price * 0.1;
        break;
    case $diff >= 21:
        $discount = $price * 0.25;
        break;
    default:
        $discount = 0;
        break;
}

echo json_encode(['price' => $price - $discount, 'days' => $diff]);