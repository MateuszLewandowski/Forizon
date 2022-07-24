<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Tensors\ColumnVector;
use Tests\Traits\Matrix\ComparableMethodAssertTrue;

class ComparableWithColumnVectorTest extends TestCase
{
    use ComparableMethodAssertTrue;

    private string $target = Matrixable::class;
    private string $accessor = 'ColumnVector';
    private float $first = 2.0;
    private float $second = 3.0;

    public function testIsEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), 0.0);
    }
    public function testIsNotEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), 1.0);
    }
    public function testIsGreaterExpectsSuccess() {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), 0.0);
    }
    public function testIsGreaterOrEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), 0.0);
    }
    public function testIsLessExpectsSuccess() {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), 1.0);
    }
    public function testIsLessOrEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), 1.0);
    }
}
