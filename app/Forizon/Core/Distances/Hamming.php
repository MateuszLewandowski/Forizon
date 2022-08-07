<?php

namespace App\Forizon\Core\Distances;

use App\Forizon\Interfaces\Core\Distance;

class Hamming implements Distance
{
    public function calc(array $a = [], array $b = []): float
    {
        if (count($a) !== count($b)) {
            //
        }
        $distance = 0.0;
        foreach ($a as $key => $value) {
            if ($value !== $b[$key]) {
                $distance++;
            }
        }

        return (float) $distance;
    }
}
