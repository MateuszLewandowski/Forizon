<?php

namespace App\Forizon\Interfaces\Core\NeuralNetwork\Layers;

use App\Forizon\Tensors\Matrix;

interface Layer
{
    public function initialize(int $neurons): int;

    public function feedForward(Matrix $matrix): Matrix;

    public function touch(Matrix $matrix): Matrix;

    public function getNeurons(): int;
}
