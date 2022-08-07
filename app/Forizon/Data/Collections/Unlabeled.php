<?php

namespace App\Forizon\Data\Collections;

use App\Abstracts\Data\DatasetCollection;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Unlabeled extends DatasetCollection
{
    public function __construct(array $samples = []) {
        try {
            if (empty($samples)) {
                throw new InvalidArgumentException('Samples can not be empty.', Response::HTTP_BAD_REQUEST);
            }
            $this->samples = $samples;
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function split(float $ratio = 0.2): array {
        $i = (int) floor($ratio * count($this->samples));
        $left = new self(array_slice($this->samples, 0, $i));
        $right = new self(array_slice($this->samples, $i));
        return [$left, $right];
    }

    public function stack(iterable $datasets): self {
        $labels = $samples = [];
        for ($i = 0; $i < count($datasets); $i++) {
            if(empty($dataset)) {
                continue;
            }
            $labels[] = $datasets[$i]->labels;
            $samples[] = $datasets[$i]->samples;
        }
        return new self(array_merge($samples), array_merge($labels));
    }

    public function stratify(): array {
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

    public function batch(int $quantity = 32): array {
        try {
            if ($quantity < 2) {
                throw new InvalidArgumentException('Batches quantity must be greater than 1', Response::HTTP_BAD_REQUEST);
            }
            return [
                new self(...array_chunk($this->samples, $quantity)),
            ];

        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function randomize(): self {
        $order = range(0, count($this->samples) - 1);
        shuffle($order);
        array_multisort(
            $order, $this->samples, $this->labels
        );
        return $this;
    }
}
