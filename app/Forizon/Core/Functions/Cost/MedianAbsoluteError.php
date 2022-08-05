<?php

namespace App\Forizon\Core\Functions\Cost;

use App\Forizon\Interfaces\Core\Functions\Cost as CostFunction;

/**
 * @todo Exception.
 */
class MedianAbsoluteError implements CostFunction
{
    public function evaluate(array $predictions, array $labels): float {
        if (count($predictions) !== count($labels)) {
            //
        }
        if (empty($predictions)) {
            return 0.0;
        }
        $errors = [];
        foreach ($predictions as $key => $prediction) {
            $errors[] = abs($labels[$key] - $prediction);
        }
        $length = count($errors);
        $middle = intdiv($length, 2);
        sort($errors);
        return -($length % 2 === 1
            ? $errors[$middle]
            : ($errors[$middle - 1] + $errors[$middle]) / 2);
    }
}
