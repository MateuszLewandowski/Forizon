<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Tensors\ColumnVector;
use App\Forizon\Tensors\Matrix;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testSumExpectsSuccess()
    {
        $columnVector = Matrix::fill(3, 3, 2.0)->sum();
        $is_summed_up = true;
        foreach ($columnVector->data as $value) {
            if ($value !== 6.0) {
                $is_summed_up = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_summed_up);
    }

    public function testMinExpectsSuccess()
    {
        $columnVector = Matrix::fillRandomizeRequireFrom(3, 3, 1, 10)->min();
        $is_minimized = true;
        foreach ($columnVector->data as $value) {
            if ($value < 1.0) {
                $is_minimized = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_minimized);
    }

    public function testMaxExpectsSuccess()
    {
        $columnVector = Matrix::fillRandomizeRequireTo(3, 3, 1.0, 10.0)->max();
        $is_maximized = true;
        foreach ($columnVector->data as $value) {
            if ($value > 10.0) {
                $is_maximized = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_maximized);
    }

    public function testLowerRangeExpectsSuccess()
    {
        $matrix = Matrix::fillRandomizeRequireFrom(3, 3, 1, 10)->lowerRange(2.0);
        $is_lower_ranged = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value < 2.0) {
                    $is_lower_ranged = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_lower_ranged);
    }

    public function testUpperRangeExpectsSuccess()
    {
        $matrix = Matrix::fillRandomizeRequireTo(3, 3, 1, 11)->upperRange(10.0);
        $is_upper_ranged = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value > 10.0) {
                    $is_upper_ranged = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_upper_ranged);
    }

    public function testRangeExpectsSuccess()
    {
        $matrix = Matrix::fillRandomize(3, 3, 1, 10)->range(2.0, 9.0);
        $is_ranged = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value < 2.0 or $value > 9.0) {
                    $is_ranged = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_ranged);
    }
}
