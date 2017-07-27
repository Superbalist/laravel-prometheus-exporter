<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Prometheus\Storage\APC;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis;
use Superbalist\LaravelPrometheusExporter\StorageAdapterFactory;

class StorageAdapterFactoryTest extends TestCase
{
    public function testMakeMemoryAdapter()
    {
        $factory = new StorageAdapterFactory();
        $adapter = $factory->make('memory');
        $this->assertInstanceOf(InMemory::class, $adapter);
    }

    public function testMakeApcAdapter()
    {
        $factory = new StorageAdapterFactory();
        $adapter = $factory->make('apc');
        $this->assertInstanceOf(APC::class, $adapter);
    }

    public function testMakeRedisAdapter()
    {
        $factory = new StorageAdapterFactory();
        $adapter = $factory->make('redis');
        $this->assertInstanceOf(Redis::class, $adapter);
    }

    public function testMakeInvalidAdapter()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The driver [moo] is not supported.');

        $factory = new StorageAdapterFactory();
        $factory->make('moo');
    }
}
