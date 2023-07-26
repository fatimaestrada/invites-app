<?php

function getCities()
{
    return [
        'DUBLIN' => ['latitude' => 53.3340285, 'longitude' => -6.2535495],
        'CORK' => ['latitude' => 51.98297, 'longitude' => -8.828756],
        'GALWAY' => ['latitude' => 53.373458, 'longitude' => -8.576091],
        'LIMERICK' => ['latitude' => 52.663971, 'longitude' => -8.618035]
    ];
}

function calculate_distance($from, $to)
{
    $degtorad = 0.01745329;
    $R = 6372.795477598;

    extract($from, EXTR_PREFIX_ALL, 'from');
    extract($to, EXTR_PREFIX_ALL, 'to');


    // Simple validation of the values to proccess
    if ($from_latitude == null || $from_longitude == null || $to_latitude == null || $to_longitude == null) {
        return null;
    }

    // If the positioning is the same theres no need to do the calculation
    if ($from_latitude === $to_latitude && $from_longitude === $to_longitude) {
        return 0;
    }

    $from_lat = $from_latitude * $degtorad;
    $from_lon = $from_longitude * $degtorad;
    $to_lat = $to_latitude * $degtorad;
    $to_lon = $to_longitude * $degtorad;

    $dist_km = $R * acos(sin($from_lat) * sin($to_lat) + cos($from_lat) * cos($to_lat) * cos($from_lon - $to_lon));

    return $dist_km;
}
