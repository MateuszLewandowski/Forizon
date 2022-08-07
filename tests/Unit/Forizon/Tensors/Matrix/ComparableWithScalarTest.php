<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Tensors\Matrix;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Matrix\ComparableMethodAssertTrue;

class ComparableWithScalarTest extends TestCase
{
    use ComparableMethodAssertTrue;

    private string $target = Matrixable::class;

    private string $accessor = 'Scalar';

    private float $first = 2.0;

    private float $second = 3.0;

    public function testIsEqualExpectsSuccess()
    {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, 0.0);
    }

    public function testIsNotEqualExpectsSuccess()
    {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, 1.0);
    }

    public function testIsGreaterExpectsSuccess()
    {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, 0.0);
    }

    public function testIsGreaterOrEqualExpectsSuccess()
    {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, 0.0);
    }

    public function testIsLessExpectsSuccess()
    {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, 1.0);
    }

    public function testIsLessOrEqualExpectsSuccess()
    {
        $this->runComparable(__FUNCTION__, Matrix::fill(3, 3, $this->first), $this->second, 1.0);
    }
}
