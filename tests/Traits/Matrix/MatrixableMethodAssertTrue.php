<?php

namespace Tests\Traits\Matrix;

use App\Forizon\Interfaces\Core\Tensor;
use BadMethodCallException;

trait MatrixableMethodAssertTrue
{
    /**
     * Undocumented function
     *
     * @param  string  $function
     * @param  float|null  $expected
     * @param  float|null  $parameter
     * @return void
     */
    private function runMatrixable(string $function, Tensor $first, Tensor|float $second, ?float $expected = null, ?float $parameter = null): void
    {
        $method = strtolower(preg_split('/(?=[A-Z])/', $function)[1]);
        if (! method_exists($first, $method)) {
            throw new BadMethodCallException();
        }
        $result = $parameter !== null
            ? $first->{$method.$this->accessor}($second)
            : $first->{$method.$this->accessor}($second, $parameter);
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
