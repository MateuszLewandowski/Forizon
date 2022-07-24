<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

class Softsign implements ActivationFunction
{
    public function use(Matrix $matrix): Matrix {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $matrix->data[$i][$j] / (1.0 + abs($matrix->data[$i][$j]));
            }
        }
        return new Matrix($data);
    }

    public function derivative(Matrix $input, Matrix $output): Matrix {
        $input = $this->use($input);
        for ($i = 0; $i < $input->rows; $i++) {
            for ($j = 0; $j < $input->columns; $j++) {
                $data[$i][$j] = 1.0 / (1.0 + abs($input->data[$i][$j])) ** 2;
            }
        }
        return new Matrix($data);
    }
}
