<?php

namespace App\Forizon\Interfaces\Core;

interface Cost {
    public function score(array $predictions, array $labels): float;
}
