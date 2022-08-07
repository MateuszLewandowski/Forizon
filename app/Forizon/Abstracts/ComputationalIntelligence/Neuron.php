<?php

namespace App\Forizon\Abstracts\ComputationalIntelligence;

// use App\Forizon\Core\Optimizers\{
//     AdaDelta, Adagrad, Adam, GradientDescent, MiniBatchGradientDescent, Momentum, NesterovAcceleratedGradient, StochasticGradientDescent
// };
// use App\Forizon\Core\Functions\Activation\{
//     BinaryStep, ExponentialLinearUnit, Gauss, HyperbolicTangent, LeakyRectifiedLinearUnit, Linear, ParametricRectifiedLinearUnit, RectifiedLinearUnit,
//     ScaledExponentialLinearUnit, Sigmoid, Softmax, SoftPlus, Softsign, Swish, ThresholdedRectifiedLinearUnit
// };
// use App\Forizon\Core\Functions\Cost\{
//     BinaryCrossEntropyCost, CategoricalCrossEnthopyCost, MeanAbsoluteError, MeanError, MeanSquaredError, MedianAbsoluteError, RootMeanSquaredError, RSquared, SymmetricMeanAbsolutePercentageError
// };
// use App\Forizon\Core\Functions\Loss\{
//     CrossEntropy, Exponentional, Hellinger, Huber, KullbackLeibler, LeastSquares, Quadratic
// };
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\NeuralNetwork;
use App\Forizon\Interfaces\Core\Functions\Cost as CostFunction;
use App\Forizon\Interfaces\Core\Functions\Loss as LossFunction;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Output;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Placeholder;
use App\Forizon\Interfaces\Core\Optimizer;
use InvalidArgumentException;

/**
 * For perceptrons & adaline.
 */
abstract class Neuron
{
    /**
     * Training samples quantity
     *
     * @var int > 0; default 16.
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
     *
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
     *
     * @var CostFunction
     */
    protected CostFunction $costFunction;

    /**
     * Input layer - A placeholder for the an input vector.
     *
     * @var Placeholder
     */
    protected Placeholder $input;

    /**
     * Array that contains only hidden layers
     *
     * @var array<Hidden>
     */
    protected array $hiddens;

    /**
     * Output layer
     *
     * @var Output
     */
    protected Output $output;

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

    protected int $best_epoch = 0;

    protected float $best_cost;

    protected float $best_loss;

    protected float $previous_loss;

    protected ?array $trainingDataset;

    protected ?array $testingDataset = null;

    protected ?array $predictingDataset = null;

    protected array $best_prediction_result;

    abstract public function train(): self;

    abstract public function process(): self;

    abstract public function predict(): self;

    protected function setEpochHistoryStamp(int $epoch, float $loss, float $cost, int $window_step, string $stop_condition): void
    {
        $this->history[] = [
            'epoch' => $epoch,
            'loss' => $loss,
            'cost' => $cost,
            'window_step' => $window_step,
            'stop_condition' => $stop_condition,
        ];

    }

    protected function generatePredictions(): array
    {
        try {
            if (is_null($this->datasetCollection)) {
                throw new InvalidArgumentException();
            }

            return array_column($this->neuralNetwork->touch($this->datasetCollection)->data, 0);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }
}
