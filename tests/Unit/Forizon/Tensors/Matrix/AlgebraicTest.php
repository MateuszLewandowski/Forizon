<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use Tests\TestCase;
use App\Forizon\Interfaces\Core\Tensor\Algebraic;
use Tests\Traits\Matrix\CallableMethodAssertTrue;
use App\Forizon\Tensors\Matrix;

class AlgebraicTest extends TestCase
{
    use CallableMethodAssertTrue;

    private string $target = Algebraic::class;

    public function testAbsExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testSqrtExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testExpExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testLogExpectsSuccess() { $this->runCallable(__FUNCTION__, 10); }
    public function testRoundExpectsSuccess() { $this->runCallable(__FUNCTION__, 2); }
    public function testFloorExpectsSuccess() { $this->runCallable(__FUNCTION__); }
    public function testNegateExpectsSuccess() {
        $basic = Matrix::fillRandomize(3, 3, 1, 10);
        if (!$basic instanceof Matrix) {
            $this->assertTrue(false);
        }
        $mutated = $basic->negate();
        for ($i = 0; $i < $basic->rows; $i++) {
            for ($j = 0; $j < $mutated->columns; $j++) {
                if ($basic->data[$i][$j] !== -$mutated->data[$i][$j]) {
                    $this->assertTrue(false);
                }
            }
        }
        $this->assertTrue(true);
     }
}
