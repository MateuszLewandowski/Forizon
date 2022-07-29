<?php

namespace Tests\Unit\Forizon\Tensors\ColumnVector;

use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\ColumnVector;

class ArrayableTest extends TestCase
{
    public function testShapeExpectsSuccess()
    {
        $columnVector = ColumnVector::fillZeros(3);
        $this->assertTrue($columnVector instanceof ColumnVector and $columnVector->shape() === [3]);
    }

    public function testSizeExpectsSuccess()
    {
        $columnVector = ColumnVector::fillZeros(3);
        $this->assertTrue($columnVector instanceof ColumnVector and $columnVector->size() === 3);
    }
}
