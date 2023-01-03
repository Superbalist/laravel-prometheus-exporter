<?php

namespace Superbalist\LaravelPrometheusExporter;

use Illuminate\Routing\Controller;
use Prometheus\RenderTextFormat;

class MetricsController extends Controller
{
    /**
     * GET /metrics
     *
     * The route path is configurable in the prometheus.metrics_route_path config var, or the
     * PROMETHEUS_METRICS_ROUTE_PATH env var.
     *
     * @param PrometheusExporter $prometheusExporter
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMetrics(PrometheusExporter $prometheusExporter)
    {
        return response()->make(
            (new RenderTextFormat)->render(
                $prometheusExporter->export()
            ),
            200,
            ['Content-Type' => RenderTextFormat::MIME_TYPE]
        );
    }
}
