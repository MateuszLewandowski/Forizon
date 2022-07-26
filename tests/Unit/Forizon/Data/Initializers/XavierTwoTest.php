<?php

namespace Tests\Unit\Forizon\Data\Initializers;

use App\Forizon\Data\Initializers\XavierTwo;
use PHPUnit\Framework\TestCase;

class XavierTwoTest extends TestCase
{
    private int $rows = 32;

    private int $columns = 32;

    public function testInitializeDefaultMatrixExpectsSuccess()
    {
        $HEInitializer = new XavierTwo();
        $matrix = $HEInitializer->init($this->rows, $this->columns);
        $flag = true;
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                if ($matrix->data[$i][$j] < -1.0 or $matrix->data[$i][$j] > 1.0) {
                    $flag = false;
                }
            }
        }
        $this->assertTrue($flag);
    }

    public function testInitializeHugeMatrixExpectsSuccess()
    {
        $multiplier = 15;
        $HEInitializer = new XavierTwo();
        $matrix = $HEInitializer->init($this->rows * $multiplier, $this->columns * $multiplier, );
        $flag = true;
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                if ($matrix->data[$i][$j] < -1.0 or $matrix->data[$i][$j] > 1.0) {
                    $flag = false;
                }
            }
        }
        $this->assertTrue($flag);
    }
}
