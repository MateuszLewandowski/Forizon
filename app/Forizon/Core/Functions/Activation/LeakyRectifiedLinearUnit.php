<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

class LeakyRectifiedLinearUnit implements ActivationFunction
{
    /**
     * @todo Validation $leaky.
     * @param float $leaky
     */
    public function __construct(private float $leaky = 0.1) {}

    public function use(Matrix $matrix): Matrix {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $matrix->data[$i][$j] > 0.0 ? $matrix->data[$i][$j] : $this->leaky * $matrix->data[$i][$j];
            }
        }
        return new Matrix($data);
    }

    public function derivative(Matrix $input, Matrix $output): Matrix {
        for ($i = 0; $i < $input->rows; $i++) {
            for ($j = 0; $j < $input->columns; $j++) {
                $data[$i][$j] = $input->data[$i][$j] > 0.0 ? 1.0 : $this->leaky;
            }
        }
        return new Matrix($data);
    }
}
