<?php

namespace App\Forizon\Core\Functions\Loss;

use App\Forizon\Interfaces\Core\Functions\Loss as LossFunction;
use App\Forizon\Interfaces\Core\Loss\Classificable;
use App\Forizon\Tensors\Matrix;

class CrossEntropy implements LossFunction, Classificable
{
    public function calculate(Matrix $output, Matrix $target): float {
        return $target->negate()->multiply(
            $output->lowerRange(1e-8)->log()
        )->mean()->mean();
    }

    public function differentive(Matrix $output, Matrix $target): Matrix {
        return $output->subtract($target)->divide(
            Matrix::fillOnes($target->rows, $target->cols)
                ->subtract($output)
                ->multiply($output)
                ->lowerRange(1e-8)
        );
    }
}
