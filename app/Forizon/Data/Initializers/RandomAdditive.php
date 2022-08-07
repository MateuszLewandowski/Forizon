<?php

namespace App\Forizon\Data\Initializers;

use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Tensors\Matrix;

class RandomAdditive implements Initializer
{
    private int $from;

    private int $to;

    public function __construct(int $from = -1, int $to = 1)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function init(int $rows, int $columns): Matrix
    {
        return Matrix::fillRandomize($rows, $columns, $this->from, $this->to);
    }
}
