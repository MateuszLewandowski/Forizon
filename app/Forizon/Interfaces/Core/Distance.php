<?php

namespace App\Forizon\Interfaces\Core;

interface Distance
{
    public function calc(array $a = [], array $b = []): float;
}
