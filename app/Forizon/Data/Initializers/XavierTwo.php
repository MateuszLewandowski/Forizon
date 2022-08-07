<?php

namespace App\Forizon\Data\Initializers;

use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Tensors\Matrix;

class XavierTwo implements Initializer
{
    public function init(int $rows, int $columns): Matrix
    {
        return Matrix::fillUniform($rows, $columns)->multiply(pow(6.0 / ($rows + $columns), .25));
    }
}
