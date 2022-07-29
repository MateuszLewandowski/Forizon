<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use App\Forizon\Interfaces\Core\Tensor\Vectorable;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Vector\VectorableMethodAssertTrue;
use App\Forizon\Tensors\RowVector;

class ArithmeticalWithRowVectorTest extends TestCase
{
    use VectorableMethodAssertTrue;

    private string $target = Vectorable::class;
    private string $accessor = 'Vector';
    private float $first = 2.0;
    private float $second = 3.0;

    public function testAddRowVectorExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), RowVector::fill(3, $this->second), $this->first + $this->second);
    }
    public function testSubtractRowVectorExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), RowVector::fill(3, $this->second), $this->first - $this->second);
    }
    public function testMultiplyRowVectorExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), RowVector::fill(3, $this->second), $this->first * $this->second);
    }
    public function testDivideRowVectorExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), RowVector::fill(3, $this->second), $this->first / $this->second);
    }
}
