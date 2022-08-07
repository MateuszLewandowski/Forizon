<?php

namespace App\Addons;

final class Word
{
    /**
     * @param  object|string  $class_name
     * @return string
     */
    final public static function getClassName(object|string $class_name): string
    {
        if (gettype($class_name) === 'Object') {
            return class_basename($class_name);
        }
        $class = explode('\\', $class_name);

        return end($class);
    }
}
