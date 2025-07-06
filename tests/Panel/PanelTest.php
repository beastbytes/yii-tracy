<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Tests\Panel;

use BeastBytes\Yii\Tracy\Tests\Support\Panel\TestPanel;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Translator\CategorySource;
use Yiisoft\Translator\IntlMessageFormatter;
use Yiisoft\Translator\Message\Php\MessageSource;
use Yiisoft\Translator\Translator;
use Yiisoft\View\View;

class PanelTest extends TestCase
{
    private const LOCALE = 'en-GB';
    private const PANEL = <<<HTML
<h1>Test Panel</h1>
<div class="tracy-inner"><div class="tracy-inner-container"><p>Test Panel Content</p></div></div>
HTML;
    private const TAB = <<<HTML
<span class="tracy-label">Test</span>
HTML;

    #[Before]
    public function setUp(): void
    {
        $this->container = new SimpleContainer([
            View::class => (new View())
                ->setParameter(
                    'translator',
                    (new Translator())
                        ->withLocale(self::LOCALE)
                        ->addCategorySources(new CategorySource(
                            TestPanel::MESSAGE_CATEGORY,
                            new MessageSource(dirname(__DIR__) . '/resources/messages'),
                            new IntlMessageFormatter(),
                        ))
                ),
        ]);
    }

    #[Test]
    public function panel(): void
    {
        $panel = (new TestPanel())
            ->withContainer($this->container)
        ;

        $this->assertSame(self::PANEL, $panel->getPanel());
        $this->assertStringContainsString(self::TAB, $panel->getTab());
    }
}