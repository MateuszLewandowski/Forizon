<?php

namespace App\Forizon\Validators;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class Configuration
{
    public static function validateBatchSize(int $batch_size): void {
        try {
            if ($batch_size < 1) {
                throw new InvalidArgumentException('Epochs must be greater or equal than 1.', Response::HTTP_BAD_REQUEST);
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public static function validateEpochs(int $epochs): void {
        try {
            if ($epochs < 1) {
                throw new InvalidArgumentException('Epochs must be greater or equal than 1.', Response::HTTP_BAD_REQUEST);
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public static function validateAlpha(float $alpha): void {
        try {
            if ($alpha > 1.0) {
                throw new InvalidArgumentException('Alpha (learning ratio) must be less than 1.0.', Response::HTTP_BAD_REQUEST);
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public static function validateMinimalChange(float $minimal_change): void {
        try {
            if ($minimal_change > 1.0) {
                throw new InvalidArgumentException('Minimal change must be less than 1.0.', Response::HTTP_BAD_REQUEST);
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public static function validateWindow(int $window): void {
        try {
            if ($window < 2) {
                throw new InvalidArgumentException('Window must be greater or equal than 1.', Response::HTTP_BAD_REQUEST);
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public static function validateHoldOut(float $hold_out): void {
        try {
            if ($hold_out <= 0.0 or $hold_out >= 1.0) {
                throw new InvalidArgumentException('Hold out must be within the range x > 0.0 and x < 1.0; x ⊂ (0; 1).', Response::HTTP_BAD_REQUEST);
            }
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }
}
