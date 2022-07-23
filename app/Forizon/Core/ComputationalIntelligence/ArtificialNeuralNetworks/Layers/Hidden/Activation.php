<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden;

use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Hidden;
use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Parameters\DelayedFunction;

/**
 * @see https://towardsdatascience.com/forward-propagation-in-neural-networks-simplified-math-and-code-version-bbcfef6f9250
 */
class Activation implements Hidden
{
    public int $length;
    private Matrix $input;
    private Matrix $output;
    private ActivationFunction $activationFunction;

    public function __construct(ActivationFunction $activationFunction) {
        $this->activationFunction = $activationFunction;
    }

    public function set(int $length): int {
        $this->length = $length;
        return $length;
    }

    public function forwardPropagation(Matrix $matrix): Matrix {
        $this->input = $matrix;
        $this->output = $this->activationFunction->use($this->input);
        return $this->output;
    }

    public function backPropagation(DelayedFunction $delayedGradient, Optimizer $optimizer): DelayedFunction {
        return new DelayedFunction(
            [$this, 'gradient'],
            [$this->input, $this->output, $delayedGradient]
        );
    }

    private function gradient(Matrix $input, Matrix $output, DelayedFunction $delayedGradient): Matrix {
        return $this->activationFunction->derivative($input, $output)->multiply($delayedGradient);
    }

    public function touch(Matrix $matrix): Matrix {
        return $this->activationFunction->use($matrix);
    }
}
