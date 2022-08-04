<?php

namespace App\Forizon\Abstracts\ComputationalIntelligence;

use App\Forizon\Core\Optimizers\{
    AdaDelta, Adagrad, Adam, GradientDescent, MiniBatchGradientDescent, Momentum, NesterovAcceleratedGradient, StochasticGradientDescent
};
use App\Forizon\Core\Functions\Activation\{
    BinaryStep, ExponentialLinearUnit, Gauss, HyperbolicTangent, LeakyRectifiedLinearUnit, Linear, ParametricRectifiedLinearUnit, RectifiedLinearUnit,
    ScaledExponentialLinearUnit, Sigmoid, Softmax, SoftPlus, Softsign, Swish, ThresholdedRectifiedLinearUnit
};
use App\Forizon\Core\Functions\Cost\{
    BinaryCrossEntropyCost, CategoricalCrossEnthopyCost, MeanAbsoluteError, MeanError, MeanSquaredError, MedianAbsoluteError, RootMeanSquaredError, RSquared, SymmetricMeanAbsolutePercentageError
};
use App\Forizon\Core\Functions\Loss\{
    CrossEntropy, Exponentional, Hellinger, Huber, KullbackLeibler, LeastSquares, Quadratic
};
use App\Forizon\Interfaces\Core\Functions\{
    Loss as LossFunction,
    Cost as CostFunction,
};
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\NeuralNetwork;
use App\Forizon\Interfaces\Core\Optimizer;
use Illuminate\Support\Collection;

/**
 * For perceptrons & adaline.
 */
abstract class Neuron
{
    /**
     * Training samples quantity
     *
     * @var int $batch_size > 0; default 16.
     */
    protected int $batch_size = 16;

    /**
     * @var int x > 0; default 100.
     */
    protected int $epochs = 100;

    /**
     * Learning ratio
     *
     * @var float default 1e-4
     */
    protected float $alpha = 1e-4;

    /**
     * Minimal change in training loss to continue training.
     *
     * @var float default 1e-4
     */
    protected float $minimal_change = 1e-4;

    /**
     * Epochs to wait for improvement validation score.
     *
     * @var int x > 0; default 5
     */
    protected float $window = 5;

    /**
     * Training / test ratio
     *
     * @var float x > 0.0 and x < 1.0; default .2
     */
    protected float $hold_out = .2;

    /**
     * Randomize training set before getting batch.
     *
     * @var bool default true
     */
    protected bool $randomize = true;

    /**
     * The gradient descent optimizer.
     *
     * @var Optimizer
     */
    protected Optimizer $optimizer;

    /**
     * @todo description
     * @var LossFunction
     */
    protected LossFunction $lossFunction;

    /**
     * Additional loss functions results excepts main LossFunction.
     *
     * @var array
     */
    protected array $losses;

    /**
     * @todo description
     * @var CostFunction
     */
    protected CostFunction $costFunction;

    /**
     * Additional cost functions results excepts main CostFunction.
     *
     * @var array
     */
    protected array $costs;

    /**
     * Results of every epoch.
     *
     * @var array
     */
    protected array $history;

    /**
     * A complete network state at the time.
     *
     * @var array
     */
    protected array $snapshoot;

    /**
     * Neural network instance.
     *
     * @var NeuralNetwork
     */
    protected NeuralNetwork $neuralNetwork;

    public abstract function train(Collection $collection): array;
    public abstract function process(Collection $collection): array;
    public abstract function predict(Collection $collection): array;
}
