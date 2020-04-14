<?php

namespace Superbalist\LaravelPrometheusExporter;

class LaravelPrometheusServiceProvider extends PrometheusServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/prometheus.php' => config_path('prometheus.php'),
        ]);

        parent::boot();
    }

    /**
     * Load routes.
     */
    protected function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/laravel_routes.php');
    }
}
