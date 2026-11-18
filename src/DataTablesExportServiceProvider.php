<?php

namespace Kafyx3\DataTablesExport;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class DataTablesExportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/datatables-export.php',
            'datatables-export'
        );
    }

    public function boot(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'datatables-export'
        );

        Blade::componentNamespace(
            'Kafyx3\\DataTablesExport\\View\\Components',
            'datatables-export'
        );

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/datatables-export.php' => config_path('datatables-export.php'),
            ], 'datatables-export-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/datatables-export'),
            ], 'datatables-export-views');
        }
    }
}
