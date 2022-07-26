<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Interfaces\Core\Tensor\Matrixable;
use App\Forizon\Tensors\ColumnVector;
use App\Forizon\Tensors\Matrix;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Matrix\MatrixableMethodAssertTrue;

class ArithmeticalWithColumnVectorTest extends TestCase
{
    use MatrixableMethodAssertTrue;

    private string $target = Matrixable::class;

    private string $accessor = 'ColumnVector';

    private float $first = 2.0;

    private float $second = 3.0;

    public function testAddColumnVectorExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), $this->first + $this->second);
    }

    public function testSubtractColumnVectorExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), $this->first - $this->second);
    }

    public function testMultiplyColumnVectorExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), $this->first * $this->second);
    }

    public function testDivideColumnVectorExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), ColumnVector::fill(3, $this->second), $this->first / $this->second);
    }
}
