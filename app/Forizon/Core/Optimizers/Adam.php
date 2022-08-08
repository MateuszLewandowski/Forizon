<?php

namespace App\Forizon\Core\Optimizers;

use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Parameters\Attribute;
use InvalidArgumentException;

/**
 * @see https://towardsdatascience.com/optimizers-for-training-neural-network-59450d71caf6
 *
 * @todo Validation, exceptions.
 */
class Adam implements Optimizer
{
    public array $memory;

    public function __construct(
        private float $learning_rate = .001,
        private float $momentum = .1,
        private float $decay = .001
    ) {
        try {
            if ($learning_rate > 1.0) {
                throw new InvalidArgumentException();
            }
            if ($momentum > 1.0) {
                throw new InvalidArgumentException();
            }
            if ($decay > 1.0) {
                throw new InvalidArgumentException();
            }
        } catch (InvalidArgumentException $e) {
            //
        }
    }

    public function initialize(Attribute $attribute): void
    {
        $class = get_class($attribute->value);
        $template = $class::fillZeros(...$attribute->value->shape());
        $this->memory[$attribute->uuid] = [$template, $template];
    }

    public function run(string $uuid, Tensor $tensor): Tensor
    {
        [$velocity, $norm] = $this->memory[$uuid];
        $velocity = $velocity->multiply($this->momentum)->add($tensor->multiply(1.0 - $this->momentum));
        $norm = $norm->multiply($this->decay)->add($tensor->square()->multiply(1.0 - $this->decay));
        $this->memory[$uuid] = [$velocity, $norm];
        $norm = $norm->sqrt()->lowerRange(1e-8);

        return $velocity->multiply($this->learning_rate)->divide($norm);
    }
}
