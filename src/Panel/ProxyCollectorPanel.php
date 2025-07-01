<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use Yiisoft\Yii\Debug\Collector\CollectorInterface;

abstract class ProxyCollectorPanel extends Panel implements CollectorPanelInterface
{
    use CollectorPanelTrait;

    public function __construct(protected CollectorInterface $collector, private readonly array $proxies)
    {
    }

    public function startup(): void
    {
        foreach ($this->proxies as $id => $proxy) {
            $this->container->add($id, $proxy);
        }

        $this->collector->startup();
    }
}