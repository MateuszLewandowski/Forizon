<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output;

use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Output;
use App\Forizon\Core\Functions\Activation\Softmax;
use App\Forizon\Core\Functions\Loss\CrossEntropy;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Interfaces\Core\Tensor;
use Illuminate\Support\Collection;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;
use App\Forizon\Interfaces\Core\Functions\{
    Loss as LossFunction,
    Activation as ActivationFunction,
};

class Multiclassifier implements Output
{
    public function __construct(
        private array $classes,
        private Matrix $input,
        private Matrix $output,
        private ActivationFunction $activationFunction = new Softmax,
        private LossFunction $lossFunction = new CrossEntropy,
    ){
        $this->classes = array_values(array_unique($classes, SORT_REGULAR));
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
            if ($neurons !== count($this->classes)) {
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
        $this->output = $this->activationFunction->use(matrix: $this->input);
        return $this->output;
    }

    /**
     * Touching the input layer constitutes sending data deep into the model.
     *
     * @param Matrix $matrix
     * @return Matrix
     */
    public function touch(Matrix $matrix): Matrix {
        return $this->activationFunction->use($this->input);
    }

    /**
     * @param Collection $expected
     * @param Optimizer $optimizer
     * @return array
     */
    public function backPropagation(Collection $labels, Optimizer $optimizer): array {
        $matched = [];
        for ($i = 0; $i < count($this->classes); $i++) {
            for ($j = 0; $j < $labels->count(); $j++) {
                $matched[$i][$j] = $labels->value($j) === $this->classes[$i] ? 1.0 : 0.0;
            }
        }
        $expected = new Matrix($matched);
        $loss = $this->lossFunction->calculate(output: $this->output, target: $expected);
        $gradient = $this->determineGradient($this->input, $expected);
        return ['loss' => $loss, 'gradient' => $gradient];
    }

    /**
     * @param Matrix $output
     * @param Matrix $expected
     * @return Matrix
     */
    public function determineGradient(Matrix $output, Matrix $expected): Matrix {
        return $this->lossFunction instanceof CrossEntropy
            ? $output->subtract($expected)->divide($output->columns)
            : $this->activationFunction->derivative($this->input, $output)->multiply($this->lossFunction->differentive($output, $expected)->divide($output->columns));
    }
}
