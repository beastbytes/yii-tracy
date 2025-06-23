<?php

declare(strict_types=1);

use BeastBytes\Yii\Tracy\Tracy;
use Psr\Container\ContainerInterface;
use Tracy\Debugger;
use Yiisoft\Yii\Http\Event\ApplicationStartup;

return [
    ApplicationStartup::class => [
        static fn(ContainerInterface $container) => $container
            ->get(Tracy::class)
            ->enable()
        ,
    ]
];