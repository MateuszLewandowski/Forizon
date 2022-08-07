<?php

namespace App\Forizon\Interfaces\Core\Tensor;

interface Statistical
{
    public function mean(): mixed;

    /**
     * @see https://pogotowiestatystyczne.pl/slowniki/wariancja/
     * @see https://www.skarbiec.pl/slownik/wariancja/
     */
    public function variance($mean = null): mixed;

    /**
     * @see https://zpe.gov.pl/a/przeczytaj/DQzJKaV85
     */
    public function quantile(float $q): mixed;
}
