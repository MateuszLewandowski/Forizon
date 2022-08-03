<?php

namespace App\Forizon\Data\Initializers;

use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Tensors\Matrix;

class He implements Initializer
{
    private const ETA = 0.70710678118;

    public function init(int $rows, int $columns): Matrix {
        return Matrix::fillUniform($rows, $columns)->multiply(pow(6.0 / ($rows + $columns), self::ETA));
    }
}
