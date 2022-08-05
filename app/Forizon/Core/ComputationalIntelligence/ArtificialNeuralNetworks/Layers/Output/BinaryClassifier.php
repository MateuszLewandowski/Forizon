<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output;

use App\Forizon\Interfaces\Core\Functions\Activation as ActivationFunction;
use App\Forizon\Interfaces\Core\Functions\Loss as LossFunction;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Output;
use App\Forizon\Core\Functions\Activation\Sigmoid;
use App\Forizon\Core\Functions\Loss\CrossEntropy;
use App\Forizon\Interfaces\Core\Optimizer;
use Illuminate\Support\Collection;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;

class BinaryClassifier implements Output
{
    private int $neurons;

    public function __construct(
        private array $classes,
        private LossFunction $lossFunction = new CrossEntropy,
        private ActivationFunction $activationFunction = new Sigmoid,
    ){
        try {
            $classes = array_values(array_unique($classes));
            if (count($classes) !== 2) {
                throw new InvalidArgumentException();
            }
            $this->classes = $classes;
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
        $this->input = $matrix;
        $this->output = $this->activationFunction->use($matrix);
        return $this->output;
    }

    /**
     * Touching the input layer constitutes sending data deep into the model.
     *
     * @param Matrix $matrix
     * @return Matrix
     */
    public function touch(Matrix $matrix): Matrix {
        return $this->activationFunction->use($matrix);
    }

    /**
     * @param Collection $expected
     * @param Optimizer $optimizer
     * @return array
     */
    public function backPropagation(Collection $labels, Optimizer $optimizer): array {
        $classes = [];
        foreach ($labels->all() as $label) {
            $classes = $this->classes[$label];
        }
        $expected = new Matrix([$classes]);
        $loss = $this->lossFunction->calculate($this->output, $expected);
        $gradient = $this->determineGradient($this->input, $this->output, $expected);
        return ['loss' => $loss, 'gradient' => $gradient];
    }

    /**
     * @param Matrix $input
     * @param Matrix $output
     * @param Matrix $expected
     * @return Matrix
     */
    public function determineGradient(Matrix $input, Matrix $output, Matrix $expected): Matrix {
        return $this->lossFunction instanceof CrossEntropy
            ? $output->subtract($expected)->divide($output->columns)
            : $this->activationFunction->derivative($input, $output)->multiply(
                $this->lossFunction->differentive($output, $expected)->divide($output->columns)
            );
    }
}
