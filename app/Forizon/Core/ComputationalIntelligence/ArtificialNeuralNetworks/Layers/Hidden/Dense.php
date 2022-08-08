<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden;

use App\Forizon\Data\Initializers\XavierOne;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Hidden;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Interfaces\Data\Initializer;
use App\Forizon\Parameters\Attribute;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;
use Psy\Exception\TypeErrorException;
use TypeError;

class Dense implements Hidden
{
    public Attribute $weights;

    public Attribute $biases;

    public function __construct(
        private int $neurons = 32,
        private float $alpha = 0.0,
        private bool $is_biased = true,
        private Initializer $weightInitializer = new XavierOne,
        private Initializer $biasInitializer = new XavierOne,
    ) {
        try {
            if ($neurons < 1) {
                throw new InvalidArgumentException();
            }
            if ($alpha > 1.0 or $alpha < 0.0) {
                throw new InvalidArgumentException();
            }
        } catch (InvalidArgumentException $e) {
            throw $e;
        } catch (TypeError $e) {
            throw $e;
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
            $this->weights = new Attribute($this->weightInitializer->init($this->neurons, $neurons));
            if ($this->is_biased) {
                $this->biases = new Attribute($this->weightInitializer->init($this->neurons, 1)->asColumnVector());
            }
            return $this->neurons;
        } catch (InvalidArgumentException $e) {
            throw $e;
        } catch (TypeError $e) {
            throw $e;
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
        try {
            if ($matrix->columns !== $this->neurons) {
                throw new InvalidArgumentException();
            }
            $this->input = $matrix;
            $output = $this->weights->value->matmul($matrix);
            return $this->is_biased
                ? $output->add($this->biases->value)
                : $output;
        } catch (InvalidArgumentException $e) {
            throw $e;
        } catch (TypeError $e) {
            throw $e;
        }
    }

    /**
     * Touching the input layer constitutes sending data deep into the model.
     *
     * @param  Matrix  $matrix
     * @return Matrix
     */
    public function touch(Matrix $matrix): Matrix
    {
        try {
            if ($matrix->columns !== $this->neurons) {
                throw new InvalidArgumentException();
            }
            $output = $this->weights->value->matmul($matrix);
            return $this->is_biased
                ? $output->add($this->biases->value)
                : $output;
        } catch (InvalidArgumentException $e) {
            throw $e;
        } catch (TypeError $e) {
            throw $e;
        }
    }

    /**
     * @param  Matrix  $gradient
     * @param  Optimizer  $optimizer
     * @return Matrix
     */
    public function backPropagation(Matrix $gradient, Optimizer $optimizer): Matrix
    {
        try {
            $weightsDerivative = $gradient->matmul($this->input->transpose());
            $weights = $this->weights->value;
            if ($this->alpha) {
                $weightsDerivative = $weightsDerivative->add($weights->multiply($this->alpha));
            }
            $this->weights->update($this->weights->value->subtract($optimizer->run($this->weights->uuid, $weightsDerivative)));
            if ($this->is_biased) {
                $this->biases->update($this->biases->value->subtract($optimizer->run($this->weights->uuid, $gradient->sum())));
            }

            return $this->determineGradient($weights, $gradient);
        } catch (TypeError $e) {
            throw $e;
        }
    }

    /**
     * @param  Matrix  $weights
     * @param  Matrix  $gradient
     * @return Matrix
     */
    public function determineGradient(Matrix $weights, Matrix $gradient): Matrix
    {
        try {
            return $weights->transpose()->matmul($gradient);
        } catch (TypeError $e) {
            throw $e;
        }
    }
}
