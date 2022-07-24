<?php

namespace Tests\Traits\Matrix;

use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;

trait CallableMethodAssertTrue
{
    /**
     * Undocumented function
     *
     * @param string $function
     * @param float|null $parameter
     * @return void
     * @throws BadMethodCallException
     * @todo Exception message & code.
     */
    private function runCallable(string $function, ?float $parameter = null): void {
        $method = strtolower(preg_split('/(?=[A-Z])/', $function)[1]);
        if (!is_callable($method)) {
            throw new InvalidArgumentException();
        }
        $basic = Matrix::fill(3, 3, 0.01, 1.0);
        $mutated = $basic->{$method}($parameter);
        for ($i = 0; $i < $basic->rows; $i++) {
            for ($j = 0; $j < $mutated->columns; $j++) {
                $flag = $parameter !== null
                    ? $mutated->data[$i][$j] === $method($basic->data[$i][$j], $parameter)
                    : $mutated->data[$i][$j] === $method($basic->data[$i][$j]);
                if (!$flag) {
                    $this->assertTrue(false);
                }
            }
        }
        $this->assertTrue(true);
    }
}
