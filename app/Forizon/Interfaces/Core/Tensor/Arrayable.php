<?php

namespace App\Forizon\Interfaces\Core\Tensor;

interface Arrayable
{
    public function shape(): array;
    public function size(): int;

}
