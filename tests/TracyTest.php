<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Tests;

use BeastBytes\Yii\Tracy\Tests\Support\Panel\TestPanel;
use BeastBytes\Yii\Tracy\Tracy;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Tracy\Bar;
use Tracy\IBarPanel;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\View\View;

class TracyTest extends TestCase
{
    private ContainerInterface $container;

    #[Before]
    public function setUp(): void
    {
        $this->container = new SimpleContainer([
            View::class => new View(),
        ]);
    }

    #[Test]
    public function tracy(): void
    {
        $tracy = new Tracy(
            [
                'enabled' => true,
                'showBar' => true,

            ],
            $this->container
        );

        /** @var Bar $bar */
        $bar = $tracy->getBar();
        $panel = $bar->getPanel('Tracy:info');

        $this->assertInstanceOf(Bar::class, $bar);;
        $this->assertInstanceOf(IBarPanel::class, $panel);;
    }

    #[Test]
    public function panelConfig(): void
    {
        $config = [
            'mode' => null,
            'dumpTheme' => 'light',
            'keysToHide' => [],
            'maxDepth' => 15,
            'maxLength' => 150,
            'maxItems' => 100,
            'scream' => false,
            'showLocation' => null,
            'strictMode' => false,
            'enabled' => true,
            'showBar' => true,
            'editor' => '',
            'editorMapping' => [],
            'email' => null,
            'emailSnooze' => null,
            'logDirectory' => null,
            'logSeverity' => 0,
            'panelConfig' => [
                'panel1' => TestPanel::class,
                'panel3' => TestPanel::class,
                'panel4' => TestPanel::class,
            ],
            'panels' => [
                'panel1',
                'panel2',
                'panel3',
                'panel4',
            ],
        ];

        $tracy = new Tracy($config, $this->container);
        $tracy->startup();

        /** @var Bar $bar */
        $bar = $tracy->getBar();

        foreach ($config['panels'] as $id) {
            $panel = $bar->getPanel($id);

            if (array_key_exists($id, $config['panelConfig'])) {
                $this->assertInstanceOf(IBarPanel::class, $panel);
            } else {
                $this->assertNull($panel);
            }
        }
    }
}