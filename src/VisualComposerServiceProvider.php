<?php

namespace Novius\Backpack\VisualComposer;

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
        $this->publishes([__DIR__.'/config' => config_path()], 'config');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'visualcomposer');
        $this->publishes([__DIR__.'/resources/views' => resource_path('views')], 'views');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/visualcomposer.php',
            'visualcomposer'
        );
    }
}
