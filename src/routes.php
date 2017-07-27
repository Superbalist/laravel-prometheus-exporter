<?php

Route::get(config('prometheus.metrics_route_path'), 'MetricsController@getMetrics')
    ->middleware(config('prometheus.metrics_route_middleware'))
    ->name('metrics');
