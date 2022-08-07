<?php

namespace Tests\Unit\Forizon\Tensors\ColumnVector;

use App\Forizon\Interfaces\Core\Tensor\Algebraic;
use App\Forizon\Tensors\ColumnVector;
use Tests\TestCase;
use Tests\Traits\Vector\CallableMethodAssertTrue;

class AlgebraicTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Algebraic::class;

    public function testAbsExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testSqrtExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testExpExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testLogExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__, 10);
    }

    public function testRoundExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__, 2);
    }

    public function testFloorExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testNegateExpectsSuccess()
    {
        $basic = ColumnVector::fillRandomize(3, 1, 10);
        if (! $basic instanceof ColumnVector) {
            $this->assertTrue(false);
        }
        $mutated = $basic->negate();
        for ($i = 0; $i < $basic->length; $i++) {
            if ($basic->data[$i] !== -$mutated->data[$i]) {
                $this->assertTrue(false);
            }
        }
        $this->assertTrue(true);
    }
}
