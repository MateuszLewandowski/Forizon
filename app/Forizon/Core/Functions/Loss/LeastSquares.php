<?php

namespace App\Forizon\Core\Functions\Loss;

use App\Forizon\Interfaces\Core\Functions\Loss as LossFunction;
use App\Forizon\Interfaces\Core\Loss\Regressable;
use App\Forizon\Tensors\Matrix;

class LeastSquares implements LossFunction, Regressable
{
    public function calculate(Matrix $output, Matrix $target): float
    {
        return $output->subtract($target)->square()->mean()->mean();
    }

    public function differentive(Matrix $output, Matrix $target): Matrix
    {
        return $output->subtract($target);
    }
}
