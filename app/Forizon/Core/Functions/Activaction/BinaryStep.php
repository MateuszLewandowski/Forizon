<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

/**
 * @see https://stats.stackexchange.com/questions/115258/comprehensive-list-of-activation-functions-in-neural-networks-with-pros-cons
 * @see https://www.v7labs.com/blog/neural-networks-activation-functions
 * @see https://towardsdatascience.com/activation-functions-neural-networks-1cbd9f8d91d6
 * @see https://www.upgrad.com/blog/types-of-activation-function-in-neural-networks/
 * @see https://github.com/pytorch/pytorch/blob/96aaa311c0251d24decb9dc5da4957b7c590af6f/torch/nn/modules/activation.py#L352
 */
class BinaryStep implements ActivationFunction
{
    public function use(Matrix $matrix): Matrix {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $matrix->data[$i][$j] >= 0.0 ? 1.0 : 0.0;
            }
        }
        return new Matrix($data);
    }

    public function derivative(Matrix $input, Matrix $output): Matrix {
        for ($i = 0; $i < $output->rows; $i++) {
            for ($j = 0; $j < $output->columns; $j++) {
                $data[$i][$j] = 0.0;
            }
        }
        return new Matrix($data);
    }
}
