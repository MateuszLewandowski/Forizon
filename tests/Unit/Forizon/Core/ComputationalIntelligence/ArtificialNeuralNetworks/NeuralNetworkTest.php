<?php

namespace Tests\Unit\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks;

use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Activation;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output\Continous;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Dense;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Dropout;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Noise;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\NeuralNetwork;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Input;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output\BinaryClassifier;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output\Multiclassifier;
use App\Forizon\Core\Functions\Activation\RectifiedLinearUnit;
use App\Forizon\Core\Functions\Loss\LeastSquares;
use App\Forizon\System\Services\ClassSearcher;
use App\Forizon\Interfaces\NotImplemented;
use App\Forizon\Core\Optimizers\Adam;
use App\Forizon\Tensors\Matrix;
use Tests\TestCase;

class NeuralNetworkTest extends TestCase
{
    private int $rows = 3;
    private int $columns = 3;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateObjectInstanceExpectsSuccess()
    {
        $neuralNetwork = new NeuralNetwork(
            input: new Input(16),
            hiddens: [
                new Dense(32),
                new Activation(new RectifiedLinearUnit),
            ],
            output: new Continous(new LeastSquares),
            optimizer: new Adam,
        );
        $neuralNetwork instanceof NeuralNetwork
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }

    public function testWorkHiddenLayerExpectsSuccess() {
        new NeuralNetwork(
            input: new Input(16),
            hiddens: [
                new Dense(32),
            ],
            output: new Continous(new LeastSquares),
            optimizer: new Adam,
        );
        new NeuralNetwork(
            input: new Input(16),
            hiddens: [
                new Activation(new RectifiedLinearUnit),
            ],
            output: new Continous(new LeastSquares),
            optimizer: new Adam,
        );
        new NeuralNetwork(
            input: new Input(16),
            hiddens: [
                new Dropout(.5),
            ],
            output: new Continous(new LeastSquares),
            optimizer: new Adam,
        );
        new NeuralNetwork(
            input: new Input(16),
            hiddens: [
                new Noise(1.1),
            ],
            output: new Continous(new LeastSquares),
            optimizer: new Adam,
        );
        new NeuralNetwork(
            input: new Input(32),
            hiddens: [
                new Dense(512),
                new Activation(new RectifiedLinearUnit),
                new Dropout(.5),
                new Noise(.5),
            ],
            output: new Continous(new LeastSquares),
            optimizer: new Adam,
        );
        $this->assertTrue(true);
    }

    public function testWorkOutputLayerExpectsSuccess() {
        new NeuralNetwork(
            input: new Input(16),
            hiddens: [
                new Dense(32),
                new Activation(new RectifiedLinearUnit),
            ],
            output: new BinaryClassifier([0, 1]),
            optimizer: new Adam,
        );
        new NeuralNetwork(
            input: new Input(16),
            hiddens: [
                new Dense(32),
                new Activation(new RectifiedLinearUnit),
            ],
            output: new Continous(new LeastSquares),
            optimizer: new Adam,
        );
        new NeuralNetwork(
            input: new Input(16),
            hiddens: [
                new Dense(32),
                new Activation(new RectifiedLinearUnit),
            ],
            output: new Multiclassifier(
                classes: [0, 1, 2],
                input: Matrix::fillRandomize($this->rows, $this->columns),
                output: Matrix::fillRandomize($this->rows, $this->columns),
            ),
            optimizer: new Adam,
        );
        new NeuralNetwork(
            input: new Input(32),
            hiddens: [
                new Dense(512),
                new Activation(new RectifiedLinearUnit),
                new Dropout(.5),
                new Noise(.5),
            ],
            output: new Continous(new LeastSquares),
            optimizer: new Adam,
        );
        $this->assertTrue(true);
    }
}
