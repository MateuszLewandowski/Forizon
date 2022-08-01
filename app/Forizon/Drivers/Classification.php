<?php

namespace App\Forizon\Drivers;

use App\Forizon\Abstracts\Configuration;
use App\Forizon\Abstracts\Driver;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Models\Classification\{
    Perceptron, Adaline
};

class Classification extends Driver
{
    public function process(Configuration $configuration): array {
        return [];
    }
}
