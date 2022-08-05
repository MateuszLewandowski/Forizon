<?php

namespace App\Forizon\Core\Functions\Cost;

use App\Forizon\Interfaces\Core\Functions\Cost as CostFunction;

class RootMeanSquaredError extends MeanSquaredError implements CostFunction
{
    public function evaluate(array $predictions, array $labels): float {
        return -sqrt(-parent::evaluate($predictions, $labels));
    }
}
