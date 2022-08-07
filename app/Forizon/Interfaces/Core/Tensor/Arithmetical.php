<?php

namespace App\Forizon\Interfaces\Core\Tensor;

interface Arithmetical
{
    public function add(mixed $tensor): mixed;

    public function subtract(mixed $tensor): mixed;

    public function multiply(mixed $tensor): mixed;

    public function divide(mixed $tensor): mixed;

    public function pow(float $base = 2): mixed;

    public function sqrt(): self;
}
