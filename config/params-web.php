<?php

declare(strict_types=1);

use BeastBytes\Yii\Tracy\Panel\Route\Route;
use Yiisoft\Router\Debug\RouterCollector;
use Yiisoft\Router\Debug\UrlMatcherInterfaceProxy;
use Yiisoft\Router\UrlMatcherInterface;

return [
    'beastbytes/yii-tracy' => [
        'mode' => null,
        'dumpTheme' => 'light',
        'keysToHide' => [],
        'maxDepth' => 15,
        'maxLength' => 150,
        'maxItems' => 100,
        'scream' => false,
        'showLocation' => null,
        'strictMode' => false,


        'enabled' => $_ENV['YII_DEBUG'],
        'showBar' => true,
        'editor' => '',
        'editorMapping' => [],
        'email' => null,
        'emailSnooze' => null,
        'logDirectory' => '@runtime/logs',
        'logSeverity' => 0,
        'panels' => [
            'route' => [
                'class' => Route::class,
            ],
        ]
    ]
];