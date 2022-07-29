<?php

namespace Tests\Unit\Forizon\Tensors\ColumnVector;

use App\Forizon\Interfaces\Core\Tensor\Vectorable;
use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Tensors\ColumnVector;
use Tests\Traits\Vector\VectorableMethodAssertTrue;

class ArithmeticalWithMatrixTest extends TestCase
{
    use VectorableMethodAssertTrue;

    private string $target = Vectorable::class;
    private string $accessor = 'Matrix';
    private float $first = 2.0;
    private float $second = 3.0;

    public function testAddMatrixExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, ColumnVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), $this->first + $this->second);
    }
    public function testSubtractMatrixExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, ColumnVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), $this->first - $this->second);
    }
    public function testMultiplyMatrixExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, ColumnVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), $this->first * $this->second);
    }
    public function testDivideMatrixExpectsSuccess() {
        $this->runVectorable(__FUNCTION__, ColumnVector::fill(3, $this->first), Matrix::fill(3, 3, $this->second), $this->first / $this->second);
    }
}
