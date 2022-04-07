# laravel-prometheus-exporter

A prometheus exporter for Laravel.

[![Author](http://img.shields.io/badge/author-@superbalist-blue.svg?style=flat-square)](https://twitter.com/superbalist)
[![Build Status](https://img.shields.io/travis/Superbalist/laravel-prometheus-exporter/master.svg?style=flat-square)](https://travis-ci.org/Superbalist/laravel-prometheus-exporter)
[![StyleCI](https://styleci.io/repos/98516814/shield?branch=master)](https://styleci.io/repos/98516814)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/superbalist/laravel-prometheus-exporter.svg?style=flat-square)](https://packagist.org/packages/superbalist/laravel-prometheus-exporter)
[![Total Downloads](https://img.shields.io/packagist/dt/superbalist/laravel-prometheus-exporter.svg?style=flat-square)](https://packagist.org/packages/superbalist/laravel-prometheus-exporter)

This package is a wrapper bridging [promphp/prometheus_client_php](https://github.com/promphp/prometheus_client_php) into Laravel.

## Installation

```bash
composer require superbalist/laravel-prometheus-exporter
```

Register the service provider in app.php
```php
'providers' => [
    // ...
    Superbalist\LaravelPrometheusExporter\PrometheusServiceProvider::class,
]
```

Register the facade in app.php
```php
'aliases' => [
    // ...
    'Prometheus' => Superbalist\LaravelPrometheusExporter\PrometheusFacade::class,
]
```

## Configuration

The package has a default configuration which uses the following environment variables.
```
PROMETHEUS_NAMESPACE=app

PROMETHEUS_METRICS_ROUTE_ENABLED=true
PROMETHEUS_METRICS_ROUTE_PATH=metrics
PROMETHEUS_METRICS_ROUTE_MIDDLEWARE=null

PROMETHEUS_STORAGE_ADAPTER=memory

REDIS_HOST=localhost
REDIS_PORT=6379
PROMETHEUS_REDIS_PREFIX=PROMETHEUS_
```

To customize the configuration file, publish the package configuration using Artisan.
```bash
php artisan vendor:publish --provider="Superbalist\LaravelPrometheusExporter\PrometheusServiceProvider"
```

You can then edit the generated config at `app/config/prometheus.php`.

### Storage Adapters

The storage adapter is used to persist metrics across requests.  The `memory` adapter is enabled by default, meaning
data will only be persisted across the current request.  We recommend using the `redis` or `apc` adapter in production
environments.

The `PROMETHEUS_STORAGE_ADAPTER` env var is used to specify the storage adapter.

If `redis` is used, the `REDIS_HOST` and `REDIS_PORT` vars also need to be configured.

### Exporting Metrics

The package adds a `/metrics` end-point, enabled by default, which exposes all metrics gathered by collectors.

This can be turned on/off using the `PROMETHEUS_METRICS_ROUTE_ENABLED` var, and can also be changed using the
`PROMETHEUS_METRICS_ROUTE_PATH` var.

If you would like to protect this end-point, you can write any custom middleware and enable it using
`PROMETHEUS_METRICS_ROUTE_MIDDLEWARE`.

### Collectors

A collector is a class, implementing the [CollectorInterface](src/CollectorInterface.php), which is responsible for
collecting data for one or many metrics.

Please see the [ExampleCollector](src/ExampleCollector.php) included in this repository.

You can auto-load your collectors by adding them to the `collectors` array in the prometheus.php config.

## Usage

```php
// retrieve the exporter
$exporter = app(\Superbalist\LaravelPrometheusExporter::class);
// or
$exporter = app('prometheus');
// or
$exporter = Prometheus::getFacadeRoot();

// register a new collector
$collector = new \My\New\Collector();
$exporter->registerCollector($collector);

// retrieve all collectors
var_dump($exporter->getCollectors());

// retrieve a collector by name
$collector = $exporter->getCollector('user');

// export all metrics
// this is called automatically when the /metrics end-point is hit
var_dump($exporter->export());

// the following methods can be used to create and interact with counters, gauges and histograms directly
// these methods will typically be called by collectors, but can be used to register any custom metrics directly,
// without the need of a collector

// create a counter
$counter = $exporter->registerCounter('search_requests_total', 'The total number of search requests.');
$counter->inc(); // increment by 1
$counter->incBy(2);

// create a counter (with labels)
$counter = $exporter->registerCounter('search_requests_total', 'The total number of search requests.', ['request_type']);
$counter->inc(['GET']); // increment by 1
$counter->incBy(2, ['GET']);

// retrieve a counter
$counter = $exporter->getCounter('search_requests_total');

// create a gauge
$gauge = $exporter->registerGauge('users_online_total', 'The total number of users online.');
$gauge->inc(); // increment by 1
$gauge->incBy(2);
$gauge->dec(); // decrement by 1
$gauge->decBy(2);
$gauge->set(36);

// create a gauge (with labels)
$gauge = $exporter->registerGauge('users_online_total', 'The total number of users online.', ['group']);
$gauge->inc(['staff']); // increment by 1
$gauge->incBy(2, ['staff']);
$gauge->dec(['staff']); // decrement by 1
$gauge->decBy(2, ['staff']);
$gauge->set(36, ['staff']);

// retrieve a gauge
$counter = $exporter->getGauge('users_online_total');

// create a histogram
$histogram = $exporter->registerHistogram(
    'response_time_seconds',
    'The response time of a request.',
    [],
    [0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0]
);
// the buckets must be in asc order
// if buckets aren't specified, the default 0.005, 0.01, 0.025, 0.05, 0.075, 0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0 buckets will be used
$histogram->observe(5.0);

// create a histogram (with labels)
$histogram = $exporter->registerHistogram(
    'response_time_seconds',
    'The response time of a request.',
    ['request_type'],
    [0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0]
);
// the buckets must be in asc order
// if buckets aren't specified, the default 0.005, 0.01, 0.025, 0.05, 0.075, 0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0 buckets will be used
$histogram->observe(5.0, ['GET']);

// retrieve a histogram
$counter = $exporter->getHistogram('response_time_seconds');
```
