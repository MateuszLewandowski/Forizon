<?php

namespace Tests\Unit\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers;
use App\Forizon\Core\ComputationalIntelligence\ArtificialNeuralNetworks\Layers\Input;
use InvalidArgumentException;
use App\Forizon\Tensors\Matrix;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testCreateObjectInstanceExpectsSuccess()
    {
        $flag = true;
        for ($i = 0; $i < 5; $i++) {
            $neurons = mt_rand(1, 999);
            $input = new Input($neurons);
            if ($neurons !== $input->getNeurons()) {
                $flag = false;
            }
        }
        $this->assertTrue($flag);
    }

    public function testCreateObjectInstanceWithZeroNeuronsExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Input(0);
    }

    public function testCreateObjectInstanceWithNegativeNumbersOfNeuronsExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Input(-25);
    }

    public function testInitializeLayerExpectsSuccess()
    {
        $flag = true;
        for ($i = 0; $i < 5; $i++) {
            $neurons = mt_rand(1, 999);
            $input = new Input($neurons);
            $_neurons = mt_rand(1, 999);
            if ($neurons !== $input->initialize($_neurons)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }

    public function testFeedForwardExpectsSuccess()
    {
        $flag = true;
        $neurons = mt_rand(4, 7);
        $input = new Input($neurons);
        $matrix = Matrix::fillRandom($neurons, 3);
        $feedForward = $input->feedForward($matrix);
        if ($feedForward->rows !== $input->getNeurons()) {
            $flag = false;
        }
        $this->assertTrue($flag);
    }

    public function testFeedForwardExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $neurons = mt_rand(4, 7);
        $input = new Input($neurons);
        $matrix = Matrix::fillRandom($neurons + 1, 3);
        $input->feedForward($matrix);
    }

    public function testTouchExpectsSuccess()
    {
        $flag = true;
        $neurons = mt_rand(4, 7);
        $input = new Input($neurons);
        $matrix = Matrix::fillRandom($neurons, 3);
        $feedForward = $input->feedForward($matrix);
        if ($feedForward->rows !== $input->getNeurons()) {
            $flag = false;
        }
        $this->assertTrue($flag);
    }

    public function testTouchExpectsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $neurons = mt_rand(4, 7);
        $input = new Input($neurons);
        $matrix = Matrix::fillRandom($neurons + 1, 3);
        $input->feedForward($matrix);
    }
}
