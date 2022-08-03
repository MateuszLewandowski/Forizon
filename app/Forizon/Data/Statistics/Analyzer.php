<?php

namespace App\Forizon\Data\Statistics;

use Illuminate\Support\Collection;

class Analyzer
{
    private Collection $collection;

    /**
     * @todo Validation.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection) {
        $this->collection = $collection;
    }

    /**
     * Return the minimum value from the loaded collection.
     *
     * @return array|float
     */
    public function min(): float {
        return (float) $this->collection->min();
    }

    /**
     * Return the maximum value from the loaded collection.
     *
     * @return array|float
     */
    public function max(): float {
        return (float) $this->collection->max();
    }

    /**
     * Return extremes (min and max values) from the loaded collection.
     *
     * @return array
     */
    public function extremes(bool $keyless = false): array {
        if ($keyless) {
            return [
                $this->min(), $this->max(),
            ];
        }
        return [
            'min' => $this->min(),
            'max' => $this->max(),
        ];
    }

    /**
     * @return float
     */
    public function mean(): float {
        return $this->sum() / $this->count();
    }

    /**
     * @see https://www.mathsisfun.com/data/standard-deviation.html
     *
     * @return float
     */
    public function variance(): float {
        $mean = $this->mean();
        $squared = $this->collection->map(function ($value) use ($mean) {
            $subtract = $value - $mean;
            return $subtract * $subtract;
        });
        return $squared->sum() / $squared->count();
    }

    /**
     * @return integer
     */
    public function count(): int {
        return $this->collection->count();
    }

    /**
     * @return integer
     */
    public function uniqueValuesCount(): int {
        return $this->collection->unique()->count();
    }

    /**
     * @return float
     */
    public function median(): float {
        return $this->collection->median();
    }

    /**
     * @return float
     */
    public function average(): float {
        return $this->collection->average();
    }

    /**
     * @return float
     */
    public function sum(): float {
        return $this->collection->sum();
    }
}
