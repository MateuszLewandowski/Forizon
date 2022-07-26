<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden;

use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Hidden;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;

class Noise implements Hidden
{
    private int $neurons;

    public function __construct(private float $standard_deviation = 1.0)
    {
        try {
            if ($standard_deviation < 0.0) {
                throw new InvalidArgumentException();
            }
        } catch (InvalidArgumentException $e) {
            //
        }
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
        return $matrix->add($this->generateNoise($matrix->rows, $matrix->columns));
    }

    /**
     * Touching the input layer constitutes sending data deep into the model.
     *
     * @param  Matrix  $matrix
     * @return Matrix
     */
    public function touch(Matrix $matrix): Matrix
    {
        return $matrix;
    }

    /**
     * @param  Matrix  $gradient
     * @param  Optimizer  $optimizer
     * @return Matrix
     */
    public function backPropagation(Matrix $gradient, Optimizer $optimizer): Matrix
    {
        return $gradient;
    }

    /**
     * @param  int  $rows
     * @param  int  $columns
     * @return Matrix
     */
    private function generateNoise(int $rows, int $columns): Matrix
    {
        return Matrix::fillGaussian($rows, $columns)->multiply($this->standard_deviation);
    }
}
