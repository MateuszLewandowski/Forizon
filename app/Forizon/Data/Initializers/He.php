<?php

namespace App\Forizon\Data\Initializers;

use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Tensors\Matrix;

class He implements Initializer
{
    public const ETA = 0.70710678118;

    public function init(int $input, int $output): Matrix {
        return Matrix::fillUniform($input, $output)->multiply(pow(6.0 / ($input + $output), self::ETA));
    }
}
