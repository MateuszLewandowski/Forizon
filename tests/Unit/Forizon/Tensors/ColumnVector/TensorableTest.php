<?php

namespace Tests\Unit\Forizon\Tensors\ColumnVector;

use App\Forizon\Tensors\ColumnVector;
use Tests\TestCase;

class TensorableTest extends TestCase
{
    private array $data = [
        1.0, 1.0, 1.0,
    ];

    public function testCreateColumnVectorExpectsSuccess()
    {
        $columnVector = ColumnVector::create($this->data);
        $this->assertTrue(
            $columnVector instanceof ColumnVector and
            $columnVector->length === 3 and
            $columnVector->rows === 3 and
            $columnVector->columns === 1
        );
    }

    public function testFastCreateColumnVectorExpectsSuccess()
    {
        $columnVector = ColumnVector::fastCreate($this->data);
        $this->assertTrue(
            $columnVector instanceof ColumnVector and
            $columnVector->length === 3 and
            $columnVector->rows === 3 and
            $columnVector->columns === 1
        );
    }

    public function testFillZerosExpectsSuccess()
    {
        $columnVector = ColumnVector::fillZeros(3);
        $is_filled_zeros = true;
        foreach ($columnVector->data as $value) {
            if ($value !== 0.0) {
                $is_filled_zeros = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_filled_zeros);
    }

    public function testFillOnesExpectsSuccess()
    {
        $columnVector = ColumnVector::FillOnes(3);
        $is_filled_ones = true;
        foreach ($columnVector->data as $value) {
            if ($value !== 1.0) {
                $is_filled_ones = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_filled_ones);
    }

    public function testFillValueExpectsSuccess()
    {
        $columnVector = ColumnVector::fill(3, .5);
        $is_filled_value = true;
        foreach ($columnVector->data as $value) {
            if ($value !== .5) {
                $is_filled_value = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_filled_value);
    }

    public function testRandomizeExpectsSuccess()
    {
        $columnVector = ColumnVector::fillRandomize(3, -1, 1);
        $is_randomized = true;
        foreach ($columnVector->data as $value) {
            if ($value > 1.0 or $value < -1.0) {
                $is_randomized = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_randomized);
    }

    public function testRandmaxExpectsSuccess()
    {
        $columnVector = ColumnVector::fillRandmax(3);
        $is_randmaxed = true;
        foreach ($columnVector->data as $value) {
            if ($value > 1.0 or $value < -1.0) {
                $is_randmaxed = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_randmaxed);
    }

    public function testfillRandomExpectsSuccess()
    {
        $columnVector = ColumnVector::fillRandom(3);
        $is_filled_random = true;
        foreach ($columnVector->data as $value) {
            if ($value > 1.0 or $value < 0.0) {
                $is_filled_random = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_filled_random);
    }

    public function testfillUniformExpectsSuccess()
    {
        $columnVector = ColumnVector::fillUniform(3);
        $is_filled_uniform = true;
        foreach ($columnVector->data as $value) {
            if ($value > 1.0 or $value < -1.0) {
                $is_filled_uniform = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_filled_uniform);
    }

    public function testfillGaussianExpectsSuccess()
    {
        $columnVector = ColumnVector::fillGaussian(3);
        $is_filled_gaussian = true;
        foreach ($columnVector->data as $value) {
            if ($value > 4.0 or $value < -4.0) {
                $is_filled_gaussian = false;
            }
        }
        $this->assertTrue($columnVector instanceof ColumnVector and $is_filled_gaussian);
    }
}
