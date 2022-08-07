<?php

namespace App\Forizon\Core\Configurations;

use App\Forizon\Abstracts\Configuration;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Activation;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Dense;
use App\Forizon\Interfaces\Core\Configurations\NeuralNetworkConfiguration;
use App\Forizon\Interfaces\Core\Functions\Cost as CostFunction;
use App\Forizon\Interfaces\Core\Functions\Loss as LossFunction;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Output;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Placeholder;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Validators\Configuration as Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Psy\Exception\TypeErrorException;

class NeuronConfiguration extends Configuration implements NeuralNetworkConfiguration
{
    private const REQUIRED = [
        'model', 'optimizer', 'lossFunction', 'costFunction', 'input', 'output',
    ];

    /**
     * @todo Exception message and status code.
     *
     * @param  array  $properties
     */
    public function __construct(array $properties)
    {
        try {
            foreach ($properties as $key => $value) {
                if (! property_exists($this, $key)) {
                    Log::warning("Attempt to assign a value to a non-existent key {$key} in NeuronConfiguration.");

                    continue;
                }
                $method = Str::camel(implode('', ['validate', ucfirst($key)]));
                if (method_exists(Validator::class, $method)) {
                    Validator::{$method}($value);
                }
                if ($key === 'hiddens') {
                    $required = [Dense::class => false, Activation::class => false];
                    foreach ($value as $layer) {
                        foreach ($required as $name => &$flag) {
                            if ($layer instanceof $name) {
                                $flag = true;
                            }
                        }
                    }
                    foreach ($required as $flag) {
                        if ($flag === false) {
                            throw new InvalidArgumentException();
                        }
                    }
                }
                $this->set($key, $value);
            }
            foreach (self::REQUIRED as $name) {
                if (! in_array($name, $this->used)) {
                    throw new InvalidArgumentException();
                }
            }
            unset($this->used);
        } catch (InvalidArgumentException $e) {
            //
        } catch (TypeErrorException $e) {
            //
        }
    }

    /**
     * Model name
     *
     * @var string
     */
    protected string $model;

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
     *
     * @var LossFunction
     */
    protected LossFunction $lossFunction;

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
}
