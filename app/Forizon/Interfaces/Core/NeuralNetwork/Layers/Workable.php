<?php

namespace App\Forizon\Interfaces\Core\NeuralNetwork\Layers;

use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Tensors\Matrix;
use Illuminate\Support\Collection;

interface Workable
{
    public function backPropagation(Collection $expected, Optimizer $optimizer): array;
    public function determineGradient(Matrix $output, Matrix $expected): Matrix;
}
