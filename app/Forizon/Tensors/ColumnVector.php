<?php

namespace App\Forizon\Tensors;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Forizon\Interfaces\Core\Tensor;
use InvalidArgumentException;
use App\Forizon\Tensors\{
    RowVector, Matrix
};
use Prophecy\Exception\Doubler\MethodNotFoundException;
use App\Forizon\Abstracts\Tensors\Vector;
use App\Forizon\Validators\Tensor as TensorValidator;
use App\Forizon\Interfaces\Core\Tensor\Vectorable;

class ColumnVector extends Vector implements Vectorable, Tensor {

    /**
     * @param array[] $data
     * @param bool $skip = false
     * @throws InvalidArgumentException
     */
    public function __construct(array $data = [], bool $skip = false) {
        try {
            if (empty($data)) {
                throw new InvalidArgumentException('Column vector cannot be empty.', Response::HTTP_BAD_REQUEST);
            }
            $data = array_values($data);
            if (!$skip) {
                foreach ($data as &$value) {
                    if (is_array($value) or is_object($value)) {
                        throw new InvalidArgumentException('A Vector was expected, a matrix was obtained', Response::HTTP_BAD_REQUEST);
                    }
                    $value = (float) $value;
                }
            }
            $this->columns = 1;
            $this->rows = count($data);
            $this->data = $data;
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param callable $callback
     * @param mixed ...$parameters
     * @return array
     */
    private function map(callable $callback, mixed ...$parameters): array {
        try {
            $data = [];
            foreach ($this->data as $value) {
                $data[] = $callback($value, ...$parameters);
            }
            return $data;
        } catch (MethodNotFoundException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param string $method
     * @param mixed $tensor
     * @return self
     * @throws InvalidArgumentException
     * @throws MethodNotFoundException
     */
    private function run(string $method, mixed $tensor): self {
        try {
            switch (gettype($tensor)) {
                case 'object':
                    return $tensor instanceof Matrix ?: $this->{$method . 'Matrix'}($tensor);
                    return $tensor instanceof Vector ?: $this->{$method . 'Vector'}($tensor);
                case 'float':
                case 'double':
                case 'integer':
                    return $this->{$method . 'Scalar'}($tensor);
            }
            throw new InvalidArgumentException('Bad type of data recived', __CLASS__);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        } catch (MethodNotFoundException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function transpose(): RowVector {
        return new RowVector($this->data);
    }

    public function asMatrixRow(): Matrix {
        return new Matrix([$this->data]);
    }

    public function asMatrixColumn(): Matrix {
        $matrix = [];
        foreach ($this->data as $row) {
            $matrix[] = [$row];
        }
        return new Matrix($matrix);
    }

    public function matmul(Matrix $matrix): Matrix {
        return $this->asMatrixColumn()->matmul($matrix);
    }

    public function variance($mean = null): mixed {
        if (is_null($mean)) {
            $mean = $this->mean();
        }
        return $this->subtractScalar($mean)
            ->square()
            ->sum() / $this->size();
    }

    public function quantile(float $q): mixed {

     }

    /**
     * Arithmetic by matrix
     */
    public function addMatrix(Matrix $matrix): Matrix {
        TensorValidator::areIdentical($this->rows, $matrix->rows);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] + $matrix->data[$i][$j];
            }
        }
        return Matrix::fastCreate($data);
    }

    public function subtractMatrix(Matrix $matrix): Matrix {
        TensorValidator::areIdentical($this->rows, $matrix->rows);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] - $matrix->data[$i][$j];
            }
        }
        return Matrix::fastCreate($data);
    }

