<?php

namespace App\Forizon\Validators;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class Tensor
{
    /**
     * @param  mixed  $first
     * @param  mixed  $second
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public static function areIdentical(mixed $first, mixed $second): void
    {
        try {
            if ($first !== $second) {
                throw new InvalidArgumentException('Items are not identical.', Response::HTTP_BAD_REQUEST);
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }
}
