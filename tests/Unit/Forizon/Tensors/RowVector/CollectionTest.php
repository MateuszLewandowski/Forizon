<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\RowVector;

class CollectionTest extends TestCase
{
    public function testSumExpectsSuccess()
    {
        $value = RowVector::fill(3, 2.0)->sum();
        $this->assertTrue($value === 6.0);
    }

    public function testMinExpectsSuccess()
    {
        $value = RowVector::fillRandomizeRequireFrom(3, 1, 10)->min();
        $this->assertTrue($value === 1.0);
    }

    public function testMaxExpectsSuccess()
    {
        $value = RowVector::fillRandomizeRequireTo(3, 1, 12)->max();
        $this->assertTrue($value === 12.0);
    }

    public function testLowerRangeExpectsSuccess()
    {
        $rowVector = RowVector::fillRandomizeRequireFrom(32, 1, 10)->lowerRange(2.0);
        $is_lower_ranged = true;
        foreach ($rowVector->data as $value) {
            if ($value < 2.0) {
                $is_lower_ranged = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_lower_ranged);
    }

    public function testUpperRangeExpectsSuccess()
    {
        $rowVector = RowVector::fillRandomizeRequireTo(3, 1, 11)->upperRange(10.0);
        $is_upper_ranged = true;
        foreach ($rowVector->data as $value) {
            if ($value > 10.0) {
                $is_upper_ranged = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_upper_ranged);
    }

    public function testRangeExpectsSuccess()
    {
        $rowVector = RowVector::fillRandomize(3, 1, 10)->range(2.0, 9.0);
        $is_ranged = true;
        foreach ($rowVector->data as $value) {
            if ($value < 2.0 or $value > 9.0) {
                $is_ranged = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_ranged);
    }
}
