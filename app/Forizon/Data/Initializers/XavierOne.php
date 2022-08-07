<?php

namespace App\Forizon\Data\Initializers;

use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Tensors\Matrix;

class XavierOne implements Initializer
{
    public function init(int $rows, int $columns): Matrix
    {
        return Matrix::randmax($rows, $columns)->multiply(sqrt(6.0 / ($rows + $columns)));
    }
}
