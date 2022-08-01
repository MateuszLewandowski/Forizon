<?php

namespace App\Forizon\Core\Configurations;

use App\Forizon\Abstracts\Configuration;
use DateTime;

/**
 * In case that there will be DateTimeFrom, DateTimeTo and batches null's. All available samples will be returned.
 */
class CollectionConfiguration extends Configuration
{
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
