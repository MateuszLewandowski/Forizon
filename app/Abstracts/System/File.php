<?php

namespace App\Abstracts\System;

use Dotenv\Exception\InvalidFileException;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;
use App\Models\System\File as FileModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

abstract class File
{
    /**
     * @var string $timestmap_format = 'TmdHis';
     */
    protected string $timestmap_format = 'YmdHis';

    /**
     * @var ?string $file_name_prefix = null;
     */
    protected ?string $file_name_prefix = null;

    /**
     * @var ?string $file_name_sufix = null;
     */
    protected ?string $file_name_sufix = null;

    /**
     * @var ?string $direcotry = null;
     */
    protected ?string $directory = null;

    public abstract function store(string|array $files, string|array $name, string $extension = 'txt', string $directory = ''): array;

    public function load(array|string $files, bool $strict = true) {
        try {
            $targets = gettype($files) === 'string' ? [$files] : $files;
            if (empty($targets)) {
                return [Response::HTTP_NOT_FOUND, __('app.404', ['attribute' => 'files '])];
            }
            $query = FileModel::orderBy('id');
            $names = [];
            foreach ($targets as $target) {
                if (gettype($target) !== 'string') {
                    return [Response::HTTP_BAD_REQUEST, ''];
                }
                if (!isset($target['id']) or !isset($target['name'])) {
                    return [Response::HTTP_BAD_REQUEST, ''];
                }
                $query->where('id', $target['id']);
                $names[] = $target['name'];
            }
            if (!$query->exists() and $strict) {
                return [Response::HTTP_NOT_FOUND, __('app.404', ['attribute' => 'files '])];
            }
            $loaded = [];
            foreach ($names as $name) {
                $data = Storage::exists($name) ? Storage::get($name) : null;
                $loaded[] = [
                    'name' => $name,
                    'data' => $data
                ];
            }
            return !empty($loaded)
                ? [Response::HTTP_OK, $loaded]
                : [Response::HTTP_NOT_FOUND, ''];
        } catch (InvalidFileException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (CannotWriteFileException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (ModelNotFoundException $e) {
            return [$e->getCode(), $e->getMessage()];
        }
    }

    protected function save(array|string $files, string $context = 'research') {
        try {
            $targets = gettype($files) === 'string' ? [$files] : $files;
            if (empty($targets)) {
                return [Response::HTTP_NOT_FOUND, __('app.404', ['attribute' => 'files '])];
            }
            $names = [];
            foreach ($targets as $target) {
                if (gettype($target) !== 'string') {
                    return [Response::HTTP_BAD_REQUEST, ''];
                }
                if (!isset($target['data'])) {
                    return [Response::HTTP_BAD_REQUEST, ''];
                }
                $data = (is_array($target['data']) or is_object($target['data'])) ? json_encode($target['data']) : $target['data'];
                $timestamp = Carbon::now()->format($this->format);
                $extension = isset($target['extension']) ? $target['extension'] : 'txt';
                $name = isset($target['name']) ? $target['name'] : 'file';
                $name = implode('_', [$timestamp, $this->file_name_prefix, $name, $this->file_name_sufix]);
                $name = implode('.', [$name, $extension]);
                $name = implode('/', [$this->directory, $name]);
                $names[] = $name;
                DB::transaction(function () use ($name, $data, $context) {
                    $created = FileModel::create([
                        'context' => $context,
                        'name' => $name
                    ]);
                    $stored = Storage::put($name, $data);
                    if (!$created or !$stored) {
                        throw new CannotWriteFileException(
                            '', Response::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                });
            }
            return [Response::HTTP_CREATED, $names];
        } catch (InvalidFileException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (ExtensionFileException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (CannotWriteFileException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (Exception $e) {
            return [$e->getCode(), $e->getMessage()];
        }
    }

    public function destroy(array|string $files): array {
        try {
            $targets = gettype($files) === 'string' ? [$files] : $files;
            if (empty($targets)) {
                return [Response::HTTP_NOT_FOUND, __('app.404', ['attribute' => 'files '])];
            }
            foreach ($targets as $target) {
                if (gettype($target) !== 'string') {
                    return [Response::HTTP_BAD_REQUEST, ''];
                }
            }
            return Storage::delete($files)
                ? [Response::HTTP_OK, '']
                : [Response::HTTP_BAD_REQUEST, ''];
        } catch (InvalidFileException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (CannotWriteFileException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (Exception $e) {
            return [$e->getCode(), $e->getMessage()];
        }
    }

    /**
     * @param array $names = []
     * @param bool $string = true
     * @return array
     * @throws NoFileException
     * @throws Exception
     */
    public function get(string|array $names = [], bool $strict = true): array {
        try {
            $get = gettype($names) === 'string' ? [$names] : $names;
            $result = [];
            foreach ($get as $name) {
                if (!Storage::exists($name)) {
                    if ($strict === true) {
                        return [Response::HTTP_NOT_FOUND, ''];
                    }
                    continue;
                }
                $result[] = json_decode(Storage::get($name), true);
            }
            return !empty($result)
                ? [Response::HTTP_OK, $result]
                : [Response::HTTP_NOT_FOUND, __('app.404', ['attribute' => 'file ' . $name])];
        } catch (NoFileException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (Exception $e) {
            return [$e->getCode(), $e->getMessage()];
        }
    }
}
