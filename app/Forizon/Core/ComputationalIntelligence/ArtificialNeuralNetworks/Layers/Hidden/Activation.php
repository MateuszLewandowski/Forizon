<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden;

use App\Forizon\Core\Functions\Activation\RectifiedLinearUnit;
use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Hidden;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;

/**
 * @see https://towardsdatascience.com/forward-propagation-in-neural-networks-simplified-math-and-code-version-bbcfef6f9250
 */
class Activation implements Hidden
{
    private int $neurons;

    private Matrix $input;

    private Matrix $output;

    public function __construct(
        private ActivationFunction $activationFunction = new RectifiedLinearUnit,
    ) {
    }

    /**
     * @return int
     */
    public function getNeurons(): int
    {
        return $this->neurons;
    }

    /**
     * Initialization of the output layer provides a container of neurons.
     * Output layer in regression contains only one neuron.
     *
     * @todo Exception message and status code.
     *
     * @param  int  $neurons
     * @return int
     */
    public function initialize(int $neurons): int
    {
        try {
            if ($neurons < 1) {
                throw new InvalidArgumentException();
            }
            $this->neurons = $neurons;

            return $this->neurons;
        } catch (InvalidArgumentException $e) {
            //
        }
    }

    /**
     * Feeding forward represents the transfer of neurons deep into the model.
     *
     * @param  Matrix  $matrix
     * @return Matrix
     */
    public function feedForward(Matrix $matrix): Matrix
    {
        $this->output = $this->activationFunction->use($matrix);
        $this->input = $matrix;

        return $this->output;
    }

    /**
     * Touching the input layer constitutes sending data deep into the model.
     *
     * @param  Matrix  $matrix
     * @return Matrix
     */
    public function touch(Matrix $matrix): Matrix
    {
        return $this->activationFunction->use($matrix);
    }

    /**
     * @param  Matrix  $gradient
     * @param  Optimizer  $optimizer
     * @return Matrix
     */
    public function backPropagation(Matrix $gradient, Optimizer $optimizer): Matrix
    {
        return $this->determineGradient($this->input, $this->output, $gradient);
    }

    /**
     * @param  Matrix  $input
     * @param  Matrix  $output
     * @param  Matrix  $expected
     * @return Matrix
     */
    public function determineGradient(Matrix $input, Matrix $output, Matrix $expected): Matrix
    {
        return $this->activationFunction->derivative($input, $output)->multiply($expected);
    }
}
