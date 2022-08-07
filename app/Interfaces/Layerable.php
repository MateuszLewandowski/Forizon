<?php

namespace App\Interfaces;

interface Layerable
{
    public function setInputLayer();

    public function setHiddenLayer();

    public function setHiddenLayers();

    public function setOutputLayer();

    public function getLayers();
}
