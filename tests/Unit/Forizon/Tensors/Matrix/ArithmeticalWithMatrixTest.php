<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Interfaces\Core\Tensor\Matrixable;
use App\Forizon\Tensors\Matrix;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Matrix\MatrixableMethodAssertTrue;

class ArithmeticalWithMatrixTest extends TestCase
{
    use MatrixableMethodAssertTrue;

    private string $target = Matrixable::class;

    private string $accessor = 'Matrix';

    private float $first = 2.0;

    private float $second = 3.0;

    public function testAddMatrixExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), Matrix::fill(3, 3, $this->second), $this->first + $this->second);
    }

    public function testSubtractMatrixExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), Matrix::fill(3, 3, $this->second), $this->first - $this->second);
    }

    public function testMultiplyMatrixExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), Matrix::fill(3, 3, $this->second), $this->first * $this->second);
    }

    public function testDivideMatrixExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), Matrix::fill(3, 3, $this->second), $this->first / $this->second);
    }
}
