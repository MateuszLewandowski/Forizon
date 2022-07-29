<?php

namespace Tests\Traits\Vector;

use App\Forizon\Abstracts\Tensors\Vector;
use BadMethodCallException;
use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Tensors\RowVector;
use App\Forizon\Tensors\ColumnVector;

trait ComparableMethodAssertTrue
{
    private $unset = [
        'test', 'Expects', 'Success', 'Failure'
    ];

    /**
     * Undocumented function
     *
     * @param string $function
     * @param float|null $expected
     * @param float|null $parameter
     * @return void
     */
    private function runComparable(string $function, Vector $first, Tensor|float $second, float $expected, ?float $parameter = null): void {
        $parts = preg_split('/(?=[A-Z])/', $function);
        foreach ($parts as $key => $part) {
            if (in_array($part, $this->unset)) {
                unset($parts[$key]);
            }
        }
        $method = lcfirst(implode('', array_merge($parts, [$this->accessor])));
        if (!method_exists($first, $method)) {
            throw new BadMethodCallException();
        }
        $result = $parameter !== null
            ? $first->{$method}($second)
            : $first->{$method}($second, $parameter);
        switch (true) {
            case $result instanceof Matrix:
                for ($i = 0; $i < $result->rows; $i++) {
                    for ($j = 0; $j < $result->columns; $j++) {
                        if ($result->data[$i][$j] !== $expected) {
                            $this->assertTrue(false);
                        }
                    }
                }
                break;
            case $result instanceof RowVector:
            case $result instanceof ColumnVector:
                for ($i = 0; $i < $first->length; $i++) {
                    if ($result->data[$i] !== $expected) {
                        $this->assertTrue(false);
                    }
                }
                break;
            default:
                $this->assertTrue(false);
                break;
        }
        $this->assertTrue(true);
    }
}
