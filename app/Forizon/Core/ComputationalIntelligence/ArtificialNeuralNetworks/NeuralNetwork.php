<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks;

use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Input;
use App\Forizon\Interfaces\Core\NeuralNetwork\Layers\{
    Placeholder, Output, Layer, Hidden,
};
use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Interfaces\Core\Tensor\Collection;
use App\Forizon\Interfaces\Core\Optimizer;
use Exception;

final class NeuralNetwork
{
    /**
     * Input layer. Placeholder for an input vector.
     *
     * @var Input
     */
    private Placeholder $input;

    /**
     * An array contains hidden layers.
     * - Dense
     * - Activation
     * - Dropout
     * - Noise
     *
     * @var array<Hidden>
     */
    private array $hiddens;

    /**
     * Output layer.
     *
     * @var Output
     */
    private Output $output;

    /**
     * Optimizer
     *
     * @var Optimizer
     */
    private Optimizer $optimizer;

    public function getLayers(): array {
        return [
            $this->input,
            ...$this->hiddens,
            $this->output
        ];
    }

    public function setInputLayer(Placeholder $input): self {
        $this->input = $input;
        return $this;
    }

    public function setOutputLayer(Output $output): self {
        $this->output = $output;
        return $this;
    }

    public function setHiddenLayer(Hidden $hidden): self {
        $this->hidden = $hidden;
        return $this;
    }

    public function initialize(): self {
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

    public function feedForward(Tensor $tensor): Tensor {
        try {
            foreach ($this->getLayers() as $layer) {
                $tensor = $layer->{__FUNCTION__}($tensor);
            }
            return $tensor;
        } catch (Exception $e) {
            // @todo
        }
    }

    public function backPropagation(array $labels): float {
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

    public function cycle(Collection $dataset): float {
        try {
            $input = Matrix::create($dataset->samples)->transpose();
            $this->feedForward($input);
            return $this->backPropagation($dataset->labels);
        } catch (Exception $e) {
            // @todo
        }
    }

    public function touch(Collection $dataset): Tensor {
        try {
            $input = Matrix::create($dataset->samples)->transpose();
            foreach ($this->getLayers() as $layer) {
                $input = $layer->touch($input);
            }
            return $input->transpose();
        } catch (Exception $e) {
            // @todo
        }
    }
}
