<?php

namespace App\Forizon\Interfaces\Core;

use App\Forizon\Interfaces\Core\Tensor\{
    Arrayable, Arithmetical, Algebraic, Trigonometric, Statistical, Collection
};

interface Tensor extends Arrayable, Arithmetical, Algebraic, Trigonometric, Statistical {
    public function shape(): array;
    public function size(): int;
}
