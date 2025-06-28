<?php

declare(strict_types=1);

use BeastBytes\Yii\Tracy\Tracy;
use Yiisoft\View\Event\WebView\AfterRender;
use Yiisoft\Yii\Http\Event\AfterEmit;
use Yiisoft\Yii\Http\Event\ApplicationStartup;
use Yiisoft\Yii\View\Renderer\Debug\WebViewCollector;

return [
    ApplicationStartup::class => [
        [Tracy::class, 'start'],
    ],
    AfterEmit::class => [
        [Tracy::class, 'stop'],
    ],
    AfterRender::class => [
        [WebViewCollector::class, 'collect'],
    ],
];