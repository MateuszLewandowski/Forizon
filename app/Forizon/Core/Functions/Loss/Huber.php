<?php

namespace App\Forizon\Core\Functions\Loss;

use App\Forizon\Interfaces\Core\Loss\Regressable;
use App\Forizon\Interfaces\Core\Functions\Loss as LossFunction;
use App\Forizon\Tensors\Matrix;

class Huber implements LossFunction, Regressable
{
    public float $alpha;
    public float $alpha_pow;

    public function __construct(float $alpha = .9) {
        $this->alpha = $alpha;
        $this->alpha_pow = pow($alpha, 2);
    }

    public function calculate(Matrix $output, Matrix $target): float {
        $pre = $target->subtract($output);
        for ($i = 0; $i < $target->rows; $i++) {
            for ($j = 0; $j < $target->cols; $j++) {
                $pre->data[$i][$j] = (sqrt(1.0 + ($pre->data[$i][$j] / $this->alpha) ** 2) - 1.0);
            }
        }
        return $pre->mean()->mean();

    }
    public function differentive(Matrix $output, Matrix $target): Matrix {
        $alpha = $output->subtract($target);
        return $alpha->square()
            ->add($this->alpha_pow)
            ->pow(-0.5)
            ->multiply($alpha);
    }
}
