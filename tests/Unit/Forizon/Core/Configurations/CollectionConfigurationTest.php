<?php

namespace Tests\Unit\Forizon\Core\Configurations;

use App\Forizon\Core\Configurations\CollectionConfiguration;
use PHPUnit\Framework\TestCase;

class CollectionConfigurationTest extends TestCase
{
    private array $basic_configuration = [
        'table' => 'test_time_series',
        'column_key' => 'key_1',
        'column_value' => 'value_1',
        'batches' => 100,
    ];

    public function testCreateCollectionConfigurationInstanceExpectsSuccess()
    {
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $flag = true;
        $config = $collectionConfiguration->getPropertiesAsArray();
        foreach ($this->basic_configuration as $key => $value) {
            if ($value !== $config[$key]) {
                $flag = false;
            }
        }
        $this->assertTrue($collectionConfiguration instanceof CollectionConfiguration and $flag);
    }
}
