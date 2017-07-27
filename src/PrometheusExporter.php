<?php

namespace Superbalist\LaravelPrometheusExporter;

use InvalidArgumentException;
use Prometheus\CollectorRegistry;

class PrometheusExporter
{
    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var CollectorRegistry
     */
    protected $prometheus;

    /**
     * @var array
     */
    protected $collectors = [];

    /**
     * @param string $namespace
     * @param CollectorRegistry $prometheus
     * @param array $collectors
     */
    public function __construct($namespace, CollectorRegistry $prometheus, array $collectors = [])
    {
        $this->namespace = $namespace;
        $this->prometheus = $prometheus;

        foreach ($collectors as $collector) {
            /* @var CollectorInterface $collector */
            $this->registerCollector($collector);
        }
    }

    /**
     * Return the metric namespace.
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Return the CollectorRegistry.
     *
     * @return CollectorRegistry
     */
    public function getPrometheus()
    {
        return $this->prometheus;
    }

    /**
     * Register a collector.
     *
     * @param CollectorInterface $collector
     */
    public function registerCollector(CollectorInterface $collector)
    {
        $name = $collector->getName();

        if (!isset($this->collectors[$name])) {
            $this->collectors[$name] = $collector;

            $collector->registerMetrics($this);
        }
    }

    /**
     * Return all collectors.
     *
     * @return array
     */
    public function getCollectors()
    {
        return $this->collectors;
    }

    /**
     * Return a collector by name.
     *
     * @param string $name
     *
     * @return CollectorInterface
     */
    public function getCollector($name)
    {
        if (!isset($this->collectors[$name])) {
            throw new InvalidArgumentException(sprintf('The collector "%s" is not registered.', $name));
        }

        return $this->collectors[$name];
    }

    /**
     * Register a counter.
     *
     * @param string $name
     * @param string $help
     * @param array $labels
     *
     * @return \Prometheus\Counter
     *
     * @see https://prometheus.io/docs/concepts/metric_types/#counter
     */
    public function registerCounter($name, $help, $labels = [])
    {
        return $this->prometheus->registerCounter($this->namespace, $name, $help, $labels);
    }

    /**
     * Return a counter.
     *
     * @param string $name
     *
     * @return \Prometheus\Counter
     */
    public function getCounter($name)
    {
        return $this->prometheus->getCounter($this->namespace, $name);
    }

    /**
     * Return or register a counter.
     *
     * @param string $name
     * @param string $help
     * @param array $labels
     *
     * @return \Prometheus\Counter
     *
     * @see https://prometheus.io/docs/concepts/metric_types/#counter
     */
    public function getOrRegisterCounter($name, $help, $labels = [])
    {
        return $this->prometheus->getOrRegisterCounter($this->namespace, $name, $help, $labels);
    }

    /**
     * Register a gauge.
     *
     * @param string $name
     * @param string $help
     * @param array $labels
     *
     * @return \Prometheus\Gauge
     *
     * @see https://prometheus.io/docs/concepts/metric_types/#gauge
     */
    public function registerGauge($name, $help, $labels = [])
    {
        return $this->prometheus->registerGauge($this->namespace, $name, $help, $labels);
    }

    /**
     * Return a gauge.
     *
     * @param string $name
     *
     * @return \Prometheus\Gauge
     */
    public function getGauge($name)
    {
        return $this->prometheus->getGauge($this->namespace, $name);
    }

    /**
     * Return or register a gauge.
     *
     * @param string $name
     * @param string $help
     * @param array $labels
     *
     * @return \Prometheus\Gauge
     *
     * @see https://prometheus.io/docs/concepts/metric_types/#gauge
     */
    public function getOrRegisterGauge($name, $help, $labels = [])
    {
        return $this->prometheus->getOrRegisterGauge($this->namespace, $name, $help, $labels);
    }

    /**
     * Register a histogram.
     *
     * @param string $name
     * @param string $help
     * @param array $labels
     * @param array $buckets
     *
     * @return \Prometheus\Histogram
     *
     * @see https://prometheus.io/docs/concepts/metric_types/#histogram
     */
    public function registerHistogram($name, $help, $labels = [], $buckets = null)
    {
        return $this->prometheus->registerHistogram($this->namespace, $name, $help, $labels, $buckets);
    }

    /**
     * Return a histogram.
     *
     * @param string $name
     *
     * @return \Prometheus\Histogram
     */
    public function getHistogram($name)
    {
        return $this->prometheus->getHistogram($this->namespace, $name);
    }

    /**
     * Return or register a histogram.
     *
     * @param string $name
     * @param string $help
     * @param array $labels
     * @param array $buckets
     *
     * @return \Prometheus\Histogram
     *
     * @see https://prometheus.io/docs/concepts/metric_types/#histogram
     */
    public function getOrRegisterHistogram($name, $help, $labels = [], $buckets = null)
    {
        return $this->prometheus->getOrRegisterHistogram($this->namespace, $name, $help, $labels, $buckets);
    }

    /**
     * Export the metrics from all collectors.
     *
     * @return \Prometheus\MetricFamilySamples[]
     */
    public function export()
    {
        foreach ($this->collectors as $collector) {
            /* @var CollectorInterface $collector */
            $collector->collect();
        }

        return $this->prometheus->getMetricFamilySamples();
    }
}
