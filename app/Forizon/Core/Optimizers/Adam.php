<?php

namespace App\Forizon\Core\Optimizers;

use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Parameters\Attribute;
use App\Forizon\Interfaces\Core\Tensor;

/**
 * @see https://towardsdatascience.com/optimizers-for-training-neural-network-59450d71caf6
 * @todo Validation, exceptions.
 */
class Adam implements Optimizer
{
    public array $memory;

    private float $learning_rate;
    private float $momentum;
    private float $decay;

    public function __construct(
        float $learning_rate = .001,
        float $momentum = .1,
        float $decay = .001
    ) {
        $this->learning_rate = $learning_rate;
        $this->momentum = $momentum;
        $this->decay = $decay;
    }

    public function init(Attribute $attribute): void {
        $class = get_class($attribute->value);
        $template = $class::fillZeros(...$attribute->value->shape());
        $this->memory[$attribute->id] = [$template, $template];
    }

    public function run(string $id, Tensor $gradient): Tensor {
        [$velocity, $norm] = $this->memory[$id];
        $velocity = $velocity->multiply($this->momentum)->add($gradient->multiply(1.0 - $this->momentum));
        $norm = $norm->multiply($this->decay)->add($gradient->square()->multiply(1.0 - $this->decay));
        $this->memory[$id] = [$velocity, $norm];
        $norm = $norm->sqrt()->lowerRange(1e-8);
        return $velocity->multiply($this->learning_rate)->divide($norm);
    }
}
