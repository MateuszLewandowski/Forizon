<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use Tests\TestCase;
use App\Forizon\Interfaces\Core\Tensor\Algebraic;
use App\Forizon\Tensors\RowVector;
use Tests\Traits\Vector\CallableMethodAssertTrue;

class AlgebraicTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Algebraic::class;

    public function testAbsExpectsSuccess() { $this->runCallable(RowVector::class, __FUNCTION__); }
    public function testSqrtExpectsSuccess() { $this->runCallable(RowVector::class, __FUNCTION__); }
    public function testExpExpectsSuccess() { $this->runCallable(RowVector::class, __FUNCTION__); }
    public function testLogExpectsSuccess() { $this->runCallable(RowVector::class, __FUNCTION__, 10); }
    public function testRoundExpectsSuccess() { $this->runCallable(RowVector::class, __FUNCTION__, 2); }
    public function testFloorExpectsSuccess() { $this->runCallable(RowVector::class, __FUNCTION__); }
    public function testNegateExpectsSuccess() {
        $basic = RowVector::fillRandomize(3, 1, 10);
        if (!$basic instanceof RowVector) {
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
