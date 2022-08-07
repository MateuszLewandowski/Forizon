<?php

namespace App\Forizon\Abstracts;

abstract class Driver
{
    abstract public function process(Configuration $configuration): array;
}
