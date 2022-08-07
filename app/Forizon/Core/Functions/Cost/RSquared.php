<?php

namespace App\Forizon\Core\Functions\Cost;

use App\Forizon\Interfaces\Core\Functions\Cost as CostFunction;

class RSquared implements CostFunction
{
    public function evaluate(array $predictions, array $labels): float
    {
        $mean = array_sum($labels) / count($labels);
        $ssr = $sst = 0.0;
        foreach ($predictions as $key => $prediction) {
            $label = $labels[$key];
            $ssr += pow($label - $prediction, 2);
            $sst += pow($label - $mean, 2);
        }

        return 1.0 - ($ssr / ($sst ?: 1e-8));
    }
}
