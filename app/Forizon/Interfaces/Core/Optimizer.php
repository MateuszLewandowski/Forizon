<?php

namespace App\Forizon\Interfaces\Core;

use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Parameters\Attribute;
use App\Forizon\Tensors\Matrix;

interface Optimizer {
    public function initialize(Attribute $attribute): void;
    public function run(string $id, Tensor $tensor): Matrix;
}
