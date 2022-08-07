<?php

namespace App\Forizon\Data\Converters;

use Illuminate\Support\Collection;

class Splitter
{
    /**
     * @param  Collection|array  $normalizedCollection
     * @param  int  $batches
     * @param  int  $batch_size
     * @return array<Collection|array>
     */
    public static function batching(Collection|array $normalizedCollection, int $batches, int $batch_size): array
    {
        $is_collection = false;
        if ($normalizedCollection instanceof Collection) {
            $is_collection = true;
            $normalizedCollection = $normalizedCollection->all();
        }
        for ($i = 0; $i < $batches; $i++) {
            for ($j = 0; $j < $batch_size; $j++) {
                $samples[$i][$j] = $normalizedCollection[$i + $j];
            }
            $labels[$i] = $normalizedCollection[$i + $j];
        }

        return $is_collection
            ? [collect($samples), collect($labels)]
            : [$samples, $labels];
    }
}
