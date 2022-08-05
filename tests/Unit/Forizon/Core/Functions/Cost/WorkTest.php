<?php

namespace Tests\Unit\Forizon\Core\Functions\Cost;

use App\Forizon\System\Services\ClassSearcher;
use App\Forizon\Interfaces\NotImplemented;
use Tests\TestCase;

class WorkTest extends TestCase
{
    private string $namespace = 'Core\Functions\Cost';
    private array $predictions = [.9, .2, .3, .7];
    private array $labels = [.9, .2, .31, .71];
    private float $cost_range = 1.1;

    public function testWorkExpectsSuccess()
    {
        $namespaceClassProviderService = new ClassSearcher($this->namespace);
        $objects = $namespaceClassProviderService->getObjects();
        $flag = true;
        foreach ($objects as $object) {
            if ($object instanceof NotImplemented) {
                continue;
            }
            $result = $object->evaluate($this->predictions, $this->labels);
            if ($result >= $this->cost_range or $result <= -$this->cost_range) {
                $flag = false;
            }
        }
        $this->assertTrue($flag);
    }
}
