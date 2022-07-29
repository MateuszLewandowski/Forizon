<?php

namespace Tests\Traits\Vector;

use App\Forizon\Abstracts\Tensors\Vector;
use BadMethodCallException;
use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Tensors\RowVector;
use App\Forizon\Tensors\ColumnVector;

trait VectorableMethodAssertTrue
{
    /**
     * Undocumented function
     *
     * @param string $function
     * @param float|null $expected
     * @param float|null $parameter
     * @return void
     */
    private function runVectorable(string $function, Vector $first, Tensor|float $second, ?float $expected = null, ?float $parameter = null): void {
        $method = strtolower(preg_split('/(?=[A-Z])/', $function)[1]);
        if (!method_exists($first, $method)) {
            throw new BadMethodCallException();
        }
        $result = $parameter !== null
            ? $first->{$method . $this->accessor}($second)
            : $first->{$method . $this->accessor}($second, $parameter);
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
        }
       $this->assertTrue(true);
    }
}
