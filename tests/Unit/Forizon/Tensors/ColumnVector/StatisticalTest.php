<?php

namespace Tests\Unit\Forizon\Tensors\ColumnVector;

use App\Forizon\Tensors\ColumnVector;
use PHPUnit\Framework\TestCase;

class StatisticalTest extends TestCase
{
    public function testMeanExpectsSuccess()
    {
        $basic = ColumnVector::fill(3, 2.0);
        $mutated = $basic->mean();
        $basic = $basic->sum() / $basic->length;
        $this->assertTrue($basic === $mutated);
    }

    public function testVarianceExpectsSuccess()
    {
        $basic = ColumnVector::fillRandomize(32, 1, 10);
        $mean = $basic->mean();
        $mutated = $basic->variance($mean);
        $basic = $basic->subtractScalar($mean)
            ->square()
            ->sum() / $basic->size();
        $this->assertTrue($basic === $mutated);
    }

    // public function testQuantileExpectsSuccess()
    // {
    //     $q = .5;
    //     $basic = Matrix::randomize(32, 32, 0.01, 10.0);
    //     $mutated = $basic->quantile($q);
    //     $x = $q * ($basic->columns - 1) + 1;
    //         $y = (int) $x;
    //         $remainder = $x - $y;
    //         $data = [];
    //         foreach ($basic->data as $row) {
    //             sort($row);
    //             $z = $row[$y - 1];
    //             $data[] = $z + $remainder * ($row[$y] - $z);
    //         }
    //     $basic = ColumnVector::fastCreate($data);
    //     $flag = true;
    //     for ($i = 0; $i < $basic->rows; $i++) {
    //         if ($basic->data[$i] !== $mutated->data[$i]) {
    //             $this->assertTrue(false);
    //         }
    //     }
    //     $this->assertTrue($basic instanceof ColumnVector and $mutated instanceof ColumnVector and $flag);
    // }
}
