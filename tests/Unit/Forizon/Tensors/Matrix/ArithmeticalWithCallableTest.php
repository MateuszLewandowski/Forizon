<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use PHPUnit\Framework\TestCase;
use Tests\Traits\Matrix\CallableMethodAssertTrue;

class ArithmeticalWithCallableTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Arithmetical::class;

    public function testPowMatrixExpectsSuccess()
    {
        $this->runCallable(__FUNCTION__, 2);
    }

    public function testSqrtMatrixExpectsSuccess()
    {
        $this->runCallable(__FUNCTION__);
    }
}
