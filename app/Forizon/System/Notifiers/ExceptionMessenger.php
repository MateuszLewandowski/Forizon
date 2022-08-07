<?php

namespace App\Forizon\System\Notifiers;

use Exception;

class ExceptionMessenger
{
    /**
     * @param  Exception  $e
     * @return string
     */
    public static function critical(Exception $e): string
    {
        return implode('_', [
            $e->getCode(), $e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString(),
        ]);
    }
}
