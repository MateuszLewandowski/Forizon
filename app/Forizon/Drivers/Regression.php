<?php

namespace App\Forizon\Drivers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Forizon\Abstracts\Core\CollectionConfiguration;
use App\Forizon\Interfaces\Core\NeuralNetwork\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Forizon\Abstracts\Configuration;
use App\Forizon\Abstracts\Data\Loader;
use App\Forizon\Abstracts\Driver;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Models\Regression\{
    Perceptron, Adaline
};

class Regression extends Driver
{
    private Model $model;
    private Loader $loader;

    public function __construct(private CollectionConfiguration $collectionConfiguration) {
        $this->initializeLoader();
    }

    public function process(Configuration $configuration): array {
        $class = ucfirst($configuration->model);
        $this->model = new $class(neuronConfiguration: $configuration, collection: $collection);
    }

    private function initializeLoader(): void {
        try {
            if (class_exists($this->collectionConfiguration->source)) {
                $loader = new $this->collectionConfiguration->source;
                $this->loader = new $loader($this->collectionConfiguration);
                return;
            }
            throw new ModelNotFoundException();
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

}
