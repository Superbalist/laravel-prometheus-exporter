<?php

namespace Superbalist\LaravelPrometheusExporter;

class LumenPrometheusServiceProvider extends PrometheusServiceProvider
{
    /**
     * Publish files.
     */
    protected function publishFiles()
    {
        // do nothing
    }

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
