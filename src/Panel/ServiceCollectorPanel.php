<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use Yiisoft\Yii\Debug\Collector\CollectorInterface;

abstract class ServiceCollectorPanel extends Panel implements CollectorPanelInterface
{
    use CollectorPanelTrait;

    public function __construct(
        protected CollectorInterface $collector,
        private string $serviceId,
        private object $proxy
    )
    {
    }

    public function start(): void 
    {
        $this->addProxyService($this->serviceId, $this->proxy);
        
        $this
            ->collector
            ->startup()
        ;
    }
}