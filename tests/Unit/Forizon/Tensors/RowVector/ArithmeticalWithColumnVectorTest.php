<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use App\Forizon\Interfaces\Core\Tensor\Vectorable;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Vector\VectorableMethodAssertTrue;
use App\Forizon\Tensors\ColumnVector;
use App\Forizon\Tensors\RowVector;

class ArithmeticalWithColumnVectorTest extends TestCase
{
    use VectorableMethodAssertTrue;

    private string $target = Vectorable::class;
    private string $accessor = 'Vector';
    private float $first = 2.0;
    private float $second = 3.0;

    public function testAddColumnVectorExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), ColumnVector::fill(3, $this->second), $this->first + $this->second);
    }
    public function testSubtractColumnVectorExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), ColumnVector::fill(3, $this->second), $this->first - $this->second);
    }
    public function testMultiplyColumnVectorExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), ColumnVector::fill(3, $this->second), $this->first * $this->second);
    }
    public function testDivideColumnVectorExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), ColumnVector::fill(3, $this->second), $this->first / $this->second);
    }
}
