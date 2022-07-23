<?php

namespace App\Forizon\Core\Functions\Cost;

use App\Forizon\Interfaces\Core\Cost as CostFunction;

class SymmetricMeanAbsolutePercentageError implements CostFunction
{
    public function score(array $predictions, array $labels): float {
        if (empty($predictions)) {
            return 0.0;
        }
        $error = 0.0;
        foreach ($predictions as $i => $prediction) {
            $label = $labels[$i];
            $error += 100.0 * abs(($prediction - $label) / ((abs($label) + abs($prediction)) ?: 1e-8));
        }
        return -($error / count($predictions));
    }
}
