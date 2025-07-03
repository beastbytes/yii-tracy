<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use Yiisoft\Yii\Debug\Collector\CollectorInterface;

abstract class ProxyCollectorPanel extends CollectorPanel
{
    public function __construct(CollectorInterface $collector, private readonly array $proxies)
    {
        parent::__construct($collector);
    }

    public function startup(): void
    {
        foreach ($this->proxies as $id => $proxy) {
            $this->container->add($id, $proxy);
        }

        parent::startup();
    }
}