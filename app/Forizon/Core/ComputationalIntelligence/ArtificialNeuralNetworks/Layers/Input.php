<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers;

use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Placeholder;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;

class Input implements Placeholder
{
    /**
     * Neurons quantity.
     *
     * @var integer
     */
    private int $neurons;

    public function __construct(int $neurons) {
        try {
            if ($neurons < 1) {
                throw new InvalidArgumentException();
            }
            $this->neurons = $neurons;
        } catch (InvalidArgumentException $e) {

        }
    }

    /**
     * @return integer
     */
    public function getNeurons(): int {
        return $this->neurons;
    }

    /**
     * Initialization of the input layer provides a container of neurons.
     *
     * @param integer $neurons
     * @return integer
     */
    public function initialize(int $neurons): int {
        return $this->neurons;
    }

    /**
     * Feeding forward represents the transfer of neurons deep into the model.
     *
     * @param Matrix $matrix
     * @return Matrix
     */
    public function feedForward(Matrix $matrix): Matrix {
        try {
            if ($matrix->rows !== $this->neurons) {
                throw new InvalidArgumentException();
            }
            return $matrix;
        } catch (InvalidArgumentException $e) {

        }
    }

    /**
     * Touching the input layer constitutes sending data deep into the model.
     *
     * @param Matrix $matrix
     * @return Matrix
     */
    public function touch(Matrix $matrix): Matrix {
        return $this->feedForward($matrix);
    }
}
