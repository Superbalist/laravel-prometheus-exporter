<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Namespace
    |--------------------------------------------------------------------------
    |
    | The namespace to use as a prefix for all metrics.
    |
    | This will typically be the name of your project, eg: 'search'.
    |
    */

    'namespace' => env('PROMETHEUS_NAMESPACE', 'app'),

    /*
    |--------------------------------------------------------------------------
    | Metrics Route Enabled?
    |--------------------------------------------------------------------------
    |
    | If enabled, a /metrics route will be registered to export prometheus
    | metrics.
    |
    */

    'metrics_route_enabled' => env('PROMETHEUS_METRICS_ROUTE_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Metrics Route Path
    |--------------------------------------------------------------------------
    |
    | The path at which prometheus metrics are exported.
    |
    | This is only applicable if metrics_route_enabled is set to true.
    |
    */

    'metrics_route_path' => env('PROMETHEUS_METRICS_ROUTE_PATH', 'metrics'),

    /*
    |--------------------------------------------------------------------------
    | Metrics Route Name
    |--------------------------------------------------------------------------
    |
    | Route Parh name aliase.
    |
    | This is only applicable if metrics_route_enabled is set to true.
    |
    */

    'metrics_route_name' => env('PROMETHEUS_METRICS_ROUTE_NAME', 'metrics'),

    /*
    |--------------------------------------------------------------------------
    | Metrics Route Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware to assign to the metrics route.
    |
    | This can be used to protect the /metrics end-point to authenticated users,
    | a specific ip address, etc.
    | You are responsible for writing the middleware and implementing any
    | business logic needed by your application.
    |
    */

    'metrics_route_middleware' => env('PROMETHEUS_METRICS_ROUTE_MIDDLEWARE'),

    /*
    |--------------------------------------------------------------------------
    | Storage Adapter
    |--------------------------------------------------------------------------
    |
    | The storage adapter to use.
    |
    | Supported: "memory", "redis", "apc"
    |
    */

    'storage_adapter' => env('PROMETHEUS_STORAGE_ADAPTER', 'memory'),

    /*
    |--------------------------------------------------------------------------
    | Storage Adapters
    |--------------------------------------------------------------------------
    |
    | The storage adapter configs.
    |
    */

    'storage_adapters' => [

        'redis' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'port' => env('REDIS_PORT', 6379),
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
            'prefix' => env('PROMETHEUS_REDIS_PREFIX', 'PROMETHEUS_'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Collectors
    |--------------------------------------------------------------------------
    |
    | The collectors specified here will be auto-registered in the exporter.
    |
    */

    'collectors' => [
        // \Your\ExporterClass::class,
    ],

];
