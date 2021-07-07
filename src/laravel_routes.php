<?php

Route::get(config('prometheus.metrics_route_path'), [
    'as' => config('prometheus.metrics_route_name'),
    'middleware' => config('prometheus.metrics_route_middleware'),
    'uses' => \Superbalist\LaravelPrometheusExporter\MetricsController::class . '@getMetrics',
]);
