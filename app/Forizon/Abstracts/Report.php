<?php

namespace App\Forizon\Abstracts;

abstract class Report
{
    abstract public function generate(): array;

    protected function saveAsFile(): bool
    {
        return false;
    }

    protected function getPropertiesListing(object $object): array
    {
        $properties = get_object_vars($object);
        if ($properties) {
            foreach ($properties as &$property) {
                if (gettype($property) === 'object') {
                    $property = $this->getPropertiesListing($property);
                }
            }
        }

        return $properties;
    }
}
