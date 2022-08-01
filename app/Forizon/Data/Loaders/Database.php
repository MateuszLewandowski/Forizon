<?php

namespace App\Forizon\Data\Loaders;

use App\Forizon\Core\Configurations\CollectionConfiguration;
use Illuminate\Database\Eloquent\Builder;
use App\Forizon\Abstracts\Data\Loader;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;
use PDOException;

class Database extends Loader
{
    private const DEFAULT_TIMESTAMP = 'Y-m-d H:i:s';

    private ?Builder $query = null;

    public function __construct(CollectionConfiguration $collectionConfiguration)
    {
        try {
            $config = $collectionConfiguration->getProperiesAsObject();
            $this->setTable($config->table)
                ->setResearchableColumnKey($config->column_key)
                ->setResearchableColumnValue($config->column_value)
                ->groupByInterval($config?->group_by_interval)
                ->setSkipValuesGreaterThan($config?->skip_values_greater_than)
                ->setSkipValuesGreaterOrEqualThan($config?->skip_values_less_than)
                ->setSkipValuesLessThan($config?->skip_values_greater_or_equal_than)
                ->setSkipValuesLessOrEqualThan($config?->skip_values_less_or_equal_than)
                ->setDateTimeFrom($config?->dateTimeFrom)
                ->setDateTimeTo($config?->dateTimeTo)
                ->setBatches($config?->batches);
        } catch (RuntimeException $e) {
            //
        } catch (PDOException $e) {
            //
        } catch (InvalidArgumentException $e) {

        }
    }

    /**
     * The column key distinct.
     *
     * @return integer
     */
    public function getColumnKeyDistinct(): int {
        try {
            return $this->query()->distinct()->count($this->column_key);
        } catch (PDOException $e) {
            //
        }
    }

    /**
     * The column value distinct.
     *
     * @return integer
     */
    public function getColumnValueDistinct(): int {
        try {
            return $this->query()->distinct()->count($this->column_value);
        } catch (PDOException $e) {
            //
        }
    }

    /**
     * The qauntity of the loaded collection samples.
     *
     * @return integer
     */
    public function getTotalSamplesQuantity(): int {
        try {
            return $this->query()->count();
        } catch (PDOException $e) {
            //
        }
    }

    private function query(): Builder {
        if (!is_null($this->query)) {
            return $this->query;
        }
        try {
            $where = [];
            $query = DB::table($this->table)
                ->selectRaw("$this->column_key as key, $this->column_value as value");
            if (!is_null($this->dateTimeFrom)) {
                $query = $query->whereDate('key', '>=', $this->DateTimeFrom->format(self::DEFAULT_TIMESTAMP));
            }
            if (!is_null($this->dateTimeTo)) {
                $query = $query->whereDate('key', '<=', $this->DateTimeTo->format(self::DEFAULT_TIMESTAMP));
            }
            if (!is_null($this->batches)) {
                $query = $query->limit($this->batches);
            }
            if (!is_null($this->skip_values_greater_than) and $this->skippig_by = 'remove') {
                $where[] = [
                    'value', '>', $this->skip_values_greater_than
                ];
            }
            if (!is_null($this->skip_values_less_than) and $this->skippig_by = 'remove') {
                $where[] = [
                    'value', '<', $this->skip_values_less_than
                ];
            }
            if (!is_null($this->skip_values_greater_or_equal_than) and $this->skippig_by = 'remove') {
                $where[] = [
                    'value', '>=', $this->skip_values_greater_or_equal_than
                ];
            }
            if (!is_null($this->skip_values_less_or_equal_than) and $this->skippig_by = 'remove') {
                $where[] = [
                    'value', '<=', $this->skip_values_less_or_equal_than
                ];
            }
            if (!empty($where)) {
                $query = $query->where($where);
            }
            return $query;
        } catch (PDOException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * Returning collection of datasets with defined column key and column value pairs.
     *
     * @return Collection
     */
    public function loadCollection(): Collection {
        try {
            return $this->query()->get();
        } catch (PDOException $e) {
            Log::critical($e->getMessage(), [__CLASS__]);
            throw $e;
        }
    }

    /**
     * Normalize dataset collection in given way.
     *
     * @return Collection
     */
    public function normalizeCollection(): Collection {

    }

}
