<?php

require 'database.php';
require 'helpers.php';

$startTimePoint = $_POST['startDate'];
$endTimePoint = $_POST['endDate'];
$datesPeriod = date_diff(date_create($startTimePoint), date_create($endTimePoint))->days;
$params = [
    'startDate' => $startTimePoint,
    'endDate' => $endTimePoint
];

$stmt = $pdo->prepare("SELECT rc_bookings.car_id,
    rc_cars_models.slug AS 'car',
    rc_cars_brands.slug AS 'brand',
    rc_cars_models.type AS 'type',
    rc_cars.registration_number,
    rc_cars.attribute_year,
    rc_bookings.start_date,
    rc_bookings.end_date,
    rc_cars_translations.title AS 'title',
    rc_cars_translations.attribute_color AS 'color'
    FROM ((((rc_bookings
    JOIN rc_cars on rc_bookings.car_id = rc_cars.car_id)
    JOIN rc_cars_models on rc_cars.car_model_id = rc_cars_models.car_model_id)
    JOIN rc_cars_brands on rc_cars_models.car_brand_id = rc_cars_brands.car_brand_id)
    JOIN rc_cars_translations on rc_bookings.car_id = rc_cars_translations.car_id)
    WHERE 
      rc_bookings.end_date > :startDate
      and rc_bookings.start_date < :endDate
      and rc_bookings.status=1
      and rc_cars.status = 1
      and rc_cars.company_id=1
      and rc_cars.is_deleted!=1
      and rc_cars_translations.lang = 'en'
ORDER By rc_bookings.car_id ASC");

$stmt->execute($params);
$cars = $stmt->fetchAll();


echo json_encode(getResult($cars, $startTimePoint, $endTimePoint, $datesPeriod));