<?php

namespace App\Forizon\Abstracts\Tensors;

use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Forizon\Validators\Tensor as TensorValidator;

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


    public final function shape(): array {
        return [$this->rows * $this->columns];
    }

    public final function size(): int {
        return $this->rows * $this->columns;
    }

    /**
     * Arithmetic by matrix
     */
    // public abstract function addMatrix(Matrix $matrix): Matrix;

    public function addMatrix(Matrix $matrix): Matrix {
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                $data[$i][$j] = $this->data[$j] + $matrix->data[$i][$j];
            }
        }
        return Matrix::fastCreate($data);
    }

    public abstract function subtractMatrix(Matrix $matrix): Matrix;
    public abstract function multiplyMatrix(Matrix $matrix): Matrix;
    public abstract function divideMatrix(Matrix $matrix): Matrix;
    public abstract function isGreaterMatrix(Matrix $matrix): Matrix;
    public abstract function isGreaterOrEqualMatrix(Matrix $matrix): Matrix;
    public abstract function isLessMatrix(Matrix $matrix): Matrix;
    public abstract function isLessOrEqualMatrix(Matrix $matrix): Matrix;

    /**
     * Arithmetic by vector
     */
    public abstract function addVector(Vector $vector): self;
    public abstract function subtractVector(Vector $vector): self;
    public abstract function multiplyVector(Vector $vector): self;
    public abstract function divideVector(Vector $vector): self;
    public abstract function isGreaterVector(Vector $vector): self;
    public abstract function isGreaterOrEqualVector(Vector $vector): self;
    public abstract function isLessVector(Vector $vector): self;
    public abstract function isLessOrEqualVector(Vector $vector): self;

    /**
     * Arithmetic by vector
     */
    public abstract function addScalar(float|int $scalar): self;
    public abstract function subtractScalar(float|int $scalar): self;
    public abstract function multiplyScalar(float|int $scalar): self;
    public abstract function divideScalar(float|int $scalar): self;
    public abstract function isGreaterScalar(float|int $scalar): self;
    public abstract function isGreaterOrEqualScalar(float|int $scalar): self;
    public abstract function isLessScalar(float|int $scalar): self;
    public abstract function isLessOrEqualScalar(float|int $scalar): self;

    /**
     * Factories
     */
    public abstract static function create(mixed $data, bool $skip = false): self;
    public abstract static function fastCreate(mixed $data, bool $skip = true): self;
    public abstract static function fillZeros(int $length): self;
    public abstract static function fillOnes(int $length): self;
    public abstract static function fill(int $length, float $value): self;
    public abstract static function fillRandomize(int $length, float $from = -1.0, float $to = 1.0, float $precision = 2): self;
    public abstract static function fillRandmax(int $length): self;
    public abstract static function fillRandom(int $length): self;
    public abstract static function fillUniform(int $length): self;
    public abstract static function fillGaussian(int $length): self;

    protected final static function randomize(int $length,  float $from = -1.0, float $to = 1.0, float $precision = 1e-2): array {
        if ($length < 2) {
            throw new InvalidArgumentException('', Response::HTTP_BAD_REQUEST);
        }
        $data = [];
        for ($i = 0; $i < $length; $i++) {
            $data[$i] = round(mt_rand($from, $to), $precision);
        }
        return $data;
    }

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
}
