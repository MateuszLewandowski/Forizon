<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use Tests\TestCase;
use App\Forizon\Tensors\Matrix;

class TensorableTest extends TestCase
{
    private array $symmetric_matrix_data = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
    ];

    private array $asymmetric_matrix_data = [
        [1, 2, 3],
        [4, 5, 6],
    ];
    public function testCreateMatrixWithSymmetricDataExpectsSuccess()
    {
        $matrix = Matrix::create($this->symmetric_matrix_data);
        $this->assertTrue(
            $matrix instanceof Matrix   and
            $matrix->rows === 3         and
            $matrix->columns === 3
        );
    }

    public function testCreateMatrixWithAsymmetricDataExpectsSuccess()
    {
        $matrix = Matrix::create($this->asymmetric_matrix_data);
        $this->assertTrue(
            $matrix instanceof Matrix   and
            $matrix->rows === 2         and
            $matrix->columns === 3
        );
    }

    public function testFastCreateMatrixWithSymmetricDataExpectsSuccess()
    {
        $matrix = Matrix::fastCreate($this->symmetric_matrix_data);
        $this->assertTrue(
            $matrix instanceof Matrix   and
            $matrix->rows === 3         and
            $matrix->columns === 3
        );
    }

    public function testFastCreateMatrixWithAsymmetricDataExpectsSuccess()
    {
        $matrix = Matrix::fastCreate($this->asymmetric_matrix_data);
        $this->assertTrue(
            $matrix instanceof Matrix   and
            $matrix->rows === 2         and
            $matrix->columns === 3
        );
    }

    public function testFillZerosExpectsSuccess()
    {
        $matrix = Matrix::fillZeros(3, 3);
        $is_filled_zeros = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== 0.0) {
                    $is_filled_zeros = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_filled_zeros);
    }

    public function testFillOnesExpectsSuccess()
    {
        $matrix = Matrix::FillOnes(3, 3);
        $is_filled_ones = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== 1.0) {
                    $is_filled_ones = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_filled_ones);
    }

    public function testFillValueExpectsSuccess()
    {
        $matrix = Matrix::fill(3, 3, .5);
        $is_filled_value = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value !== .5) {
                    $is_filled_value = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_filled_value);
    }

    public function testRandomizeExpectsSuccess()
    {
        $matrix = Matrix::fillRandomize(3, 3, -1, 1, 2);
        $is_randomized = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value > 1.0 or $value < -1.0) {
                    $is_randomized = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_randomized);
    }

    public function testRandmaxExpectsSuccess()
    {
        $matrix = Matrix::randmax(3, 3);
        $is_randmaxed = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value > 1.0 or $value < -1.0) {
                    $is_randmaxed = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_randmaxed);
    }

    public function testfillRandomExpectsSuccess()
    {
        $matrix = Matrix::fillRandom(3, 3);
        $is_filled_random = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value > 1.0 or $value < 0.0) {
                    $is_filled_random = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_filled_random);
    }

    public function testfillUniformExpectsSuccess()
    {
        $matrix = Matrix::fillUniform(3, 3);
        $is_filled_uniform = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value > 1.0 or $value < -1.0) {
                    $is_filled_uniform = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_filled_uniform);
    }

    public function testfillGaussianExpectsSuccess()
    {
        $matrix = Matrix::fillGaussian(3, 3);
        $is_filled_gaussian = true;
        foreach ($matrix->data as $row) {
            foreach ($row as $value) {
                if ($value > 4.0 or $value < -4.0) {
                    $is_filled_gaussian = false;
                }
            }
        }
        $this->assertTrue($matrix instanceof Matrix and $is_filled_gaussian);
    }
}
