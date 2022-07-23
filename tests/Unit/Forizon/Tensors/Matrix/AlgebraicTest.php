<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use Tests\TestCase;
use App\Forizon\Tensors\Matrix;

class AlgebraicTest extends TestCase
{
    public function testAbsExpectsSuccess()
    {
        $matrix = Matrix::randomize(3, 3, -10.0, 10.0);
        $matrix_abs = $matrix->abs();
        $is_abs = true;
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                if (abs($matrix->data[$i][$j]) !== $matrix_abs->data[$i][$j]) {
                    $is_abs = false;
                }
            }
        }
        $this->assertTrue($matrix_abs instanceof Matrix and $is_abs);
    }

    public function testSqrtExpectsSuccess()
    {
        $matrix = Matrix::fill(3, 3, 9.0)->sqrt();
        $is_sqrt = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== 3.0) {
                    $is_sqrt = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_sqrt);
    }

    public function testExpExpectsSuccess()
    {
        $matrix = Matrix::fill(3, 3, 1.0)->exp();
        $is_exp = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== exp(1.0)) {
                    $is_exp = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_exp);
    }

    public function testLogExpectsSuccess()
    {
        $matrix = Matrix::fill(3, 3, 10.0)->log(10);
        $is_log = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== 1.0) {
                    $is_log = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_log);
    }

    public function testRoundExpectsSuccess()
    {
        $matrix = Matrix::fill(3, 3, 1.1234567)->round(3);
        $is_round = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== 1.123) {
                    $is_round = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_round);
    }

    public function testFloorExpectsSuccess()
    {
        $matrix = Matrix::fill(3, 3, 3.9)->floor();
        $is_floor = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== 3.0) {
                    $is_floor = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_floor);
    }

    public function testCeilExpectsSuccess()
    {
        $matrix = Matrix::fill(3, 3, 3.1)->ceil();
        $is_ceil = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== 4.0) {
                    $is_ceil = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_ceil);
    }

    public function testNegateExpectsSuccess()
    {
        $matrix = Matrix::fill(3, 3, -2)->negate();
        $is_negate = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== 2.0) {
                    $is_negate = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_negate);
    }
}
