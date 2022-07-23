<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\Matrix;

class ArithmeticalWithMatrixTest extends TestCase
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

    public function testAddMatrixExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->b);
        $ab = $a->add($b);
        $as_added_up = true;
        foreach ($ab->data as $row) {
            foreach ($row as $value) {
                if ($value !== 5.0) {
                    $as_added_up = false;
                }
            }
        }
        $this->assertTrue($ab instanceof Matrix and $as_added_up);
    }

    public function testSubtractMatrixExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->b);
        $ab = $a->subtract($b);
        $as_added_up = true;
        foreach ($ab->data as $row) {
            foreach ($row as $value) {
                if ($value !== -1.0) {
                    $as_added_up = false;
                }
            }
        }
        $this->assertTrue($ab instanceof Matrix and $as_added_up);
    }

    public function testMultiplyMatrixExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->b);
        $ab = $a->multiply($b);
        $as_added_up = true;
        foreach ($ab->data as $row) {
            foreach ($row as $value) {
                if ($value !== 6.0) {
                    $as_added_up = false;
                }
            }
        }
        $this->assertTrue($ab instanceof Matrix and $as_added_up);
    }

    public function testDivideMatrixExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $b = Matrix::create($this->b);
        $ab = $a->divide($b);
        $as_added_up = true;
        foreach ($ab->data as $row) {
            foreach ($row as $value) {
                if ($value !== 2/3) {
                    $as_added_up = false;
                }
            }
        }
        $this->assertTrue($ab instanceof Matrix and $as_added_up);
    }

    public function testPowMatrixExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $ab = $a->pow(2);
        $as_added_up = true;
        foreach ($ab->data as $row) {
            foreach ($row as $value) {
                if ($value !== 4.0) {
                    $as_added_up = false;
                }
            }
        }
        $this->assertTrue($ab instanceof Matrix and $as_added_up);
    }

    public function testSqrtMatrixExpectsSuccess()
    {
        $a = Matrix::create($this->a);
        $ab = $a->sqrt();
        $as_added_up = true;
        foreach ($ab->data as $row) {
            foreach ($row as $value) {
                if ($value !== sqrt(2.0)) {
                    $as_added_up = false;
                }
            }
        }
        $this->assertTrue($ab instanceof Matrix and $as_added_up);
    }
}
