<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output;

use App\Forizon\Interfaces\Core\Functions\Loss as LossFunction;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Output;
use App\Forizon\Core\Functions\Loss\LeastSquares;
use App\Forizon\Interfaces\Core\Optimizer;
use Illuminate\Support\Collection;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;

class Continous implements Output
{
    private int $neurons;
    private Matrix $input;

    public function __construct(
        private LossFunction $lossFunction = new LeastSquares,
    ){}

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
            if ($neurons !== 1) {
                throw new InvalidArgumentException();
            }
            $this->neurons = $neurons;
            return $this->neurons;
        } catch (InvalidArgumentException $e) {

        }
    }

    /**
     * Feeding forward represents the transfer of neurons deep into the model.
     *
     * @param Matrix $matrix
     * @return Matrix
     */
    public function feedForward(Matrix $matrix): Matrix {
        return $matrix;
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

    /**
     * @param Collection $expected
     * @param Optimizer $optimizer
     * @return array
     */
    public function backPropagation(Collection $labels, Optimizer $optimizer): array {
        $expected = new Matrix([$labels->all()]);
        $loss = $this->lossFunction->calculate($this->input, $expected);
        $gradient = $this->determineGradient($this->input, $expected);
        return ['loss' => $loss, 'gradient' => $gradient];
    }

    /**
     * @param Matrix $output
     * @param Matrix $expected
     * @return Matrix
     */
    public function determineGradient(Matrix $output, Matrix $expected): Matrix {
        return $this->lossFunction->differentive($output, $expected)->divide($output->columns);
    }
}
