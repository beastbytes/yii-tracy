<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use Psr\Log\LoggerInterface;
use Yiisoft\Yii\Debug\Collector\CollectorInterface;

abstract class LoggerCollectorPanel extends CollectorPanel
{
    public function __construct(CollectorInterface $collector, protected LoggerInterface $logger)
    {
        parent::__construct($collector);
    }
}