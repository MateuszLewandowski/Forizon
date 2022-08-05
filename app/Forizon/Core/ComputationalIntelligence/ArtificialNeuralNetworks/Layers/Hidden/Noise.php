<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden;

use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Hidden;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;

class Noise implements Hidden
{
    private int $neurons;

    public function __construct(private float $standard_deviation) {
        try {
            if ($standard_deviation < 0.0) {
                throw new InvalidArgumentException();
            }
        } catch (InvalidArgumentException $e) {
            //
        }
    }

    /**
     * @return integer
     */
    public function getNeurons(): int {
        return $this->neurons;
    }

    /**
     * Initialization of the output layer provides a container of neurons.
     * Output layer in regression contains only one neuron.
     *
     * @todo Exception message and status code.
     * @param integer $neurons
     * @return integer
     */
    public function initialize(int $neurons): int {
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
     * @param Matrix $matrix
     * @return Matrix
     */
    public function feedForward(Matrix $matrix): Matrix {
        return $matrix->add($this->createNoise($matrix->rows, $matrix->columns));
    }

    /**
     * Touching the input layer constitutes sending data deep into the model.
     *
     * @param Matrix $matrix
     * @return Matrix
     */
    public function touch(Matrix $matrix): Matrix {
        return $matrix;
    }

    /**
     * @param Matrix $gradient
     * @param Optimizer $optimizer
     * @return Matrix
     */
    public function backPropagation(Matrix $gradient, Optimizer $optimizer): Matrix {
        return $gradient;
    }

    /**
     * @param integer $rows
     * @param integer $columns
     * @return Matrix
     */
    private function createNoise(int $rows, int $columns): Matrix {
        return Matrix::fillGaussian($rows, $columns)->multiply($this->standard_deviation);
    }
}
