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

use App\Forizon\Interfaces\Core\{
    Optimizable
};

/**
 * For perceptrons & adaline
 */
abstract class Neuron {

    /**
     * Training samples quantity
     * 
     * @var int $batch_size > 0
     */
    protected int $batch_size;

    /**
     * The gradient descent optimizer
     * 
     * @var Optimizable
     */
    protected Optimizable $optimizer;

    /**
     * @var int x > 0
     */
    protected int $epochs;

    /**
     * Minimal change in training loss to continue training
     * 
     * @var float
     */
    protected float $minimal_change;

    /**
     * Epochs to wait for improvement validation score
     * 
     * @var int x > 0
     */
    protected float $window;

    /**
     * Training / test ratio
     * 
     * @var float x > 0.0 and x < 1.0
     */
    protected float $hold_out;
}