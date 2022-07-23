<?php

namespace App\Forizon\Interfaces\Core\Functions;

use App\Forizon\Tensors\Matrix;

interface Activation {
    public function use(Matrix $matrix): Matrix;
    public function derivative(Matrix $input, Matrix $output): Matrix;
}
