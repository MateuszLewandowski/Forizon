<?php

namespace App\Forizon\System\Reports;

use App\Addons\Word;
use App\Forizon\Abstracts\Report;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\NeuralNetwork;
use App\Forizon\Core\Configurations\NeuronConfiguration;
use App\Forizon\Interfaces\Core\NeuralNetwork\Model;
use Prophecy\Exception\Doubler\ClassNotFoundException;

class Regression extends Report
{
    public function __construct(
        private NeuralNetwork $neuralNetwork,
        private NeuronConfiguration $neuronConfiguration,
        private Model $model,
    ) {
    }

    public function generate(): array
    {
        return [
            'Neural Network' => $this->getNeuralNetworkDetails(),
            'Configuration' => $this->getConfigurationDetails(),
            'Regression Model' => $this->getModelDetails(),
        ];
    }

    private function getNeuralNetworkDetails()
    {
        [$input, $hiddens, $output, $optimizer] = get_object_vars($this->neuralNetwork);
        if ($hiddens) {
            $hiddens = [];
            foreach ($hiddens as $component) {
                $hiddens[] = $this->getClassNameAndPropertiesPair($component);
            }
        }

        return [
            'input' => $this->getClassNameAndPropertiesPair($input),
            'hiddens' => $hiddens,
            'output' => $this->getClassNameAndPropertiesPair($output),
            'optimizer' => $this->getClassNameAndPropertiesPair($optimizer),
        ];
    }

    private function getConfigurationDetails(): array
    {
        $unset = ['optimizer', 'input', 'hiddens', 'output', 'used'];
        $properties = get_object_vars($this->neuronConfiguration);
        foreach ($properties as $key => &$property) {
            if (in_array($key, $unset)) {
                unset($properties[$key]);
            }
            if (gettype($property) === 'object') {
                $property = $this->getClassNameAndPropertiesPair($property);
            }
        }

        return $properties;
    }

    private function getModelDetails(): array
    {
        return [
            'best_epoch' => $this->model->best_epoch,
            'best_cost' => $this->model->best_cost,
            'best_loss' => $this->model->best_loss,
            'best_prediction_result' => $this->model->best_prediction_result,
            'history' => $this->model->history,
        ];
    }

    private function getClassNameAndPropertiesPair(mixed $class): array
    {
        try {
            return [
                Word::getClassName($class) => $this->getPropertiesListing($class),
            ];
        } catch (ClassNotFoundException $e) {
            throw $e;
        }
    }
}
