<?php

namespace Tests\Traits\Vector;

use App\Forizon\Tensors\ColumnVector;
use App\Forizon\Tensors\RowVector;
use BadMethodCallException;
use InvalidArgumentException;

trait CallableMethodAssertTrue
{
    /**
     * Undocumented function
     *
     * @param string $function
     * @param float|null $parameter
     * @return void
     * @throws InvalidArgumentException
     * @todo Exception message & code.
     */
    private function runCallable(string $vector, string $function, ?float $parameter = null): void {
        $method = strtolower(preg_split('/(?=[A-Z])/', $function)[1]);
        if (!is_callable($method)) {
            throw new InvalidArgumentException();
        }
        $basic = $vector::fillRandomize(3, 0, 1);
        $mutated = $basic->{$method}($parameter);
        for ($i = 0; $i < $basic->length; $i++) {
            $flag = $parameter !== null
                ? $mutated->data[$i] === $method($basic->data[$i], $parameter)
                : $mutated->data[$i] === $method($basic->data[$i]);
            if (!$flag) {
                $this->assertTrue(false);
            }
        }
        $this->assertTrue(true);
    }
}
