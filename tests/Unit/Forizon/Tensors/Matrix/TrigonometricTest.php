<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Interfaces\Core\Tensor\Trigonometric;
use PHPUnit\Framework\TestCase;
use Tests\Traits\Matrix\CallableTrait;

class TrigonometricTest extends TestCase
{
    use CallableTrait;

    private string $target = Trigonometric::class;

    public function testSinExpectsSuccess() { $this->call(__FUNCTION__); }
    public function testAsinExpectsSuccess() { $this->call(__FUNCTION__); }
    public function testCosExpectsSuccess() { $this->call(__FUNCTION__); }
    public function testAcosExpectsSuccess() { $this->call(__FUNCTION__); }
    public function testTanExpectsSuccess() { $this->call(__FUNCTION__); }
    public function testAtanExpectsSuccess() { $this->call(__FUNCTION__); }
}
