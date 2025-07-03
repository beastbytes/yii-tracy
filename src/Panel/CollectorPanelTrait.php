<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use BeastBytes\Yii\Tracy\ProxyContainer;

trait CollectorPanelTrait
{
    private ?ProxyContainer $proxyContainer = null;
    
    public function getCollected(): array
    {
        return $this->collector->getCollected();
    }

    public function getName(): string
    {
        return $this->collector->getName();
    }

    public function getSummary(): array
    {
        return $this->collector->getSummary();
    }

    public function startup(): void
    {
        $this->collector->startup();
    }

    public function shutdown(): void
    {
        $this->collector->shutdown();
    }

    private function addProxyService(string $serviceId, object $proxy): void 
    {        
        $this->container->add($serviceId, $proxy);
    }
}