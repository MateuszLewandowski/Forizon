<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

class ExponentialLinearUnit implements ActivationFunction
{
    private float $alpha;

    public function __construct(float $alpha = 1.0) {
        $this->alpha = $alpha;
    }

    public function use(Matrix $matrix): Matrix {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $matrix->data[$i][$j] > 0.0 ? $matrix->data[$i][$j] : $this->alpha * (exp($matrix->data[$i][$j]) - 1.0);
            }
        }
        return new Matrix($data);
    }

    public function derivative(Matrix $input, Matrix $output): Matrix {
        for ($i = 0; $i < $output->rows; $i++) {
            for ($j = 0; $j < $output->columns; $j++) {
                $data[$i][$j] = $output->data[$i][$j] > 0.0 ? 1.0 : $output->data[$i][$j] + $this->alpha;
            }
        }
        return new Matrix($data);
    }
}
