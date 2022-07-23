<?php

namespace App\Forizon\Core\Functions\Loss;

use App\Forizon\Interfaces\Core\Functions\Loss as LossFunction;
use App\Forizon\Interfaces\Core\Loss\Classificable;
use App\Forizon\Tensors\Matrix;

class RelativeEntropy implements LossFunction, Classificable
{
    public function calc(Matrix $output, Matrix $target): float {
        $target = $target->range(1e-8, 1.0);
        $output = $output->range(1e-8, 1.0);
        return $target->divide($output)->log()
            ->multiply($target)
            ->mean()
            ->mean();
    }

    public function differentive(Matrix $output, Matrix $target): Matrix {
        $target = $target->range(1e-8, 1.0);
        $output = $output->range(1e-8, 1.0);
        return $output->subtract($target)
            ->divide($output);
    }
}
