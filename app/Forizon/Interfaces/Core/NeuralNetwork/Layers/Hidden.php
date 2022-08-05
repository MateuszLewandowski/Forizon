<?php

namespace App\Forizon\Interfaces\Core\NeuralNetwork\Layers;

use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Tensors\Matrix;

interface Hidden extends Layer, Workable {
    public function backPropagation(Matrix $gradient, Optimizer $optimizer): Matrix;
    // public function determineGradient(Matrix $weights, Matrix $gradient): Matrix;
}
