<?php

namespace App\Forizon\Core\Distances;

use App\Forizon\Interfaces\Core\Distance;

class Manhattan implements Distance
{
    public function calc(array $a = [], array $b = []): float {
        if (count($a) !== count($b)) {
            //
        }
        $distance = 0.0;
        foreach ($a as $key => $value) {
            $distance += abs($value - $b[$key]);
        }
        return $distance;
    }
}
