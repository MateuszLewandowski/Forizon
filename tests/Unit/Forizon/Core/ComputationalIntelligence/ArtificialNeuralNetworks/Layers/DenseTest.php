<?php

namespace Tests\Unit\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers;

use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Hidden\Dense;
use App\Forizon\Core\Optimizers\Adam;
use App\Forizon\Tensors\Matrix;
use InvalidArgumentException;
use Psy\Exception\TypeErrorException;
use Tests\TestCase;
use App\Forizon\Parameters\Attribute;
use TypeError;
use stdClass;

class DenseTest extends TestCase
{
    public function testCreateObjectInstanceExpectsSuccess()
    {
        $flag = true;
        for ($i = 0; $i < 5; $i++) {
            $neurons = mt_rand(1, 999);
            $dense = new Dense($neurons);
            if ($neurons !== $dense->getNeurons()) {
                $flag = false;
            }
        }
        $this->assertTrue($flag);
    }


    public function testCreateObjectInstanceWithZeroNeuronsExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Dense(0);
    }

    public function testCreateObjectInstanceWithNegativeNumbersOfNeuronsExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Dense(-25);
    }

    public function testCreateObjectInstanceWithTooBigAlphaExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Dense(10, 1.1);
    }

    public function testCreateObjectInstanceWithTooSmallAlphaExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Dense(10, -1);
    }

    public function testCreateObjectInstanceWithWrongIsBiasedTypeExpectsInvalidArgumentException()
    {
        $this->expectException(TypeError::class);
        new Dense(10, .5, new stdClass);
    }

    public function testCreateObjectInstanceWithWrongInitializerTypeExpectsInvalidArgumentException()
    {
        $this->expectException(TypeError::class);
        new Dense(10, .5, false, new stdClass);
    }

    public function testInitializeLayerExpectsSuccess()
    {
        $flag = true;
        for ($i = 0; $i < 5; $i++) {
            $neurons = mt_rand(1, 999);
            $dense = new Dense($neurons);
            $_neurons = mt_rand(1, 999);
            if ($neurons !== $dense->initialize($_neurons)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }

    public function testInitializeLayerExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $dense = new Dense(5);
        $dense->initialize(-5);
    }

    public function testInitializeLayerExpectsTypeErrorException()
    {
        $this->expectException(TypeError::class);
        $dense = new Dense(5);
        $dense->initialize(new stdClass);
    }

    public function testFeedForwardExpectsSuccess()
    {
        $flag = true;
        for ($i = 0; $i < 5; $i++) {
            $neurons = mt_rand(1, 25);
            $dense = new Dense($neurons);
            $_neurons = mt_rand(1, 25);
            $dense->initialize($_neurons);
            $dense->feedForward(Matrix::fillRandom($_neurons, $neurons));
        }
        $this->assertTrue($flag);
    }

    public function testFeedForwardExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $neurons = mt_rand(1, 25);
        $dense = new Dense($neurons);
        $_neurons = mt_rand(1, 25);
        $dense->initialize($_neurons);
        $dense->feedForward(Matrix::fillRandom($_neurons + 1, $neurons + 1));
    }

    public function testFeedForwardExpectsInMatrixValidationInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $neurons = mt_rand(1, 25);
        $dense = new Dense($neurons);
        $_neurons = mt_rand(1, 25);
        $dense->initialize($_neurons);
        $dense->feedForward(Matrix::fillRandom($_neurons + 1, $neurons));
    }

    public function testFeedForwardExpectsTypeErrorException()
    {
        $this->expectException(TypeError::class);
        $neurons = mt_rand(1, 25);
        $dense = new Dense($neurons);
        $_neurons = mt_rand(1, 25);
        $dense->initialize($_neurons);
        $dense->feedForward(new stdClass);
    }

    public function testTouchExpectsSuccess()
    {
        $flag = true;
        for ($i = 0; $i < 5; $i++) {
            $neurons = mt_rand(1, 25);
            $dense = new Dense($neurons);
            $_neurons = mt_rand(1, 25);
            $dense->initialize($_neurons);
            $dense->touch(Matrix::fillRandom($_neurons, $neurons));
        }
        $this->assertTrue($flag);
    }

    public function testTouchExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $neurons = mt_rand(1, 25);
        $dense = new Dense($neurons);
        $_neurons = mt_rand(1, 25);
        $dense->initialize($_neurons);
        $dense->touch(Matrix::fillRandom($_neurons + 1, $neurons + 1));
    }



    public function testTouchExpectsInMatrixValidationInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $neurons = mt_rand(1, 25);
        $dense = new Dense($neurons);
        $_neurons = mt_rand(1, 25);
        $dense->initialize($_neurons);
        $dense->touch(Matrix::fillRandom($_neurons + 1, $neurons));
    }

    public function testTouchExpectsTypeErrorException()
    {
        $this->expectException(TypeError::class);
        $neurons = mt_rand(1, 25);
        $dense = new Dense($neurons);
        $_neurons = mt_rand(1, 25);
        $dense->initialize($_neurons);
        $dense->touch(new stdClass);
    }




    public function testBackPropagationExpectsSuccess()
    {
        $neurons = mt_rand(1, 25);
        $dense = new Dense($neurons);
        $dense->initialize($neurons);
        $dense->feedForward(Matrix::fillRandom($neurons, $neurons));
        $adam = new Adam();
        $adam->initialize($dense->weights);
        $adam->initialize($dense->biases);
        $dense->backPropagation(Matrix::fillRandom($neurons, $neurons), $adam);
        $this->assertTrue(true);
    }
}
