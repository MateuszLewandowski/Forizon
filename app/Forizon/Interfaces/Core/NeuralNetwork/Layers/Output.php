<?php

namespace App\Forizon\Interfaces\Core\NeuralNetwork\Layers;

use App\Forizon\Interfaces\Core\Optimizer;
use Illuminate\Support\Collection;

interface Output extends Layer, Workable
{
    public function backPropagation(Collection $labels, Optimizer $optimizer): array;
}
