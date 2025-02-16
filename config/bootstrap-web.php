<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Tracy\Debugger;
use Yiisoft\Aliases\Aliases;

return [
    static function (ContainerInterface $container) {
        /** @var Aliases $aliases */
        $aliases = $container->get('Yiisoft\Aliases\Aliases');

        Debugger::enable(
            logDirectory: $aliases->get('@runtime/logs'),
        );
    },
];