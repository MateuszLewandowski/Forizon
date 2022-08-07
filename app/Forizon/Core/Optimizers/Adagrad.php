<?php

namespace App\Forizon\Core\Optimizers;

use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Parameters\Attribute;
use App\Forizon\Tensors\Matrix;

/**
 * @see https://towardsdatascience.com/optimizers-for-training-neural-network-59450d71caf6
 */
class Adagrad implements Optimizer
{
    public array $memory;

    private float $learning_rate;

    public function __construct(float $learning_rate = .001)
    {
        $this->learning_rate = $learning_rate;
    }

    public function initialize(Attribute $attribute): void
    {
        $class = get_class($attribute->value);
        $this->memory[$attribute->id] = $class::fillZeros(...$attribute->value->shape());
    }

    public function run(string $id, Tensor $tensor): Matrix
    {
        $norm = $this->memory[$id];
        $norm = $norm->add($tensor->square());
        $this->memory[$id] = $norm;

        return $tensor->multiply($this->learning_rate)->divide($norm->sqrt()->clipLower());
    }
}
