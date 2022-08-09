<?php

namespace Tests\Unit\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers;

use Tests\TestCase;
use App\Forizon\Tensors\Matrix;
use App\Forizon\Core\Optimizers\Adam;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Output\Continous;
use App\Forizon\Parameters\Attribute;
use stdClass;
use InvalidArgumentException;
use TypeError;

class ContinousTest extends TestCase
{
    public function testCreateObjectInstanceExpectsSuccess()
    {
        new Continous();
        $this->assertTrue(true);
    }


    public function testCreateObjectInstanceWithWrongObjectInvalidArgumentException()
    {
        $this->expectException(TypeError::class);
        new Continous(new stdClass);
    }

    public function testInitializeLayerExpectsSuccess()
    {
        $continous = new Continous();
        $continous->initialize(1);
        $this->assertTrue(true);
    }

    public function testInitializeLayerExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $continous = new Continous();
        $continous->initialize(2);
    }

    public function testInitializeLayerExpectsTypeErrorException()
    {
        $this->expectException(TypeError::class);
        $continous = new Continous();
        $continous->initialize(new stdClass);
    }

    public function testFeedForwardExpectsSuccess()
    {
        $flag = true;
        $continous = new Continous();
        $neurons = mt_rand(1, 25);
        $continous->initialize(1);
        $matrix = Matrix::fillRandom($neurons, $neurons);
        $feedForward = $continous->feedForward($matrix);
        for ($i = 0; $i < $matrix->rows; $i++) {
            for ($j = 0; $j < $matrix->columns; $j++) {
                if ($matrix->data[$i][$j] !== $feedForward->data[$i][$j]) {
                    $flag = false;
                    break;
                }
            }
        }
        $this->assertTrue($flag);
    }

    public function testFeedForwardExpectsTypeErrorException()
    {
        $this->expectException(TypeError::class);
        $continous = new Continous();
        $continous->feedForward(new stdClass);
    }

    public function testTouchExpectsSuccess()
    {
        $this->testFeedForwardExpectsSuccess();
    }

    public function testTouchExpectsTypeErrorException()
    {
        $this->expectException(TypeError::class);
        $continous = new Continous();
        $continous->touch(new stdClass);
    }

    public function testBackPropagationExpectsSuccess()
    {
        $continous = new Continous();
        $continous->initialize(1);
        $continous->feedForward(Matrix::fillRandom(1, 1));
        $adam = new Adam();
        $adam->initialize(new Attribute(Matrix::fillRandom(5, 5)));
        $adam->initialize(new Attribute(Matrix::fillRandom(5, 1)));
        $continous->backPropagation(collect([.5]), $adam);
        $this->assertTrue(true);
    }

    public function testDetermineGradientExpectsSuccess()
    {
        $neurons = mt_rand(1, 25);
        $continous = new Continous();
        $continous->determineGradient(Matrix::fillRandom($neurons, $neurons), Matrix::fillRandom($neurons, $neurons));
        $this->assertTrue(true);
    }
}
