<?php

namespace App\Forizon\Tensors;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Interfaces\Core\Tensor\Matrixable;
use InvalidArgumentException;
use App\Forizon\Tensors\{
    ColumnVector, RowVector
};
use Prophecy\Exception\Doubler\MethodNotFoundException;
use App\Forizon\Validators\Tensor as TensorValidator;

class Matrix implements Matrixable, Tensor {

    /**
     * @var array[] $data
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
     * @param array[] $data
     * @param bool $skip = false
     * @throws InvalidArgumentException
     */
    public function __construct(array $data = [], $skip = false) {
        try {
            if (empty($data)) {
                throw new InvalidArgumentException('Matrix cannot be empty.', Response::HTTP_BAD_REQUEST);
            }
            if (!isset($data[0]) or (isset($data[0]) and !is_array($data[0]))) {
                throw new InvalidArgumentException('A matrix was expected, a vector was obtained', Response::HTTP_BAD_REQUEST);
            }
            $this->rows = count($data);
            $this->columns = count(current($data) ?: []);

            if (!$skip) {
                foreach ($data as &$row) {
                    if (count($row) !== $this->columns) {
                        throw new InvalidArgumentException('The uniform dimension of the matrix columns was not maintained.', Response::HTTP_BAD_REQUEST);
                    }
                    foreach ($row as &$value) {
                        $value = (float) $value;
                    }
                }
            }
            $this->data = $data;
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @return int
     */
    public function size(): int {
        return $this->rows * $this->columns;
    }

    /**
     * @return int[]
     */
    public function shape(): array {
        return [$this->rows, $this->columns];
    }

    /**
     * @return bool
     */
    public function isSquared(): bool {
        return $this->rows === $this->columns;
    }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Arithmetical
     */
    public function add(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function subtract(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function multiply(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function divide(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function pow(float $base = 2): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] ** $base;
            }
        }
        return self::fastCreate($data);
    }

    public function matmul(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = 0.0;
                for ($k = 0; $k < $this->columns; $k++) {
                   $data[$i][$j] += $this->data[$i][$k] * $matrix->data[$k][$j];
                }
            }
        }
        return self::fastCreate($data);
    }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Comparable
     */
    public function isEqual(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function isNotEqual(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function isGreater(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function isGreaterOrEqual(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function isLess(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }
    public function isLessOrEqual(mixed $tensor): self { return $this->run(__FUNCTION__, $tensor); }

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Algebric
     */
    public function abs(): self { return $this->map(__FUNCTION__); }
    public function sqrt(): self { return $this->map(__FUNCTION__); }
    public function exp(): self { return $this->map(__FUNCTION__); }
    public function log(float $base = M_E): self {
        foreach ($this->data as $i => $row) {
            foreach ($row as $j => $value) {
                $data[$i][$j] = log($value, $base);
            }
        }
        return self::fastCreate($data);
    }
    public function round(int $precision = 0): self {
        foreach ($this->data as $i => $row) {
            foreach ($row as $j => $value) {
                $data[$i][$j] = round($value, $precision);
            }
        }
        return self::fastCreate($data);
    }
    public function floor(): self { return $this->map(__FUNCTION__); }
    public function ceil(): self { return $this->map(__FUNCTION__); }
    public function negate(): self { return $this->map(fn ($value) => -$value); }

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
     * @see App\Forizon\Interfaces\Core\Tensor\Collection
     */
    public function sum(): ColumnVector {
        return ColumnVector::fastCreate(
            array_map('array_' . __FUNCTION__, $this->data)
        );
    }

    public function min(): mixed { return ColumnVector::fastCreate(
        array_map(__FUNCTION__, $this->data)
    );}

    public function max(): mixed { return ColumnVector::fastCreate(
        array_map(__FUNCTION__, $this->data)
    );}

    public function lowerRange(float $min): mixed {
        return $this->range($min, null);
    }

    public function upperRange(float $max): mixed {
        return $this->range(null, $max);
    }

    public function range(?float $min, ?float $max): mixed {
        try {
            if ($min === null and $max === null) {
                throw new InvalidArgumentException('No scope was given.', Response::HTTP_BAD_REQUEST);
            }
            if ($min !== null and $max !== null and $min > $max) {
                $tmp = $min;
                $min = $max;
                $max = $tmp;
            }
            $data = [];
            foreach ($this->data as $key => $row) {
                foreach ($row as $value) {
                    if ($min !== null and $value < $min) {
                        $data[$key][] = $min;
                        continue;
                    }
                    if ($max !== null and $value > $max) {
                        $data[$key][] = $max;
                        continue;
                    }
                    $data[$key][] = $value;
                }
            }
            return self::fastCreate($data);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function product(): mixed { return ColumnVector::fastCreate(
        array_map('array_' . __FUNCTION__, $this->data)
    );}

    /**
     * @see App\Forizon\Interfaces\Core\Tensor\Statistical
     */
    public function mean(): ColumnVector {
        return $this->sum()->divideScalar($this->columns);
    }

    public function variance($mean = null): mixed {
        if ($mean !== null) {
            $mean = $this->mean();
        }
        try {
            if (!$mean instanceof ColumnVector) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            if ($mean->rows !== $this->rows) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            return $this->subtractColumnVector($mean)
                ->square()
                ->sum()
                ->divide($this->rows);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function quantile(float $q): mixed {
        try {
            if ($q > 1.0 or $q < 0.0) {
                throw new InvalidArgumentException('Argument q mus be between 0.0 and 1.0');
            }
            $x = $q * ($this->columns - 1) + 1;
            $y = (int) $x;
            $remainder = $x - $y;
            $data = [];
            foreach ($this->data as $row) {
                sort($row);
                $z = $row[$y - 1];
                $data[] = $z + $remainder * ($row[$y] - $z);
            }
            return ColumnVector::fastCreate($data);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function covariance(?ColumnVector $mean = null) : self {
        try {
            if ($mean === null) {
                $mean = $this->mean();
            }
            if (!$mean instanceof ColumnVector) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            if ($mean->rows !== $this->rows) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            $base = $this->subtractColumnVector($mean);
            return $base->matmul($base->transpose())->divideScalar($this->rows);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    public function transpose(): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$j][$i] = $this->data[$i][$j];
            }
        }
        return self::fastCreate($data);
    }

    public function square(): Matrix {
        return $this->multiplyMatrix($this);
    }

    /**
     * Arithmetic by matrix
     */
    public function addMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] + $matrix->data[$i][$j];
            }
        }
        return self::fastCreate($data);
    }

    public function subtractMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] - $matrix->data[$i][$j];
            }
        }
        return self::fastCreate($data);
    }

