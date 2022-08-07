<?php

namespace Tests\Unit\Forizon\Data\Initializers;

use App\Forizon\Data\Initializers\RandomAdditive;
use PHPUnit\Framework\TestCase;

class RandomAdditiveTest extends TestCase
{
    private int $rows = 32;

    private int $columns = 32;

    private float $from = -2;

    private float $to = 2;

    public function testInitializeDefaultMatrixExpectsSuccess()
    {
        $randomAdditiveInitializer = new RandomAdditive($this->from, $this->to);
        $matrix = $randomAdditiveInitializer->init($this->rows, $this->columns);
        $flag = true;
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                if ($matrix->data[$i][$j] < $this->from or $matrix->data[$i][$j] > $this->to) {
                    $flag = false;
                }
            }
        }
        $this->assertTrue($flag);
    }

    public function testInitializeHugeMatrixExpectsSuccess()
    {
        $multiplier = 15;
        $randomAdditiveInitializer = new RandomAdditive($this->from, $this->to);
        $matrix = $randomAdditiveInitializer->init($this->rows * $multiplier, $this->columns * $multiplier, );
        $flag = true;
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                if ($matrix->data[$i][$j] < $this->from or $matrix->data[$i][$j] > $this->to) {
                    $flag = false;
                }
            }
        }
        $this->assertTrue($flag);
    }
}
