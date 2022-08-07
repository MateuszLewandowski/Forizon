<?php

namespace App\Forizon\Core\Configurations\Collections;

use App\Forizon\Abstracts\Core\CollectionConfiguration;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Psy\Exception\TypeErrorException;

class DatabaseCollectionConfiguration extends CollectionConfiguration
{
    private const REQUIRED = [
        'source', 'column_key', 'column_value',
    ];

    private const REQUIRED_ONE_OF = [
        'batches', 'dateTimeFrom', 'dateTimeTo',
    ];

    /**
     * @todo Exception message and status code.
     *
     * @param  array  $properties
     */
    public function __construct(array $properties)
    {
        try {
            foreach ($properties as $key => $value) {
                if (! property_exists($this, $key)) {
                    Log::warning("Attempt to assign a value to a non-existent key {$key} in CollectionConfiguration.");

                    continue;
                }
                $this->set($key, $value);
            }
            foreach (self::REQUIRED as $name) {
                if (! in_array($name, $this->used)) {
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
            if (! $flag) {
                throw new InvalidArgumentException();
            }
            unset($this->used);
        } catch (InvalidArgumentException $e) {
            //
        } catch (TypeErrorException $e) {
            //
        }
    }
}
