<?php

namespace Tests\Unit\Forizon\Data\Loader;

use App\Forizon\Core\Configurations\CollectionConfiguration;
use App\Forizon\Data\Loaders\Database;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    private array $basic_configuration = [
        'table' => 'test_time_series',
        'column_key' => 'key_1',
        'column_value' => 'value_1',
        'batches' => 100,
    ];

    public function testCreateObjectInstanceExpectsSuccess()
    {
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $this->assertTrue($databaseLoader instanceof Database);
    }

    public function testGetColumnKeyDistinctExpectsSuccess()
    {
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $this->assertTrue($databaseLoader->getColumnKeyDistinct() > 0);
    }

    public function testGetColumnValueDistinctExpectsSuccess()
    {
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $this->assertTrue($databaseLoader->getColumnValueDistinct() > 0);
    }

    public function testGetTotalSamplesQuantityExpectsSuccess()
    {
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $this->assertTrue($databaseLoader->getTotalSamplesQuantity() > 0);
    }

    public function testLoadDefaultCollectionExpectsSuccess()
    {
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }

    public function testLoadCollectionWithSecondKeyValuePairExpectsSuccess()
    {
        $this->basic_configuration['column_key'] = 'key_2';
        $this->basic_configuration['column_value'] = 'value_2';
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }

    public function testLoadCollectionWithThirdKeyValuePairExpectsSuccess()
    {
        $this->basic_configuration['column_key'] = 'key_3';
        $this->basic_configuration['column_value'] = 'value_3';
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }

    public function testLoadCollectionWithFourthKeyValuePairExpectsSuccess()
    {
        $this->basic_configuration['column_key'] = 'key_4';
        $this->basic_configuration['column_value'] = 'value_4';
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }

    public function testLoadCollectionWithDoubledBatchSizePairExpectsSuccess()
    {
        $this->basic_configuration['batches'] = 250;
        $collectionConfiguration = new CollectionConfiguration($this->basic_configuration);
        $databaseLoader = new Database($collectionConfiguration);
        $collection = $databaseLoader->loadCollection();
        $this->assertTrue($collection->count() > 0);
    }
}
