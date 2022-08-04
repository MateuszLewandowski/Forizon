<?php

namespace App\Forizon\Interfaces\Core\Functions;

use App\Forizon\Tensors\Matrix;

interface Loss {
    public function calculate(Matrix $output, Matrix $target): float;
    public function differentive(Matrix $output, Matrix $target): Matrix;
}
