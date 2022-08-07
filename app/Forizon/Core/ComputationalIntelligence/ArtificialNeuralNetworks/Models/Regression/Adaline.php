<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Models\Regression;

use App\Forizon\Abstracts\ComputationalIntelligence\Neuron;
use App\Forizon\Core\Configurations\NeuronConfiguration;
use Illuminate\Support\Collection;

final class Adaline extends Neuron
{
    private bool $is_madaline = false;

    public function __construct(NeuronConfiguration $neuronConfiguration)
    {
    }

    public function train(Collection $collection): array
    {
    }

    public function process(Collection $collection): array
    {
    }

    public function predict(Collection $collection): array
    {
    }
}
