<?php

namespace BeastBytes\Yii\Tracy\Tests;

use BeastBytes\Yii\Tracy\ContainerProxy;
use BeastBytes\Yii\Tracy\Tests\Support\ProxyTestService;
use BeastBytes\Yii\Tracy\Tests\Support\TestCollector;
use BeastBytes\Yii\Tracy\Tests\Support\TestService;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\View\View;

class ProxyContainerTest extends TestCase
{
    private ContainerInterface $container;

    #[Before]
    public function setUp(): void
    {
        $this->container = new ContainerProxy(
            new SimpleContainer([
                TestCollector::class => new TestCollector(),
                TestService::class => new TestService(),
                View::class => new View(),
            ])
        );
    }

    #[Test]
    public function proxy_container(): void
    {
        $this->assertTrue($this->container->has(TestCollector::class));
        $this->assertInstanceOf(TestCollector::class, $this->container->get(TestCollector::class));

        $this->assertTrue($this->container->has(TestService::class));
        $this->assertInstanceOf(TestService::class, $this->container->get(TestService::class));

        $this->container->add(
            TestService::class,
            new ProxyTestService(
                $this->container->get(TestService::class),
                $this->container->get(TestCollector::class)
            )
        );

        $this->assertTrue($this->container->has(TestService::class));
        $this->assertInstanceOf(ProxyTestService::class, $this->container->get(TestService::class));

        $this->assertFalse($this->container->has(self::class));
    }
}