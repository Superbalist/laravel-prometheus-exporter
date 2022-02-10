<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Prometheus\Exception\StorageException;
use Prometheus\Storage\APC;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis;
use Healthengine\LaravelPrometheusExporter\StorageAdapterFactory;

/**
 * @covers \Healthengine\LaravelPrometheusExporter\StorageAdapterFactory
 */
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
        if (!extension_loaded('apcu')) {
            $this->markTestSkipped('APCu extension is not loaded');
        }

        if (!apcu_enabled()) {
            $this->markTestSkipped('APCu is not enabled');
        }

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
