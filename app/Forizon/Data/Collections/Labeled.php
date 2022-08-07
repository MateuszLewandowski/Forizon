<?php

namespace App\Forizon\Data\Collections;

use App\Abstracts\Data\DatasetCollection;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class Labeled extends DatasetCollection
{
    public function __construct(array $samples = [], array $labels = [])
    {
        try {
            if (empty($samples) or empty($labels)) {
                throw new InvalidArgumentException('Samples nor labels can not be empty.', Response::HTTP_BAD_REQUEST);
            }
            if (count($samples) !== count($labels)) {
                throw new InvalidArgumentException('Samples and labels array must contain the same row quantity.', Response::HTTP_BAD_REQUEST);
            }
            $samples = array_values($samples);
            foreach ($samples as $row => &$sample) {
                $sample = is_array($sample) ? array_values($sample) : [$sample];
            }
            $this->samples = $samples;
            $this->labels = array_values($labels);
            $this->features = $this->transpose($this->samples);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * Veryfi if that splitting is correct (testing - training switch positions?)
     *
     * @param  float  $ratio
     * @return array<Labeled,Labeled>
     */
    public function split(float $ratio = 0.2): array
    {
        $i = (int) floor($ratio * count($this->samples)) + 1;
        $training = new self(
            array_slice($this->samples, 0, $i),
            array_slice($this->labels, 0, $i)
        );
        $testing = new self(
            array_slice($this->samples, $i),
            array_slice($this->labels, $i)
        );

        return [$training, $testing];
    }

    public function stack(iterable $datasets): self
    {
        try {
            $labels = $samples = [];
            foreach ($datasets as $i => $dataset) {
                if (! $dataset instanceof Labeled) {
                    throw new InvalidArgumentException('Dataset must be labeled', Response::HTTP_BAD_REQUEST);
                }
                if (empty($dataset->samples)) {
                    continue;
                }
                $labels[] = $dataset->labels;
                $samples[] = $dataset->samples;
            }

            return new self(array_merge(...$samples), array_merge(...$labels));
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function stratify(): array
    {
        $data = [];
        foreach ($this->labels as $i => $label) {
            $data[$label][] = $this->samples[$i];
        }
        foreach ($data as $label => &$stratum) {
            $labels = array_fill(0, count($stratum), $label);
            $stratum = new self($stratum, $labels);
        }

        return $data;
    }

    public function batch(int $quantity = 32): array
    {
        try {
            if ($quantity < 2) {
                throw new InvalidArgumentException('Batches quantity must be greater than 1', Response::HTTP_BAD_REQUEST);
            }

            return [
                new self(...array_chunk($this->samples, $quantity)),
                new self(...array_chunk($this->labels, $quantity)),
            ];
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function randomize(): self
    {
        $order = range(0, $this->samples_quantity - 1);
        shuffle($order);
        array_multisort(
            $order, $this->samples, $this->labels
        );

        return $this;
    }

    public function create(array $samples = [], array $labels = []): self
    {
        return new self($samples, $labels);
    }
}
