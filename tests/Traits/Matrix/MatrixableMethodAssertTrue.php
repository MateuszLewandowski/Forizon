<?php

namespace Tests\Traits\Matrix;

use App\Forizon\Tensors\Matrix;
use BadMethodCallException;

trait MatrixableMethodAssertTrue
{
    /**
     * Undocumented function
     *
     * @param string $function
     * @param float|null $expected
     * @param float|null $parameter
     * @return void
     */
    private function runMatrixable(string $function, ?float $expected = null, ?float $parameter = null): void {
        $method = strtolower(preg_split('/(?=[A-Z])/', $function)[1]);
        $this->test($method, $expected, $parameter);
    }

    /**
    * @param string $method
    * @param float|null $expected = null
    * @param float|null $parameter = null
    * @return void
    * @throws BadMethodCallException
    * @todo Exception message & code.
    */
    private function test(string $method, ?float $expected = null, ?float $parameter = null): void {
        $first = Matrix::fill(3, 3, $this->first);
        $second = Matrix::fill(3, 3, $this->second);
        if (!method_exists($first, $method)) {
            throw new BadMethodCallException();
        }
        $result = $parameter !== null
            ? $first->{$method . $this->accessor}($second)
            : $first->{$method . $this->accessor}($second, $parameter);
        for ($i = 0; $i < $first->rows; $i++) {
            for ($j = 0; $j < $second->columns; $j++) {
                if ($result->data[$i][$j] !== $expected) {
                    $this->assertTrue(false);
                }
            }
       }
       $this->assertTrue(true);
   }
}
