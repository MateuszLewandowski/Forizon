<?php

namespace App\Services\System;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;
use App\Abstracts\System\File as AbstractFile;
use InvalidArgumentException;

/**
 * Class File
 * @package App\Services
 */
final class File extends AbstractFile
{
    private const DIRECTORY = 'files';

    public function __construct() {
        $this->timestamp = Carbon::now()->format($this->timestamp_format);
        $this->prefix = 'f';
    }

    public function store(string|array $files, string|array $name, string $extension = 'txt', string $directory = ''): array {
        $store = gettype($files) === 'string' ? [$files] : $files;
        if (empty($store)) {
            return [Response::HTTP_NOT_FOUND, __('app.404', ['attribute' => 'files '])];
        }
        $stored = [];
        $directory = $directory !== '' ? $directory : self::DIRECTORY;
        foreach ($store as $file) {
            [$status, $result] = $this->save($file, $name, $extension, $directory);
            if ($status !== Response::HTTP_CREATED) {
                return $this->destroy($stored);
            }
            $stored[] = $result;
        }
        return $stored
            ? [Response::HTTP_CREATED, $stored]
            : [Response::HTTP_BAD_REQUEST, ''];
    }
}
