<?php

namespace App\Forizon\Abstracts;

abstract class Driver
{
    public abstract function process(Configuration $configuration): array;
}
