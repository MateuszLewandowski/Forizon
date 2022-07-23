<?php

namespace App\Forizon\Validators;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class Tensor
{
    /**
     * @throws InvalidArgumentException
     */
    public static function areIdentical(mixed $first, mixed $second): void {
        try {
            if ($first !== $second) {
                throw new InvalidArgumentException('Items are not identical', Response::HTTP_BAD_REQUEST);
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }
}
