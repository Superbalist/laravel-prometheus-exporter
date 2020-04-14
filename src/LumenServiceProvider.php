<?php

namespace Superbalist\LaravelPrometheusExporter;

class LumenServiceProvider extends PrometheusServiceProvider
{
    /**
     * Load routes.
     */
    protected function loadRoutes()
    {
        $this->app->router
            ->group(['namespace' => 'Superbalist\LaravelPrometheusExporter'], function ($router) {
                require __DIR__ . '/lumen_routes.php';
            });
    }
}
