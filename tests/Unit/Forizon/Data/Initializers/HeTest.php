<?php

namespace Tests\Unit\Forizon\Data\Initializers;

use App\Forizon\Data\Initializers\He;
use PHPUnit\Framework\TestCase;

class HeTest extends TestCase
{
    private int $rows = 32;
    private int $columns = 32;

    public function testInitializeDefaultMatrixExpectsSuccess()
    {
        $HEInitializer = new He();
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
        $HEInitializer = new He();
        $matrix = $HEInitializer->init($this->rows * $multiplier, $this->columns * $multiplier,);
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
