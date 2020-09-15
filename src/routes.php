<?php

/** @var \Illuminate\Routing\Route|\Laravel\Lumen\Routing\Router $route */
$route = app('router');

$params = array_filter([
    'uses' => \Superbalist\LaravelPrometheusExporter\MetricsController::class . '@getMetrics',
    'as' =>  config('prometheus.metrics_route_name'),
    'middleware' =>  config('prometheus.metrics_route_middleware'),
]);

$route->get(config('prometheus.metrics_route_path'), $params);
