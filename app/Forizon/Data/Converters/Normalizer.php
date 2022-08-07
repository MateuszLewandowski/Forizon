<?php

namespace App\Forizon\Data\Converters;

use App\Forizon\Data\Statistics\Analyzer;
use Illuminate\Support\Collection;

/**
 * @see https://en.wikipedia.org/wiki/Normalization_(statistics)
 */
class Normalizer
{
    /**
     * @var Analyzer
     */
    private Analyzer $analyzer;

    /**
     * @var Collection
     */
    private Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
        $this->analyzer = new Analyzer($this->collection);
    }

    /**
     * Min-max normalization (features scaling) [0, 1]
     *
     * @see https://stackoverflow.com/questions/39355942/denormalize-data
     *
     * @return Collection
     */
    public function minMaxFeatureScaling(bool $return_as_array = false): Collection
    {
        [$min, $max] = $this->analyzer->extremes(keyless: true);
        $collection = $this->collection;
        $collection = $collection->map(function ($value) use ($min, $max) {
            return ($value - $min) / ($max - $min);
        });

        return $return_as_array === true
            ? $collection->all()
            : $collection;
    }

    /**
     * @param  Collection  $normalizedCollection
     * @return Collection
     */
    public function minMaxFeatureDescaling(Collection $normalizedCollection, bool $return_as_array = false): Collection
    {
        [$min, $max] = $this->analyzer->extremes(keyless: true);
        $normalizedCollection = $normalizedCollection->map(function ($value) use ($min, $max) {
            return $value * ($max - $min) + $min;
        });

        return $return_as_array === true
            ? $normalizedCollection->all()
            : $normalizedCollection;
    }
}
