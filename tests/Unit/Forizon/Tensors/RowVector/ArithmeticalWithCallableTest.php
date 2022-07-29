<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use PHPUnit\Framework\TestCase;
use Tests\Traits\Vector\CallableMethodAssertTrue;
use App\Forizon\Tensors\RowVector;

class ArithmeticalWithCallableTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Arithmetical::class;

    public function testPowRowVectorExpectsSuccess() { $this->runCallable(RowVector::class, __FUNCTION__, 2); }
    public function testSqrtRowVectorExpectsSuccess() { $this->runCallable(RowVector::class, __FUNCTION__); }
}
