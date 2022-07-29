<?php

namespace Tests\Unit\Forizon\Tensors\RowVector;

use Tests\TestCase;
use App\Forizon\Tensors\RowVector;

class TensorableTest extends TestCase
{
    private array $data = [
        1.0, 1.0, 1.0
    ];

    public function testCreateRowVectorExpectsSuccess()
    {
        $rowVector = RowVector::create($this->data);
        $this->assertTrue(
            $rowVector instanceof RowVector     and
            $rowVector->length === 3            and
            $rowVector->rows === 1              and
            $rowVector->columns === 3
        );
    }

    public function testFastCreateRowVectorExpectsSuccess()
    {
        $rowVector = RowVector::fastCreate($this->data);
        $this->assertTrue(
            $rowVector instanceof RowVector     and
            $rowVector->length === 3            and
            $rowVector->rows === 1              and
            $rowVector->columns === 3
        );
    }

    public function testFillZerosExpectsSuccess()
    {
        $rowVector = RowVector::fillZeros(3);
        $is_filled_zeros = true;
        foreach ($rowVector->data as $value) {
            if ($value !== 0.0) {
                $is_filled_zeros = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_filled_zeros);
    }

    public function testFillOnesExpectsSuccess()
    {
        $rowVector = RowVector::FillOnes(3);
        $is_filled_ones = true;
        foreach ($rowVector->data as $value) {
            if ($value !== 1.0) {
                $is_filled_ones = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_filled_ones);
    }

    public function testFillValueExpectsSuccess()
    {
        $rowVector = RowVector::fill(3, .5);
        $is_filled_value = true;
        foreach ($rowVector->data as $value) {
            if ($value !== .5) {
                $is_filled_value = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_filled_value);
    }

    public function testRandomizeExpectsSuccess()
    {
        $rowVector = RowVector::fillRandomize(3, -1, 1);
        $is_randomized = true;
        foreach ($rowVector->data as $value) {
            if ($value > 1.0 or $value < -1.0) {
                $is_randomized = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_randomized);
    }

    public function testRandmaxExpectsSuccess()
    {
        $rowVector = RowVector::fillRandmax(3);
        $is_randmaxed = true;
        foreach ($rowVector->data as $value) {
            if ($value > 1.0 or $value < -1.0) {
                $is_randmaxed = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_randmaxed);
    }

    public function testfillRandomExpectsSuccess()
    {
        $rowVector = RowVector::fillRandom(3);
        $is_filled_random = true;
        foreach ($rowVector->data as $value) {
            if ($value > 1.0 or $value < 0.0) {
                $is_filled_random = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_filled_random);
    }

    public function testfillUniformExpectsSuccess()
    {
        $rowVector = RowVector::fillUniform(3);
        $is_filled_uniform = true;
        foreach ($rowVector->data as $value) {
            if ($value > 1.0 or $value < -1.0) {
                $is_filled_uniform = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_filled_uniform);
    }

    public function testfillGaussianExpectsSuccess()
    {
        $rowVector = RowVector::fillGaussian(3);
        $is_filled_gaussian = true;
        foreach ($rowVector->data as $value) {
            if ($value > 4.0 or $value < -4.0) {
                $is_filled_gaussian = false;
            }
        }
        $this->assertTrue($rowVector instanceof RowVector and $is_filled_gaussian);
    }
}
