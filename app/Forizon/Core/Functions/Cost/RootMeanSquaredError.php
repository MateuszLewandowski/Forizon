<?php

namespace App\Forizon\Core\Functions\Cost;

use App\Forizon\Interfaces\Core\Cost as CostFunction;

class RootMeanSquaredError extends MeanSquaredError implements CostFunction
{
    public function score(array $predictions, array $labels): float {
        return -sqrt(-parent::score($predictions, $labels));
    }
}
