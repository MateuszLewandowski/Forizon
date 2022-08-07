<?php

namespace App\Forizon\System\Services;

use Illuminate\Support\Facades\File;

/**
 * @todo target switch -> path or namespace
 */
class ClassSearcher
{
    private string $app_name;

    private array $base;

    public function __construct(private string $target, private bool $is_path = false)
    {
        // $this->app_name = ucfirst(config('app.name'));
        $this->app_name = 'Forizon';
        $this->is_path = $is_path;
        $this->target = $target;
        $this->base = ['app', $this->app_name];
    }

    /**
     * @return array
     */
    public function getClasses(): array
    {
        $path = $this->covertNamespaceToPath($this->target);
        $files = File::allFiles($path);
        $classes = [];
        if ($files) {
            foreach ($files as $file) {
                $parts = explode('.', $file->getFilename());
                $filename = current($parts);
                $realpath = $file->getRealPath();
                $parts = explode('.', $realpath);
                $base = implode('/', $this->base);
                $class = strstr(current($parts), $base);
                $classes[$filename] = $this->covertPathToNamespace($class);
            }
        }

        return $classes;
    }

    /**
     * @return array<ActivationFunction>
     */
    public function getObjects(): array
    {
        $objects = [];
        foreach ($this->getClasses() as $name => $class) {
            $objects[$name] = new $class;
        }

        return $objects;
    }

    private function covertNamespaceToPath(string $namespace): string
    {
        $parts = explode('\\', $namespace);

        return implode('/', array_merge($this->base, $parts));
    }

    private function covertPathToNamespace(string $path): string
    {
        $parts = explode('/', $path);
        foreach ($parts as &$part) {
            $part = ucfirst($part);
        }

        return implode('\\', $parts);
    }
}
