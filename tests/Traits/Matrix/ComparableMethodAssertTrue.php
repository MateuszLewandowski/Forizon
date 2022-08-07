<?php

namespace Tests\Traits\Matrix;

use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Tensors\Matrix;
use BadMethodCallException;

trait ComparableMethodAssertTrue
{
    private $unset = [
        'test', 'Expects', 'Success', 'Failure',
    ];

    /**
     * Undocumented function
     *
     * @param  string  $function
     * @param  float|null  $expected
     * @param  float|null  $parameter
     * @return void
     */
    private function runComparable(string $function, Matrix $first, Tensor|float $second, float $expected, ?float $parameter = null): void
    {
        $parts = preg_split('/(?=[A-Z])/', $function);
        foreach ($parts as $key => $part) {
            if (in_array($part, $this->unset)) {
                unset($parts[$key]);
            }
        }
        $method = lcfirst(implode('', array_merge($parts, [$this->accessor])));
        if (! method_exists($first, $method)) {
            throw new BadMethodCallException();
        }
        $result = $parameter !== null
            ? $first->{$method}($second)
            : $first->{$method}($second, $parameter);
        for ($i = 0; $i < $first->rows; $i++) {
            for ($j = 0; $j < $first->columns; $j++) {
                if ($result->data[$i][$j] !== $expected) {
                    $this->assertTrue(false);
                }
            }
        }
        $this->assertTrue(true);
    }
}
