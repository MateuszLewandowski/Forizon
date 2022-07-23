<?php

namespace App\Forizon\Data\Initializers;

use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Tensors\Matrix;

class XavierTwo implements Initializer
{
    public function init(int $input, int $output): Matrix {
        return Matrix::fillUniform($input, $output)->multiply(pow(6.0 / ($input + $output), .25));
    }
}
