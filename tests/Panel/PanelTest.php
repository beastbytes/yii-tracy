<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Tests\Panel;

use BeastBytes\Yii\Tracy\Tests\Support\Panel\TestPanel;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\View\View;

class PanelTest extends TestCase
{
    private const PANEL = <<<CONTENT
<h1>Test Panel</h1>
<div class="tracy-inner">
    <div class="tracy-inner-container">
        <p>Test Panel Content</p>
    </div>
</div>
CONTENT;

    private const TAB = <<<CONTENT
    <span class="tracy-label">
        Test
    </span>
</span>
CONTENT;

    #[Test]
    public function panel(): void
    {
        $panel = (new TestPanel())
            ->withContainer(new SimpleContainer([
                View::class => new View()
            ]))
        ;

        $this->assertStringContainsString(self::PANEL, $panel->getPanel());
        $this->assertStringContainsString(self::TAB, $panel->getTab());
    }
}