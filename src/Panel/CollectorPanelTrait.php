<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use BeastBytes\Yii\Tracy\ProxyContainer;
use Yiisoft\Yii\Debug\Collector\CollectorInterface;

trait CollectorPanelTrait
{
    private ?ProxyContainer $proxyContainer = null;
    
    public function getCollector(): CollectorInterface
    {
        return $this->collector;
    }

    private function addProxyService(string $serviceId, object $proxy): void 
    {        
        $this->container->add($serviceId, $proxy);
    }
}