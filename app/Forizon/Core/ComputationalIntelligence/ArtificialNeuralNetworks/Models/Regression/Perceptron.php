<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Models\Regression;

use App\Forizon\Abstracts\ComputationalIntelligence\Neuron;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Core\Configurations\NeuronConfiguration;
use Illuminate\Support\Collection;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\{
    Placeholder, Output, Layer, Hidden,
};

final class Perceptron extends Neuron
{
    public function __construct(NeuronConfiguration $neuronConfiguration)
    {

    }

    public function train(Collection $collection): array {

    }

    public function process(Collection $collection): array {

    }

    public function predict(Collection $collection): array {

    }
}
