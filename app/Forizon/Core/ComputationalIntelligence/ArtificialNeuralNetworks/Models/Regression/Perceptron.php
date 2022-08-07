<?php

namespace App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Models\Regression;

use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output\Continous;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\NeuralNetwork;
use App\Forizon\System\Reports\Regression as RegressionReport;
use App\Forizon\Abstracts\ComputationalIntelligence\Neuron;
use App\Forizon\Core\Configurations\NeuronConfiguration;
use App\Forizon\Interfaces\Core\NeuralNetwork\Model;
use App\Forizon\Data\Converters\Normalizer;
use App\Abstracts\Data\DatasetCollection;
use App\Forizon\Data\Converters\Splitter;
use App\Forizon\Data\Collections\Labeled;
use Illuminate\Support\Collection;
use InvalidArgumentException;


final class Perceptron extends Neuron implements Model
{
    private DatasetCollection $datasetCollection;
    private bool $is_multiperceptron = false;
    private Normalizer $normalizer;
    private array $predictions;

    public function __construct(
        private NeuronConfiguration $neuronConfiguration,
        private Collection $collection,
    ) {
        try {
            foreach ($neuronConfiguration->getPropertiesAsObject() as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
            if (!empty($this->hiddens)) {
                $this->is_multiperceptron = true;
            }
            $this->normalizer = new Normalizer($collection);
            $normalizedCollection = $this->normalizer->minMaxFeatureScaling(return_as_array: true);
            [$samples, $labels] = Splitter::batching(normalizedCollection: $normalizedCollection->all(), batches: $this->batches, batch_size: $this->batch_size);
            $this->datasetCollection = new Labeled(samples: $samples, labels: $labels);

            /**
             * @todo Normalize collection calling service and creating Labeled or Unlabeled dataset object.
             */
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }

    public function train(): self {
        try {
            if (is_null($this->datasetCollection)) {
                throw new InvalidArgumentException();
            }
            $this->neuralNetwork = new NeuralNetwork(
                input: $this->input,
                hiddens: $this->hiddens,
                output: $this->output ?: new Continous,
                optimizer: $this->optimizer
            );
            $this->neuralNetwork->initialize();
            return $this;
        } catch (InvalidArgumentException $e) {
            throw $e;
        }

    }

    public function process(): self {
        try {
            if (is_null($this->datasetCollection)) {
                throw new InvalidArgumentException();
            }
            [$trainingDataset, $testingDataset] = $this->datasetCollection->randomize()->split(ratio: $this->hold_out);
            for ($epoch = 1; $epoch <= $this->epochs; $epoch++) {
                $cost = 0.0;
                $loss = 0.0;
                $window_step = 0;
                foreach ($trainingDataset->randomize()->batch($this->batch_size) as $i => $batch) {
                    $loss += $this->neuralNetwork->cycle($batch);
                }
                if ($loss /= $i < $this->best_loss) {
                    $this->best_loss = $loss;
                }
                if ($testingDataset->samples) {
                    $prediction = $this->generatePredictions($testingDataset);
                    $cost = $this->costFunction->evaluate($prediction, $testingDataset->labels);
                    $this->costs[$epoch] = $cost;
                    if ($cost > 0.0) {
                        $this->setEpochHistoryStamp(epoch: $epoch, loss: $loss, cost: $cost, window_step: $window_step, stop_condition: 'cost > 0.0');
                        break;
                    }
                    if ($cost > $this->best_cost) {
                        $this->best_cost = $cost;
                        $this->best_epoch = $epoch;
                        $this->best_prediction_result = $prediction;
                        $window_step = 0;
                    } else {
                        $window_step++;
                    }
                    if ($window_step >= $this->window) {
                        $this->setEpochHistoryStamp(epoch: $epoch, loss: $loss, cost: $cost, window_step: $window_step, stop_condition: 'window step > given window');
                        break;
                    }
                }
                $this->setEpochHistoryStamp(epoch: $epoch, loss: $loss, cost: $cost, window_step: $window_step, stop_condition: '-');
            }
            return $this;
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }

    public function report(): array {
        $regressionReport = new RegressionReport(neuralNetwork: $this->neuralNetwork, neuronConfiguration: $this->neuronConfiguration, model: $this);
        return $regressionReport->generate();
    }

    public function predict(): self {
        $this->predictions = $this->generatePredictions();
        return $this;
    }
}
