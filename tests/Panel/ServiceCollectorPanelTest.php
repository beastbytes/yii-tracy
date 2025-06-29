<?php

namespace BeastBytes\Yii\Tracy\Tests\Panel;

use BeastBytes\Yii\Tracy\ProxyContainer;
use BeastBytes\Yii\Tracy\Tests\Support\Panel\TestServiceCollectorPanel;
use BeastBytes\Yii\Tracy\Tests\Support\ProxyTestService;
use BeastBytes\Yii\Tracy\Tests\Support\TestCollector;
use BeastBytes\Yii\Tracy\Tests\Support\TestService;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\View\View;

class ServiceCollectorPanelTest extends TestCase
{
    private const PANEL = <<<CONTENT
<h1>Service Collector Test Panel</h1>
<div class="tracy-inner">
    <div class="tracy-inner-container">
        <table><tbody>%s</tbody></table>
    </div>
</div>
CONTENT;

    private const TAB = <<<CONTENT
    <span class="tracy-label">
        Greetings: %d
    </span>
</span>
CONTENT;

    private array $collection;
    private ContainerInterface $container;

    #[Before]
    public function setUp(): void
    {
        $this->container = new ProxyContainer(
            new SimpleContainer([
                TestCollector::class => new TestCollector(),
                TestService::class => new TestService(),
                View::class => new View(),
            ])
        );

        $this->collection = $this
            ->container
            ->get(TestCollector::class)
            ->getCollected()
        ;

    }

    #[Test]
    public function panel(): void
    {
        $panel = (new TestServiceCollectorPanel(
            $this->container->get(TestCollector::class),
            [
                TestService::class => new ProxyTestService(
                    $this->container->get(TestService::class),
                    $this->container->get(TestCollector::class)
                ),
            ]
        ))
            ->withContainer($this->container)
            ->start()
        ;

        $iterations = rand(10, 25);
        for ($i = 0; $i < $iterations; $i++) {
            $who = array_rand($this->collection);
            $this->container->get(TestService::class)->greet($who);
            $this->collection[$who]++;
        }

        $this->assertStringContainsString(sprintf(self::TAB, $iterations), $panel->getTab());
        $this->assertStringContainsString(sprintf(self::PANEL, $this->getPanel()), $panel->getPanel());
    }

    private function getPanel(): string
    {
        $panel = '';
        foreach ($this->collection as $who => $count) {
            $panel .= sprintf('<tr><td>%s</td><td>%d</td></tr>', $who, $count);
        }
        return $panel;
    }
}