    public function multiplyMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] * $matrix->data[$i][$j];
            }
        }
        return self::fastCreate($data);
    }

    public function divideMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] / $matrix->data[$i][$j];
            }
        }
        return self::fastCreate($data);
    }

    public function isEqualMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] === $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }
    public function isNotEqualMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] !== $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isGreaterMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] > $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isGreaterOrEqualMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] >= $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isLessMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] < $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isLessOrEqualMatrix(Matrix $matrix): self {
        TensorValidator::areIdentical($this->shape(), $matrix->shape());
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] <= $matrix->data[$i][$j] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    /**
     * Arithmetic by column vector
     */
    public function addColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] + $columnVector->data[$i];
            }
        }
        return self::fastCreate($data);
    }

    public function subtractColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] - $columnVector->data[$i];
            }
        }
        return self::fastCreate($data);
    }

    public function multiplyColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] * $columnVector->data[$i];
            }
        }
        return self::fastCreate($data);
    }

    public function divideColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] / $columnVector->data[$i];
            }
        }
        return self::fastCreate($data);
    }


    public function isEqualColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] === $columnVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isNotEqualColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] !== $columnVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isGreaterColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] > $columnVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isGreaterOrEqualColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] >= $columnVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isLessColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] < $columnVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isLessOrEqualColumnVector(ColumnVector $columnVector): self {
        TensorValidator::areIdentical($this->rows, $columnVector->rows);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] <= $columnVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    /**
     * Arithmetic by row vector
     */
    public function addRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] + $rowVector->data[$j];
            }
        }
        return self::fastCreate($data);
    }

    public function subtractRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] - $rowVector->data[$j];
            }
        }
        return self::fastCreate($data);
    }

    public function multiplyRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] * $rowVector->data[$j];
            }
        }
        return self::fastCreate($data);
    }

    public function divideRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] / $rowVector->data[$j];
            }
        }
        return self::fastCreate($data);
    }

    public function isEqualRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] === $rowVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isNotEqualRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] !== $rowVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isGreaterRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] > $rowVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isGreaterOrEqualRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] >= $rowVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isLessRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] < $rowVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isLessOrEqualRowVector(RowVector $rowVector): self {
        TensorValidator::areIdentical($this->columns, $rowVector->columns);
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] <= $rowVector->data[$i] ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }


    /**
     * Arithmetic by scalar
     */
    public function addScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] + (float) $scalar;
            }
        }
        return self::fastCreate($data);
    }

    public function subtractScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] - (float) $scalar;
            }
        }
        return self::fastCreate($data);
    }

    public function multiplyScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] * (float) $scalar;
            }
        }
        return self::fastCreate($data);
    }

    public function divideScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] / (float) $scalar;
            }
        }
        return self::fastCreate($data);
    }

    public function isEqualScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] === $scalar ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isNotEqualScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] !== $scalar ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isGreaterScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] > (float) $scalar ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isGreaterOrEqualScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] >= (float) $scalar ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isLessScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] < (float) $scalar ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
    }

    public function isLessOrEqualScalar(float|int $scalar): self {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $data[$i][$j] = $this->data[$i][$j] <= (float) $scalar ? 1.0 : 0.0;
            }
        }
        return self::fastCreate($data);
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
                    if ($tensor instanceof Matrix and method_exists($this, $method . 'Matrix'))
                        return $this->{$method . 'Matrix'}($tensor);
                    if ($tensor instanceof ColumnVector and method_exists($this, $method . 'ColumnVector'))
                        return $this->{$method . 'ColumnVector'}($tensor);
                    if ($tensor instanceof RowVector and method_exists($this, $method . 'RowVector'))
                        return $this->{$method . 'RowVector'}($tensor);
                case 'float':
                case 'double':
                case 'integer':
                    if (method_exists($this, $method . 'Scalar')) {
                        return $this->{$method . 'Scalar'}();
                    }
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

    /**
     * @param callable $callback
     * @param mixed ...$parameters
     * @return self
     * @throws InvalidArgumentException
     */
    private function map(callable $callback, mixed ...$parameters): self {
        try {
            foreach ($this->data as $i => $row) {
                foreach ($row as $j => $value) {
                    $data[$i][$j] = $callback($value, ...$parameters);
                }
            }
            return self::fastCreate($data);
        } catch (MethodNotFoundException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
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
     * @param int $rows
     * @param int $columns
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillZeros(int $rows, int $columns): self {
        try {
            if ($rows < 1 or $columns < 1) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            $data = [];
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {
                    $data[$i][$j] = 0.0;
                }
            }
            return new self($data, true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $rows
     * @param int $columns
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillOnes(int $rows, int $columns): self {
        try {
            if ($rows < 1 or $columns < 1) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            $data = [];
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {
                    $data[$i][$j] = 1.0;
                }
            }
            return new self($data, true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $rows
     * @param int $columns
     * @param float $value
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fill(int $rows, int $columns, float $value): self {
        try {
            if ($rows < 1 or $columns < 1) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            $data = [];
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {
                    $data[$i][$j] = $value;
                }
            }
            return new self($data, true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $rows
     * @param int $columns
     * @return self
     * @throws InvalidArgumentException
     */
    public static function randmax(int $rows, int $columns): self {
        try {
            if ($rows < 1 or $columns < 1) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            $data = [];
            $randmax = getrandmax();
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {
                    $data[$i][$j] = rand(-$randmax, $randmax) / $randmax;
                }
            }
            return new self($data, true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $rows
     * @param int $columns
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillRandom(int $rows, int $columns): self {
        try {
            if ($rows < 1 or $columns < 1) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {
                    $data[$i][$j] = mt_rand() / getrandmax();
                }
            }
            return new self($data, true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $rows
     * @param int $columns
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillUniform(int $rows, int $columns): self {
        try {
            if ($rows < 1 or $columns < 1) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            $getrandmax = getrandmax();
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {
                    $data[$i][$j] = mt_rand(-$getrandmax, $getrandmax) / $getrandmax;
                }
            }
            return new self($data, true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $rows
     * @param int $columns
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillGaussian(int $rows, int $columns): self {
        try {
            if ($rows < 1 or $columns < 1) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            $getrandmax = getrandmax();
            $ext = [];
            for ($i = 0; $i < $rows; $i++) {
                $row = [];
                if ($ext) {
                    $row[] = array_pop($ext);
                }
                for ($j = 0; $j < $columns; $j++) {
                    $r = sqrt(-2.0 * log(rand() / $getrandmax));
                    $phi = rand() / $getrandmax * M_PI * 2;
                    $row[] = $r * sin($phi);
                    $row[] = $r * cos($phi);
                }
                $data[] = array_slice($row, 0, $columns);
            }
            return new self($data, true);
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    private static function randomize(int $rows, int $columns, int $from = -1, int $to = 1, int $precision = 2): array {
        try {
            if ($rows < 1 or $columns < 1) {
                throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
            }
            $precision = $precision <= 0 ? 1 : pow(10, $precision);
            $data = [];
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {
                    $data[$i][$j] = mt_rand($from * $precision, $to * $precision) / $precision;
                }
            }
            return $data;
        } catch (InvalidArgumentException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * @param int $rows
     * @param int $columns
     * @param int $from
     * @param int $to
     * @param int $precision = 2
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillRandomize(int $rows, int $columns, int $from = -1, int $to = 1, int $precision = 2): self {
        return new self(self::randomize($rows, $columns, $from, $to, $precision));
    }

    /**
     * @param int $rows
     * @param int $columns
     * @param int $from
     * @param int $to
     * @param int $precision = 2
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillRandomizeRequireFrom(int $rows, int $columns, int $from = -1, int $to = 1, int $precision = 2): self {
        $data = self::randomize($rows, $columns, $from, $to, $precision);
        $i = mt_rand(0, $rows);
        $j = mt_rand(0, $columns);
        $data[$i][$j] = $from;
        return new self($data, true);
    }

    /**
     * @param int $rows
     * @param int $columns
     * @param int $from
     * @param int $to
     * @param int $precision = 2
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fillRandomizeRequireTo(int $rows, int $columns, int $from = -1, int $to = 1, int $precision = 2): self {
        $data = self::randomize($rows, $columns, $from, $to, $precision);
        $i = mt_rand(0, $rows);
        $j = mt_rand(0, $columns);
        $data[$i][$j] = $to;
        return new self($data, true);
    }
}
