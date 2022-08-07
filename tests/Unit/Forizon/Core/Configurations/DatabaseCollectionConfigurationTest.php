<?php

namespace Tests\Unit\Forizon\Core\Configurations;

use App\Forizon\Core\Configurations\Collections\DatabaseCollectionConfiguration;
use PHPUnit\Framework\TestCase;

class DatabaseCollectionConfigurationTest extends TestCase
{
    private array $basic_configuration = [
        'source' => 'test_time_series',
        'column_key' => 'key_1',
        'column_value' => 'value_1',
        'batches' => 100,
    ];

    public function testCreateCollectionConfigurationInstanceExpectsSuccess()
    {
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $flag = true;
        $config = $databaseCollectionConfiguration->getPropertiesAsArray();
        foreach ($this->basic_configuration as $key => $value) {
            if ($value !== $config[$key]) {
                $flag = false;
            }
        }
        $this->assertTrue($databaseCollectionConfiguration instanceof DatabaseCollectionConfiguration and $flag);
    }
}
