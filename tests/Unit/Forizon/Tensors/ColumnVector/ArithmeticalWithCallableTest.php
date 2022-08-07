<?php

namespace Tests\Unit\Forizon\Tensors\ColumnVector;

use App\Forizon\Tensors\ColumnVector;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Vector\CallableMethodAssertTrue;

class ArithmeticalWithCallableTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Arithmetical::class;

    public function testPowColumnVectorExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__, 2);
    }

    public function testSqrtColumnVectorExpectsSuccess()
    {
        $this->runCallable(ColumnVector::class, __FUNCTION__);
    }
}
