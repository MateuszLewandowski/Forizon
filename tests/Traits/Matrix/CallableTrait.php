<?php

namespace Tests\Traits\Matrix;

use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;
use LengthException;
use RuntimeException;

trait CallableTrait
{
    private array $finalized = [];

    private function call(string $function) {
        $method = strtolower(preg_split('/(?=[A-Z])/', $function)[1]);
        if (!is_callable($method)) {
            /**
             * @todo Exception message & code.
             */
            throw new InvalidArgumentException();
        }
        $basic = Matrix::randomize(3, 3, 0.01, 1.0);
        $mutated = $basic->{$method}();

        $this->test($method, $basic, $mutated);
    }

    /**
    * @param callable $method
    * @param Matrix $basic
    * @param Matrix $mutated
    * @return void
    */
   private function test(callable $method, Matrix $basic, Matrix $mutated) {
       $flag = true;
       for ($i = 0; $i < $basic->rows; $i++) {
           for ($j = 0; $j < $mutated->columns; $j++) {
               if ($mutated->data[$i][$j] !== $method($basic->data[$i][$j])) {
                   $flag = false;
               }
           }
       }
       $this->finalized[] = $method;
       $this->assertTrue($flag);
   }

    /**
     * @todo Exception message & code.
     */
    public function testClosure() {
        $methods = get_class_methods($this->target);
        if (count($methods) < 1) {
            throw new LengthException();
        }
        foreach ($methods as $method) {
            if (array_key_exists($method, $this->finalized)) {
                throw new RuntimeException();
            }
        }
        $this->assertTrue(true);
    }
}
