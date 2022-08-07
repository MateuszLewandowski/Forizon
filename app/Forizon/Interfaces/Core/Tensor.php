<?php

namespace App\Forizon\Interfaces\Core;

use App\Forizon\Interfaces\Core\Tensor\Algebraic;
use App\Forizon\Interfaces\Core\Tensor\Arithmetical;
use App\Forizon\Interfaces\Core\Tensor\Arrayable;
use App\Forizon\Interfaces\Core\Tensor\Collection;
use App\Forizon\Interfaces\Core\Tensor\Statistical;
use App\Forizon\Interfaces\Core\Tensor\Trigonometric;

interface Tensor extends Arrayable, Arithmetical, Algebraic, Trigonometric, Statistical, Collection
{
    public function shape(): array;

    public function size(): int;
}
