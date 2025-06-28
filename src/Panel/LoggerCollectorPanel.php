<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use Yiisoft\Yii\Debug\Collector\CollectorInterface;

abstract class LoggerCollectorPanel extends Panel implements CollectorPanelInterface
{
    use CollectorPanelTrait;

    public function __construct(protected CollectorInterface $collector)
    {
    }
}