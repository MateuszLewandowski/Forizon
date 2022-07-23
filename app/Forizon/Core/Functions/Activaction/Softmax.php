<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

class Softmax implements ActivationFunction
{
    public function use(Matrix $matrix): Matrix {
        $x = $matrix->exp()->transpose();
        $sum = $x->sum()->clipLower();
        return $x->divide($sum)->transpose();
    }

    public function derivative(Matrix $input, Matrix $output): Matrix {
        $x = $input->exp()->transpose();
        $sum = $x->sum()->clipLower();
        return $x->divide($sum)->transpose();
    }
}
