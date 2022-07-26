<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Interfaces\Core\Tensor\Matrixable;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Tensors\RowVector;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Matrix\MatrixableMethodAssertTrue;

class ArithmeticalWithRowVectorTest extends TestCase
{
    use MatrixableMethodAssertTrue;

    private string $target = Matrixable::class;

    private string $accessor = 'RowVector';

    private float $first = 2.0;

    private float $second = 3.0;

    public function testAddRowVectorExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), RowVector::fill(3, $this->second), $this->first + $this->second);
    }

    public function testSubtractRowVectorExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), RowVector::fill(3, $this->second), $this->first - $this->second);
    }

    public function testMultiplyRowVectorExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), RowVector::fill(3, $this->second), $this->first * $this->second);
    }

    public function testDivideRowVectorExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), RowVector::fill(3, $this->second), $this->first / $this->second);
    }
}
