<?php

namespace App\Forizon\Interfaces\Core\Tensor;

interface Algebraic {

    public function abs(): mixed;
    public function sqrt(): mixed;
    public function exp(): mixed;

    /**
     * @see https://www.php.net/manual/en/math.constants.php
     */
    public function log(float $base = M_E): mixed;
    public function round(int $precision = 0): mixed;
    public function floor(): mixed;
    public function ceil(): mixed;
    public function negate(): mixed;

}
