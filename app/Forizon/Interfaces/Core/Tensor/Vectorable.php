<?php

namespace App\Forizon\Interfaces\Core\Tensor;

use App\Forizon\Abstracts\Tensors\Vector;
use App\Forizon\Tensors\Matrix;

interface Vectorable
{
    /**
     * Arithmetic by matrix
     */
    public function addMatrix(Matrix $matrix): Matrix;

    public function subtractMatrix(Matrix $matrix): Matrix;

    public function multiplyMatrix(Matrix $matrix): Matrix;

    public function divideMatrix(Matrix $matrix): Matrix;

    public function isGreaterMatrix(Matrix $matrix): Matrix;

    public function isGreaterOrEqualMatrix(Matrix $matrix): Matrix;

    public function isLessMatrix(Matrix $matrix): Matrix;

    public function isLessOrEqualMatrix(Matrix $matrix): Matrix;

    /**
     * Arithmetic by vector
     */
    public function addVector(Vector $vector): Vector;

    public function subtractVector(Vector $vector): Vector;

    public function multiplyVector(Vector $vector): Vector;

    public function divideVector(Vector $vector): Vector;

    public function isGreaterVector(Vector $vector): Vector;

    public function isGreaterOrEqualVector(Vector $vector): Vector;

    public function isLessVector(Vector $vector): Vector;

    public function isLessOrEqualVector(Vector $vector): Vector;

    /**
     * Arithmetic by scalar
     */
    public function addScalar(float|int $scalar): Vector;

    public function subtractScalar(float|int $scalar): Vector;

    public function multiplyScalar(float|int $scalar): Vector;

    public function divideScalar(float|int $scalar): Vector;

    public function isGreaterScalar(float|int $scalar): Vector;

    public function isGreaterOrEqualScalar(float|int $scalar): Vector;

    public function isLessScalar(float|int $scalar): Vector;

    public function isLessOrEqualScalar(float|int $scalar): Vector;
}
