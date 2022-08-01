<?php

namespace App\Forizon\Core\Configurations;

use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Input;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Output;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Abstracts\Configuration;
use App\Forizon\Interfaces\Core\Functions\{
    Loss as LossFunction,
    Cost as CostFunction,
};

class NeuronConfiguration extends Configuration
{
    protected string $model;

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
    protected int $window = 5;

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
     * Input layer - A placeholder for the an input vector.
     *
     * @var Input
     */
    protected Input $input;

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
}
