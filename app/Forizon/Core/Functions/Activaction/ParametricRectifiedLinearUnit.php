<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

/**
 * @see https://towardsdatascience.com/intuitions-behind-different-activation-functions-in-deep-learning-a2b1c8d044a
 */
class ParametricRectifiedLinearUnit implements ActivationFunction
{
    private float $beta;

    public function __construct(float $beta = 0.0) {
        $this->beta = $beta;
    }

    public function use(Matrix $matrix): Matrix {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $matrix->data[$i][$j] > 0.0 ? $matrix->data[$i][$j] : $this->beta * $matrix->data[$i][$j];
            }
        }
        return new Matrix($data);
    }

    public function derivative(Matrix $input, Matrix $output): Matrix {
        for ($i = 0; $i < $input->rows; $i++) {
            for ($j = 0; $j < $input->columns; $j++) {
                $data[$i][$j] = $input->data[$i][$j] > 0.0 ? 1.0 : $this->beta;
            }
        }
        return new Matrix($data);
    }
}
