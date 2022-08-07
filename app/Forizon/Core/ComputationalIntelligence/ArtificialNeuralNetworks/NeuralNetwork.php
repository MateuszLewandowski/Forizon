<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks;

use App\Abstracts\Data\DatasetCollection;
use App\Forizon\Core\Optimizers\Adam;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Output;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\Placeholder;
use App\Forizon\Interfaces\Core\Optimizer;
use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Tensors\Matrix;
use Exception;

final class NeuralNetwork
{
    public function __construct(
        private Placeholder $input,
        private array $hiddens,
        private Output $output,
        private Optimizer $optimizer = new Adam,
    ) {
    }

    public function getLayers(): array
    {
        return [
            $this->input,
            ...$this->hiddens,
            $this->output,
        ];
    }

    public function initialize(): self
    {
        $input = 1;
        foreach ($this->getLayers() as $layer) {
            $input = $layer->initialize($input);
            $weights = 'weights';
            $biases = 'biases';
            if (property_exists($layer, $weights)) {
                $this->optimizer->initialize($layer->{$weights});
            }
            if (property_exists($layer, $biases)) {
                $this->optimizer->initialize($layer->{$biases});
            }
        }

        return $this;
    }

    public function feedForward(Tensor $tensor): Tensor
    {
        try {
            foreach ($this->getLayers() as $layer) {
                $tensor = $layer->{__FUNCTION__}($tensor);
            }

            return $tensor;
        } catch (Exception $e) {
            // @todo
        }
    }

    public function backPropagation(array $labels): float
    {
        try {
            [$loss, $gradient] = $this->output->{__FUNCTION__}($labels, $this->optimizer);
            foreach (array_reverse($this->getLayers()) as $layer) {
                $gradient = $layer->{__FUNCTION__}($gradient, $this->optimizer);
            }

            return $loss;
        } catch (Exception $e) {
            // @todo
        }
    }

    public function cycle(DatasetCollection $datasetCollection): float
    {
        try {
            $input = Matrix::create($datasetCollection->samples)->transpose();
            $this->feedForward($input);

            return $this->backPropagation($datasetCollection->labels);
        } catch (Exception $e) {
            // @todo
        }
    }

    public function touch(DatasetCollection $datasetCollection): Tensor
    {
        try {
            $input = Matrix::create($datasetCollection->samples)->transpose();
            foreach ($this->getLayers() as $layer) {
                $input = $layer->touch($input);
            }

            return $input->transpose();
        } catch (Exception $e) {
            // @todo
        }
    }
}
