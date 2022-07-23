<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\Matrix;

class ComparableWithMatrixTest extends TestCase
{
    private array $a = [
        [2, 2, 2],
        [2, 2, 2],
        [2, 2, 2],
    ];

    private array $b = [
        [3, 3, 3],
        [3, 3, 3],
        [3, 3, 3],
    ];

    public function testIsEqualExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->a);
        $a = $a->isEqual($b);
        $is_equal = true;
        foreach ($a->data as $row) {
            foreach ($row as $value) {
                if ($value !== 1.0) {
                    $is_equal = false;
                }
            }
        }
        $this->assertTrue($a instanceof Matrix and $b instanceof Matrix and $is_equal);
    }

    public function testIsNotEqualExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->b);
        $a = $a->isNotEqual($b);
        $is_not_equal = true;
        foreach ($a->data as $row) {
            foreach ($row as $value) {
                if ($value !== 1.0) {
                    $is_not_equal = false;
                }
            }
        }
        $this->assertTrue($a instanceof Matrix and $b instanceof Matrix and $is_not_equal);
    }

    public function testIsGreaterExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->b);
        $a = $a->isGreater($b);
        $is_greater = true;
        foreach ($a->data as $row) {
            foreach ($row as $value) {
                if ($value !== 0.0) {
                    $is_greater = false;
                }
            }
        }
        $this->assertTrue($a instanceof Matrix and $b instanceof Matrix and $is_greater);
    }

    public function testIsGreaterOrEqualExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->a);
        $a = $a->isGreaterOrEqual($b);
        $is_greater_or_equal = true;
        foreach ($a->data as $row) {
            foreach ($row as $value) {
                if ($value !== 1.0) {
                    $is_greater_or_equal = false;
                }
            }
        }
        $this->assertTrue($a instanceof Matrix and $b instanceof Matrix and $is_greater_or_equal);
    }

    public function testIsLessExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->b);
        $a = $a->isLessOrEqual($b);
        $is_less = true;
        foreach ($a->data as $row) {
            foreach ($row as $value) {
                if ($value !== 1.0) {
                    $is_less = false;
                }
            }
        }
        $this->assertTrue($a instanceof Matrix and $b instanceof Matrix and $is_less);
    }

    public function testIsLessOrEqualExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->a);
        $a = $a->isLessOrEqual($b);
        $is_less_or_equal = true;
        foreach ($a->data as $row) {
            foreach ($row as $value) {
                if ($value !== 1.0) {
                    $is_less_or_equal = false;
                }
            }
        }
        $this->assertTrue($a instanceof Matrix and $b instanceof Matrix and $is_less_or_equal);
    }

}
