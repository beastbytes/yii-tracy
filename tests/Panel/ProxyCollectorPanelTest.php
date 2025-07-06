<?php

namespace BeastBytes\Yii\Tracy\Tests\Panel;

use BeastBytes\Yii\Tracy\ProxyContainer;
use BeastBytes\Yii\Tracy\Tests\Support\Panel\TestProxyCollectorPanel;
use BeastBytes\Yii\Tracy\Tests\Support\ProxyTestService;
use BeastBytes\Yii\Tracy\Tests\Support\TestCollector;
use BeastBytes\Yii\Tracy\Tests\Support\TestService;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Translator\CategorySource;
use Yiisoft\Translator\IntlMessageFormatter;
use Yiisoft\Translator\Message\Php\MessageSource;
use Yiisoft\Translator\Translator;
use Yiisoft\View\View;

class ProxyCollectorPanelTest extends TestCase
{
    private const LOCALE = 'en-GB';
    private const PANEL = <<<HTML
<h1>Proxy Collector Test Panel</h1>
<div class="tracy-inner"><div class="tracy-inner-container"><table><tbody>%s</tbody></table></div></div>
HTML;
    private const TAB = <<<HTML
<span class="tracy-label">Greetings: %d</span>
HTML;

    private array $collection;
    private ContainerInterface $container;

    #[Before]
    public function setUp(): void
    {
        $this->container = new ProxyContainer(
            new SimpleContainer([
                TestCollector::class => new TestCollector(),
                TestService::class => new TestService(),
                View::class => (new View())
                    ->setParameter(
                        'translator',
                        (new Translator())
                            ->withLocale(self::LOCALE)
                            ->addCategorySources(new CategorySource(
                                TestProxyCollectorPanel::MESSAGE_CATEGORY,
                                new MessageSource(dirname(__DIR__) . '/resources/messages'),
                                new IntlMessageFormatter(),
                            ))
                    ),
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
        $panel = (new TestProxyCollectorPanel(
            $this->container->get(TestCollector::class),
            [
                TestService::class => new ProxyTestService(
                    $this->container->get(TestService::class),
                    $this->container->get(TestCollector::class)
                ),
            ]
        ))
            ->withContainer($this->container)
        ;
        $panel->startup();

        $iterations = rand(10, 25);
        for ($i = 0; $i < $iterations; $i++) {
            $who = array_rand($this->collection);
            $this->container->get(TestService::class)->greet($who);
            $this->collection[$who]++;
        }

        $this->assertStringContainsString(sprintf(self::TAB, $iterations), $panel->getTab());
        $this->assertSame(sprintf(self::PANEL, $this->getPanel()), $panel->getPanel());
    }

    private function getPanel(): string
    {
        $panel = '';
        foreach ($this->collection as $who => $count) {
            $panel .= sprintf('<tr><th>%s</th><td>%d</td></tr>', $who, $count);
        }
        return $panel;
    }
}
