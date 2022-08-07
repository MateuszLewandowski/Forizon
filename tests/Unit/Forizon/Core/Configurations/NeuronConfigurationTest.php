<?php

namespace Tests\Unit\Forizon\Core\Configurations;

use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Activation;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Dense;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Dropout;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Noise;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Input;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output\Continous;
use App\Forizon\Core\Configurations\NeuronConfiguration;
use App\Forizon\Core\Functions\Activation\LeakyRectifiedLinearUnit;
use App\Forizon\Core\Functions\Cost\MeanSquaredError;
use App\Forizon\Core\Functions\Loss\Huber;
use App\Forizon\Core\Functions\Loss\LeastSquares;
use App\Forizon\Core\Optimizers\Adam;
use PHPUnit\Framework\TestCase;

class NeuronConfigurationTest extends TestCase
{
    private function getBasicConfigurationWithOneHiddenLayerAndFilledCriticalParameters(): array
    {
        return [
            'model' => 'perceptron',
            'batch_size' => 16,
            'epochs' => 100,
            'alpha' => 1e-4,
            'minimal_change' => 1e-4,
            'window' => 5,
            'hold_out' => .2,
            'randomize' => true,
            'optimizer' => new Adam,
            'lossFunction' => new Huber,
            'costFunction' => new MeanSquaredError,
            'input' => new Input(neurons: 32),
            'hiddens' => [
                new Dense(neurons: 32, alpha: .001, is_biased: true),
                new Activation(new LeakyRectifiedLinearUnit(leaky: .15)),
                new Noise(standard_deviation: .1),
                new Dropout(coefficient: .2),
            ],
            'output' => new Continous(new LeastSquares),
        ];
    }

    public function testCreateCollectionConfigurationInstanceExpectsSuccess()
    {
        $collectionConfiguration = new NeuronConfiguration($this->getBasicConfigurationWithOneHiddenLayerAndFilledCriticalParameters());
        $flag = true;
        $config = $collectionConfiguration->getPropertiesAsArray();
        foreach ($this->getBasicConfigurationWithOneHiddenLayerAndFilledCriticalParameters() as $key => $value) {
            if (! isset($config[$key])) {
                $flag = false;
                break;
            }
            if (gettype($value) === 'object' and $value != $config[$key]) {
                $flag = false;
                break;
            }
            if (gettype($value) === 'array' and $value != $config[$key]) {
                $flag = false;
                break;
            }
            if (gettype($value) !== 'object' and gettype($value) !== 'array' and $value !== $config[$key]) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($collectionConfiguration instanceof NeuronConfiguration and $flag);
    }
}
