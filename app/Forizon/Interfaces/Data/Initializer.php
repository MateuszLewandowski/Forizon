<?php

namespace App\Forizon\Interfaces\Data;

use App\Forizon\Tensors\Matrix;

interface Initializer {
    public function init(int $rows, int $columns): Matrix;
}
