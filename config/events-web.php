<?php

declare(strict_types=1);

use BeastBytes\Yii\Tracy\Tracy;
use Yiisoft\Yii\Http\Event\ApplicationShutdown;
use Yiisoft\Yii\Http\Event\ApplicationStartup;

return [
    ApplicationShutdown::class => [
        [Tracy::class, 'shutdown'],
    ],
    ApplicationStartup::class => [
        [Tracy::class, 'startup'],
    ],
];