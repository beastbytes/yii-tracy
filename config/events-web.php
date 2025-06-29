<?php

declare(strict_types=1);

use BeastBytes\Yii\Tracy\Tracy;
use Yiisoft\Yii\Http\Event\AfterEmit;
use Yiisoft\Yii\Http\Event\ApplicationStartup;

return [
    ApplicationStartup::class => [
        [Tracy::class, 'start'],
    ],
    AfterEmit::class => [
        [Tracy::class, 'stop'],
    ],
];