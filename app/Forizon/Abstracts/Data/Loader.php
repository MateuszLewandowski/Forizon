<?php

namespace App\Forizon\Abstracts\Data;

use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;

/**
 * @see App\Forizon\Core\Configurations\CollectionConfiguration
 */
abstract class Loader
{
    public array $collection;

    public string $source;

    public string $column_key;

    public string $column_value;

    public string $group_by_interval = 'd';

    public bool $skip_extremes = false;

    public float|bool $skippig_by = false;

    public ?float $skip_values_greater_than = null;

    public ?float $skip_values_less_than = null;

    public ?float $skip_values_greater_or_equal_than = null;

    public ?float $skip_values_less_or_equal_than = null;

    public ?DateTime $dateTimeFrom = null;

    public ?DateTime $dateTimeTo = null;

    public ?int $batches = null;

    /**
     * @param  string  $source
     * @return self
     */
    abstract public function source(string $source): self;

    /**
     * @param  string  $column_key
     * @return self
     */
    abstract public function researchableColumnKey(string $column_key): self;

    /**
     * @param  string  $column_value
     * @return self
     */
    abstract public function researchableColumnValue(string $column_value): self;

    /**
     * The way in which the samples have to be grouped. default daily.
     *
     * h - hourly
     * d - daily
     * w - weekly
     * m - monthly
     * y - yearly
     *
     * @param  string  $interval
     * @return self
     */
    public function groupByInterval(string $interval = 'd'): self
    {
        switch ($interval) {
            case 'h':
            case 'd':
            case 'w':
            case 'm':
            case 'y':
                $this->group_by_interval = $interval;
                break;
            default:
                $this->group_by_interval = 'd';
                Log::warning("Incorrect interval grouping range given ($interval). Default has been set.");
                break;
        }

        return $this;
    }

    /**
     * @todo Exception message and status code.
     *
     * @return float
     */
    public function getMin(): float
    {
        if (! $this->collection) {
            throw new RuntimeException();
        }
        $min = INF;
        foreach ($this->collection as $value) {
            if ($value < $min) {
                $min = $value;
            }
        }

        return $min;
    }

    public function skipValuesGreaterThan(?float $value = null): self
    {
        if (! is_null($value)) {
            $this->skip_values_greater_or_equal_than = null;
            $this->skip_values_greater_or_than = $value;
        }

        return $this;
    }

    public function skipValuesGreaterOrEqualThan(?float $value = null): self
    {
        if (! is_null($value)) {
            $this->skip_values_greater_or_than = null;
            $this->skip_values_greater_or_equal_than = $value;
        }

        return $this;
    }

    public function skipValuesLessThan(?float $value = null): self
    {
        if (! is_null($value)) {
            $this->skip_values_less_or_equal_than = null;
            $this->skip_values_less_or_than = $value;
        }

        return $this;
    }

    public function skipValuesLessOrEqualThan(?float $value = null): self
    {
        if (! is_null($value)) {
            $this->skip_values_less_or_than = null;
            $this->skip_values_less_or_equal_than = $value;
        }

        return $this;
    }

    /**
     * @todo Validate if given batches quantity in available.
     * @todo Exception message and status code.
     *
     * @param  int  $batches
     * @return self
     */
    public function batches(?int $batches = null): self
    {
        if ($batches < 1) {
            throw new InvalidArgumentException();
        }
        $this->batches = $batches;

        return $this;
    }

    /**
     * @todo Validate if date exists in source's column key.
     *
     * @param  DateTime  $dateTimeFrom
     * @return self
     */
    public function dateTimeFrom(?DateTime $dateTimeFrom = null): self
    {
        $this->dateTimeFrom = $dateTimeFrom;

        return $this;
    }

    /**
     * @todo Validate if date exists in source's column key.
     *
     * @param  DateTime  $dateTimeFrom
     * @return self
     */
    public function dateTimeTo(?DateTime $dateTimeTo = null): self
    {
        $this->dateTimeTo = $dateTimeTo;

        return $this;
    }

    /**
     * The qauntity of the loaded collection samples.
     *
     * @return int
     */
    abstract public function getTotalSamplesQuantity(): int;

    /**
     * The column key distinct.
     *
     * @return int
     */
    abstract public function getColumnKeyDistinct(): int;

    /**
     * The column value distinct.
     *
     * @return int
     */
    abstract public function getColumnValueDistinct(): int;

    /**
     * Returning collection of datasets with defined column key and column value pairs.
     *
     * @return Collection
     */
    abstract public function loadCollection(): Collection;
}
