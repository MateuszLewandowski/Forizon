<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use App\Forizon\Interfaces\Core\Tensor\Vectorable;
use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Tensors\RowVector;
use Tests\Traits\Vector\ComparableMethodAssertTrue;

class ComparableWithMatrixTest extends TestCase
{
    use ComparableMethodAssertTrue;

    private string $target = Vectorable::class;
    private string $accessor = 'Matrix';
    private float $first = 2.0;
    private float $second = 3.0;

    public function testIsEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, RowVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), 0.0);
    }
    public function testIsNotEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, RowVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), 1.0);
    }
    public function testIsGreaterExpectsSuccess() {
        $this->runComparable(__FUNCTION__, RowVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), 0.0);
    }
    public function testIsGreaterOrEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, RowVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), 0.0);
    }
    public function testIsLessExpectsSuccess() {
        $this->runComparable(__FUNCTION__, RowVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), 1.0);
    }
    public function testIsLessOrEqualExpectsSuccess() {
        $this->runComparable(__FUNCTION__, RowVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), 1.0);
    }
}