<?php

namespace App\Forizon\Core\Functions\Cost;

use App\Forizon\Interfaces\Core\Cost as CostFunction;

/**
 * @todo Exception.
 */
class MeanSquaredError implements CostFunction
{
    public function score(array $predictions, array $labels): float {
        if (count($predictions) !== count($labels)) {
            //
        }
        if (empty($predictions)) {
            return 0.0;
        }
        $error = 0.0;
        foreach ($predictions as $key => $prediction) {
            $error += pow($prediction - $labels[$key], 2);
        }
        return $error / count($predictions);
    }
}
