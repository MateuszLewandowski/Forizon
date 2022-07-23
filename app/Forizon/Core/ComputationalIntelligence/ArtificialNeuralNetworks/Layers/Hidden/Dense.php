<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden;

use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Hidden;

class Dense implements Hidden {

    public function __construct(
        int $length,
        float $alpha = 0.0,
        bool $bias = true,
    ) {

    }
}
