<?php

namespace App\Forizon\Abstracts\Tensors;

use App\Forizon\Tensors\ColumnVector;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Tensors\RowVector;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

/**
 * For perceptrons & adaline
 */
abstract class Vector {

    /**
     * @var float[] $data
     */
    public array $data;

    /**
     * @var int $rows
     */
    public int $rows;

    /**
     * @var int $columns
     */
    public int $columns;

    /**
     * @var int $length
     */
    public int $length;

    public final function shape(): array {
        return [$this->rows * $this->columns];
    }

    public final function size(): int {
        return $this->rows * $this->columns;
    }

    /**
     * Arithmetic by matrix
     */
    // public abstract function _addMatrix(Matrix $matrix): array;

    public function _addMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] + $matrix->data[$i][$j];
            }
        }
        return $data;
    }

    public function _subtractMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] - $matrix->data[$i][$j];
            }
        }
        return $data;
    }

    public function _multiplyMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] * $matrix->data[$i][$j];
            }
        }
        return $data;
    }

    public function _divideMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] / $matrix->data[$i][$j];
            }
        }
        return $data;
    }

    public function _isEqualMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] === $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return $data;
    }

    public function _isNotEqualMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$i] !== $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return $data;
    }

    public function _isGreaterMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] > $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return $data;
    }

    public function _isGreaterOrEqualMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] >= $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return $data;
    }

    public function _isLessMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] < $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return $data;
    }

    public function _isLessOrEqualMatrix(Matrix $matrix): array {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] <= $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return $data;
    }

    /**
     * Arithmetic by vector
     */
    public function _addVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] + $vector->data[$i];
        }
        return $data;
    }

    public function _subtractVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] - $vector->data[$i];
        }
        return $data;
    }

    public function _multiplyVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] * $vector->data[$i];
        }
        return $data;
    }

    public function _divideVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] / $vector->data[$i];
        }
        return $data;
    }

    public function _isEqualVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] === $vector->data[$i] ? 1.0 : 0.0;
        }
        return $data;
    }

    public function _isNotEqualVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] !== $vector->data[$i] ? 1.0 : 0.0;
        }
        return $data;
    }

    public function _isGreaterVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] > $vector->data[$i] ? 1.0 : 0.0;
        }
        return $data;
    }

    public function _isGreaterOrEqualVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] >= $vector->data[$i] ? 1.0 : 0.0;
        }
        return $data;
    }

    public function _isLessVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] < $vector->data[$i] ? 1.0 : 0.0;
        }
        return $data;
    }

    public function _isLessOrEqualVector(Vector $vector): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] <= $vector->data[$i] ? 1.0 : 0.0;
        }
        return $data;
    }

    /**
     * Arithmetic by vector
     */
    public function _addScalar(float|int $scalar): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] + $scalar;
        }
        return $data;
    }

    public function _subtractScalar(float|int $scalar): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] - $scalar;
        }
        return $data;
    }

    public function _multiplyScalar(float|int $scalar): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] * $scalar;
        }
        return $data;
    }

    public function _divideScalar(float|int $scalar): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] / $scalar;
        }
        return $data;
    }

    public function _isGreaterScalar(float|int $scalar): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] > $scalar ? 1.0 : 0.0;
        }
        return $data;
    }

    public function _isGreaterOrEqualScalar(float|int $scalar): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] >= $scalar ? 1.0 : 0.0;
        }
        return $data;
    }

    public function _isLessScalar(float|int $scalar): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] < $scalar ? 1.0 : 0.0;
        }
        return $data;
    }

    public function _isLessOrEqualScalar(float|int $scalar): array {
        for ($i = 0; $i < $this->length; $i++) {
            $data[] = $this->data[$i] <= $scalar ? 1.0 : 0.0;
        }
        return $data;
    }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Statistical
     */
    public function mean(): float {
        return $this->sum() / $this->size();
    }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Collection
     */
    public function sum(): float {
        return array_sum($this->data);
    }

    public function min(): float {
        return (float) min($this->data);
    }

    public function max(): float {
        return (float) max($this->data);
    }

    public function _range(?float $min = null, ?float $max = null): array {
        if ($min === null and $max === null) {
            throw new InvalidArgumentException('No scope was given.', Response::HTTP_BAD_REQUEST);
        }
        if ($min === $max) {
            throw new InvalidArgumentException('Invalid scope.', Response::HTTP_BAD_REQUEST);
        }
        if ($min !== null and $max !== null and $min > $max) {
            $tmp = $min;
            $min = $max;
            $max = $tmp;
        }
        $data = [];
        foreach ($this->data as $value) {
            if ($min !== null and $value < $min) {
                $data[] = $min;
                continue;
            }
            if ($max !== null and $value > $max) {
                $data[] = $max;
                continue;
            }
            $data[] = $value;
        }
        return $data;
    }

    public function product(): float {
        return array_product($this->data);
    }

    /**
     * Factories
     */
    public abstract static function create(mixed $data, bool $skip = false): RowVector|ColumnVector;
    public abstract static function fastCreate(mixed $data, bool $skip = true): RowVector|ColumnVector;
    public abstract static function fillZeros(int $length): RowVector|ColumnVector;
    public abstract static function fillOnes(int $length): RowVector|ColumnVector;
    public abstract static function fill(int $length, float $value): RowVector|ColumnVector;
    public abstract static function fillRandomize(int $length, int $from = 1, int $to = 1, int $precision = 2): RowVector|ColumnVector;
    public abstract static function fillRandmax(int $length): RowVector|ColumnVector;
    public abstract static function fillRandom(int $length): RowVector|ColumnVector;
    public abstract static function fillUniform(int $length): RowVector|ColumnVector;
    public abstract static function fillGaussian(int $length): RowVector|ColumnVector;

    protected final static function randmax(int $length): array {
        if ($length < 2) {
            throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
        }
        $randmax = getrandmax();
        for ($i = 0; $i < $length; $i++) {
            $data[$i] = rand(-$randmax, $randmax) / $randmax;
        }
        return $data;
    }

    protected final static function random(int $length): array {
        if ($length < 2) {
            throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
        }
        for ($i = 0; $i < $length; $i++) {
            $data[$i] = mt_rand() / getrandmax();
        }
        return $data;
    }

    protected final static function uniform(int $length): array {
        if ($length < 2) {
            throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
        }
        $getrandmax = getrandmax();
        for ($i = 0; $i < $length; $i++) {
            $data[$i] = mt_rand(-$getrandmax, $getrandmax) / $getrandmax;
        }
        return $data;
    }

    protected final static function gaussian(int $length): array {
        if ($length < 2) {
            throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
        }
        $getrandmax = getrandmax();
        for ($i = 0; $i < $length; $i++) {
            $r = sqrt(-2.0 * log(rand() / $getrandmax));
            $phi = rand() / $getrandmax * M_PI * 2;
            $data[] = $r * sin($phi);
            $data[] = $r * cos($phi);
        }
        if (count($data) > $length) {
            array_slice($data, 0, $length);
        }
        return $data;
    }

    protected final static function randomize(int $length, int $from = -1, int $to = 1, int $precision = 2): array {
        if ($length < 2) {
            throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
        }
        $data = [];
        $precision = $precision <= 0 ? 1 : pow(10, $precision);
        for ($i = 0; $i < $length; $i++) {
            $data[$i] = mt_rand($from * $precision, $to * $precision) / $precision;
        }
        return $data;
    }

    /**
     * @param int $rows
     * @param int $columns
     * @param float $from
     * @param float $to
     * @param float $precision = 1e-2
     * @return array
     * @throws InvalidArgumentException
     */
    public final static function randomizeRequireFrom(int $length, float $from = -1.0, float $to = 1.0, float $precision = 2): array {
        try {
            $data = self::randomize($length, $from, $to, $precision);
            $i = mt_rand(0, $length);
            $data[$i] = $from;
            return $data;
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $rows
     * @param int $columns
     * @param float $from
     * @param float $to
     * @param float $precision = 1e-2
     * @return array
     * @throws InvalidArgumentException
     */
    public final static function randomizeRequireTo(int $length, float $from = -1.0, float $to = 1.0, float $precision = 2): array {
        try {
            $data = self::randomize($length, $from, $to, $precision);
            $i = mt_rand(0, $length);
            $data[$i] = $to;
            return $data;
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }
}
