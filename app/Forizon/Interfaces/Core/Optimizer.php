<?php

namespace App\Forizon\Interfaces\Core;

use App\Forizon\Parameters\Attribute;
use App\Forizon\Interfaces\Core\Tensor;

interface Optimizer {
    public function init(Attribute $attribute): void;
    public function run(string $id, Tensor $gradient): Tensor;
}
