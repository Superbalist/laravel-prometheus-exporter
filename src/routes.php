<?php

$route = Route::get(
    config('prometheus.metrics_route_path'),
    \Superbalist\LaravelPrometheusExporter\MetricsController::class . '@getMetrics'
)->name('metrics'); /** @var \Illuminate\Routing\Route $route */
$middleware = config('prometheus.metrics_route_middleware');

if ($middleware) {
    $route->middleware($middleware);
}
