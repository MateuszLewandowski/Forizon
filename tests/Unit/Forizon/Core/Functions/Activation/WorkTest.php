<?php

namespace Tests\Unit\Forizon\Core\Functions\Activation;

use App\Forizon\System\Services\ClassSearcher;
use App\Forizon\Interfaces\NotImplemented;
use App\Forizon\Tensors\Matrix;
use Tests\TestCase;

class WorkTest extends TestCase
{
    private string $namespace = 'Core\Functions\Activation';
    private int $rows = 4;
    private int $columns = 4;
    private float $activation_range = 2.0;

    private function getDefaultsInputAndOutputMatrixes(): array {
        $matrix = Matrix::fillRandomize($this->rows, $this->columns);
        return [clone $matrix, clone $matrix];
    }

    public function testWorkExpectsSuccess() {
        $namespaceClassProviderService = new ClassSearcher($this->namespace);
        $objects = $namespaceClassProviderService->getObjects();
        [$input, $output] = $this->getDefaultsInputAndOutputMatrixes();
        $flag = true;
        foreach ($objects as $object) {
            if ($object instanceof NotImplemented) {
                continue;
            }
            $used = $object->use($input);
            $derivatived = $object->derivative($input, $output);
            if (!$used instanceof Matrix or $used->rows !== $this->rows or $used->columns !== $this->columns) {
                $flag = false;
                break;
            }
            if (!$derivatived instanceof Matrix or $derivatived->rows !== $this->rows or $derivatived->columns !== $this->columns) {
                $flag = false;
                break;
            }
            for ($i = 0; $i < $used->rows; $i++) {
                for ($j = 0; $j < $used->columns; $j++) {
                    if ($used->data[$i][$j] > $this->activation_range or $used->data[$i][$j] < -$this->activation_range) {
                        $flag = false;
                    }
                }
            }
            for ($i = 0; $i < $derivatived->rows; $i++) {
                for ($j = 0; $j < $derivatived->columns; $j++) {
                    if ($derivatived->data[$i][$j] > $this->activation_range or $derivatived->data[$i][$j] < -$this->activation_range) {
                        $flag = false;
                    }
                }
            }

        }
        $this->assertTrue($flag);
    }
}
