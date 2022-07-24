<?php

namespace App\Forizon\Core\Functions\Activation;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Tensors\Matrix;

/**
 * @see https://pytorch.org/docs/stable/generated/torch.nn.SELU.html
 * @see https://github.com/onnx/onnx/issues/816
 * @see https://docs.w3cub.com/pytorch/generated/torch.nn.selu.html
 */
class ScaledExponentialLinearUnit implements ActivationFunction
{
    private const ALPHA = 1.6732632423543772848170429916717;
    private const SCALE = 1.0507009873554804934193349852946;
    private const BETA = self::ALPHA * self::SCALE;

    public function use(Matrix $matrix): Matrix {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $matrix->data[$i][$j] > 0.0
                    ? $matrix->data[$i][$j] * self::SCALE
                    : (exp($matrix->data[$i][$j]) - 1.0) * self::BETA;
            }
        }
        return new Matrix($data);
    }

    public function derivative(Matrix $input, Matrix $output): Matrix {
        for ($i = 0; $i < $output->rows; $i++) {
            for ($j = 0; $j < $output->columns; $j++) {
                $data[$i][$j] = $output->data[$i][$j] > 0.0
                    ? self::SCALE
                    : ($output->data[$i][$j] + self::ALPHA) * self::SCALE;
            }
        }
        return new Matrix($data);
    }
}
