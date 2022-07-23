<?php

namespace App\Forizon\Interfaces\Core\Tensor;
use App\Forizon\Tensors\{
    Matrix, RowVector, ColumnVector
};

interface Matrixable {

    /**
     * Arithmetic by matrix
     */
    public function addMatrix(Matrix $matrix): self;
    public function subtractMatrix(Matrix $matrix): self;
    public function multiplyMatrix(Matrix $matrix): self;
    public function divideMatrix(Matrix $matrix): self;
    public function isGreaterMatrix(Matrix $matrix): self;
    public function isGreaterOrEqualMatrix(Matrix $matrix): self;
    public function isLessMatrix(Matrix $matrix): self;
    public function isLessOrEqualMatrix(Matrix $matrix): self;

    /**
     * Arithmetic by column vector
     */
    public function addColumnVector(ColumnVector $vector): self;
    public function subtractColumnVector(ColumnVector $vector): self;
    public function multiplyColumnVector(ColumnVector $vector): self;
    public function divideColumnVector(ColumnVector $vector): self;
    public function isGreaterColumnVector(ColumnVector $vector): self;
    public function isGreaterOrEqualColumnVector(ColumnVector $vector): self;
    public function isLessColumnVector(ColumnVector $vector): self;
    public function isLessOrEqualColumnVector(ColumnVector $vector): self;

    /**
     * Arithmetic by row vector
     */
    public function addRowVector(RowVector $vector): self;
    public function subtractRowVector(RowVector $vector): self;
    public function multiplyRowVector(RowVector $vector): self;
    public function divideRowVector(RowVector $vector): self;
    public function isGreaterRowVector(RowVector $vector): self;
    public function isGreaterOrEqualRowVector(RowVector $vector): self;
    public function isLessRowVector(RowVector $vector): self;
    public function isLessOrEqualRowVector(RowVector $vector): self;

    /**
     * Arithmetic by vector
     */
    public function addScalar(float|int $scalar): self;
    public function subtractScalar(float|int $scalar): self;
    public function multiplyScalar(float|int $scalar): self;
    public function divideScalar(float|int $scalar): self;
    public function isGreaterScalar(float|int $scalar): self;
    public function isGreaterOrEqualScalar(float|int $scalar): self;
    public function isLessScalar(float|int $scalar): self;
    public function isLessOrEqualScalar(float|int $scalar): self;

    /**
     * Factories
     */
    public static function create(mixed $data, bool $skip = false): mixed;
    public static function fastCreate(mixed $data, bool $skip = true): mixed;
    public static function fillZeros(int $rows, int $columns): mixed;
    public static function fillOnes(int $rows, int $columns): mixed;
    public static function fill(int $rows, int $columns, float $value): mixed;
    public static function randomize(int $rows, int $columns, float $from = -1.0, float $to = 1.0, float $precision = 1e-2): self;
    public static function randmax(int $rows, int $columns): self;
    public static function fillRandom(int $rows, int $columns): self;
    public static function fillUniform(int $rows, int $columns): self;
    public static function fillGaussian(int $rows, int $columns): self;
    public static function randomizeRequireFrom(int $rows, int $columns, float $from = -1.0, float $to = 1.0, float $precision = 1e-2);
    public static function randomizeRequireTo(int $rows, int $columns, float $from = -1.0, float $to = 1.0, float $precision = 1e-2);

}
