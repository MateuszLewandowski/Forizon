<?php

namespace App\Forizon\Core\Configurations;

use App\Forizon\Abstracts\Configuration;
use Psy\Exception\TypeErrorException;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use DateTime;

/**
 * In case that there will be DateTimeFrom, DateTimeTo and batches null's. All available samples will be returned.
 */
class CollectionConfiguration extends Configuration
{
    private const REQUIRED = [
        'table', 'column_key', 'column_value',
    ];

    private const REQUIRED_ONE_OF = [
        'batches', 'dateTimeFrom', 'dateTimeTo',
    ];

    /**
     * @todo Exception message and status code.
     *
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        try {
            foreach ($properties as $key => $value) {
                if (!property_exists($this, $key)) {
                    Log::warning("Attempt to assign a value to a non-existent key {$key} in CollectionConfiguration.");
                    continue;
                }
                $this->set($key, $value);
            }
            foreach (self::REQUIRED as $name) {
                if (!in_array($name, $this->used)) {
                    throw new InvalidArgumentException();
                }
            }
            $flag = false;
            foreach (self::REQUIRED_ONE_OF as $name) {
                if (in_array($name, $this->used)) {
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                throw new InvalidArgumentException();
            }
        } catch (InvalidArgumentException $e) {

        } catch (TypeErrorException $e) {

        }
    }
    /**
     * Table from which researchable data will be taken.
     *
     * @var string
     */
    public string $table;

    /**
     * A column in a previously edited table whose data is mixed type, but string or date are prefered.
     *
     * @var string
     */
    public string $column_key;

    /**
     * A column in a previously edited table whose data is float type.
     *
     * @var string
     */
    public string $column_value;

    /**
     * Group interval signature for time series order. default daily.
     *
     * h - hourly
     * d - daily
     * w - weekly
     * m - monthly
     * y - yearly
     *
     * @var string
     */
    public string $group_by_interval = 'd';

    /**
     * Replace the skipped value with:
     *
     * - false - no action
     * - remove
     * - zero
     * - one
     * - mean
     * - median
     * - precise value
     *
     * @var float|bool
     */
    public float|bool $skippig_by = false;

    /**
     * Default false.
     *
     * @var boolean
     */
    public bool $skip_extremes = false;

    /**
     * Skip all values that are greater than given value.
     *
     * @var float|null
     */
    public ?float $skip_values_greater_than = null;

    /**
     * Skip all values that are less than given value.
     *
     * @var float|null
     */
    public ?float $skip_values_less_than = null;

    /**
     * Skip all values that are greater or equal than given value.
     *
     * @var float|null
     */
    public ?float $skip_values_greater_or_equal_than = null;

    /**
     * Skip all values that are less or equal than given value.
     *
     * @var float|null
     */
    public ?float $skip_values_less_or_equal_than = null;

    /**
     * @var DateTime
     * Date time from - default = first sample
     * Date time to - default = last sample
     */
    public ?DateTime $dateTimeFrom = null, $dateTimeTo = null;

    /**
     * If specified, get only samples in the defined batches quantity.
     * It is batch size (input vector length) as base, and:
     * + batches in regression problems.
     * + no action in classification.
     *
     * @todo Verify comment.
     * @var integer
     */
    public ?int $batches = null;
}
