<?php

namespace App\Forizon\Core\Functions\Cost;

use App\Forizon\Interfaces\Core\Cost as CostFunction;

/**
 * @see https://medium.com/@zeeshanmulla/cost-activation-loss-function-neural-network-deep-learning-what-are-these-91167825a4de
 * @see https://stats.stackexchange.com/questions/154879/a-list-of-cost-functions-used-in-neural-networks-alongside-applications
 * @see https://peltarion.com/knowledge-center/documentation/modeling-view/build-an-ai-model/loss-functions/categorical-crossentropy
 */
class BinaryCrossEntropyCost implements CostFunction
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
            $error += $prediction * log($labels[$key]) + (1 - $prediction) * log(1 - $labels[$key]);
        }
        return -($error / count($predictions));
    }
}
