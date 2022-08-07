<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->useSubFoldersDuringMigration();
    }

    /**
     * @see https://stackoverflow.com/questions/55018704/how-to-specify-folder-for-laravel-migrations
     *
     * @return void
     */
    private function useSubFoldersDuringMigration(): void
    {
        $mainPath = database_path('migrations');
        $directories = glob($mainPath.'/*', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }
}
