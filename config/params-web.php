<?php

declare(strict_types=1);

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
        'panels' => [],
    ],
    'yiisoft/debug' => [
        'enabled' => false,
    ],
];