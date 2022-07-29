<?php

namespace Tests\Unit\Forizon\Tensors\ColumnVector;

use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\ColumnVector;
use Tests\Traits\Vector\ComparableMethodAssertTrue;

class ComparableWithScalarTest extends TestCase
{
    use ComparableMethodAssertTrue;

    private string $target = Vectorable::class;
    private string $accessor = 'Scalar';
    private float $first = 2.0;
    private float $second = 3.0;

    public function testIsEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, ColumnVector::fill(3, $this->first), $this->second, 0.0);
    }
    public function testIsNotEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, ColumnVector::fill(3, $this->first), $this->second, 1.0);
    }
    public function testIsGreaterExpectsSuccess() {
        $this->runComparable(__FUNCTION__, ColumnVector::fill(3, $this->first), $this->second, 0.0);
    }
    public function testIsGreaterOrEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, ColumnVector::fill(3, $this->first), $this->second, 0.0);
    }
    public function testIsLessExpectsSuccess() {
        $this->runComparable(__FUNCTION__, ColumnVector::fill(3, $this->first), $this->second, 1.0);
    }
    public function testIsLessOrEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, ColumnVector::fill(3, 3, $this->first), $this->second, 1.0);
    }
}