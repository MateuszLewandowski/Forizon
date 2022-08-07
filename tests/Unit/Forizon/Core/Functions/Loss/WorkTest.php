<?php

namespace Tests\Unit\Forizon\Core\Functions\Loss;

use App\Forizon\System\Services\ClassSearcher;
use App\Forizon\Interfaces\NotImplemented;
use App\Forizon\Tensors\Matrix;
use Tests\TestCase;

class WorkTest extends TestCase
{
    private string $namespace = 'Core\Functions\Loss';
    private int $rows = 4;
    private int $columns = 4;
    private float $loss_range = 12.0;

    private function getDefaultsInputAndOutputMatrixes(): array {
        $matrix = Matrix::fillRandomize($this->rows, $this->columns);
        return [clone $matrix, clone $matrix];
    }

    public function testWorkExpectsSuccess()
    {
        $namespaceClassProviderService = new ClassSearcher($this->namespace);
        $objects = $namespaceClassProviderService->getObjects();
        [$input, $output] = $this->getDefaultsInputAndOutputMatrixes();
        $flag = true;
        foreach ($objects as $object) {
            if ($object instanceof NotImplemented) {
                continue;
            }
            $calculated = $object->calculate($input, $output);
            $differentive = $object->differentive($input, $output);
            if ($calculated > $this->loss_range or $calculated < -$this->loss_range) {
                $flag = false;
                break;
            }
            if (!$differentive instanceof Matrix or $differentive->rows !== $this->rows or $differentive->columns !== $this->columns) {
                $flag = false;
                break;
            }
            for ($i = 0; $i < $differentive->rows; $i++) {
                for ($j = 0; $j < $differentive->columns; $j++) {
                    if ($differentive->data[$i][$j] > $this->loss_range or $differentive->data[$i][$j] < -$this->loss_range) {
                        $flag = false;
                    }
                }
            }
        }
        $this->assertTrue($flag);
    }
}
