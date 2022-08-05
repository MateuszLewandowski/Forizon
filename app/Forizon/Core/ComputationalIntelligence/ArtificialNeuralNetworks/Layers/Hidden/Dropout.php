<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden;

use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Hidden;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;

class Dropout implements Hidden
{
    private int $neurons;
    private Matrix $mask;

    public function __construct(private float $coefficient = 0.5) {
        try {
            if ($coefficient < 0.0 or $coefficient >= 1.0) {
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
        $this->mask = $this->createMask($matrix->rows, $matrix->columns);
        $output = $matrix->multiply($this->mask);
        return $output;
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
        return $this->determineGradient($gradient, $this->mask);
    }

    /**
     * @param Matrix $weights
     * @param Matrix $gradient
     * @return Matrix
     */
    public function determineGradient(Matrix $gradient, Matrix $mask): Matrix {
        return $gradient->multiply($mask);
    }

    private function createMask(int $rows, int $columns): Matrix {
        return Matrix::fillRandomize($rows, $columns)->isGreater($this->coefficient)->multiply(1.0 / (1.0 - $this->coefficient));
    }
}
