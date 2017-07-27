<?php

namespace Tests;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Mockery;
use PHPUnit\Framework\TestCase;
use Prometheus\RenderTextFormat;
use Superbalist\LaravelPrometheusExporter\MetricsController;
use Superbalist\LaravelPrometheusExporter\PrometheusExporter;

class MetricsControllerTest extends TestCase
{
    public function testConstruct()
    {
        $responseFactory = Mockery::mock(ResponseFactory::class);
        $exporter = Mockery::mock(PrometheusExporter::class);
        $controller = new MetricsController($responseFactory, $exporter);
        $this->assertSame($responseFactory, $controller->getResponseFactory());
        $this->assertSame($exporter, $controller->getPrometheusExporter());
    }

    public function testGetMetrics()
    {
        $response = Mockery::mock(Response::class);

        $responseFactory = Mockery::mock(ResponseFactory::class);
        $responseFactory->shouldReceive('make')
            ->once()
            ->withArgs([
                "\n",
                200,
                ['Content-Type' => RenderTextFormat::MIME_TYPE],
            ])
            ->andReturn($response);

        $exporter = Mockery::mock(PrometheusExporter::class);
        $exporter->shouldReceive('export')
            ->once()
            ->andReturn([]);

        $controller = new MetricsController($responseFactory, $exporter);

        $r = $controller->getMetrics();
        $this->assertSame($response, $r);
    }
}
