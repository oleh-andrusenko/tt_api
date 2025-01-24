<?php
header("Access-Control-Allow-Origin: *");
function prepareData( $cars)
{
    $data = [];
    $ids = array_unique(array_column($cars, "car_id"));
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

function getResult($cars, $startTimePoint, $endTimePoint, $datesPeriod){
    $data = prepareData($cars);
    $res = [];

    foreach ($data as $record) {
        $busy = getCarBusyDays($record['dates'], $startTimePoint, $endTimePoint);
        $res[] = [
            'car_id' => $record['car_id'],
            'title' => $record['title'],
            'car' => $record['car'],
            'brand' => $record['brand'],
            'type' => $record['type'],
            'number' => $record['number'],
            'year' => $record['year'],
            'color' => $record['color'],
            'busy' => $busy,
            'free' => $datesPeriod - $busy,
            'total' => $datesPeriod
        ];
    }
    return $res;
}