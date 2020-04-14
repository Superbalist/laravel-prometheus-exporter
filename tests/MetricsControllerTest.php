<?php

namespace Tests;

use Mockery;
use PHPUnit\Framework\TestCase;
use Prometheus\RenderTextFormat;
use Superbalist\LaravelPrometheusExporter\MetricsController;
use Superbalist\LaravelPrometheusExporter\PrometheusExporter;

class MetricsControllerTest extends TestCase
{
    public function testConstruct()
    {
        $exporter = Mockery::mock(PrometheusExporter::class);
        $controller = new MetricsController($exporter);
        $this->assertSame($exporter, $controller->getPrometheusExporter());
    }

    public function testGetMetrics()
    {
        $exporter = Mockery::mock(PrometheusExporter::class);
        $exporter->shouldReceive('export')
            ->once()
            ->andReturn([]);

        $controller = new MetricsController($exporter);

        $response = $controller->getMetrics();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(RenderTextFormat::MIME_TYPE, $response->headers->get('Content-Type'));
    }
}
