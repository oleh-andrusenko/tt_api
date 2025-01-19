<?php

require 'database.php';


$startTimePoint = $_POST['startDate'];
$endTimePoint = $_POST['endDate'];
$datesPeriod = date_diff(date_create($startTimePoint), date_create($endTimePoint))->days;


$stmt = $pdo->prepare("select rc_bookings.car_id,
    rc_cars_models.slug as 'car',
    rc_cars_brands.slug as 'brand',
    rc_cars_models.type as 'type',
    rc_cars.registration_number,
    rc_cars.attribute_year,
    rc_bookings.start_date,
    rc_bookings.end_date,
    rc_cars_translations.title as 'title',
    rc_cars_translations.attribute_color as 'color'
    FROM ((((rc_bookings
    JOIN rc_cars on rc_bookings.car_id = rc_cars.car_id)
    join rc_cars_models on rc_cars.car_model_id = rc_cars_models.car_model_id)
    join rc_cars_brands on rc_cars_models.car_brand_id = rc_cars_brands.car_brand_id)
    join rc_cars_translations on rc_bookings.car_id = rc_cars_translations.car_id)
    WHERE 
      rc_bookings.end_date > :startDate
      and rc_bookings.start_date < :endDate
      and rc_bookings.status=1
      and rc_cars.status = 1
      and rc_cars.company_id=1
      and rc_cars.is_deleted!=1
      and rc_cars_translations.lang = 'en'
ORDER By rc_bookings.car_id ASC;");


$params = [
    'startDate' => $startTimePoint,
    'endDate' => $endTimePoint
];

$stmt->execute($params);
$cars = $stmt->fetchAll();


$ids = array_unique(array_column($cars, "car_id"));

function prepareData($ids, $cars)
{
    $data = [];
    foreach ($ids as $id) {
        $car = array_filter($cars, function ($car) use ($id) {
            return ($car["car_id"] === $id);
        });
        $dates = [];
        foreach ($car as $carData) {
            $dates[] = [
                'start_date' => $carData["start_date"],
                "end_date" => $carData["end_date"]
            ];
        }
        $data[] = [
            'car_id' => $car[array_key_first($car)]['car_id'],
            'title' => $car[array_key_first($car)]['title'],
            'car' => $car[array_key_first($car)]['car'],
            'brand' => $car[array_key_first($car)]['brand'],
            'type' => $car[array_key_first($car)]['type'],
            'number' => $car[array_key_first($car)]['registration_number'],
            'year' => $car[array_key_first($car)]['attribute_year'],
            'color' => $car[array_key_first($car)]['color'],
            'dates' => $dates
        ];
    }
    return $data;
}


function checkStartDate($sD): int
{
    $timePoint = clone $sD;
    $timePoint->setTime(21, 0, 0);
    $diff = date_diff($timePoint, $sD);
    return ($diff->h * 60 + $diff->i) > 180 ? 1 : 0;
}

function checkEndDate($eD): int
{
    $timePoint = clone $eD;
    $timePoint->setTime(9, 0, 0);
    $diff = date_diff($timePoint, $eD);
    $busyMins = $diff->h * 60 + $diff->i;
    $diff->invert ? $busyMins *= -1 : $busyMins;
    return $busyMins > 180 ? 1 : 0;
}

function getCarBusyDays($bookings, $start, $end)
{
    $total = 0;
    $startTimePoint = date_create($start);
    $endTimePoint = date_create($end);

    foreach ($bookings as $date) {
        $startDate = date_create(substr($date['start_date'], 0, 10));
        $endDate = date_create(substr($date['end_date'], 0, 10));
        $busyDays = date_diff(
                $startDate < $startTimePoint ? clone $startTimePoint : $startDate,
                $endDate > $endTimePoint ? clone $endTimePoint : $endDate)->days - 1;

        if (date_create($date['start_date']) < $startTimePoint) {
            $date['start_date'] = $startTimePoint->format('Y-m-d H:i:s');
        }

        if (date_create($date['end_date']) > $endTimePoint) {
            $date['end_date'] = $endTimePoint->format('Y-m-d H:i:s');
        }

        $busyDays += checkStartDate(date_create($date['start_date']));
        $busyDays += checkEndDate(date_create($date['end_date']));

        $total += $busyDays;
    }
    return $total;
}

$d = prepareData($ids, $cars);
$res = [];
foreach ($d as $data) {
    $busy = getCarBusyDays($data['dates'], $startTimePoint, $endTimePoint);
    $res[] = [
        'car_id' => $data['car_id'],
        'title' => $data['title'],
        'car' => $data['car'],
        'brand' => $data['brand'],
        'type' => $data['type'],
        'number' => $data['number'],
        'year' => $data['year'],
        'color' => $data['color'],
        'busy' => $busy,
        'free' => $datesPeriod - $busy,
        'total' => $datesPeriod
    ];
}


echo json_encode($res);