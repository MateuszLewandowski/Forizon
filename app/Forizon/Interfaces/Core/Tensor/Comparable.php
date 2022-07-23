<?php 

namespace App\Forizon\Interfaces\Core\Tensor;

interface Comparable {

    public function isEqual(mixed $tensor): mixed;
    public function isNotEqual(mixed $tensor): mixed;
    public function isGreater(mixed $tensor): mixed;
    public function isGreaterOrEqual(mixed $tensor): mixed;
    public function isLess(mixed $tensor): mixed;
    public function isLessOrEqual(mixed $tensor): mixed;

}