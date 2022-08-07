<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

/**
 * @see https://paperswithcode.com/method/swish
 * @see https://blog.paperspace.com/swish-activation-function/
 * @see https://towardsdatascience.com/swish-booting-relu-from-the-activation-function-throne-78f87e5ab6eb
 */
class Swish implements ActivationFunction
{
    /**
     * @todo $beta
     *
     * @param  float  $beta
     */
    public function __construct(private float $beta = 1.0)
    {
    }

    public function use(Matrix $matrix): Matrix
    {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $matrix->data[$i][$j] * (1 + exp(-$matrix->data[$i][$j])) ** -1;
            }
        }

        return new Matrix($data);
    }

    public function derivative(Matrix $input, Matrix $output): Matrix
    {
        $input = $this->use($input);
        for ($i = 0; $i < $input->rows; $i++) {
            for ($j = 0; $j < $input->columns; $j++) {
                $data[$i][$j] = $input->data[$i][$j] + $output->data[$i][$j] * (1 - $input->data[$i][$j]);
            }
        }

        return new Matrix($data);
    }
}
