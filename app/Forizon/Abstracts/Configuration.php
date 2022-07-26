<?php

namespace App\Forizon\Abstracts;

use stdClass;
use Symfony\Component\Process\Exception\InvalidArgumentException;

abstract class Configuration
{
    /**
     * attributes that has been used in the initialization process.
     *
     * @var array
     */
    protected array $used = [];

    /**
     * Set configuration variable.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function set(string $key, mixed $value): void
    {
        $this->{$key} = $value;
        $this->setUsed($key);

    }

    /**
     * @param  string  $key
     * @return void
     */
    public function setUsed(string $key): void
    {
        if (! array_key_exists($key, $this->used)) {
            $this->used[] = $key;
        }

    }

    /**
     * Get config variable or variable array.
     *
     * @param  string|array  $key
     * @param  bool  $strict
     * @return mixed
     */
    public function get(string|array $key, bool $strict = true): mixed
    {
        if ($strict) {
            $this->validateStrict($key);
        }
        if (is_array($key)) {
            $result = [];
            foreach ($key as $k) {
                $result[$k] = isset($this->{$k})
                ? $this->{$key}
                : null;
            }

            return $result;
        }

        return isset($this->{$key})
            ? [$key => $this->{$key}]
            : [$key => null];
    }

    /**
     * Returning all defined properties as array.
     *
     * @return array
     */
    public function getPropertiesAsArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Returning all defined properties as object.
     *
     * @return stdClass
     */
    public function getPropertiesAsObject(): stdClass
    {
        return (object) $this->getPropertiesAsArray();
    }

    /**
     * Check if configuration key exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        return isset($this->{$key});
    }

    /**
     * Unset configuration key or keys. Strict flag require that unsetting property is previously defined.
     *
     * @param  string|array  $key
     * @param  bool  $strict
     * @return void
     */
    public function unset(string|array $key, bool $strict = true): void
    {
        if ($strict) {
            $this->validateStrict($key);
        }
        if (is_array($key)) {
            foreach ($key as $k) {
                unset($this->{$k});
            }

            return;
        }
        unset($this->{$key});
    }

    /**
     * @todo
     *
     * @param  string|array  $key
     * @return void
     */
    private function validateStrict(string|array $key): void
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                if (! isset($this->{$k})) {
                    throw new InvalidArgumentException();
                }
                //
            }

            return;
        }
        if (! isset($this->{$key})) {
            throw new InvalidArgumentException();
        }
        //
    }
}