    public function multiplyMatrix(Matrix $matrix): Matrix {
        TensorValidator::areIdentical($this->rows, $matrix->rows);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] * $matrix->data[$i][$j];
            }
        }
        return Matrix::fastCreate($data);
    }

    public function divideMatrix(Matrix $matrix): Matrix {
        TensorValidator::areIdentical($this->rows, $matrix->rows);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] / $matrix->data[$i][$j];
            }
        }
        return Matrix::fastCreate($data);
    }

    public function isGreaterMatrix(Matrix $matrix): Matrix {
        TensorValidator::areIdentical($this->rows, $matrix->rows);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] > $matrix->data[$i][$j] ? 1 : 0;
            }
        }
        return Matrix::fastCreate($data);
    }

    public function isGreaterOrEqualMatrix(Matrix $matrix): Matrix {
        TensorValidator::areIdentical($this->rows, $matrix->rows);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] >= $matrix->data[$i][$j] ? 1 : 0;
            }
        }
        return Matrix::fastCreate($data);
    }

    public function isLessMatrix(Matrix $matrix): Matrix {
        TensorValidator::areIdentical($this->rows, $matrix->rows);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] < $matrix->data[$i][$j] ? 1 : 0;
            }
        }
        return Matrix::fastCreate($data);
    }

    public function isLessOrEqualMatrix(Matrix $matrix): Matrix {
        TensorValidator::areIdentical($this->rows, $matrix->rows);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] <= $matrix->data[$i][$j] ? 1 : 0;
            }
        }
        return Matrix::fastCreate($data);
    }

    /**
     * Arithmetic by vector
     */
    public function addVector(Vector $vector): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] + $vector->data[$i];
        }
        return self::fastCreate($data);
    }

    public function subtractVector(Vector $vector): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] - $vector->data[$i];
        }
        return self::fastCreate($data);
    }

    public function multiplyVector(Vector $vector): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] * $vector->data[$i];
        }
        return self::fastCreate($data);
    }

    public function divideVector(Vector $vector): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] / $vector->data[$i];
        }
        return self::fastCreate($data);
    }

    public function isGreaterVector(Vector $vector): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] > $vector->data[$i] ? 1.0 : 0.0;
        }
        return self::fastCreate($data);
    }

    public function isGreaterOrEqualVector(Vector $vector): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] >= $vector->data[$i] ? 1.0 : 0.0;
        }
        return self::fastCreate($data);
    }

    public function isLessVector(Vector $vector): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] < $vector->data[$i] ? 1.0 : 0.0;
        }
        return self::fastCreate($data);
    }

    public function isLessOrEqualVector(Vector $vector): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] <= $vector->data[$i] ? 1.0 : 0.0;
        }
        return self::fastCreate($data);
    }

    /**
     * Arithmetic by vector
     */
    public function addScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] + $scalar;
        }
        return self::fastCreate($data);
    }

    public function subtractScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] - $scalar;
        }
        return self::fastCreate($data);
    }

    public function multiplyScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] * $scalar;
        }
        return self::fastCreate($data);
    }

    public function divideScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] / $scalar;
        }
        return self::fastCreate($data);
    }

    public function isGreaterScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] > $scalar ? 1.0 : 0.0;
        }
        return self::fastCreate($data);
    }

    public function isGreaterOrEqualScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] >= $scalar ? 1.0 : 0.0;
        }
        return self::fastCreate($data);
    }

    public function isLessScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] < $scalar ? 1.0 : 0.0;
        }
        return self::fastCreate($data);
    }

    public function isLessOrEqualScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            $data[] = $this->data[$i] <= $scalar ? 1.0 : 0.0;
        }
        return self::fastCreate($data);
    }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Arithmetical
     */
    public function add(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function subtract(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function multiply(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function divide(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Comparable
     */
    public function isGreater(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function isGreaterOrEqual(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function isLess(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function isLessOrEqual(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Algebric
     */
    public function abs(): self {
        return self::fastCreate($this->map(__FUNCTION__));
    }
    public function square(): self {
        return self::fastCreate($this->map(__FUNCTION__));
    }
    public function sqrt(): self {
        return self::fastCreate($this->map(__FUNCTION__));
    }
    public function exp(): self {
        return self::fastCreate($this->map(__FUNCTION__));
    }
    public function log(float $base = M_E): self {
        return self::fastCreate($this->map(__FUNCTION__, $base));
    }
    public function round(int $precision = 0): self {
        return self::fastCreate($this->map(__FUNCTION__, $precision));
    }
    public function floor(): self {
        return self::fastCreate($this->map(__FUNCTION__));
    }
    public function ceil(): self {
        return self::fastCreate($this->map(__FUNCTION__));
    }
    public function negate(): self {
        return self::fastCreate($this->map(function ($value) { return -$value; }));
    }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Trigonometric
     */
    public function sin(): mixed { return $this->map(__FUNCTION__); }
    public function asin(): mixed { return $this->map(__FUNCTION__); }
    public function cos(): mixed { return $this->map(__FUNCTION__); }
    public function acos(): mixed { return $this->map(__FUNCTION__); }
    public function tan(): mixed { return $this->map(__FUNCTION__); }
    public function atan(): mixed { return $this->map(__FUNCTION__); }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Arithmetical
     */
    public function pow(float $base = 2): array {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] ** $base;
            }
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

    public function lowerRange(float $min): array {
        return $this->range($min, null);
    }

    public function upperRange(float $max): array {
        return $this->range(null, $max);
    }

    public function range(?float $min, ?float $max): array {
        if ($min === null and $max === null) {
            throw new InvalidArgumentException('No scope was given.', Response::HTTP_BAD_REQUEST);
        }
        if ($min > $max) {
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
     * @param mixed $data
     * @param bool $skip = false
     * @return self
     */
    public static function create(mixed $data, bool $skip = false): self {
        return new self($data, $skip);
    }

    /**
     * @param mixed $data
     * @param bool $skip = true
     * @return self
     */
    public static function fastCreate(mixed $data, bool $skip = true): self {
        return new self($data, $skip);
    }

    /**
     * @param int $length
     * @return self
     */
    public static function fillZeros(int $length): self {
        $data = [];
        for ($i = 0; $i < $length; $i++) {
            $data[$i] = 0.0;
        }
        return new self($data, true);
    }

    /**
     * @param int $length
     * @return self
     */
    public static function fillOnes(int $length): self {
        $data = [];
        for ($i = 0; $i < $length; $i++) {
            $data[$i] = 1.0;
        }
        return new self($data, true);
    }

    /**
     * @param int $length
     * @param float $value
     * @return self
     */
    public static function fill(int $length, float $value): self {
        $data = [];
        for ($i = 0; $i < $length; $i++) {
            $data[$i] = $value;
        }
        return new self($data, true);
    }

    /**
     * @param int $length
     * @param float $from
     * @param float $to
     * @param float $precision = 1e-2
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillRandomize(int $length, float $from = -1.0, float $to = 1.0, float $precision = 1e-2): self {
        try {
            return new self(self::randomize($length, $from, $to, $precision), true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $length
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillRandmax(int $length): self {
        try {
            return new self(self::randmax($length), true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $length
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillRandom(int $length): self {
        try {
            return new self(self::random($length), true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $length
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillUniform(int $length): self {
        try {
            return new self(self::uniform($length), true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $length
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillGaussian(int $length): self {
        try {
            return new self(self::gaussian($length), true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }
}
