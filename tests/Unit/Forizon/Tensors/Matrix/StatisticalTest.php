<?php

namespace Tests\Unit\Forizon\Tensors\Matrix;

use App\Forizon\Tensors\ColumnVector;
use PHPUnit\Framework\TestCase;
use App\Forizon\Tensors\Matrix;

class StatisticalTest extends TestCase
{
    public function testMeanExpectsSuccess()
    {
        $basic = Matrix::fill(3, 3, 2.0);
        $mutated = $basic->mean();
        $basic = $basic->sum()->divide($basic->columns);
        $flag = true;
        for ($i = 0; $i < $basic->rows; $i++) {
            if ($basic->data[$i] !== $mutated->data[$i]) {
                $this->assertTrue(false);
            }
        }
        $this->assertTrue($basic instanceof ColumnVector and $mutated instanceof ColumnVector and $flag);
    }

    public function testVarianceExpectsSuccess()
    {
        $basic = Matrix::fillRandomize(32, 32, 1, 10);
        $mean = $basic->mean();
        $mutated = $basic->variance($mean);
        $basic = $basic->subtractColumnVector($mean)
            ->square()
            ->sum()
            ->divide($basic->rows);
        $flag = true;
        for ($i = 0; $i < $basic->rows; $i++) {
            if ($basic->data[$i] !== $mutated->data[$i]) {
                $this->assertTrue(false);
            }
        }
        $this->assertTrue($basic instanceof ColumnVector and $mutated instanceof ColumnVector and $flag);
    }

    public function testQuantileExpectsSuccess()
    {
        $q = .5;
        $basic = Matrix::fillRandomize(32, 32, 1, 10);
        $mutated = $basic->quantile($q);
        $x = $q * ($basic->columns - 1) + 1;
            $y = (int) $x;
            $remainder = $x - $y;
            $data = [];
            foreach ($basic->data as $row) {
                sort($row);
                $z = $row[$y - 1];
                $data[] = $z + $remainder * ($row[$y] - $z);
            }
        $basic = ColumnVector::fastCreate($data);
        $flag = true;
        for ($i = 0; $i < $basic->rows; $i++) {
            if ($basic->data[$i] !== $mutated->data[$i]) {
                $this->assertTrue(false);
            }
        }
        $this->assertTrue($basic instanceof ColumnVector and $mutated instanceof ColumnVector and $flag);
    }
}
