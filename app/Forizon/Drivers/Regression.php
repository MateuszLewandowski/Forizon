<?php

namespace App\Forizon\Drivers;

use App\Forizon\Abstracts\Configuration;
use App\Forizon\Abstracts\Driver;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Models\Regression\{
    Perceptron, Adaline
};

class Regression extends Driver
{
    public function __construct()
    {

    }

    public function process(Configuration $configuration): array {
        $model = ucfirst($configuration->model);
    }
}
