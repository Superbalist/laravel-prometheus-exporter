# laravel-prometheus-exporter

A prometheus exporter for Laravel.

[![Author](http://img.shields.io/badge/author-@superbalist-blue.svg?style=flat-square)](https://twitter.com/superbalist)
[![Build Status](https://img.shields.io/travis/Superbalist/laravel-prometheus-exporter/master.svg?style=flat-square)](https://travis-ci.org/Superbalist/laravel-prometheus-exporter)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/superbalist/laravel-prometheus-exporter.svg?style=flat-square)](https://packagist.org/packages/superbalist/laravel-prometheus-exporter)
[![Total Downloads](https://img.shields.io/packagist/dt/superbalist/laravel-prometheus-exporter.svg?style=flat-square)](https://packagist.org/packages/superbalist/laravel-prometheus-exporter)

This package is a wrapper bridging [jimdo/prometheus_client_php](https://github.com/Jimdo/prometheus_client_php) into Laravel.

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

// TODO:

## Usage

```php
// TODO:
```
