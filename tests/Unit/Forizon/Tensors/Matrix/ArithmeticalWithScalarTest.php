<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Tensors\Matrix;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Matrix\MatrixableMethodAssertTrue;

class ArithmeticalWithScalarTest extends TestCase
{
    use MatrixableMethodAssertTrue;

    private string $target = Matrixable::class;

    private string $accessor = 'Scalar';

    private float $first = 2.0;

    private float $second = 3.0;

    public function testAddScalarExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, $this->first + $this->second);
    }

    public function testSubtractScalarExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, $this->first - $this->second);
    }

    public function testMultiplyScalarExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, $this->first * $this->second);
    }

    public function testDivideScalarExpectsSuccess()
    {
        $this->runMatrixable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, $this->first / $this->second);
    }
}
