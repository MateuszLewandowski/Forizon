<?php

namespace App\Forizon\Validators;

use App\Abstracts\Data\DatasetCollection;
use App\Forizon\Data\Collections\Labeled;
use App\Forizon\Data\Collections\Unlabeled;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class Dataset
{
    /**
     * @param  mixed  $first
     * @param  mixed  $second
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public static function isCorrectlyNormalized(DatasetCollection $datasetCollection): void
    {
        try {
            if ($datasetCollection instanceof Labeled) {
                if (empty($datasetCollection->samples) or empty($datasetCollection->labels)) {
                    throw new InvalidArgumentException('Samples nor labels can not be empty.', Response::HTTP_BAD_REQUEST);
                }
                if (count($datasetCollection->samples) !== count($datasetCollection->labels)) {
                    throw new InvalidArgumentException('Samples and labels array must contain the same row quantity.', Response::HTTP_BAD_REQUEST);
                }
            } elseif ($datasetCollection instanceof Unlabeled) {
                if (empty($datasetCollection->samples)) {
                    throw new InvalidArgumentException('Samples can not be empty.', Response::HTTP_BAD_REQUEST);
                }
            } else {
                // ?
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }
}
