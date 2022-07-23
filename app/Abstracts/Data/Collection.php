<?php

namespace App\Abstracts\Data;

use Illuminate\Support\ItemNotFoundException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

abstract class Collection
{
    /**
     * @var float[] $samples
     */
    public array $samples = [];

    /**
     * @var float[] $labels
     */
    public array $labels = [];

    /**
     * @var float[] $features
     */
    public array $features = [];

    public abstract function split(float $ratio = 0.2): array;
    public abstract function stack(iterable $dataset): self;
    public abstract function stratify(): array;
    public abstract function batch(int $quantity = 32): array;
    public abstract function randomize(): self;

    public function size(): int {
        return count($this->samples) * count($this->features);
    }

    public function shape(): array {
        return [
            count($this->samples), count($this->features)
        ];
    }

    public function sample(int $row, int $column): float {
        try {
            if ($row < 1 or $column < 1) {
                throw new ItemNotFoundException('row and column number must be a positive.', Response::HTTP_BAD_REQUEST);
            }
            if (isset($this->samples[$row][$column])) {
                return $this->samples[$row][$column];
            }
            throw new ItemNotFoundException('There is no sample with index like that.', Response::HTTP_BAD_REQUEST);
        } catch(ItemNotFoundException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function feature(int $i): array {
        try {
            if ($i < 1) {
                throw new ItemNotFoundException('index number must be a positive number.', Response::HTTP_BAD_REQUEST);
            }
            if (isset($this->samples[$i])) {
                return array_column($this->samples, $i);
            }
            throw new ItemNotFoundException('There is no sample with index like that.', Response::HTTP_BAD_REQUEST);
        } catch(ItemNotFoundException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function classes(): array {
        return array_values(array_unique($this->labels, SORT_REGULAR));
    }

    public function transpose(array $data = []) {
        if (empty($data)) {
            return $data;
        }
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[0]); $j++) {
                $result[$j][$i] = $data[$i][$j];
            }
        }
        return $result;
    }
}
