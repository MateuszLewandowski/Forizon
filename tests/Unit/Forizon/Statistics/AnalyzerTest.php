<?php

namespace Tests\Unit\Forizon\Statistics;

use App\Forizon\Data\Statistics\Analyzer;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class AnalyzerTest extends TestCase
{
    private const DEFAULT_DATE_FORMAT = 'Y-m-d';

    private function createDefaultCollection(): Collection {
        return collect([
            Carbon::create(2022, 1, 1)->format(self::DEFAULT_DATE_FORMAT) => 1000.00,
            Carbon::create(2022, 1, 2)->format(self::DEFAULT_DATE_FORMAT) => 2000.00,
            Carbon::create(2022, 1, 3)->format(self::DEFAULT_DATE_FORMAT) => 3000.00,
            Carbon::create(2022, 1, 4)->format(self::DEFAULT_DATE_FORMAT) => 4000.00,
            Carbon::create(2022, 1, 5)->format(self::DEFAULT_DATE_FORMAT) => 5000.00,
            Carbon::create(2022, 1, 6)->format(self::DEFAULT_DATE_FORMAT) => 5000.00,
            Carbon::create(2022, 1, 7)->format(self::DEFAULT_DATE_FORMAT) => 6000.00,
        ]);
    }

    public function testCreateAnalyzerInstanceExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer instanceof Analyzer);
    }

    public function testMinExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->min() === 1000.00);
    }

    public function testMaxExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->max() === 6000.00);
    }

    public function testExtremesKeylessTrueExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->extremes(keyless: true) === [1000.00, 6000.00]);
    }

    public function testExtremesKeylessFalseExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->extremes(keyless: false) === [
            'min' => 1000.00,
            'max' => 6000.00,
        ]);
    }

    public function testMeanExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->mean() === $collection->sum() / $collection->count());
    }

    public function testVarianceExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $mean = $analyzer->mean();
        $squared = $collection->map(function ($value) use ($mean) {
            $subtract = $value - $mean;
            return $subtract * $subtract;
        });
        $this->assertTrue($analyzer->variance() === $squared->sum() / $squared->count());
    }

    public function testCountExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->count() === $collection->count());
    }

    public function testUniqueValuesCountExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->uniqueValuesCount() === $collection->unique()->count());
    }

    public function testMedianExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->median() === $collection->median());
    }

    public function testAverageExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->average() === $collection->average());
    }

    public function testSumExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $analyzer = new Analyzer($collection);
        $this->assertTrue($analyzer->sum() === $collection->sum());
    }
}
