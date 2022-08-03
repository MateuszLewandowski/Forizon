<?php

namespace Tests\Unit\Forizon\Core\Configurations;

use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Input;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\{
    Activation, Dense, Dropout, Noise
};
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output\{
    BinaryClassifier, Continous, Multiclassifier
};
use App\Forizon\Core\Optimizers\Adam;
use App\Forizon\Core\Functions\Loss\Huber;
use App\Forizon\Core\Functions\Cost\MeanSquaredError;
use PHPUnit\Framework\TestCase;

class NeuronConfigurationTest extends TestCase
{
    private function getBasicConfiguration(): array {
        return [
            'batch_size' => 16,
            'epochs' => 100,
            'alpha' => 1e-4,
            'minimal_change' => 1e-4,
            'window' => 5,
            'hold_out' => .2,
            'randomize' => true,
            'optimizer' => new Adam(),
            'lossFunction' => new Huber(),
            'costFunction' => new MeanSquaredError(),
            'input' => new Input,
            'hiddens' => [

            ],
            'output' => 100,
        ];
    }

    public function testCreateCollectionConfigurationInstanceExpectsSuccess()
    {
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $flag = true;
        $config = $collectionConfiguration->getPropertiesAsArray();
        foreach ($this->basic_configuration as $key => $value) {
            if ($value !== $config[$key]) {
                $flag = false;
            }
        }
        $this->assertTrue($collectionConfiguration instanceof CollectionConfiguration and $flag);
    }
}
