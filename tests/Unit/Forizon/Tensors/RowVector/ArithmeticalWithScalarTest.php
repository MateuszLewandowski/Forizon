<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use App\Forizon\Interfaces\Core\Tensor\Vectorable;
use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\RowVector;
use Tests\Traits\Vector\VectorableMethodAssertTrue;

class ArithmeticalWithScalarTest extends TestCase
{
    use VectorableMethodAssertTrue;

    private string $target = Vectorable::class;
    private string $accessor = 'Scalar';
    private float $first = 2.0;
    private float $second = 3.0;

    public function testAddMatrixExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), $this->second, $this->first + $this->second);
    }
    public function testSubtractMatrixExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), $this->second, $this->first - $this->second);
    }
    public function testMultiplyMatrixExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), $this->second, $this->first * $this->second);
    }
    public function testDivideMatrixExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, RowVector::fill(3, $this->first), $this->second, $this->first / $this->second);
    }
}
