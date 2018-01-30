<?php

namespace Novius\Backpack\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class VisualComposerServiceProvider extends LaravelServiceProvider
{
    const PACKAGE_NAME = 'laravel-backpack-visualcomposer';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $packageDir = dirname(__DIR__);

        //$this->publishes([$packageDir.'/config' => config_path('backpack')], 'config');
        //$this->publishes([$packageDir.'/resources/lang' => resource_path('lang/vendor/backpack')], 'lang');
        //$this->publishes([$packageDir.'/routes' => base_path().'/routes'], 'routes');
        //$this->publishes([$packageDir.'/resources/views' => resource_path('views/vendor/'.static::PACKAGE_NAME)], 'views');
        //$this->publishes([$packageDir.'/database/migrations' => database_path('migrations')], 'migrations');
        //$this->loadMigrationsFrom($packageDir.'/database/migrations');
        //$this->loadTranslationsFrom($packageDir.'/resources/lang', static::PACKAGE_NAME);
        //$this->loadViewsFrom($packageDir.'/resources/views', static::PACKAGE_NAME);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupRoutes();
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $commonPath = '/routes/backpack/'.static::PACKAGE_NAME.'.php';
        $appRoutesPath = base_path().$commonPath;
        $packageRoutesPath = dirname(__DIR__).$commonPath;
        $this->loadRoutesFrom(file_exists($appRoutesPath) ? $appRoutesPath : $packageRoutesPath);
    }
}
