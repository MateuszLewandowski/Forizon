<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\RowVector;

class ArrayableTest extends TestCase
{
    public function testShapeExpectsSuccess()
    {
        $rowVector = RowVector::fillZeros(3);
        $this->assertTrue($rowVector instanceof RowVector and $rowVector->shape() === [3]);
    }

    public function testSizeExpectsSuccess()
    {
        $rowVector = RowVector::fillZeros(3);
        $this->assertTrue($rowVector instanceof RowVector and $rowVector->size() === 3);
    }
}
