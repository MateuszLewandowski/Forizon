<?php

namespace Tests\Unit\Forizon\Data\Loader;

use App\Forizon\Core\Configurations\Collections\DatabaseCollectionConfiguration;
use App\Forizon\Data\Loaders\Database;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    private array $basic_configuration = [
        'source' => 'test_time_series',
        'column_key' => 'key_1',
        'column_value' => 'value_1',
        'batches' => 100,
    ];

    public function testCreateObjectInstanceExpectsSuccess()
    {
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $this->assertTrue($databaseLoader instanceof Database);
    }

    public function testGetColumnKeyDistinctExpectsSuccess()
    {
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $this->assertTrue($databaseLoader->getColumnKeyDistinct() > 0);
    }

    public function testGetColumnValueDistinctExpectsSuccess()
    {
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $this->assertTrue($databaseLoader->getColumnValueDistinct() > 0);
    }

    public function testGetTotalSamplesQuantityExpectsSuccess()
    {
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $this->assertTrue($databaseLoader->getTotalSamplesQuantity() > 0);
    }

    public function testLoadDefaultCollectionExpectsSuccess()
    {
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }

    public function testLoadCollectionWithSecondKeyValuePairExpectsSuccess()
    {
        $this->basic_configuration['column_key'] = 'key_2';
        $this->basic_configuration['column_value'] = 'value_2';
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }

    public function testLoadCollectionWithThirdKeyValuePairExpectsSuccess()
    {
        $this->basic_configuration['column_key'] = 'key_3';
        $this->basic_configuration['column_value'] = 'value_3';
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }

    public function testLoadCollectionWithFourthKeyValuePairExpectsSuccess()
    {
        $this->basic_configuration['column_key'] = 'key_4';
        $this->basic_configuration['column_value'] = 'value_4';
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }

    public function testLoadCollectionWithDoubledBatchSizePairExpectsSuccess()
    {
        $this->basic_configuration['batches'] = 250;
        $databaseCollectionConfiguration = new DatabaseCollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($databaseCollectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }
}
