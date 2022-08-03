<?php

namespace Tests\Unit\Forizon\Statistics\Converters;

use App\Forizon\Data\Converters\Normalizer;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class NormalizerTest extends TestCase
{
    private const DEFAULT_DATE_FORMAT = 'Y-m-d';

    private function createDefaultCollection(): Collection {
        return collect([
            Carbon::create(2022, 1, 1)->format(self::DEFAULT_DATE_FORMAT) => 1000.00,
            Carbon::create(2022, 1, 2)->format(self::DEFAULT_DATE_FORMAT) => 2000.00,
            Carbon::create(2022, 1, 3)->format(self::DEFAULT_DATE_FORMAT) => 3000.00,
            Carbon::create(2022, 1, 4)->format(self::DEFAULT_DATE_FORMAT) => 4000.00,
            Carbon::create(2022, 1, 5)->format(self::DEFAULT_DATE_FORMAT) => 5000.00,
            Carbon::create(2022, 1, 6)->format(self::DEFAULT_DATE_FORMAT) => 6000.00,
        ]);
    }

    public function testCreateNormalizerInstanceExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $normalizer = new Normalizer($collection);
        $this->assertTrue($normalizer instanceof Normalizer);
    }

    public function testMinMaxFeatureScalingExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $normalizer = new Normalizer($collection);
        $normalizedCollection = $normalizer->minMaxFeatureScaling();
        $flag = true;
        foreach ($normalizedCollection as $value) {
            if ($value < 0.0 or $value > 1.0) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }

    public function testMinMaxFeatureDescalingExpectsSuccess()
    {
        $collection = $this->createDefaultCollection();
        $normalizer = new Normalizer($collection);
        $normalizedCollection = $normalizer->minMaxFeatureScaling();
        $denormalizedCollection = $normalizer->minMaxFeatureDescaling($normalizedCollection);
        $flag = true;
        foreach ($denormalizedCollection as $key => $value) {
            if (!$val = $collection->get($key)) {
                $flag = false;
                break;
            }
            if ($val !== $value) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }
}
