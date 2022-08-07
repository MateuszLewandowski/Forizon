<?php

namespace Tests\Unit\Forizon\Tensors\ColumnVector;

use App\Forizon\Interfaces\Core\Tensor\Trigonometric;
use App\Forizon\Tensors\ColumnVector;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Vector\CallableMethodAssertTrue;

class TrigonometricTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Trigonometric::class;

    public function testSinExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testAsinExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testCosExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testAcosExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testTanExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }

    public function testAtanExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }
}
