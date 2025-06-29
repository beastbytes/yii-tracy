<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Tests;

use BeastBytes\Yii\Tracy\Tracy;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tracy\Bar;
use Tracy\IBarPanel;
use Yiisoft\Test\Support\Container\SimpleContainer;

class TracyTest extends TestCase
{
    #[Test]
    public function tracy(): void
    {
        $tracy = new Tracy(
            [
                'enabled' => true,
                'showBar' => true
            ],
            new SimpleContainer()
        );

        /** @var Bar $bar */
        $bar = $tracy->getBar('Tracy:info');
        $panel = $bar->getPanel('Tracy:info');

        $this->assertInstanceOf(Bar::class, $bar);;
        $this->assertInstanceOf(IBarPanel::class, $panel);;
    }
}