<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Tests\Support\Panel;

use BeastBytes\Yii\Tracy\Panel\ProxyCollectorPanel;

class TestProxyCollectorPanel extends ProxyCollectorPanel
{
    private const ICON = <<<ICON
<svg
    xmlns="http://www.w3.org/2000/svg"
    height="24px"
    viewBox="0 -960 960 960"
    width="24px"
    fill="#e3e3e3"
>
    <path
        d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156
        31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0
        227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Z"
    />
</svg>

ICON;

    protected function panelParameters(): array
    {
        return [
            'collected' => $this->collector->getCollected()
        ];
    }

    protected function panelTitle(): string
    {
        return 'Proxy Collector Test Panel';
    }

    protected function tabIcon(array $parameters): string
    {
        return self::ICON;
    }

    protected function tabParameters(): array
    {
        return [
            'summary' => $this->collector->getSummary()
        ];
    }

    protected function tabTitle(): string
    {
        return 'Service Collection Panel Tab';
    }

    public function getViewPath(): string
    {
        return __DIR__ . '/views/TestServiceCollectorPanel';
    }
}