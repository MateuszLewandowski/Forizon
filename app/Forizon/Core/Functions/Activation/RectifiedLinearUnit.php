<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

class RectifiedLinearUnit implements ActivationFunction
{
    public function use(Matrix $matrix): Matrix
    {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $matrix->data[$i][$j] > 0.0 ? $matrix->data[$i][$j] : 0.0;
            }
        }

        return new Matrix($data);
    }

    public function derivative(Matrix $input, Matrix $output): Matrix
    {
        return $input->isGreater(0.0);
    }
}
