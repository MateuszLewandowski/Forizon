<?php

namespace App\Forizon\Interfaces\Core\Functions;

interface Cost {
    public function evaluate(array $predictions, array $labels);
}
