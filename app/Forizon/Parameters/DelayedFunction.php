<?php

namespace App\Forizon\Parameters;

class DelayedFunction
{
    private mixed $function;

    private array $arguments;

    public function __construct(callable $function, array $arguments = [])
    {
        $this->function = $function;
        $this->arguments = $arguments;
    }

    public function __invoke(): mixed
    {
        return call_user_func_array($this->function, $this->arguments);
    }
}
