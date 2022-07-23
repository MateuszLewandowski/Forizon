<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Interfaces\Core\Tensor\Trigonometric;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Matrix\CallableMethodAssertTrue;

class TrigonometricTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Trigonometric::class;

    public function testSinExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testAsinExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testCosExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testAcosExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testTanExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testAtanExpectsSuccess() { $this->runCallable(__FUNCTION__); }
}
