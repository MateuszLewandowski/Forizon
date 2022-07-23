<?php

namespace App\Forizon\Interfaces\Core\Tensor;

interface Collection
{
    public function sum(): mixed;
    public function min(): mixed;
    public function max(): mixed;
    public function lowerRange(float $min): mixed;
    public function upperRange(float $max): mixed;
    public function range(float $min, float $max): mixed;
    public function product(): mixed;
}
