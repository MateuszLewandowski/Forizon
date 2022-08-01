<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Models\Regression;

use App\Forizon\Abstracts\ComputationalIntelligence\Neuron;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\{
    Placeholder, Output, Layer, Hidden,
};
use App\Forizon\Core\Distances\NeuronConfiguration;

final class Perceptron extends Neuron
{
    private bool $is_multiperceptron = false;

    public function __construct(NeuronConfiguration $neuronConfiguration)
    {
        foreach ($neuronConfiguration->getAll() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
                continue;
            }
            $neuronConfiguration->unused[] = $key;
        }
    }

    public abstract function train(Collection $dataset): array {

    }

    public abstract function process(Collection $dataset): array {

    }

    public abstract function predict(Collection $dataset): array {

    }
}
