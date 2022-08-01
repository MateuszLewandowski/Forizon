<?php

namespace App\Forizon\Abstracts\Data;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;
use DateTime;

/**
 * @see App\Forizon\Core\Configurations\CollectionConfiguration
 */
abstract class Loader
{
    public array $collection;
    public string $table;
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
     * @todo Check if table exists.
     *
     * @param string $table
     * @return self
     */
    public function setTable(string $table): self {
        if (!Schema::hasTable($table)) {

        }
        $this->table = $table;
        return $this;
    }

    /**
     * @todo Check if table and column exists and its data type.
     *
     * @param string $column_key
     * @return self
     */
    public function setResearchableColumnKey(string $column_key): self {
        if (!$this->table)  {

        }
        if (!Schema::hasColumn($this->table, $column_key)) {

        }
        $this->column_key = $column_key;
        return $this;
    }

    /**
     * @todo Check if table and column exists and its data type.
     *
     * @param string $column_value
     * @return self
     */
    public function setResearchableColumnValue(string $column_value): self {
        if (!$this->table)  {

        }
        if (!Schema::hasColumn($this->table, $column_value)) {

        }
        $this->column_value = $column_value;
        return $this;
    }

    /**
     * The way in which the samples have to be grouped. default daily.
     *
     * h - hourly
     * d - daily
     * w - weekly
     * m - monthly
     * y - yearly
     *
     * @param string $interval
     * @return self
     */
    public function groupByInterval(string $interval = 'd'): self {
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
     * Return the minimum value from the loaded collection.
     * @todo Exception message and status code.
     * @return float
     */
    public function getMin(): float {
        if (!$this->collection) {
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

    /**
     * Return the maximum value from the loaded collection.
     *
     * @todo Exception message and status code.
     * @return float
     */
    public function getMax(): float {
        if (!$this->collection) {
            throw new RuntimeException();
        }
        $max = -INF;
        foreach ($this->collection as $value) {
            if ($value > $max) {
                $max = $value;
            }
        }
        return $max;
    }

    /**
     * Return extremes (min and max values) from the loaded collection.
     *
     * @return array
     */
    public function getExtremes(): array {
        return [
            'min' => $this->getMin(),
            'max' => $this->getMax(),
        ];
    }

    public function setSkipValuesGreaterThan(?float $value = null): self {
        if (!is_null($value)) {
            $this->skip_values_greater_or_equal_than = null;
            $this->skip_values_greater_or_than = $value;
        }
        return $this;
    }

    public function setSkipValuesGreaterOrEqualThan(?float $value = null): self {
        if (!is_null($value)) {
            $this->skip_values_greater_or_than = null;
            $this->skip_values_greater_or_equal_than = $value;
        }
        return $this;
    }

    public function setSkipValuesLessThan(?float $value = null): self {
        if (!is_null($value)) {
            $this->skip_values_less_or_equal_than = null;
            $this->skip_values_less_or_than = $value;
        }
        return $this;
    }

    public function setSkipValuesLessOrEqualThan(?float $value = null): self {
        if (!is_null($value)) {
            $this->skip_values_less_or_than = null;
            $this->skip_values_less_or_equal_than = $value;
        }
        return $this;
    }

    /**
     * @todo Validate if given batches quantity in available.
     * @todo Exception message and status code.
     * @param integer $batches
     * @return self
     */
    public function setBatches(int $batches): self {
        if ($batches < 1) {
            throw new InvalidArgumentException();
        }
        $this->batches = $batches;
        return $this;
    }

    /**
     * @todo Validate if date exists in table's column key.
     * @param DateTime $dateTimeFrom
     * @return self
     */
    public function setDateTimeFrom(DateTime $dateTimeFrom): self {
        $this->dateTimeFrom = $dateTimeFrom;
        return $this;
    }

    /**
     * @todo Validate if date exists in table's column key.
     * @param DateTime $dateTimeFrom
     * @return self
     */
    public function setDateTimeTo(DateTime $dateTimeTo): self {
        $this->dateTimeTo = $dateTimeTo;
        return $this;
    }

    /**
     * The qauntity of the loaded collection samples.
     *
     * @return integer
     */
    public abstract function getTotalSamplesQuantity(): int;

    /**
     * The column key distinct.
     *
     * @return integer
     */
    public abstract function getColumnKeyDistinct(): int;

    /**
     * The column value distinct.
     *
     * @return integer
     */
    public abstract function getColumnValueDistinct(): int;

    /**
     * Returning collection of datasets with defined column key and column value pairs.
     *
     * @return Collection
     */
    public abstract function loadCollection(): Collection;

    /**
     * Normalize dataset collection in given way.
     *
     * @return Collection
     */
    public abstract function normalizeCollection(): Collection;
}
