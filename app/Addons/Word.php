<?php

namespace App\Addons;

use Illuminate\Database\Eloquent\Model;

final class Word
{
    /**
     * @param Object|string $class_name
     * @return string
     */
    public final static function getClassName(Object|string $class_name): string {
        if (gettype($class_name) === 'Object') {
            return class_basename($class_name);
        }
        $class = explode("\\", $class_name);
        return end($class);
    }
}
