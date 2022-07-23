<?php

namespace App\Forizon\Data\Initializers;

use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Tensors\Matrix;

class RandomZeroRange implements Initializer
{
    private float $min;
    private float $max;

    public function __construct(float $min = -0.1, float $max = 0.1) {
        $this->min = $min;
        $this->max = $max;
    }

    public function init(int $input, int $output): Matrix {
        return Matrix::randomize($input, $output, $this->min, $this->max);
    }
}
