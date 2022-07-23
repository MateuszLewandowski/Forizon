<?php

namespace App\Forizon\Core\Distances;

use App\Forizon\Interfaces\Core\Distance;

/**
 * @todo Exceptions
 */
class Minkowski implements Distance
{
    private float $lambda;
    private float $inverse;

    public function __construct(float $lambda = 2.0) {
        if ($lambda < 1.0) {
            //
        }
        $this->lambda = $lambda;
        $this->inverse = 1.0 / $lambda;
    }

    public function calc(array $a = [], array $b = []): float {
        if (count($a) !== count($b)) {
            //
        }
        $distance = 0.0;
        foreach ($a as $key => $value) {
            $distance += pow(abs($value - $b[$key]), $this->lambda);
        }
        return pow($distance, $this->inverse);
    }
}
