<?php

namespace hamburgscleanest\LaravelExtendedData;

use Illuminate\Support\ServiceProvider;

class LaravelExtendedDataServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config.php' => \config_path('laravel-extended-data')
        ]);

        $this->loadMigrationsFrom(__DIR__ . 'Migrations');
    }

}