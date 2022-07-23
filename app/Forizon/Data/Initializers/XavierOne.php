<?php

namespace App\Forizon\Data\Initializers;

use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Tensors\Matrix;

class XavierOne implements Initializer
{
    public function init(int $input, int $output): Matrix {
        return Matrix::randmax($input, $output)->multiply(sqrt(6.0 / ($input + $output)));
    }
}
