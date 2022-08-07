<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Tensors\Matrix;
use PHPUnit\Framework\TestCase;

class ArrayableTest extends TestCase
{
    public function testShapeExpectsSuccess()
    {
        $matrix = Matrix::fillZeros(3, 3);
        $this->assertTrue($matrix instanceof Matrix and $matrix->shape() === [3, 3]);
    }

    public function testSizeExpectsSuccess()
    {
        $matrix = Matrix::fillZeros(3, 3);
        $this->assertTrue($matrix instanceof Matrix and $matrix->size() === 9);
    }
}
