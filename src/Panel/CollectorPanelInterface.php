<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use Yiisoft\Yii\Debug\Collector\CollectorInterface;

interface CollectorPanelInterface
{
    public function getCollector(): CollectorInterface;

    public function start(): void;
}