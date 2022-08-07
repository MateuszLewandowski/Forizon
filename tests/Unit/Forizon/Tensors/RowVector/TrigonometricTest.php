<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use App\Forizon\Interfaces\Core\Tensor\Trigonometric;
use App\Forizon\Tensors\RowVector;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Vector\CallableMethodAssertTrue;

class TrigonometricTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Trigonometric::class;

    public function testSinExpectsSuccess()
    {
        $this->runCallable(RowVector::class, __FUNCTION__);
    }

    public function testAsinExpectsSuccess()
    {
        $this->runCallable(RowVector::class, __FUNCTION__);
    }

    public function testCosExpectsSuccess()
    {
        $this->runCallable(RowVector::class, __FUNCTION__);
    }

    public function testAcosExpectsSuccess()
    {
        $this->runCallable(RowVector::class, __FUNCTION__);
    }

    public function testTanExpectsSuccess()
    {
        $this->runCallable(RowVector::class, __FUNCTION__);
    }

    public function testAtanExpectsSuccess()
    {
        $this->runCallable(RowVector::class, __FUNCTION__);
    }
}
